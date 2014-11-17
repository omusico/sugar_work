<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

array_push($job_strings, 'GoogleCalendarSync');
array_push($job_strings, 'ExchangeRate_UA');// by kolerts
array_push($job_strings, 'OpportunitiesReminder');// by kolerts
array_push($job_strings, 'check_auth_users');
array_push($job_strings, 'transfer_message_archive_chat');
$job_strings[] = 'runMassSMSCampaign';
$job_strings[] = 'sendSmsReminders';
$job_strings[] = 'deleteOldUsers';

function runMassSMSCampaign() {

	$GLOBALS['log']->debug('Called:runMassSMSCampaign');

	if (!class_exists('DBManagerFactory')){
		require('include/database/DBManagerFactory.php');
	}

	global $beanList;
	global $beanFiles;
	require("config.php");
	require('include/modules.php');
	if(!class_exists('AclController')) {
		require('modules/ACL/ACLController.php');
	}

	require('modules/EmailMan/SMSManDelivery.php');
	return true;
}

function sendSmsReminders(){
    $GLOBALS['log']->info('----->Scheduler fired job of type sendEmailReminders()');
    require_once("modules/Activities/SmsReminder.php");
    $reminder = new SmsReminder();
    return $reminder->process();
}

function ExchangeRate_UA() {
	require_once 'custom/modules/Realty/Currencies_hook.php';
	$Currencies_ = new Currencies_hook();
	$Currencies_->toUAH_update();
}

function OpportunitiesReminder() {
	$GLOBALS['log']->info('----->Scheduler fired job of type sendEmailReminders()');
	require_once("custom/modules/Opportunities/Reminder.php");
	$reminder = new Reminder();
	return $reminder->process();
}

function GoogleCalendarSync() {

    require_once 'modules/GoogleSync/GoogleSync.php';

    global $timedate;

    GoogleSync::init();
    $usr = new User();
    $users = $usr->get_full_list();
    foreach ($users as $user){
        $client = GoogleSync::getClient($user);

        if ($client!=false){
            $service = new Zend_Gdata_Calendar($client);

            try {
                $listFeed= $service->getCalendarEventFeed();
                foreach ($listFeed as $calendar) {
                    $id = $calendar->id;

                    $googleSync = new GoogleSync();
                    $list = $googleSync->get_list('',"{$googleSync->table_name}.google_id='$id'");

                    if($list['row_count']>0)
                    {
                        $event = BeanFactory::getBean($list['list'][0]->parent_name);
                        $event->retrieve($list['list'][0]->parent_id);

                        $event->name = $calendar->title->text;
                        if (!preg_match('/event.private$/',$calendar->visibility->value))
                        {
                            $event->description = $calendar->content->text;
                        }

                        GoogleSync::setDates($event, $calendar->when[0]->startTime, 0);

                        switch ($event->module_dir)
                        {
                            case 'Calls': $event->name = preg_replace('/^Звонок: /ui','',$calendar->title->text);
                            GoogleSync::setReminder($event,$calendar->when[0]->reminders[0]);
                            GoogleSync::setDuration(&$event,$calendar->when[0]->startTime,$calendar->when[0]->endTime);
                            break;
                            case 'Meetings':$event->name = preg_replace('/^Звонок: /ui','',$calendar->title->text);
                            GoogleSync::setReminder($event,$calendar->when[0]->reminders[0]);
                            GoogleSync::setDuration(&$event,$calendar->when[0]->startTime,$calendar->when[0]->endTime);
                            $event->location = $calendar->where[0]->valueString;
                            break;
                            case 'Tasks': $event->name = preg_replace('/^Задача: /ui','',$calendar->title->text);
                            GoogleSync::setDates($event, $calendar->when[0]->endTime, 1);
                            break;
                        }

                        $event->from_where = 'GOOGLE';
                        $event->save();
                    }
                    else
                    {
                        if(preg_match('/^Звонок/ui',$calendar->title->text)){
                            $event = new Call();
                            $event->name = preg_replace('/^Звонок: /ui','',$calendar->title->text);

                            GoogleSync::setReminder($event,$calendar->when[0]->reminders[0]);

                            GoogleSync::setDuration(&$event,$calendar->when[0]->startTime,$calendar->when[0]->endTime);
                        }
                        elseif (preg_match('/^Встреча/ui',$calendar->title->text)){
                            $event = new Meeting();
                            $event->name = preg_replace('/^Встреча: /ui','',$calendar->title->text);

                            GoogleSync::setReminder($event,$calendar->when[0]->reminders[0]);

                            GoogleSync::setDuration(&$event,$calendar->when[0]->startTime,$calendar->when[0]->endTime);

                            $event->location = $calendar->where[0]->valueString;
                        }
                        elseif(preg_match('/^Задача/ui',$calendar->title->text)){
                            $event = new Task();
                            $event->name = preg_replace('/^Задача: /ui','',$calendar->title->text);

                            GoogleSync::setDates($event, $calendar->when[0]->endTime, 1);
                        }

                        if (isset($event))
                        {
                            if (!preg_match('/event.private$/',$calendar->visibility->value))
                            {
                                $event->description = $calendar->content->text;
                            }

                            GoogleSync::setDates($event, $calendar->when[0]->startTime, 0);

                            $event->from_where = 'GOOGLE';
                            $event->assigned_user_id = $user->id;
                            $event_id = $event->save();

                            $googleSync->parent_name = $event->module_dir;
                            $googleSync->parent_id = $event_id;
                            $googleSync->google_id = $id;
                            $googleSync->user_id = $user->id;
                            $googleSync->save();
                        }
                    }


                }
            } catch (Zend_Gdata_App_Exception $e) {

            }
        }
    }

    return true;
}

function deleteOldUsers() 
{
    global $db;
    $sql = 'DELETE 
            FROM users 
            WHERE is_admin = 0 
                AND do_not_delete = 0 
                AND DATE_FORMAT(date_entered, "%Y-%m-%d") < DATE_FORMAT(SUBDATE(UTC_TIMESTAMP(),INTERVAL 14 DAY), "%Y-%m-%d")';
    $result = $db->query($sql);        
    return true;
}

function check_auth_users()
{

    $time_now = strtotime(date("Y-m-d H:i:s"));

    $db = DBManagerFactory::getInstance();

    $sql ="SELECT uu.auth_time, uu.auth_action, uu.id
                FROM users AS uu
                WHERE deleted = 0
                AND auth_action = 1
    ";
    $query = $db->query($sql);
    while($row = $db->fetchByAssoc($query)){

        $time_auth = strtotime($row['auth_time']);
        $difference = $time_now - $time_auth;
        if($difference > 30){

            $user = new User();
            $user -> retrieve($row['id']);
            $user -> auth_action = 0;
            $user -> save();

        }
    }

}

function transfer_message_archive_chat()
{
    $db = DBManagerFactory::getInstance();

    $date_record = date('Y-m-d H:i:s', strtotime('- 1 days' ));

    $sql_find_mess = "SELECT id AS mess_id, cm.date_time, cm.message, cm.session_id, cm.sender_id
                     FROM chat_messages AS cm
                     WHERE deleted = 0
                     AND date_time < '{$date_record}'
                     ";

    $query_find_mess = $db->query($sql_find_mess);

    while($row_find_mess = $db->fetchByAssoc($query_find_mess)){

        $chat_archives = new Chat_Archives;
        $chat_archives -> date_time = $row_find_mess['date_time'];
        $chat_archives -> message = $row_find_mess['message'];
        $chat_archives -> session_id = $row_find_mess['session_id'];
        $chat_archives -> sender_id = $row_find_mess['sender_id'];
        $chat_archives -> save();

        $mess_id = $row_find_mess['mess_id'];

        $sql_delete_mess = "DELETE FROM  chat_messages
                        WHERE id = '{$mess_id}'
                        ";

        $query_delete_mess = $db->query($sql_delete_mess);
    }
}
?>

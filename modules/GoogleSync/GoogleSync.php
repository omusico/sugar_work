<?php
/*******************************************************************************
 * The contents of this file are subject to the SugarCRM Public License Version
 * 1.1.3 ("License"); You may not use this file except in compliance with the
 * License. You may obtain a copy of the License at http://www.sugarcrm.com/SPL
 * Software distributed under the License is distributed on an "AS IS" basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License for
 * the specific language governing rights and limitations under the License.
 * 
 * The Original Code is: SugarCRM Open Source
 * 
 * The Initial Developer of the Original Code is SugarCRM, Inc.
 * Portions created by SugarCRM are Copyright (C) 2004 SugarCRM, Inc.;
 * All Rights Reserved.
 * Contributor(s): EMPPOR GmbH
 ******************************************************************************/

/* Include all other system or application files that you need to reference here.*/
//require_once('include/logging.php'); /*Include this file if you want to write messages to the log file*/
require_once('data/SugarBean.php'); /*Include this file since we are extending SugarBean*/
require_once('include/utils.php'); /* Include this file if you want access to Utility methods such as return_module_language,return_mod_list_strings_language, etc ..*/
require_once('modules/GoogleSync/functions.php'); /* Include this file to use some custom utility functions */

if(strpos(ini_get('include_path'), 'ZendGdata') === false) {
    ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . 'include/ZendGdata/library/');
}
require_once('Zend/Loader.php');

class GoogleSync extends SugarBean {
    var $id;
    var $date_entered;
    var $created_by;
    var $date_modified;
    var $modified_user_id;
    var $deleted;
    
    var $table_name = 'GoogleSync';
    
    var $object_name = 'GoogleSync';
    
    var $module_dir = 'GoogleSync';
    
    var $new_schema = true;
	
    
    var $column_fields = array(
    );
    
    var $required_fields =  array(
    );
    
    var $additional_column_fields = array(
    );
    
    function GoogleSync() {
        parent::SugarBean();
    }
    
    static function eventSave($bean) {
        if (!self::init())
            return false;
        $userids = array();
        $userids[] = $bean->assigned_user_id;
        if (!empty($bean->users_arr) && is_array($bean->users_arr)) {
            foreach ($bean->users_arr as $id) {
                $userids[] = $id;
            }
        }
        $userids = array_unique($userids);
        foreach ($userids as $id) {
            $user = new User();
            $user->retrieve($id);
            if (!empty($user->googleaccount_c) && !empty($user->googlepass_c)) {
                self::checkEvent($bean, $user);
            }
        }
    }
    
    static function getEvent($bean, $user) {
        $client = self::getClient($user);
        if ($client!=false){
            $gdataCal = new Zend_Gdata_Calendar($client);

            $newEvent = null;
            $gid = self::getGoogleId($bean, $user);
            if ($gid) {
                try {
                    $newEvent = $gdataCal->getEntry($gid, 'Zend_Gdata_Calendar_EventEntry');
                } catch (Exception $e) {
                    // Not found, creating
                }
            }
            if ($newEvent === null) {
                $newEvent = $gdataCal->newEventEntry();
            }
            return $newEvent;
        }
    }
    
    static function updateEvent(&$newEvent, $bean, $user) {
        $client = self::getClient($user);
        if ($client!=false)
        {
            $gdataCal = new Zend_Gdata_Calendar($client);

            global $timedate;
            $date_time_start = $bean->date_start.' '.$bean->time_start;
            if (toTimestamp($date_time_start) < mktime(0,0,0,1,1,2001)) {
                //$date_time_start = DateTime::get_time_start($timedate->to_db_date($bean->date_start,false),$bean->time_start.":00");
                //$date_time_start = $date_time_start->get_mysql_date().' '.$date_time_start->get_mysql_time();
                $date_time_start = date($timedate->get_db_date_time_format(), strtotime($bean->date_start));
            }
            //$date_time_start = $timedate->handle_offset($date_time_start, $timedate->get_db_date_time_format(), true);
            $time = toTimestamp($date_time_start);

            $duration = ($bean->duration_hours * 60 * 60) + ($bean->duration_minutes * 60);

            $when = $gdataCal->newWhen();
            $when->startTime = strftime("%Y-%m-%dT%H:%M:%S.000+00:00", $time);
            $when->endTime = strftime("%Y-%m-%dT%H:%M:%S.000+00:00", $time + $duration);

            // Tasks
            if(isset($bean->date_due) === true) {
                $date_time_end = $bean->date_due.' '.$bean->time_due;
                if (toTimestamp($date_time_start) < mktime(0,0,0,1,1,2001)) {
                    $date_time_end = date($timedate->get_db_date_time_format(), strtotime($bean->date_due));
                }
                $time = toTimestamp($date_time_end);
                $when->endTime = strftime("%Y-%m-%dT%H:%M:%S.000+00:00", $time);
            }
            // Tasks

            if ($bean->reminder_time < 0) {
                $when->reminders = array();
            } else {
                $mins = (int) ($bean->reminder_time / 60); // reminder_time are seconds
                if ($mins < 5) $mins = 5;
                $reminder = $gdataCal->newReminder();
                //$reminder->method = "sms";
                $reminder->minutes = $mins;
                $when->reminders = array($reminder);
            }

            $newEvent->when = array($when);
            /** Conditionals **/
            if ($bean->module_dir == "Meetings") {
                $newEvent->where = array($gdataCal->newWhere($bean->location));
                $newEvent->title = $gdataCal->newTitle("Встреча: " . $bean->name);
            } elseif ($bean->module_dir == "Calls") {
                $newEvent->title = $gdataCal->newTitle("Звонок: " . $bean->name);
            } elseif ($bean->module_dir == "Tasks")
            {
                $newEvent->title = $gdataCal->newTitle("Задача: " . $bean->name);
            }

            $newEvent->content = $gdataCal->newContent($bean->description);
        }
    }
    
    static function saveEvent(&$newEvent, $bean, $user) {
        $client = self::getClient($user);
        if ($client!=false){
            $gdataCal = new Zend_Gdata_Calendar($client);

            if (empty($newEvent->id->text)) {
                try {
                    // Upload the event to the calendar server
                    // A copy of the event as it is recorded on the server is returned
                    $createdEvent = $gdataCal->insertEvent($newEvent);
                } catch (Zend_Gdata_App_Exception $e) {
                    var_dump($e->getResponse());
                    $GLOBALS['log']->error("Failed to insert Event in GoogleCalender: ".print_r($e->getMessage(), 1));
                    die();
                }
            } else {
                try {
                    $newEvent->save();
                    $createdEvent = $newEvent;
                } catch (Zend_Gdata_App_Exception $e) {
                    var_dump($e->getResponse());
                    $GLOBALS['log']->error("Failed to update Event in GoogleCalender: ".print_r($e->getMessage(), 1));
                    die();
                }
            }

            $gs = new GoogleSync;
            if ($gsid = self::getGoogleEntryId($bean, $user)) {
                $gs->retrieve($gsid);
            }
            $gs->parent_name = $bean->module_dir;
            $gs->parent_id = $bean->id; // Had to be saved already!;
            $gs->user_id = $user->id;
            $gs->google_id = $createdEvent->id->text;
            $gs->save();
        }
    }
    
    static function deleteEvent(&$newEvent, $bean, $user) {
        //$client = self::getClient();
        //$gdataCal = new Zend_Gdata_Calendar($client);
        if (empty($newEvent->id->text)) {
            // cant delete, doesn't exists yet ;)
        } else {
            try {
                $newEvent->delete();
            } catch (Zend_Gdata_App_Exception $e) {
                var_dump($e->getResponse());
                $GLOBALS['log']->error("Failed to update Event in GoogleCalender: ".print_r($e->getMessage(), 1));
                die();
            }
        }
    }
    
    static function checkEvent($bean, $user) {
        $event = self::getEvent($bean, $user);
        if ($event)
        {
            if ($bean->deleted != 1) {
                self::updateEvent($event, $bean, $user);
                self::saveEvent($event, $bean, $user);
            } else {
                self::deleteEvent($event, $bean, $user);
            }
        }
    }
    
    static function getGoogleId($bean, $user) {
        $row = self::getGoogleEntry($bean, $user);
        if ($row) {
            return $row['google_id'];
        }
    }
    
    static function getGoogleEntryId($bean, $user) {
        $row = self::getGoogleEntry($bean, $user);
        if ($row) {
            return $row['id'];
        }
    }
    
    static function getGoogleEntry($bean, $user) {
        $gs = new GoogleSync;
        $list = $gs->db->query(sprintf("SELECT * FROM `%s` WHERE deleted = 0 AND parent_name = '%s' AND parent_id = '%s' AND user_id = '%s'",
            $gs->table_name, $bean->module_dir, $bean->id, $user->id));
        while ($row = $gs->db->fetchByAssoc($list)) {
            return $row;
        }
        return false;
    }
    
    static function init() {
        static $initied = false;
        if (!$initied) {
            Zend_Loader::loadClass('Zend_Gdata');
            Zend_Loader::loadClass('Zend_Gdata_Calendar');
            $initied = true;
        }
        return true;
    }
    
    static function getClient($user = null) {
        if ($user === null) {
            global $current_user;
            $user = $current_user;
        }
        static $clients = array();
        if (!isset($clients[$user->id])){
            if (!empty($user->googleaccount_c) && !empty($user->googlepass_c)) {
                Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
                $service = Zend_Gdata_Calendar::AUTH_SERVICE_NAME; // predefined service name for calendar
                $clients[$user->id] = Zend_Gdata_ClientLogin::getHttpClient($user->googleaccount_c, $user->googlepass_c, $service);
                if (!$clients[$user->id]) {
                    return false;
                }
            }
            else
                return false;
        }
        return $clients[$user->id];
    }

    static function setDuration(&$event,$dateStart,$dateEnd){
        $event->duration_minutes = ((strtotime($dateEnd)-strtotime($dateStart))/60)%60;
        $event->duration_hours = floor((strtotime($dateEnd)-strtotime($dateStart))/3600);
    }

    static function setReminder(&$event,$reminder){
        if ($reminder)
        {
            $event->reminder_checked = true;
            $event->reminder_time = ($reminder->days*24*60+$reminder->hours*60+$reminder->minutes)*60;
        }
    }

    static function setDates(&$event,$date,$mod){
        global $timedate;
        if($mod==1){
            $event->date_due = $timedate->handle_offset($date,$timedate->get_date_time_format(),true);
            $event->time_due = $timedate->handle_offset($date,$timedate->get_time_format(),true);
        }
        else{
            $event->date_start = $timedate->handle_offset($date,$timedate->get_date_time_format(),true);
            $event->time_start = $timedate->handle_offset($date,$timedate->get_time_format(),true);
        }
    }
}
?>

<?php
if ( !defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2012 SugarCRM Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/

 
require_once("modules/Meetings/Meeting.php");
require_once("modules/Calls/Call.php");
require_once("modules/Users/User.php");
require_once("modules/Contacts/Contact.php");
require_once("modules/Leads/Lead.php");

/**
 * Class for sending email reminders of meetings and call to invitees
 * 
 */
class SmsReminder
{
    
    /**
     * string db datetime of now
     */
    protected $now;
    
    /**
     * string db datetime will be fetched till
     */
    protected $max;
    
    /**
     * constructor
     */
    public function __construct()
    {
        $max_time = 0;
        if(isset($GLOBALS['app_list_strings']['reminder_time_options'])){
            foreach($GLOBALS['app_list_strings']['reminder_time_options'] as $seconds => $value ) {
                if ( $seconds > $max_time ) {
                    $max_time = $seconds;
                }
            }
        }else{
            $max_time = 8400;
        }
        $this->now = $GLOBALS['timedate']->nowDb();
        $this->max = $GLOBALS['timedate']->getNow()->modify("+{$max_time} seconds")->asDb();
    }
    
    /**
     * main method that runs reminding process
     * @return boolean
     */
    public function process()
    {

        $admin = new Administration();
        $admin->retrieveSettings();
        
        $meetings = $this->getMeetingsForRemind();
        foreach($meetings as $id ) {
            $recipients = $this->getRecipients($id,'Meetings');
            $bean = new Meeting();
            $bean->retrieve($id);
            if ( $this->sendReminders($bean, $admin, $recipients) ) {
                $bean->sms_reminder_sent = 1;
                $bean->save();
            }            
        }
        
        $calls = $this->getCallsForRemind();
        foreach($calls as $id ) {
            $recipients = $this->getRecipients($id,'Calls');
            $bean = new Call();
            $bean->retrieve($id);
            if ( $this->sendReminders($bean, $admin, $recipients) ) {
                $bean->sms_reminder_sent = 1;
                $bean->save();
            }
        }
        
        return true;
    }
    
    /**
     * send reminders
     * @param SugarBean $bean
     * @param Administration $admin
     * @param array $recipients
     * @return boolean
     */
    protected function sendReminders(SugarBean $bean, Administration $admin, $recipients)
    {
        
        if ( empty($_SESSION['authenticated_user_language']) ) {
            $current_language = $GLOBALS['sugar_config']['default_language'];
        }else{
            $current_language = $_SESSION['authenticated_user_language'];
        }            
                
                if ( !empty($bean->created_by) ) {
            $user_id = $bean->created_by;
        }else if ( !empty($bean->assigned_user_id) ) {
            $user_id = $bean->assigned_user_id;
        }else {
            $user_id = $GLOBALS['current_user']->id;
        }
        $user = new User();
        $user->retrieve($bean->created_by);
            
        $OBCharset = $GLOBALS['locale']->getPrecedentPreference('default_email_charset');


        ///////////////////SMS///////////////////////////
        require_once('custom/sms/sms.php');
        $sms = new sms();
        $sms->parent_type = 'Users';

        foreach($recipients as $r ) {
            $sms->parent_id = $r['id'];
            $sms->pname = $r['name'];
            $type = ($bean->object_name == "Call")?"Вам назначен звонок ":"Вам назначена Встреча ";
            $text = $type.$bean->name." на ".$bean->date_start;
            $resp = $sms->send_message($r['number'], $text);
            //TODO
            if ($resp == "SENT") return true;
            else return false;
        }
        return true;
    }
    
    /**
     * set reminder body
     * @param XTemplate $xtpl
     * @param SugarBean $bean
     * @param User $user
     * @return XTemplate 
    */
    protected function setReminderBody(XTemplate $xtpl, SugarBean $bean, User $user)
    {
    
        $object = strtoupper($bean->object_name);

        $xtpl->assign("{$object}_SUBJECT", $bean->name);
        $date = $GLOBALS['timedate']->fromUser($bean->date_start,$GLOBALS['current_user']);
        $xtpl->assign("{$object}_STARTDATE", $GLOBALS['timedate']->asUser($date, $user)." ".TimeDate::userTimezoneSuffix($date, $user));
        if ( isset($bean->location) ) {
            $xtpl->assign("{$object}_LOCATION", $bean->location);
        }
        $xtpl->assign("{$object}_CREATED_BY", $user->full_name);
        $xtpl->assign("{$object}_DESCRIPTION", $bean->description);

        return $xtpl;
    }
    
    /**
     * get meeting ids list for remind
     * @return array
     */
    public function getMeetingsForRemind()
    {
        global $db;
        $query = "
            SELECT id, date_start, sms_reminder_time FROM meetings
            WHERE sms_reminder_time != -1
            AND deleted = 0
            AND sms_reminder_sent = 0
            AND status != 'Held'
            AND date_start >= '{$this->now}'
            AND date_start <= '{$this->max}'
        ";
        $re = $db->query($query);
        $meetings = array();
        while($row = $db->fetchByAssoc($re) ) {
            $remind_ts = $GLOBALS['timedate']->fromDb($db->fromConvert($row['date_start'],'datetime'))->modify("-{$row['sms_reminder_time']} seconds")->ts;
            $now_ts = $GLOBALS['timedate']->getNow()->ts;
            if ( $now_ts >= $remind_ts ) {
                $meetings[] = $row['id'];
            }
        }
        return $meetings;
    }
    
    /**
     * get calls ids list for remind
     * @return array
     */
    public function getCallsForRemind()
    {
        global $db;
        $query = "
            SELECT id, date_start, sms_reminder_time FROM calls
            WHERE sms_reminder_time != -1
            AND deleted = 0
            AND sms_reminder_sent = 0
            AND status != 'Held'
            AND date_start >= '{$this->now}'
            AND date_start <= '{$this->max}'
        ";
        $re = $db->query($query);
        $calls = array();
        while($row = $db->fetchByAssoc($re) ) {
            $remind_ts = $GLOBALS['timedate']->fromDb($db->fromConvert($row['date_start'],'datetime'))->modify("-{$row['sms_reminder_time']} seconds")->ts;
            $now_ts = $GLOBALS['timedate']->getNow()->ts;
            if ( $now_ts >= $remind_ts ) {
                $calls[] = $row['id'];
            }
        }
        return $calls;
    }
    
    /**
     * get recipients of reminding email for specific activity
     * @param string $id
     * @param string $module
     * @return array
     */
    protected function getRecipients($id, $module = "Meetings")
    {
        global $db;

//        require_once('custom/sms/sms.php');
//        $sms = new sms();
        require_once("modules/Administration/izeno_smsPhone/sms_enzyme.php");
        $e = new sms_enzyme('Users');
        $sms_field = $e->get_custom_phone_field();


        switch($module ) {
            case "Meetings":
                $field_part = "meeting";
                break;
            case "Calls":
                $field_part = "call";
                break;
            default:
                return array();
        }
    
        $phones = array();
        // fetch users
        $query = "SELECT user_id FROM {$field_part}s_users WHERE {$field_part}_id = '{$id}' AND accept_status != 'decline' AND deleted = 0
        ";
        $re = $db->query($query);
        while($row = $db->fetchByAssoc($re) ) {
            $user = new User();
            $user->retrieve($row['user_id']);
                $arr = array(
                    'type' => 'Users',
                    'name' => $user->full_name,
                    'number' => $user->phone_mobile,
                    'id' => $user->id,
                );
                $phones[] = $arr;

        }        

        return $phones;
    }
}


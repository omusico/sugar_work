<?php
//if ( !defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * "Created by Kolerts"
 ********************************************************************************/

require_once("include/javascript/jsAlerts.php");
require_once("modules/Opportunities/Opportunity.php");
require_once("modules/Users/User.php");


class Reminder
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
        $this->now = $GLOBALS['timedate']->nowDb();
    }
    
    /**
     * main method that runs reminding process
     * @return boolean
     */
    public function process()
    {
        $admin = new Administration();
        $admin->retrieveSettings();
        
		$GLOBALS['log']->info('----->test');
        $opportunities = $this->getOpportunitiesForRemind();
        foreach($opportunities as $id ) {
			
		echo"----->id:$id";
            $recipients = $this->getRecipients($id);
			$bean = new Opportunity();
            $bean->retrieve($id);
            if ( $this->sendReminders($bean, $admin, $recipients) ) {
                $bean->date_remind = 0;
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
        global $sugar_config;
		$user = new User();
        $user->retrieve($bean->created_by);
            
        $OBCharset = $GLOBALS['locale']->getPrecedentPreference('default_email_charset');
		
		///////////////////EMAIL///////////////////////////
        require_once("include/SugarPHPMailer.php");
        $mail = new SugarPHPMailer();
        $mail->setMailerForSystem();
        
        if(empty($admin->settings['notify_send_from_assigning_user']))
        {
            $from_address = $admin->settings['notify_fromaddress'];
            $from_name = $admin->settings['notify_fromname'] ? "" : $admin->settings['notify_fromname'];
        }
        else
        {
            $from_address = $user->emailAddress->getReplyToAddress($user);
            $from_name = $user->full_name;
        }

        $mail->From = $from_address;
        $mail->FromName = $from_name;
        
        
        $mail->Body = "Напоминание о сделке '{$bean->name}' - {$sugar_config['site_url']}/index.php?action=DetailView&module=Opportunities&record={$bean->id}";
               $mail->Subject = "SugarCRM::Напоминание о сделке";
               
        $oe = new OutboundEmail();
        $oe = $oe->getSystemMailerSettings();
        if ( empty($oe->mail_smtpserver) ) {
            $GLOBALS['log']->fatal("Email Reminder: error sending email, system smtp server is not set");
            return;
        }

        foreach($recipients as $r ) {
            $mail->ClearAddresses();
            $mail->AddAddress($r['email'],$GLOBALS['locale']->translateCharsetMIME(trim($r['name']), 'UTF-8', $OBCharset));    
            $mail->prepForOutbound();
            if ( !$mail->Send() ) {
                $GLOBALS['log']->fatal("Email Reminder: error sending e-mail (method: {$mail->Mailer}), (error: {$mail->ErrorInfo})");
            }
        }
		
		///////////////////SMS///////////////////////////
        require_once('custom/sms/sms.php');
        $sms = new sms();
        $sms->parent_type = 'Users';

        foreach($recipients as $r )
		{
            $sms->parent_id = $r['id'];
            $sms->pname = $r['name'];
            $type = "Напоминание о сделке ";
            $text = $type.$bean->name;
            /*if($sms->send_message($r['number'], $text) == "SENT")
				return true;
            else
				return false;*/
        }
		
		///////////////////ALERT/////////////////////////// !TODO
		/*$timeStart = strtotime($db->fromConvert($bean->date_start, 'datetime'));
		$this->addAlert($app_strings['MSG_JS_ALERT_MTG_REMINDER_CALL'], $bean->name, $app_strings['MSG_JS_ALERT_MTG_REMINDER_TIME'].$timedate->to_display_date_time($db->fromConvert($bean->date_remind, 'datetime')) , $app_strings['MSG_JS_ALERT_MTG_REMINDER_DESC'].$bean->description. $app_strings['MSG_JS_ALERT_MTG_REMINDER_CALL_MSG'] , $timeStart - strtotime($this->now), 'index.php?action=DetailView&module=Opportunities&record=' . $bean->id);
		*/
		
        return true;
    }
    
    
    /**
     * @return array
     */
    public function getOpportunitiesForRemind()
    {
        global $db;
        $query = "
            SELECT id, date_remind FROM opportunities 
            WHERE deleted = 0
            AND date_remind <> 0
            AND date_remind <= '{$this->now}'
        ";
        $re = $db->query($query);
        $opportunities = array();
        while($row = $db->fetchByAssoc($re) ) {
            $remind_ts = $GLOBALS['timedate']->fromDb($db->fromConvert($row['date_remind'],'datetime'))->ts;
            $now_ts = $GLOBALS['timedate']->getNow()->ts;
            if ( $now_ts >= $remind_ts ) {
                $opportunities[] = $row['id'];
            }
        }
        return $opportunities;
    }
    
    protected function getRecipients($id)
    {
        global $db;
        
        $emails = array();
        // fetch users
        $query = "SELECT assigned_user_id FROM opportunities WHERE id = '{$id}'";
        $re = $db->query($query);
        while($row = $db->fetchByAssoc($re) ) {
            $user = new User();
            $user->retrieve($row['assigned_user_id']);
            if ( !empty($user->email1) ) {
                $arr = array(
                    'type' => 'Users',
                    'name' => $user->full_name,
                    'email' => $user->email1,
                );
                $emails[] = $arr;
            }
        } 
        return $emails;
    }
}


<?php
/**
 * Created by iluxovi4 - Убирайте везде эту подпись
 * Protected by SugarTalk.ru greshdrtju
=======
 */

function sendSugarPHPMail($tos, $subject, $body, $attach="", $nameToSend="", $assigned_user_id, $type ) 
{

    require_once('include/SugarPHPMailer.php');
    require_once('modules/Administration/Administration.php');
     

    global $current_user;
    $mail = new SugarPHPMailer();
    $admin = new Administration();
    $admin->retrieveSettings();
    $user = new User();
  
    
    if($type == 'Realty')
    {
        $user_id = $assigned_user_id;
        
        $user->retrieve($user_id);

        $oe = new OutboundEmail();

        $userSettings = $oe->getUserMailerSettings($user);
        
        if ($admin->settings['mail_sendtype'] == "SMTP") 
        {
            $mail->Host = $admin->settings['mail_smtpserver'];
            $mail->Port = $admin->settings['mail_smtpport'];

            if ($admin->settings['mail_smtpauth_req']) 
            {
                $mail->SMTPAuth = TRUE;
                $mail->Username = $admin->settings['mail_smtpuser'];
                $mail->Password =$admin->settings['mail_smtppass'];
            }

            $mail->Mailer   = "smtp";
            $mail->SMTPKeepAlive = true;

        }
        else
        {
            $mail->mailer = 'sendmail';
        }

        $mail->IsSMTP(); // send via SMTP
        if ($admin->settings['mail_smtpssl'] == '2') $mail->SMTPSecure = "tls";
        elseif ($admin->settings['mail_smtpssl'] == '1') $mail->SMTPSecure = "ssl";
        //$mail->Body = $body."<br/> <b style='color: red;'><strong> Важно! </strong> Ответ присылайте на почту: </b>".$userSettings->mail_smtpuser;
        $mail->Body = $body;
        $mail->From = $admin->settings['notify_fromaddress'];
    }
    elseif($type == 'Contacts' or $type == 'Accounts')
    {
        $user_id = $assigned_user_id;
        
        $user->retrieve($user_id);

        $oe = new OutboundEmail();

        $userSettings = $oe->getUserMailerSettings($user);
        
        if ($userSettings->mail_sendtype == "SMTP") 
        {
            $mail->Host = $admin->settings['mail_smtpserver'];
            $mail->Port = $admin->settings['mail_smtpport'];

            if ($userSettings->mail_smtpauth_req) 
            {
                $mail->SMTPAuth = TRUE;
                $mail->Username = $userSettings->mail_smtpuser;
                $mail->Password =$userSettings->mail_smtppass;
            }

            $mail->Mailer   = "smtp";
            $mail->SMTPKeepAlive = true;

        }
        else
        {
            $mail->mailer = 'sendmail';
        }

        $mail->IsSMTP(); // send via SMTP
        if ($admin->settings['mail_smtpssl'] == '2') $mail->SMTPSecure = "tls";
        elseif ($admin->settings['mail_smtpssl'] == '1') $mail->SMTPSecure = "ssl";
        $mail->Body = $body;
       $mail->From = $user->email1;
    }
    
    //$user->retrieve();
    $mail->CharSet='UTF-8';
   
    $mail->FromName = $admin->settings['notify_fromname'];
    $mail->ContentType = "text/html"; //"text/plain"
    $mail->IsHTML(true);

    $mail->Subject = $subject;
    
    $mail->AddAttachment($attach, $nameToSend);
    
    foreach ($tos as $name => $address)
    {
        $mail->AddAddress("{$address}", "{$name}");
    }

    if (!$mail->send())
    {
        $GLOBALS['log']->info("sendSugarPHPMail - Mailer error: " . $mail->ErrorInfo);
        return false;
    }
    else
    {
        return true;
    }

}

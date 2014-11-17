<?php
function sendSugarPHPMail($tos, $subject, $body)
{

    require_once('include/SugarPHPMailer.php');
    require_once('modules/Administration/Administration.php');

    global $current_user;
    $mail = new SugarPHPMailer();
    $admin = new Administration();
    $admin->retrieveSettings();

    if ($admin->settings['mail_sendtype'] == "SMTP") {
        $mail->Host = $admin->settings['mail_smtpserver'];
        $mail->Port = $admin->settings['mail_smtpport'];

        if ($admin->settings['mail_smtpauth_req']) {
            $mail->SMTPAuth = TRUE;
            $mail->Username = $admin->settings['mail_smtpuser'];
            $mail->Password =$admin->settings['mail_smtppass'];
        }

        $mail->Mailer   = "smtp";
        $mail->SMTPKeepAlive = true;

    }else{
        $mail->mailer = 'sendmail';
    }

    $mail->IsSMTP(); // send via SMTP
    if ($admin->settings['mail_smtpssl'] == '2') $mail->SMTPSecure = "tls";
    elseif ($admin->settings['mail_smtpssl'] == '1') $mail->SMTPSecure = "ssl";
    $mail->CharSet='UTF-8';

    $mail->From     = $admin->settings['notify_fromaddress'];
    $mail->FromName = $admin->settings['notify_fromname'];
    $mail->ContentType = "text/html"; //"text/plain"
    $mail->IsHTML(true);

    $mail->Subject = $subject;
    $mail->Body = $body;

    foreach ($tos as $name => $address){
        $mail->AddAddress("{$address}", "{$name}");
    }

    if (!$mail->send()) {
        $GLOBALS['log']->info("sendSugarPHPMail - Mailer error: " . $mail->ErrorInfo);
        return false;
    }else{
        return true;
    }

}
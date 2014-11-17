<?php

require_once 'custom/include/fpdf17/fpdf.php';
require_once("custom/send_mail.php");
require_once('custom/Presentation/generate.php');
global $sugar_config, $db;

echo "<h3>Генерация презентации</h3><br/>";

$emails = array();
$contact = new Account();
$contact->retrieve($_GET['id']);
$assigned_user_id = $contact->assigned_user_id;
$ass = new User();
$ass->retrieve($assigned_user_id);

$sqlemail = "SELECT email_addresses.email_address 
			FROM email_addresses
			LEFT JOIN email_addr_bean_rel ON email_addr_bean_rel.email_address_id = email_addresses.id AND email_addr_bean_rel.deleted = 0
			WHERE email_addresses.deleted = 0 
			AND bean_id = '{$contact->id}' ";
$resultemail = $db->query($sqlemail);
While($rowemail = $db->fetchByAssoc($resultemail))
{
	$emails[] = $rowemail['email_address'];
}

$sqla = "SELECT realty_id FROM realty_accounts_m_to_m_table WHERE presentation_checked=1 AND account_id = '".$contact->id."' AND deleted = 0";
$resulta = $db->query($sqla);
While($row = $db->fetchByAssoc($resulta))
{
    $pdf = GeneratePresentation($row['realty_id']/*, $contact*/);
    
    $realty = new Realty();
    $realty->retrieve($row['realty_id']);
    
	/*require_once('custom/sms/sms.php');
    $sms = new sms();
    //$sms->parent_type = 'Users';
    $sms->retrieve_settings();
    //$sms->parent_id = $user->id;
    //$sms->pname = $user->full_name;
    //$type = ($bean->object_name == "Call")?"Вам назначен звонок ":"Вам назначена Встреча ";
    $resp = $sms->send_message($ass->phone_mobile, 'Презентация отправлена');
    $resp = $sms->send_message($contact->phone_office, 'Вам на почту отправлена презентация');*/
    
    /*$presentations = new Presentations();
    $presentations->account_id = $contact->id;
    $presentations->realty_id = $realty->id;
    $presentations->name = $pdf;
    $presentations->save();*/
    
    //$body = "Во вложении.";
    
    $body =" 
С уважением<br/>
{$ass->last_name} {$ass->first_name},<br/>
Компания 'Агентство Недвижимости'<br/>
<br/>
Контактный тел.<br/>
офисный:    8(945) 1234567;<br/>
мобильный:	8(945) 1234567;<br/>
{$sugar_config['site_url']}<br/>
<strong style='font-family:Arial,Tahoma,Verdana,sans-serif;font-size:12.800000190734863px;color:red'>Важно! Ответ присылайте на почту:</strong><a target='_blank' href='mailto:{$ass->email1}>{$ass->email1}</a><br/>
";
    
	// $nameToSend = $pdf;
	$nameToSendArr = explode("/",$pdf);
    $nameToSend = $nameToSendArr[5];
    $file_name = $pdf;
    $result = sendSugarPHPMail($emails, 'Презентация ', $body, $file_name, $nameToSend, $assigned_user_id, 'Accounts');
    if($result)
        echo "<span style='color: green; font-size: 14px'>Письмо отправлено</span>";
	else
        echo "<span style='color: red; font-size: 14px'>Что-то пошло не так. Обратитесь к администратору!</span>";
	echo"Ссылка для скачивания презентации - <a href='$pdf'>$pdf</a><br/>";
		// echo (var_export($emails).'Презентация '.$body.$file_name.$nameToSend.$assigned_user_id.'Accounts');
    $db1= DBManagerFactory::getInstance();
    $sql = "UPDATE realty_accounts_m_to_m_table
			SET presentation_checked = 0, presentation_text = 'Презентация отправлена'
			WHERE realty_id = '{$row['realty_id']}'";
    $db1->query($sql);
}

?>

<?php

require_once('custom/include/fpdf17/fpdf.php');
require_once("custom/send_mail.php");
require_once('custom/Presentation/generate.php');

global $sugar_config, $db;

echo "<h3>Генерация презентации</h3><br/>";

$realty = new Realty();
$realty->retrieve($_GET['id']);

$pdf = GeneratePresentation($_GET['id']);

echo " <br/><b>Ссылка для скачивания презентации - <a href='$pdf'>$pdf</a></b><br/>";

//Accounts
$sql = "SELECT account_id FROM realty_accounts_m_to_m_table WHERE presentation_checked=1 AND realty_id = '{$_GET['id']}' AND deleted = 0";
$result = $db->query($sql);
while($row = $db->fetchByAssoc($result))
{
    $emails = array();
    $account = new Account();
    $account->retrieve($row['account_id']);
	$assigned_user_id = $account->assigned_user_id;
    $ass = new User();
    $ass->retrieve($assigned_user_id);

    $dbemail= DBManagerFactory::getInstance();
    $sqlemail = "SELECT email_addresses.email_address
        FROM email_addresses
        LEFT JOIN email_addr_bean_rel ON email_addr_bean_rel.email_address_id = email_addresses.id AND email_addr_bean_rel.deleted = 0
        WHERE email_addresses.deleted = 0
        AND bean_id = '{$account->id}' ";

    $resultemail = $dbemail->query($sqlemail);
    while($rowemail = $dbemail->fetchByAssoc($resultemail))
    {
        $emails[] = $rowemail['email_address'];
    }


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

    $nameToSendArr = explode("/",$pdf);
    $nameToSend = $nameToSendArr[5];
    $file_name = $pdf;
    $result1 = sendSugarPHPMail($emails, 'Презентация ', $body, $file_name, $nameToSend, $assigned_user_id, 'Realty');
    if($result1)
        echo "<br/><span style='color: green; font-size: 14px'>Письмо отправлено</span><br/>";
    else
        echo "<br/><span style='color: red; font-size: 14px'>Что-то пошло не так. Обратитесь к администратору!</span><br/>";
    $db1= DBManagerFactory::getInstance();
    $sql2 = "UPDATE realty_accounts_m_to_m_table
			SET presentation_checked = 0, SET presentation_text = 'Презентация отправлена'
			WHERE realty_id = '{$_GET['id']}' AND account_id = '{$account->id}'";
    $db2->query($sql2);
}

//Contacts
$sql = "SELECT contact_id FROM realty_contacts_table WHERE presentation_checked=1 AND realty_id = '{$_GET['id']}' AND deleted = 0";
$result = $db->query($sql);
while($row = $db->fetchByAssoc($result))
{
    $emails = array();
    $contact = new Contact();
    $contact->retrieve($row['contact_id']);
	$assigned_user_id = $contact->assigned_user_id;
    $ass = new User();
    $ass->retrieve($assigned_user_id);

    $dbemail= DBManagerFactory::getInstance();
    $sqlemail = "SELECT email_addresses.email_address
        FROM email_addresses
        LEFT JOIN email_addr_bean_rel ON email_addr_bean_rel.email_address_id = email_addresses.id AND email_addr_bean_rel.deleted = 0
        WHERE email_addresses.deleted = 0
        AND bean_id = '".$contact->id."'
            ";
    $resultemail = $dbemail->query($sqlemail);
    while($rowemail = $dbemail->fetchByAssoc($resultemail))
    {
        $emails[] = $rowemail['email_address'];
    }


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

    $nameToSendArr = explode("/",$pdf);
    $nameToSend = $nameToSendArr[5];
    $file_name = $pdf;
    $result2 = sendSugarPHPMail($emails, 'Презентация ', $body, $file_name, $nameToSend, $assigned_user_id, 'Realty');
    if($result2)
        echo "<br/><span style='color: green; font-size: 14px'>Письмо отправлено</span><br/>";
    else
        echo "<br/><span style='color: red; font-size: 14px'>Что-то пошло не так. Обратитесь к администратору!</span><br/>";
    $db1= DBManagerFactory::getInstance();
    $sql2 = "UPDATE realty_contacts_table
		SET presentation_checked = 0, presentation_text = 'Презентация отправлена'
		WHERE realty_id = '{$_GET['id']}' AND contact_id = '{$contact->id}'";
    $db1->query($sql2);
}

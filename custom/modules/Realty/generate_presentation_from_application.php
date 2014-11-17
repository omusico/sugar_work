<?php

require_once 'custom/include/fpdf17/fpdf.php';
require_once("custom/send_mail.php");
require_once('custom/Presentation/generate.php');
global $sugar_config, $db, $current_user;

echo "<h3>Генерация презентации</h3><br/>";

$emails = array();
$realty_id = $_GET['id'];
$realty = new Realty();
$realty->retrieve($realty_id);
$my_user_id = $current_user -> id;

$rec = new Request();

$sql_c = "SELECT request_id FROM realty_requests_interest_table WHERE presentation_checked=1 AND realty_id = '".$realty_id."' AND deleted = 0";
$result_c = $db->query($sql_c);

while($row_c = $db->fetchByAssoc($result_c))
{
	$rec->retrieve($row_c['request_id']);
	$parent_id = $rec->parent_id;

	$sqlemail = "SELECT email_addresses.email_address 
			FROM email_addresses
			LEFT JOIN email_addr_bean_rel ON email_addr_bean_rel.email_address_id = email_addresses.id AND email_addr_bean_rel.deleted = 0
			WHERE email_addresses.deleted = 0 
			AND bean_id = '{$parent_id}' ";

	$resultemail = $db->query($sqlemail);
	$rowemail = $db->fetchByAssoc($resultemail);
	$emails[] = $rowemail['email_address'];

    $pdf = GeneratePresentation($realty_id);
    
    $body =" 
	С уважением<br/>
	{$current_user->last_name} {$current_user->first_name},<br/>
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

    $result2 = sendSugarPHPMail($emails, 'Презентация ', $body, $file_name, $nameToSend, $my_user_id, 'Realty');//Realty
	
    if($result2)
        echo "<span style='color: green; font-size: 14px'>Письмо отправлено</span>";
	else
        echo "<span style='color: red; font-size: 14px'>Что-то пошло не так. Обратитесь к администратору!</span>";
	echo"Ссылка для скачивания презентации - <a href='$pdf'>$pdf</a><br/>";
    $db1= DBManagerFactory::getInstance();
    $sql2 = "UPDATE realty_requests_interest_table
			SET presentation_checked = 0, presentation_text = 'Презентация отправлена'
			WHERE realty_id = '{$realty_id}'";
    $db1->query($sql2);
        
    $sql3 = "UPDATE request
			SET send_presentation = 1
			WHERE parent_id = '{$parent_id}'";
    $result_3 = $db->query($sql3);
}
?>

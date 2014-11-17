<?php 
if(!defined('sugarEntry')) define('sugarEntry', true);
include_once('modules/Configurator/Configurator.php'); 
require_once('custom/sms/sms.php'); 
include_once('sugar_version.php');

if(!defined("MSG_UNVERIFIED")) 
	define("MSG_UNVERIFIED", "Невозможно подключить ваш аккаунт. Пожалуйста, повторите попытку или свяжитесь с провайдером для проверки.");

$sms = new sms();
$parent_link = "<a href='index.php?module=Administration&action=index'>Administration</a><span class='pointer'>&raquo;</span>";
 

	// just draw the gateway settings panel
	// $_POST['account_id'] = '123';
	if (isset($_POST['account_id'])) {
		$flag = (isset($_POST['use_template'])) ? true : false;
		$sms->params['sms_instance_id'] = trim($_POST['account_id']);
		$sms->params['uses_sms_template'] = $flag;
		$sms->params['sugartalk_url'] = trim($_POST['sugartalk_url']);
		$sms->params['sender'] = trim($_POST['sender']);
        if (empty($_POST['domain_name']))
            $sms->params['domain_name'] = '1';
        else
		    $sms->params['domain_name'] = trim($_POST['domain_name']);
		$sms->params['default_country_code'] = trim($_POST['default_country_code']);
		$sms->params['local_prefix'] = trim($_POST['local_prefix']);
		$sms->save_settings();
        //echo "Настройки успешно сохраненины";
        SugarApplication::redirect('index.php?module=Administration&action=index');
    }
	   
 	include_once("modules/Administration/sugartalk_smsPhone/smsPhone.js.php");
 	$sms->retrieve_settings();
	

	

		// show settings
		$sugartalk_url = !empty($sms->params['sugartalk_url']) ? $sms->params['sugartalk_url'] : "";
		$account_id = !empty($sms->params['sms_instance_id']) ? $sms->params['sms_instance_id'] : "";
		$sender = !empty($sms->params['sender']) ? $sms->params['sender'] : "";
		$domain_name = !empty($sms->params['domain_name']) ? $sms->params['domain_name'] : "";	 	//security code
		$uses_sms_template = !empty($sms->params['uses_sms_template']) ? $sms->params['uses_sms_template'] : false;
		$chk = $uses_sms_template==true ? "checked" : "";
		
		$default_country_code = !empty($sms->params['default_country_code']) ? $sms->params['default_country_code'] : "";
		$local_prefix = isset($sms->params['local_prefix']) ? $sms->params['local_prefix'] : "";
		
		echo "<div class='moduleTitle'><h2>{$parent_link}Настройки SMS счета</h2></div>";
		echo "<form method='post' id='frm_settings' action='./index.php?module=sugartalk_SMS&action=smsProvider'>";
		echo "<div id='LBL_CONTACT_INFORMATION' class='detail view'>";
		echo "<table  border='1' cellspacing='0' cellpadding='0' class='other view'>";

		echo "<tr><td style='text-align:left;' scope='row' width='20%'>Публичный ключ:</td>";
		echo "<td width='80%'><input type='text' style='width:100%;' name='account_id' value='{$account_id}'></td></tr>";
                echo "<tr><td style='text-align:left;' scope='row' width='20%'>Приватный ключ:</td>";
                echo "<td width='80%'><input type='text' style='width:100%;' name='domain_name' value='{$domain_name}' title='Complete instance URL'></td></tr>";

                echo "<tr><td style='text-align:left;' scope='row' width='20%'>Имя отправителя:</td>";
                echo "<td width='80%'><input type='text' style='width:100%;' name='sender' value='{$sender}'></td></tr>";


		echo "</table>";

		
		echo "<div id='response_text' style='color:red;'></div>"; 

		echo "<input type='button' class='button' value='Сохранить' onclick='submit();' ></div>";
                echo "<input type='button' class='button' value='Проверить счет' onclick='balance();' ></div>";
		echo "</form>";	



?>
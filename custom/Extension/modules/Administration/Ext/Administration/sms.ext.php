<?php 
			
$admin_option_defs = array();

$admin_option_defs['Administration']['config1'] = array(
				'icon_AdminMobile',
				'Настройка шлюза',
				"Настройка учетной записи, для рассылки SMS",
				'./index.php?module=sugartalk_SMS&action=smsProvider'
		); 

$admin_option_defs['Administration']['config2']= array(
				'icon_AdminMobile',
				'Связь SMS с другими модулями',
				'Настройка соответствующих модулей для SMS',
				'./index.php?module=Administration&action=customUsage'
		);
		
$admin_option_defs['Administration']['config3'] = array(
				'icon_AdminMobile',
				'Выбор полей',
				'Выберите телефонные номера, для отправки SMS',
				'./index.php?module=Administration&action=smsPhone'
		);  
//
//$admin_option_defs['Administration']['config4']= array(
//				'icon_AdminMobile',
//				'SMS Credit Balance',
//				"Check your account's available credits",
//				'./index.php?module=Administration&action=smsProvider&option=smsBalance'
//		);
//
//$admin_option_defs['Administration']['config5']= array(
//				'icon_AdminMobile',
//				'Credit Usages',
//				"Check your credit usage trend",
//				'./index.php?module=Administration&action=smsProvider&option=smsUsage'
//		);
// $admin_option_defs['Administration']['config5']= array(
				// 'icon_AdminMobile',
				// 'SMS Macro',
				// 'Sets SMS macro for every module',
				// './index.php?module=Administration&action=smsProvider&option=macro'
		// );
				
$admin_group_header[]= array(
				'Short Message Service (SMS)',
				'',
				false,
				$admin_option_defs, 
				'Модуль интеграции SMS.'
		);
		
?>
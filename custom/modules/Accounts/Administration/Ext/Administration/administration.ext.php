<?php 
 //WARNING: The contents of this file are auto-generated


if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

global $sugar_config;


    $admin_option_defs = array();
	$admin_option_defs['Administration']['simple_chat'] = array(
		'Administration',
		'LBL_SIMPLECHAT_TITLE',
		'LBL_SIMPLECHAT_DESCRIPTION',
		'index.php?module=let_Chat&action=settings&return_module=Administration&return_action=index'
	);
    $admin_option_defs['Administration']['simple_chat_feedback'] = array(
		'EmailFolder',
		'LBL_SIMPLECHAT_FEEDBACK_TITLE',
		'LBL_SIMPLECHAT_FEEDBACK_DESCRIPTION',
		'index.php?module=let_Chat&action=proposals&return_module=Administration&return_action=index'
	);
    $admin_option_defs['Administration']['simple_chat_check'] = array(
		'sugarupdate',
		'LBL_SIMPLECHAT_CHECK_TITLE',
		'LBL_SIMPLECHAT_CHECK_DESCRIPTION',
		'index.php?module=let_Chat&action=new_version&return_module=Administration&return_action=index'
	);
    $admin_option_defs['Administration']['simple_chat_aboutus'] = array(
		'Users',
		'LBL_SIMPLECHAT_ABOUTUS_TITLE',
		'LBL_SIMPLECHAT_ABOUTUS_DESCRIPTION',
		'index.php?module=let_Chat&action=index&return_module=Administration&return_action=index'
	);

	$admin_group_header[]= array(
		'LBL_SIMPLECHAT_ACTIONS_TITLE',
		'',
		false,
		$admin_option_defs,
		'LBL_SIMPLECHAT_ACTIONS_DESC'
	);










$admin_option_defs = array();

$admin_option_defs['Administration']['listtemplates'] = array('OfficeReportMerge', 'TH_LISTREPORT_TITLE','TH_LISTREPORT_DESC','index.php?module=OfficeReportsMerge&action=index');
$admin_option_defs['Administration']['listtemplatevariable'] = array('TemplateVariables', 'TH_LISTTEMPLATEVARIABLE_TITLE','TH_LISTTEMPLATEVARIABLE_DESC','index.php?module=OfficeReportsVariables&action=index');

$admin_option_defs['Administration']['createtemplate'] = array('CreateOfficeReportMerge', 'TH_CREATEREPORT_TITLE','TH_CREATEREPORT_DESC','index.php?module=OfficeReportsMerge&action=EditView');
$admin_option_defs['Administration']['createtemplatevariable'] = array('CreateTemplateVariables', 'TH_CREATETEMPLATEVARIABLE_TITLE','TH_CREATETEMPLATEVARIABLE_DESC','index.php?module=OfficeReportsVariables&action=EditView');

$admin_option_defs['Administration']['officereporthistory'] = array('OfficeReportHistory', 'TH_OFFICEREPORTHISTORY_TITLE','TH_OFFICEREPORTHISTORY_DESC','index.php?module=OfficeReportsHistory&action=index');
//$admin_option_defs['Administration']['codetemplatevariable'] = array('TempateVariablesForMerge', 'TH_CODEVARIABLE_TITLE','TH_CODEVARIABLE_DESC','index.php?module=OfficeReportsVariables&action=showCode');

$admin_option_defs['Administration']['settings'] = array('ReportSettings', 'TH_SETTINGSREPORT_TITLE','TH_SETTINGSREPORT_DESC','index.php?module=OfficeReportsMerge&action=Settings');

$admin_group_header[]= array('LBL_OFFICEREPORT_ADMIN_TITLE', '', false, $admin_option_defs, 'LBL_OFFICEREPORT_ADMIN_DESCRIPTION');


 
			
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
		


//Included to provide a little security to the system
require_once('config.php');
//**********************************************************************************
//   Home Page Manager Admin Menu File
//**********************************************************************************
$admin_option_defs=array();
$admin_option_defs['hpm']= array('Users','LBL_DEFAULT_HOMEPAGE','LBL_DEFAULT_HOMEPAGE','index.php?module=Users&action=EditHomepageSettings');
$admin_group_header[0][3]['Users']=array_merge($admin_group_header[0][3]['Users'],$admin_option_defs);
//**********************************************************************************
//   END Home Page Manager Admin Menu File
//**********************************************************************************

?>
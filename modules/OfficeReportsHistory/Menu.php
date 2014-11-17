<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

global $mod_strings, $app_strings, $sugar_config, $current_user;

if(ACLController::checkAccess('OfficeReportsHistory', 'list', true))
	$module_menu[]=Array("index.php?module=OfficeReportsHistory&action=index&return_module=OfficeReportsHistory&return_action=DetailView", $mod_strings['LNK_LIST'], 'OfficeReportHistory', 'OfficeReportHistory');


<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

global $mod_strings, $app_strings, $sugar_config, $current_user;

if(ACLController::checkAccess('OfficeReportsMerge', 'edit', true))
	$module_menu[]=Array("index.php?module=OfficeReportsMerge&action=EditView&return_module=OfficeReportsMerge&return_action=DetailView", $mod_strings['LNK_NEW_RECORD'], 'CreateOfficeReportMerge', 'OfficeReportsMerge');

if(ACLController::checkAccess('OfficeReportsMerge', 'list', true))
	$module_menu[]=Array("index.php?module=OfficeReportsMerge&action=index&return_module=OfficeReportsMerge&return_action=DetailView", $mod_strings['LNK_LIST'], 'OfficeReportMerge', 'OfficeReportsMerge');


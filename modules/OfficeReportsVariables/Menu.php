<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

global $mod_strings, $app_strings, $sugar_config, $current_user;

if(ACLController::checkAccess('OfficeReportsVariables', 'edit', true))
	$module_menu[]=Array("index.php?module=OfficeReportsVariables&action=EditView&return_module=OfficeReportsVariables&return_action=DetailView", $mod_strings['LNK_NEW_RECORD'], 'CreateOfficeReportsVariables', 'OfficeReportsVariables');

if(ACLController::checkAccess('OfficeReportsVariables', 'list', true))
	$module_menu[]=Array("index.php?module=OfficeReportsVariables&action=index&return_module=OfficeReportsVariables&return_action=DetailView", $mod_strings['LNK_LIST'], 'OfficeReportsVariables', 'OfficeReportsVariables');


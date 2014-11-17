<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); 


global $mod_strings, $app_strings, $sugar_config;
	if(ACLController::checkAccess('Realty', 'edit', true))$module_menu[] = Array("index.php?module=Realty&action=EditView&return_module=Realty&return_action=index", $mod_strings['LNK_NEW_REALTY'],"RealtyImage", 'Realty');
	if(ACLController::checkAccess('Realty', 'list', true))$module_menu[] =Array("index.php?module=Realty&action=index&return_module=Realty&return_action=DetailView", $mod_strings['LNK_REALTY_LIST'],"RealtyImage", 'Realty');
	if(ACLController::checkAccess('Realty', 'import', true))$module_menu[] =Array("index.php?module=Import&action=Step1&import_module=Realty&return_module=Realty&return_action=index", $mod_strings['LNK_IMPORT_REALTY'],"Import", 'Realty');

?>
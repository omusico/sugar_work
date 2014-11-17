<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); 


global $mod_strings, $app_strings, $sugar_config;
	if(ACLController::checkAccess('RealtyTemplates', 'edit', true))$module_menu[] = Array("index.php?module=RealtyTemplates&action=EditView&return_module=RealtyTemplates&return_action=index", $mod_strings['LNK_NEW_REALTY'],"RealtyImage", 'RealtyTemplates');
	if(ACLController::checkAccess('RealtyTemplates', 'list', true))$module_menu[] =Array("index.php?module=RealtyTemplates&action=index&return_module=RealtyTemplates&return_action=DetailView", $mod_strings['LNK_REALTY_LIST'],"RealtyImage", 'RealtyTemplates');
	if(ACLController::checkAccess('RealtyTemplates', 'import', true))$module_menu[] =Array("index.php?module=Import&action=Step1&import_module=RealtyTemplates&return_module=RealtyTemplates&return_action=index", $mod_strings['LNK_IMPORT_REALTY'],"Import", 'RealtyTemplates');

?>
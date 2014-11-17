<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once ('include/SubPanel/SubPanelDefinitions.php');

global $current_user;
global $mod_strings, $app_strings, $app_list_strings;

if (!is_admin($current_user))
{
	sugar_die("Unauthorized access to administration.");
}

if(isset($_REQUEST['process']) && $_REQUEST['process'] == 'true')
{
	$_REQUEST['officeDocxExcludeModules'] = explode(':', $_REQUEST['officeDocxExcludeModules']);
	$config = Reports_Utils::set_config($_REQUEST);
	header('Location: index.php?module=OfficeReportsMerge&action=Settings');
}

$focus = new OfficeReportMerge();
$ss	= new Sugar_Smarty();

$config = Reports_Utils::get_config();

$listEnableModules = Reports_Utils::available_modules();
$listDisableModules = $config['officeDocxExcludeModules'];

if (!is_array($listDisableModules)) $listDisableModules = array();

$enabled = array();
foreach ($listEnableModules as $key)
{
	if(empty($key)) continue;

	if (isset($app_list_strings['moduleList'][$key]))
	{
		$label = $app_list_strings['moduleList'][$key];
	}
	else
	{
		$label = $key;
	}
	$enabled[] =  array("module" => $key, "label" => $label);
}

$disabled = array();
foreach ($listDisableModules as $key)
{
	if(empty($key)) continue;
	if (isset($app_list_strings['moduleList'][$key]))
	{
		$label = $app_list_strings['moduleList'][$key];
	}
	else
	{
		$label = $key;
	}
	$disabled[] =  array("module" => $key, "label" => $label);
}

$ss->assign('MOD', $mod_strings);
$ss->assign('APP', $app_strings);
$ss->assign('APP_LIST', $app_list_strings);
$ss->assign("config", $config);

$ss->assign('enabled_modules', json_encode($enabled));
$ss->assign('disabled_modules', json_encode($disabled));

$ss->assign("MODULE_NAME", $focus->module_dir);
$ss->assign("ACTION_NAME", 'Settings');


$ss->display('modules/' . $focus->module_dir . '/tpl/Settings.tpl');
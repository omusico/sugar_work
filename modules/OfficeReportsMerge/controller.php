<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once 'include/controller/Controller.php';
require_once 'custom/include/OfficeReportsMerge/Reports/Utils.php';
require_once 'custom/include/OfficeReportsMerge/Reports/Merge/Utils.php';

class OfficeReportsMergeController extends SugarController
{
	public function __construct()
	{
		parent::SugarController();
	}

	protected function action_getOfficeForm()
	{
		global $mod_strings, $currentModule;

		$this->view = 'getofficeform';
		if (!isset($_REQUEST['report_module']) OR empty($_REQUEST['report_module'])
			OR !isset($_REQUEST['record']) OR empty($_REQUEST['record']))
		{
			sugar_die($mod_strings['ERR_REPORT_PARAMS']);
		}

		if (!in_array($_REQUEST['report_module'], Reports_Utils::available_modules()))
		{
			sugar_die($mod_strings['ERR_REPORT_PARAMS']);
		}

		if (!Reports_Utils::check_access_report($currentModule, $_REQUEST['record'], 'export'))
		{
			sugar_die($mod_strings['ERR_RIGHTS_FOR_EXPORT']);
		}
	}


}
<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/MVC/View/views/view.edit.php');

class OfficeReportsMergeViewEdit extends ViewEdit
{

 	function __construct()
 	{
		parent::SugarView();
	}

 	function display()
 	{
 		global $app_list_strings;

 		$this->ev->process();

 		$modules = Reports_Utils::available_modules();
 		foreach ($modules as $key => &$val)
 		{
 			if (isset($app_list_strings['moduleList'][$key]))
			{
				$val = $app_list_strings['moduleList'][$key];
			}
 		}
 		$this->ss->assign('AVAILABLE_MODULES', get_select_options_with_id($modules, $this->bean->report_module));

		$options_fields = '';
		$fields = unencodeMultienum($this->bean->report_vars);
		foreach ($fields as $field)
		{
			if (empty($field)) continue;
			$options_fields .= '<option value="' . $field . '">' . Reports_Utils::translateField($field, $this->bean->report_module) . '</option>';
		}
		$this->ss->assign('REPORT_FIELDS', $options_fields);

		echo $this->ev->display($this->showTitle);
	}


}

?>
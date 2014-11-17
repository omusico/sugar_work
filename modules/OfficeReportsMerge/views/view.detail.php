<?php

require_once('include/MVC/View/views/view.detail.php');

class OfficeReportsMergeViewDetail extends ViewDetail
{

 	function __construct()
 	{
 		parent::ViewDetail();
 	}

 	function display()
 	{
		$output = array();
		$fields = unencodeMultienum($this->bean->report_vars);
		foreach ($fields as $field)
		{
			if (strpos($field, '.'))
			{
				list($module_name, $field_name) = explode('.', $field, 2);
				if (!isset($output[$module_name]))
				{
					$output[$module_name] = array();
				}

				$output[$module_name][$field_name] = Reports_Utils::translateField($field, '', false);
			}
			else
			{
				$output[$field] = Reports_Utils::translateField($field, $this->bean->report_module);
			}

			$html = '<ul>';

			//krsort($output);

			foreach ($output as $key => $field)
			{
				if (is_array($field))
				{
					$html .= "<li><b>{$key}</b></li><ul>";
					foreach ($field as $rel_key => $rel_field)
					{
						$html .= "<li>{$rel_field}&nbsp;&nbsp;&nbsp;<input type='text' size=25 value='[{$key}.{$rel_key}]'></li>";
					}
					$html .= '</ul>';
				}
				else
				{
					$html .= "<li>{$field}&nbsp;&nbsp;&nbsp;<input type='text' size=25 value='[{$key}]'></li>";
				}
			}
			$html .= '</ul>';

        }

		$this->ss->assign('REPORT_VARS_TREE', $html);

        $this->ss->assign('DOWNLOAD_TEMPLATE_LINK', $this->bean->getStoredFileName());

 		parent::display();
 	}
}
?>
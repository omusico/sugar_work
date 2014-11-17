<?php
require_once('include/EditView/EditView2.php');

class OfficeReportsVariablesViewShowcode extends SugarView
{
 	protected $ev;
 	public $type = 'edit';
 	public $useForSubpanel = false;  //boolean variable to determine whether view can be used for subpanel creates
 	public $useModuleQuickCreateTemplate = false; //boolean variable to determine whether or not SubpanelQuickCreate has a separate display function
 	public $showTitle = true;


 	public function __construct()
 	{
		if (isset($_REQUEST['as_frame']) AND $_REQUEST['as_frame'] == "true")
		{
			$this->options = array('show_header' => true, 'show_title' => false, 'show_subpanels' => false, 'show_search' => false, 'show_footer' => false, 'show_javascript' => true, 'view_print' => true,);
			$this->showTitle = false;
		}
 		parent::SugarView();
 	}

 	public function preDisplay()
 	{
		 if(file_exists("cache/modules/OfficeReportsVariables/EditView.tpl"))
			       unlink("cache/modules/OfficeReportsVariables/EditView.tpl");

 		$metadataFile = null;

		$metaFileName = 'showcode';
		if (isset($_REQUEST['metafile']) AND !empty($_REQUEST['metafile']))
		{
			$metaFileName = $_REQUEST['metafile'];
		}

		if (file_exists('custom/modules/' . $this->module . '/metadata/' . $metaFileName . '.php'))
		{
			$metadataFile = 'custom/modules/' . $this->module . '/metadata/' . $metaFileName . '.php';
 		}
		elseif ('modules/' . $this->module . '/metadata/' . $metaFileName . '.php')
		{
			$metadataFile = 'modules/' . $this->module . '/metadata/' . $metaFileName . '.php';
		}
		else
		{
			$metadataFile = 'modules/' . $this->module . '/metadata/editviewdefs.php';
		}

 		$this->ev = new EditView();
 		$this->ev->ss = &$this->ss;
 		$this->ev->setup($this->module, $this->bean, $metadataFile, 'include/EditView/EditView.tpl');
 	}


 	public function display()
 	{
 		global $app_list_strings;

		$modules = Reports_Utils::available_modules();
		foreach ($modules as $key => &$val)
		{
			if (isset($app_list_strings['moduleList'][$key]))
			{
				$val = $app_list_strings['moduleList'][$key];
			}
		}
		asort($modules);

		if (isset($_REQUEST['report_module']) AND !empty($_REQUEST['report_module']))
		{
			$cur_module = $_REQUEST['report_module'];
		}
		else
		{
			$ind = array_keys($modules);
			$cur_module = $ind[0];
		}

		$this->ss->assign('AVAILABLE_MODULES', get_select_options_with_id($modules, $cur_module));

		$related_modules = Reports_Utils::getRelatedModules($cur_module);
		$related_modules[''] = '';
		asort($related_modules);
		$this->ss->assign('RELATED_MODULES', get_select_options_with_id($related_modules, ''));

		$module_fields = Reports_Utils::getModuleFields($cur_module);
		asort($module_fields);
		$this->ss->assign('MODULE_FIELDS', get_select_options_with_id($module_fields, ''));

		$module_fields = Reports_Utils::getModuleFields($cur_module);
		asort($module_fields);
		$this->ss->assign('MODULE_FIELDS', get_select_options_with_id($module_fields, ''));

		$custom_fields = Reports_Utils::getReportCustomFields($cur_module);
		$this->ss->assign('CUSTOM_FIELDS', get_select_options_with_id($custom_fields, ''));

		$this->ev->process();
		echo $this->ev->display($this->showTitle);
 	}

}
?>
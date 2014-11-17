<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class OfficeReportsMergeViewGetofficeform extends SugarView
{
	public $options = array('show_header' => false, 'show_title' => false, 'show_subpanels' => false, 'show_search' => false, 'show_footer' => false, 'show_javascript' => false, 'view_print' => false, 'show_all' => false, );

	// var with path to tpl
	protected $tpl = '';
	private $report_module;
	private $record;

 	public function __construct()
 	{
 		parent::SugarView();

 		// this request vars check in controller
 		$this->report_module = $_REQUEST['report_module'];
 		$this->record = $_REQUEST['record'];
 	}

 	public function process()
 	{
 		global $beanList, $beanFiles;

 		$this->tpl = 'modules/' . $this->module . '/tpl/' . strtolower($this->action) . '.tpl';
		$ss = &$this->ss;

 		$templates = Reports_Utils::getListTemplate($this->report_module);

 		$select = array();
 		$objects_array = array();
 		if (!empty($templates))
 		{
			foreach ($templates as $template)
			{
				$select[$template->id] = $template->name;
				$objects_array[$template->id] = $template->toArray();
			}
 		}

 		$ss->assign('AVAILABLE_TEMPLATES', get_select_options_with_id($select, ''));

		$json = getJSONobj();
 		$ss->assign('JSON_TEMPLATES', $json->encode($objects_array) );

        //current format is first format in list templates
 		$this->ss->assign('CURRENT_FORMAT', strtoupper($templates[0]->extension_template));

        if (isset($beanList[$this->report_module]))
		{
			require_once $beanFiles[$beanList[$this->report_module]];
			$seed = new $beanList[$this->report_module];
			$seed->retrieve($this->record);

			$ss->assign("fields", $seed->toArray());
		}
		else
		{
			$ss->assign("fields", array() );
		}

		$email_templates_arr = get_bean_select_array(true, 'EmailTemplate','name', '','name', true);
		$email_templates_select = get_select_options_with_id($email_templates_arr, '');
		$ss->assign("EMAIL_TEMPLATES", $email_templates_select);

 		//get theme
 		$themeObject = SugarThemeRegistry::current();
        $theme = $themeObject->__toString();

        $ss->assign("THEME", $theme);
 		$ss->assign("MODULE_NAME", $this->module);
 		$ss->assign("ACTION_NAME", $this->action);

 		$this->display();
 	}

 	public function display()
 	{
		echo $this->ss->fetch($this->tpl);
 	}

}
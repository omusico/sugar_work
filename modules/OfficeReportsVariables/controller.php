<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once 'include/controller/Controller.php';
require_once 'custom/include/OfficeReportsMerge/Reports/Utils.php';
require_once 'custom/include/OfficeReportsMerge/Reports/Merge/Utils.php';

class OfficeReportsVariablesController extends SugarController
{
    public function __construct()
    {
        parent::SugarController();
    }

    public function process()
    {
        global $app_list_strings;

        $app_list_strings['report_available_modules'] = Reports_Utils::available_modules(FALSE);

        foreach ($app_list_strings['report_available_modules'] as $key => &$val)
        {
            if (isset($app_list_strings['moduleList'][$key]))
            {
                $val = $app_list_strings['moduleList'][$key];
            }
        }

        parent::process();
    }

//	protected function action_showCode()
//	{
//		$this->view = 'showcode';
//	}

    protected function action_RelatedModules()
    {
        if (!empty($_REQUEST['report_module']))
        {
            $cur_module = $_REQUEST['report_module'];
            $dropdown = Reports_Utils::getRelatedModules($cur_module);
            $dropdown[''] = '';
            asort($dropdown);
            echo get_select_options_with_id($dropdown, '');
            exit();
        }
        else
        {
            sugar_die('Need report module name');
        }
    }

    protected function action_ModuleFields()
    {
        global $mod_strings;

        if (!empty($_REQUEST['relate_module']))
        {
            $cur_module = $_REQUEST['relate_module'];
            $module_fields = Reports_Utils::getModuleFields($cur_module);
            asort($module_fields);

            echo "<optgroup label='{$mod_strings['LBL_MODULE_FIELDS']}'>";
            echo get_select_options_with_id($module_fields, '');
            echo "</optgroup>";

            $custom_fields = Reports_Utils::getReportCustomFields($cur_module);

            echo "<optgroup label='{$mod_strings['LBL_CUSTOM_FIELDS']}'>";
            echo get_select_options_with_id($custom_fields, '');
            echo "</optgroup>";
            exit();
        }
        else
        {
            sugar_die('Need module name');
        }
    }

    public function pre_save()
    {
        $this->dieIfNotAdmin();
        parent::pre_save();
    }

    protected function action_delete()
    {
        $this->dieIfNotAdmin();
        parent::action_delete();
    }

    protected function action_massupdate()
    {
        $this->dieIfNotAdmin();
        parent::action_massupdate();
    }

    private function processView()
    {
        $view = ViewFactory::loadView($this->view, $this->module, $this->bean, $this->view_object_map, $this->target_module);
        $GLOBALS['current_view'] = $view;
        if(!empty($this->bean) && !$this->bean->ACLAccess($view->type) && $view->type != 'list'){
            ACLController::displayNoAccess(true);
            sugar_cleanup(true);
        }
        if(isset($this->errors)){
            $view->errors = $this->errors;
        }
        $view->process();
    }

    private function dieIfNotAdmin()
    {
        global $current_user;
        if (!is_admin($current_user))
        {
            ACLController::displayNoAccess(true);
            sugar_cleanup(true);
        }
    }


}
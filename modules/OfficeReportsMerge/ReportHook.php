<?php
if(!defined('sugarEntry'))define('sugarEntry', true);

require_once 'custom/include/OfficeReportsMerge/Reports/Utils.php';

class ReportHook
{

	public function addButton($event, $arguments)
	{
		if ($this->checkView() AND $this->checkModule() AND $this->checkAccess()
            AND empty($GLOBALS['officereport_already_fired']) AND $this->existForCurrentModule())
		{
			$GLOBALS['officereport_already_fired'] = true;

			$officeModuleName = 'OfficeReportsMerge';

            $content = file_get_contents("modules/$officeModuleName/javascript/officeloader.js");

            global $sugar_config;

            if (preg_match('/^6\.5/',$sugar_config['sugar_version']))
            {
                $html = <<<EOQ
<script type="text/javascript">$content</script>
			<script type="text/javascript">
			var OfficeParams = { "module" : "{$_REQUEST['module']}", "record" : "{$_REQUEST['record']}"};
			var OfficeLazyLoad = true;
			YAHOO.util.Event.onDOMReady(officeCreateReportButton65);
			</script>
EOQ;
            }
            else
            {
                $html = <<<EOQ
			<script type="text/javascript">$content</script>
			<script type="text/javascript">
			var OfficeParams = { "module" : "{$_REQUEST['module']}", "record" : "{$_REQUEST['record']}"};
			var OfficeLazyLoad = true;
			YAHOO.util.Event.onDOMReady(officeCreateReportButton);
			</script>
EOQ;
            }

			echo $html;
		}
	}

	private function checkView()
	{
		if (isset($_REQUEST['action']) AND $_REQUEST['action'] == 'DetailView'
			AND empty($_REQUEST['to_pdf']) AND empty($_REQUEST['to_csv']))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	private function checkModule()
	{
		global $currentModule;

		return in_array($currentModule, Reports_Utils::available_modules());
	}

    private function existForCurrentModule()
    {
        global $currentModule;
        $seed = new OfficeReportMerge();

        $listing_result = $seed->get_list('', ' report_module=\'' . $currentModule . '\'', 0, 1);

        if ($listing_result['row_count'] > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

	private function checkAccess()
	{
		global $currentModule;

		if (isset($_REQUEST['record']) AND !empty($_REQUEST['record']))
		{
			return Reports_Utils::check_access_report($currentModule, $_REQUEST['record'], 'export');
		}
		else
		{
			return FALSE;
		}
	}

}

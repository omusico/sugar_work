<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

error_reporting(0); //switch off all error because result file will be invalid format
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

require_once 'custom/include/OfficeReportsMerge/Reports/Merge/Utils.php';
require_once 'custom/include/OfficeReportsMerge/Reports/Utils.php';

global $beanList, $beanFiles, $currentModule;
global $mod_strings, $sugar_config;
global $current_user;

// get settings
$answer = array();
$officeParams = array();
$patternSettings = 'officeTemplate';
foreach ($_REQUEST as $key => $val)
{
	if (strpos($key, $patternSettings) === 0)
		$officeParams[strtolower(substr($key, strlen($patternSettings)))] = $val;
}

$record_id = $_REQUEST['record'];
if (empty($record_id) OR empty($officeParams['record']))
{
	sugar_die($mod_strings['ERR_REPORT_BEAN']);
}

$bean = new OfficeReportMerge();
$bean->retrieve($record_id);

$format = strtolower($bean->extension_template);

// check user rights on this report
if (!Reports_Utils::check_access_report($currentModule, $record_id, 'detail'))
{
	sugar_die($mod_strings['ERR_REPORT_BEAN']);
}

// check user rights on this record
if (!Reports_Utils::check_access_report($bean->report_module, $officeParams['record'], 'export'))
{
	sugar_die($mod_strings['ERR_REPORT_BEAN']);
}

$officeConfig = Reports_Utils::get_config();

if (isset($officeParams['link']))
{
	//need download template
	//generate link for this
	$answer['download'] = $mod_strings['BOX_DOWNLOAD_LINK'] . ':&nbsp;<a href="index.php?module=' . $bean->module_dir . '&action=processOfficeReport&to_pdf=true&officeTemplateDownload=on&record=' . $record_id . '&officeTemplateRecord=' . $officeParams['record'] . '" target="_blank" title="' . $mod_strings['BOX_DOWNLOAD_ON_LOCAL_PC'] . '">' . $mod_strings['BOX_DOWNLOAD_ON_LOCAL_PC'] . '</a>';
}

if (isset($officeParams['download']) OR isset($officeParams['history']) OR isset($officeParams['email']) )
{
	//need generate report
	$document = $bean->buildReport($officeParams['record']);

	$filename = strftime($bean->report_filename) . '.' . $format;

	$seed = new $beanList[$bean->report_module];
	$seed->retrieve($officeParams['record']);

	// history reports bean
	$historyBean = new OfficeReportHistory();
	$historyBean->name = $filename;
        
        if ($seed->module_dir == 'Contract' && isset($seed->opp_id))
        {
                        $historyBean->parent_id = $seed->opp_id;
			$historyBean->parent_type = 'Opportunities';
            
        }
        else
        {
	$historyBean->parent_type = $seed->module_dir;
	$historyBean->parent_id = $seed->id;
        }
	$historyBean->file_mime_type = $document->getMimetype();
	$historyBean->assigned_user_id = $current_user->id;

	if ($officeConfig['officeDocxHistorySave'] === TRUE AND $officeConfig['officeDocxHistorySaveReport'] === TRUE)
	{
		// save attachment for history reports
		$historyBean->id = create_guid();
		$historyBean->new_with_id = TRUE;
		$historyBean->filename = $filename;
		file_put_contents($sugar_config['upload_dir'] . $historyBean->id, $document->getContent());
	}

	// save file to notes
	if (isset($officeParams['history']))
	{
		$historyBean->attach_to_notes = TRUE;

		$noteBean = new Note();
		$noteBean->id = create_guid();
		$noteBean->new_with_id = TRUE; // duplicating the note with files
		$noteBean->name = strftime($bean->report_filename);
		$noteBean->filename = $filename;

		if ($seed->module_dir == 'Contacts')
		{
			//need assign contact_id additional
			$noteBean->parent_id = $seed->account_id;
			$noteBean->parent_type = 'Accounts';
			$noteBean->contact_id = $seed->id;
		}
		else if ($seed->module_dir == 'Contract' && isset($seed->opp_id))
                {
                        $noteBean->parent_id = $seed->opp_id;
			$noteBean->parent_type = 'Opportunities';
			//$noteBean->contact_id = $seed->id;
                }
		else
		{
			$noteBean->parent_id = $seed->id;
			$noteBean->parent_type = $seed->module_dir;
		}

		$noteBean->file_mime_type = $document->getMimetype();
		$noteBean->save();

		$noteFileName = $sugar_config['upload_dir'] . $noteBean->id;
		file_put_contents($noteFileName, $document->getContent());

		$answer['history'] = $mod_strings['BOX_ATTACH_TO_HISTORY'] . ':&nbsp;' . $mod_strings['OTH_SUCCESS'];
	}

	//send report by email
	if (isset($officeParams['email']))
	{
		$historyBean->send_on_email = TRUE;
		$historyBean->email_addrs = $officeParams['emailaddr'];

		$email = new Email();
		$email->email2init();

		if (isset($officeParams['emailaddr']) AND !empty($officeParams['emailaddr']))
		{
			$emailAdrrs = str_replace(PHP_EOL, ',', $officeParams['emailaddr']);
			$toAddresses = $email->email2ParseAddresses($emailAdrrs);
		}

		if (isset($officeParams['emailtemplate']))
		{
			$templateId = $officeParams['emailtemplate'];
		}
		else
		{
			$templateId = '';
		}

		$answer['email'] = $mod_strings['BOX_SEND_ON_EMAIL'] . ':&nbsp;';
		if (!empty($toAddresses))
		{
			if (!isset($noteFileName)) // need save this file for attach in email
			{
				$tmpFileName = $sugar_config['upload_dir'] . uniqid() . uniqid();
				file_put_contents($tmpFileName, $document->getContent());

				$res = Reports_Utils::sendEmailTemplate($filename, $tmpFileName, $toAddresses, $templateId, $seed);

				unlink($tmpFileName);
			}
			else
			{
				$res = Reports_Utils::sendEmailTemplate($filename, $noteFileName, $toAddresses, $templateId, $seed);
			}

			if ($res['status'] == FALSE)
			{
				$answer['email'] .= $mod_strings['OTH_FAIL'] . ' ' . $res['error'];
			}
			else
			{
				$answer['email'] .= $mod_strings['OTH_SUCCESS'];
			}
		}
		else
		{
			$answer['email'] .= $mod_strings['OTH_FAIL'] . ' ' . $mod_strings['ERR_INVALID_EMAILS'];
		}

	}

	// download report for user
	if (isset($officeParams['download']))
	{
		$historyBean->download_on_pc = true;
		if ($officeConfig['officeDocxHistorySave'] === TRUE)
		{
			$historyBean->save();
		}

		header("Content-type: " . $document->getMimetype());
        header("Content-disposition: attachment; filename=\"" . $filename . "\";");

		print $document->getContent();
		exit();
	}
}

$answer = join('<br><br>', $answer); // maybe rewrite in full json object and make this html on client side

$json = getJSONobj();
echo $json->encode(array('result' => 'ok', 'answer' => $answer));


if ($officeConfig['officeDocxHistorySave'] === TRUE)
{
	// save history
	$historyBean->save();
}

exit();

?>

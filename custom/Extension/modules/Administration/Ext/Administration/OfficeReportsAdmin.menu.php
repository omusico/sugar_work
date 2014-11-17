<?php

$admin_option_defs = array();

$admin_option_defs['Administration']['listtemplates'] = array('OfficeReportMerge', 'TH_LISTREPORT_TITLE','TH_LISTREPORT_DESC','index.php?module=OfficeReportsMerge&action=index');
$admin_option_defs['Administration']['listtemplatevariable'] = array('TemplateVariables', 'TH_LISTTEMPLATEVARIABLE_TITLE','TH_LISTTEMPLATEVARIABLE_DESC','index.php?module=OfficeReportsVariables&action=index');

$admin_option_defs['Administration']['createtemplate'] = array('CreateOfficeReportMerge', 'TH_CREATEREPORT_TITLE','TH_CREATEREPORT_DESC','index.php?module=OfficeReportsMerge&action=EditView');
$admin_option_defs['Administration']['createtemplatevariable'] = array('CreateTemplateVariables', 'TH_CREATETEMPLATEVARIABLE_TITLE','TH_CREATETEMPLATEVARIABLE_DESC','index.php?module=OfficeReportsVariables&action=EditView');

$admin_option_defs['Administration']['officereporthistory'] = array('OfficeReportHistory', 'TH_OFFICEREPORTHISTORY_TITLE','TH_OFFICEREPORTHISTORY_DESC','index.php?module=OfficeReportsHistory&action=index');
//$admin_option_defs['Administration']['codetemplatevariable'] = array('TempateVariablesForMerge', 'TH_CODEVARIABLE_TITLE','TH_CODEVARIABLE_DESC','index.php?module=OfficeReportsVariables&action=showCode');

$admin_option_defs['Administration']['settings'] = array('ReportSettings', 'TH_SETTINGSREPORT_TITLE','TH_SETTINGSREPORT_DESC','index.php?module=OfficeReportsMerge&action=Settings');

$admin_group_header[]= array('LBL_OFFICEREPORT_ADMIN_TITLE', '', false, $admin_option_defs, 'LBL_OFFICEREPORT_ADMIN_DESCRIPTION');

?>
<?php

$dictionary['OfficeReportMerge'] = array(

	'table' => 'officereportsmerge',

	'audited' => true,

	'fields' => array (

		'filename' =>
		array (
			'required' => false,
			'name' => 'filename',
			'vname' => 'LBL_TEMPLATENAME',
			'type' => 'varchar',
			'massupdate' => '0',
			'comments' => '',
			'help' => '',
			'importable' => 'true',
			'duplicate_merge' => 'disabled',
			'duplicate_merge_dom_value' => '0',
			'audited' => false,
			'reportable' => true,
			'len' => '255',
			'size' => '20',
		),

		'report_filename' =>
		array (
			'required' => false,
			'name' => 'report_filename',
			'vname' => 'LBL_REPORT_FILENAME',
			'type' => 'varchar',
			'massupdate' => '0',
			'comments' => '',
			'help' => '',
			'importable' => 'true',
			'duplicate_merge' => 'disabled',
			'duplicate_merge_dom_value' => '0',
			'audited' => false,
			'reportable' => true,
			'len' => '255',
			'size' => '20',
		),

		'extension_template' =>
		array (
			'required' => false,
			'name' => 'extension_template',
			'vname' => 'LBL_EXTENSION_TEMPLATE',
			'type' => 'varchar',
			'massupdate' => '0',
			'comments' => '',
			'help' => '',
			'importable' => 'true',
			'duplicate_merge' => 'disabled',
			'duplicate_merge_dom_value' => '0',
			'audited' => false,
			'reportable' => true,
			'len' => '10',
		),

		'report_module' =>
		array (
			'required' => false,
			'name' => 'report_module',
			'vname' => 'LBL_REPORT_MODULE',
			'type' => 'varchar',
			'massupdate' => '0',
			'comments' => '',
			'help' => '',
			'importable' => 'true',
			'duplicate_merge' => 'disabled',
			'duplicate_merge_dom_value' => '0',
			'audited' => true,
			'reportable' => true,
			'len' => '100',
			'size' => '30',
		),

		'report_vars' =>
		array (
			'required' => false,
			'name' => 'report_vars',
			'vname' => 'LBL_VARS',
			'type' => 'multienum',
			'massupdate' => '0',
			'comments' => '',
			'help' => '',
			'importable' => 'false',
			'audited' => 0,
			'reportable' => 0,
			'len' => '10000',
			'options' => 'vars_for_reports',
			'studio' => 'visible',
			'isMultiSelect' => true,
		),

	),

	'relationships'=>array (),

	'optimistic_locking'=>true,
);

if (!class_exists('VardefManager'))
{
	require_once('include/SugarObjects/VardefManager.php');
}

VardefManager::createVardef('OfficeReportsMerge','OfficeReportMerge', array('basic','assignable'));

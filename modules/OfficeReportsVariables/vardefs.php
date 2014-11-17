<?php

$dictionary['OfficeReportVariable'] = array(

	'table' => 'officereportsvariables',

	'audited' => false,

	'fields' => array (

		  'friendly_name'=>
			array (
				'required' => true,
				'name' => 'friendly_name',
				'vname' => 'LBL_FRIENDLY_NAME',
				'type' => 'varchar',
				'massupdate' => '0',
				'comments' => '',
				'help' => '',
				'len' => 255,
				'importable' => 'true',
				'duplicate_merge' => 'disabled',
				'duplicate_merge_dom_value' => '0',
				'audited' => false,
				'reportable' => true,
			),

		  'code'=>
			array (
				'required' => false,
				'name' => 'code',
				'vname' => 'LBL_CODE',
				'type' => 'text',
				'massupdate' => '0',
				'comments' => '',
				'help' => '',
				'importable' => 'true',
				'duplicate_merge' => 'disabled',
				'duplicate_merge_dom_value' => '0',
				'audited' => false,
				'reportable' => true,
			),

		  'for_modules'=>
			array (
				'required' => true,
				'name' => 'for_modules',
				'vname' => 'LBL_FOR_MODULES',
				'type' => 'multienum',
				'options' => 'report_available_modules',
				'isMultiSelect' => true,
				'massupdate' => '0',
				'comments' => '',
				'help' => '',
				'importable' => 'true',
				'duplicate_merge' => 'disabled',
				'duplicate_merge_dom_value' => '0',
				'audited' => false,
				'reportable' => true,
			),

	),

	'relationships' => array (),

	'optimistic_locking' => true,
);

if (!class_exists('VardefManager'))
{
	require_once('include/SugarObjects/VardefManager.php');
}

VardefManager::createVardef('OfficeReportsVariables','OfficeReportVariable', array('basic','assignable'));

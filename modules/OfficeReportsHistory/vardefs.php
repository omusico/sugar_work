<?php

$dictionary['OfficeReportHistory'] = array(

	'table' => 'officereportshistory',

	'audited' => false,

	'fields' => array (

		'file_mime_type' =>
		array (
			'required' => false,
			'name' => 'file_mime_type',
			'vname' => 'LBL_FILE_MIME_TYPE',
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

		'filename' =>
		array (
			'required' => false,
			'name' => 'filename',
			'vname' => 'LBL_FILENAME',
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
		),

		'parent_type'=>
		  array(
		  	'name' => 'parent_type',
		  	'vname' => 'LBL_PARENT_NAME',
		    'type' => 'parent_type',
		    'dbType' => 'varchar',
		  	'group' => 'parent_name',
		  	'required' => true,
			'audited' => 0,
		  	'len' => '25',
		    'comment' => 'The Sugar object to which the messenger is related'
		  ),

		  'parent_name'=>
		  array(
			'name' => 'parent_name',
			'parent_type' => 'record_type_mes_display',
			'type_name' => 'parent_type',
			'id_name' => 'parent_id',
		    'vname' => 'LBL_LIST_RELATED_TO',
			'type' => 'parent',
			'group' => 'parent_name',
			'source' => 'non-db',
			'options' => 'parent_type_mes_display',
		    'required' => true,
			'audited' => 0,
		  ),

		  'parent_id' =>
		  array (
		    'name' => 'parent_id',
		    'type' => 'id',
		    'group' => 'parent_name',
		    'reportable' => false,
		    'vname'=>'LBL_PARENT_ID',
		  ),

		  'send_on_email'=>
			array (
				'required' => false,
				'name' => 'send_on_email',
				'vname' => 'LBL_SEND_ON_EMAIL',
				'type' => 'bool',
				'massupdate' => '0',
				'comments' => '',
				'help' => '',
				'importable' => 'true',
				'duplicate_merge' => 'disabled',
				'duplicate_merge_dom_value' => '0',
				'audited' => false,
				'reportable' => true,
			),

		  'download_on_pc'=>
			array (
				'required' => false,
				'name' => 'download_on_pc',
				'vname' => 'LBL_DOWNLOAD_ON_PC',
				'type' => 'bool',
				'massupdate' => '0',
				'comments' => '',
				'help' => '',
				'importable' => 'true',
				'duplicate_merge' => 'disabled',
				'duplicate_merge_dom_value' => '0',
				'audited' => false,
				'reportable' => true,
			),

		  'attach_to_notes'=>
			array (
				'required' => false,
				'name' => 'attach_to_notes',
				'vname' => 'LBL_ATTACH_TO_NOTES',
				'type' => 'bool',
				'massupdate' => '0',
				'comments' => '',
				'help' => '',
				'importable' => 'true',
				'duplicate_merge' => 'disabled',
				'duplicate_merge_dom_value' => '0',
				'audited' => false,
				'reportable' => true,
			),

		  'email_addrs'=>
			array (
				'required' => false,
				'name' => 'email_addrs',
				'vname' => 'LBL_EMAIL_ADDR',
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

	),

	'relationships'=>array (),

	'optimistic_locking'=>true,
);

if (!class_exists('VardefManager'))
{
	require_once('include/SugarObjects/VardefManager.php');
}

VardefManager::createVardef('OfficeReportsHistory','OfficeReportHistory', array('basic','assignable'));

<?php
/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Professional Subscription
 * Agreement ("License") which can be viewed at
 * http://www.sugarcrm.com/crm/products/sugar-professional-eula.html
 * By installing or using this file, You have unconditionally agreed to the
 * terms and conditions of the License, and You may not use this file except in
 * compliance with the License.  Under the terms of the license, You shall not,
 * among other things: 1) sublicense, resell, rent, lease, redistribute, assign
 * or otherwise transfer Your rights to the Software, and 2) use the Software
 * for timesharing or service bureau purposes such as hosting the Software for
 * commercial gain and/or for the benefit of a third party.  Use of the Software
 * may be subject to applicable fees and any use of the Software without first
 * paying applicable fees is strictly prohibited.  You do not have the right to
 * remove SugarCRM copyrights from the source code or user interface.
 *
 * All copies of the Covered Code must include on each user interface screen:
 *  (i) the "Powered by SugarCRM" logo and
 *  (ii) the SugarCRM copyright notice
 * in the same form as they appear in the distribution.  See full license for
 * requirements.
 *
 * Your Warranty, Limitations of liability and Indemnity are expressly stated
 * in the License.  Please refer to the License for the specific language
 * governing these rights and limitations under the License.  Portions created
 * by SugarCRM are Copyright (C) 2004-2010 SugarCRM, Inc.; All Rights Reserved.
 ********************************************************************************/
$dictionary['sugartalk_SMS'] = array(
	'table'=>'sugartalk_sms',
	'audited'=>true,
	'fields'=>array (
  'name' => 
  array (
    'required' => '1',
    'name' => 'name',
    'vname' => 'LBL_NAME',
    'type' => 'varchar',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => 0,
    'reportable' => 1,
    'len' => '50',
  ),
  'type' => 
  array (
    'required' => '1',
    'name' => 'type',
    'vname' => 'LBL_TYPE',
    'type' => 'enum',
    'massupdate' => 0,
    'default' => 'outbound',
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => 0,
    'reportable' => 1,
    'len' => 100,
    'options' => 'type_list',
    'studio' => 'visible',
    'dependency' => false,
  ),
  'phone_number' => 
  array (
    'required' => '1',
    'name' => 'phone_number',
    'vname' => 'LBL_PHONE_NUMBER',
    'type' => 'varchar',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => 0,
    'reportable' => 1,
    'len' => '25',
  ),
  'description' => 
  array (
    'required' => '1',
    'name' => 'description',
    'vname' => 'LBL_DESCRIPTION',
    'type' => 'text',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => 0,
    'reportable' => 1,
    'studio' => 'visible',
  ),
  'api_message' => 
  array (
    'required' => false,
    'name' => 'api_message',
    'vname' => 'LBL_API_MESSAGE',
    'type' => 'varchar',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => 0,
    'reportable' => 1,
    'len' => '255',
  ),
	'provider' => 
	array (
		'required' => '1',
		'name' => 'provider',
		'vname' => 'LBL_PROVIDER',
		'type' => 'varchar',
		'massupdate' => 0,
		'comments' => '',
		'help' => '',
		'importable' => 'true',
		'duplicate_merge' => 'disabled',
		'duplicate_merge_dom_value' => '0',
		'audited' => 0,
		'reportable' => 1,
		'len' => '255',
	),
	'delivery_status' => 
	array ( 
		'required' => '1',
		'name' => 'delivery_status',
		'vname' => 'LBL_DELIVERY_STATUS',
		'type' => 'enum',
		'massupdate' => 0,
		'default' => '',
		'comments' => '',
		'help' => '',
		'importable' => 'true',
		'duplicate_merge' => 'disabled',
		'duplicate_merge_dom_value' => '0',
		'audited' => 0,
		'reportable' => 1,
		'len' => 100,
		'options' => 'delivery_status_list',
		'studio' => 'visible',
		'dependency' => false,   
	),
	'parent_type'=>
	array(
		'name'=>'parent_type',
		'vname'=>'LBL_PARENT_TYPE',
		'type' => 'parent_type',
		'dbType'=>'varchar',
		'required'=>false,
		'group'=>'parent_name',
		'options'=> 'sugartalk_sms_module_selected_list',
		'reportable'=>true,
		'len'=>255,
		'comment' => 'The Sugar object to which the call is related'
	), 
	'parent_name'=>
	array(
		'name'=> 'parent_name',
		'parent_type'=>'record_type_display' ,
		'type_name'=>'parent_type',
		'id_name'=>'parent_id',
        'vname'=>'LBL_LIST_RELATED_TO',
		'type'=>'parent',
		'group'=>'parent_name',
		'source'=>'non-db',
		'options'=> 'sugartalk_sms_module_selected_list',
	),
	'parent_id'=>
	array(
		'name'=>'parent_id',
		'vname'=>'LBL_LIST_RELATED_TO_ID',
		'type'=>'id',
		'group'=>'parent_name',
		'reportable'=>true,
		'comment' => 'The ID of the parent Sugar object identified by parent_type',
	),
   
	),
	'relationships'=>array ( ),
	'optimistic_lock'=>true,
);
if (!class_exists('VardefManager')){
        require_once('include/SugarObjects/VardefManager.php');
} 
VardefManager::createVardef('sugartalk_SMS','sugartalk_SMS', array('basic','assignable'));

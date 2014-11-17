<?php
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/
$module = 'Branch';
$dictionary['Branch'] = array(
'table'=>'branch',
'audited'=>true,
'duplicate_merge'=>true,
'fields'=>array(
	"department" => array (
		'name' => 'department',
		'type' => 'link',
		'relationship' => 'branch_department',
		'module'=>'Department',
		'bean_name'=>'Department',
		'source'=>'non-db',
		'vname'=>'LBL_DEPARTMENT',
	),	
	"contact_phone" => array (
		'name' => 'contact_phone',
		'type' => 'varchar',
		'vname'=>'LBL_CONTACT_PHONE',
	),

	'address_country' => array(
		'name' => 'address_country',
		'vname' => 'LBL_ADDRESS_COUNTRY',
		'type' => 'varchar'
	),

	'address_city' => array(
		'name' => 'address_city',
		'vname' => 'LBL_ADDRESS_CITY',
		'type' => 'varchar',
	),

	'address_street' => array(
		'name' => 'address_street',
		'vname' => 'LBL_ADDRESS_STREET',
		'type' => 'varchar',
	),

	'address_house' => array(
		'name' => 'address_house',
		'vname' => 'LBL_ADDRESS_HOUSE',
		'type' => 'varchar',
	),

	// Email Address FIELD ------> START
	"email1" => array (
		'name'  => 'email1',
		'vname' => 'LBL_EMAIL',
		'type'  => 'varchar',
		'function' =>
		array (
			'name' => 'getEmailAddressWidget',
			'returns' => 'html',
		),
		'source' => 'non-db',
		'group' => 'email1',
		'merge_filter' => 'enabled',
		'studio' => 'visible',
	),

	'email_addresses_primary' => array(
		'name' => 'email_addresses_primary',
		'type' => 'link',
		'relationship' => strtolower($module).'_email_addresses_primary',
		'source' => 'non-db',
		'vname' => 'LBL_EMAIL_ADDRESS_PRIMARY',
		'duplicate_merge' => 'disabled',
	),

	'email_addresses' => array (
		'name' => 'email_addresses',
		'type' => 'link',
		'relationship' => strtolower($module).'_email_addresses',
		'source' => 'non-db',
		'vname' => 'LBL_EMAIL_ADDRESSES',
		'reportable'=>false,
		'unified_search' => true,
		'rel_fields' => array('primary_address' => array('type'=>'bool')),
	),

	// Email Address FIELD ------> END
),
'relationships'=>array(
	'branch_department' => array (
		'lhs_module'=> 'Branch', 
		'lhs_table'=> 'branch', 
		'lhs_key' => 'id',
		'rhs_module'=> 'Department', 
		'rhs_table'=> 'department', 
		'rhs_key' => 'branch_id',
		'relationship_type'=>'one-to-many',


		// Email Address RELATIONSHIP ------> START
        strtolower($module).'_email_addresses' => array(
            'lhs_module'=> $module,
            'lhs_table'=> strtolower($module),
            'lhs_key' => 'id',
            'rhs_module'=> 'EmailAddresses',
            'rhs_table'=> 'email_addresses',
            'rhs_key' => 'id',
            'relationship_type'=>'many-to-many',
            'join_table'=> 'email_addr_bean_rel',
            'join_key_lhs'=>'bean_id',
            'join_key_rhs'=>'email_address_id',
            'relationship_role_column'=>'bean_module',
            'relationship_role_column_value'=>$module
        ),

        strtolower($module).'_email_addresses_primary' => array(
            'lhs_module'=> $module,
            'lhs_table' => strtolower($module),
            'lhs_key' => 'id',
            'rhs_module' => 'EmailAddresses',
            'rhs_table' => 'email_addresses',
            'rhs_key' => 'id',
            'relationship_type'=>'many-to-many',
            'join_table'=> 'email_addr_bean_rel',
            'join_key_lhs'=>'bean_id',
            'join_key_rhs'=>'email_address_id',
            'relationship_role_column'=>'primary_address',
            'relationship_role_column_value'=>'1'
        ),

        // Email Address RELATIONSHIP ------> END
	),
),
	'optimistic_locking'=>true,
		'unified_search'=>true,
	);
if (!class_exists('VardefManager')){
        require_once('include/SugarObjects/VardefManager.php');
}
VardefManager::createVardef('Branch','Branch', array('basic','assignable'));
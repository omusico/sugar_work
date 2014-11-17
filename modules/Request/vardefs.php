<?php
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2012 SugarCRM Inc.
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

$dictionary['Request'] = array(
	'table'=>'request',
	'audited'=>true,
        'duplicate_merge'=>true,
        'fields'=>array (
            'status' => array(
                'name' => 'status',
                'vname' => 'LBL_REALTY_REQUESTS_STATUS',
                'type' => 'enum',
                'options' => 'request_status_new_list',
				'len' => '30',
            ),
			'operation' => array(
                'name' => 'operation',
                'vname' => 'LBL_OPERATION',
                'type' => 'enum',
                'options' => 'operation_realty_list',
            ),
            'type_of_realty' => array(
                'name' => 'type_of_realty',
                'vname' => 'LBL_TYPE_OF_REALTY',
                'type' => 'enum',
                'options' => 'type_of_realty_list',
            ),
            'kind_of_realty' => array(
                'name' => 'kind_of_realty',
                'vname' => 'LBL_KIND_OF_REALTY',
                'type' => 'enum',
                'options' => 'kind_of_realty_list',
            ),
            'rooms_quantity' => array(
                'name' => 'rooms_quantity',
                'vname' => 'LBL_ROOMS_QUANTITY',
                'type' => 'int',
            ),
            'rooms_quantity_to' => array(
                'name' => 'rooms_quantity_to',
                'vname' => 'LBL_ROOMS_QUANTITY_TO',
                'type' => 'int',
            ),
            'cost_to' => array(
                'name' => 'cost_to',
                'vname' => 'LBL_COST_TO',
                'type' => 'float',
                'dbtype' => 'double',
                'precision' => '2',
                'required' => true,
            ),
            'square_min' => array(
                'name' => 'square_min',
                'vname' => 'LBL_MIN_SQUARE',
                'type' => 'int',
            ),
            'square_max' => array(
                'name' => 'square_max',
                'vname' => 'LBL_MAX_SQUARE',
                'type' => 'int',
            ),
            'min_floor' => array(
                'name' => 'min_floor',
                'vname' => 'LBL_MIN_FLOOR',
                'type' => 'int',
            ),
            'max_floor' => array(
                'name' => 'max_floor',
                'vname' => 'LBL_MAX_FLOOR',
                'type' => 'int',
            ),
            'metro' => array(
                'name' => 'metro',
                'vname' => 'LBL_METRO',
                'type' => 'varchar',
            ),

            'layout' => array(
                'name' => 'layout',
                'vname' => 'LBL_LAYOUT',
                'type' => 'varchar',
            ),

            'state_of_object' => array(
                'name' => 'state_of_object',
                'vname' => 'LBL_STATE_OF_OBJECT',
                'type' => 'enum',
                'options' => 'request_state_of_object_list',
            ),

            'address_city' => array(
                'name' => 'address_city',
                'vname' => 'LBL_ADDRESS_CITY',
                'type' => 'varchar',
            ),

            'address_country' => array(
                'name' => 'address_country',
                'vname' => 'LBL_ADDRESS_COUNTRY',
                'type' => 'varchar',
            ),

            'address_street' => array(
                'name' => 'address_street',
                'vname' => 'LBL_ADDRESS_STREET',
                'type' => 'varchar',
            ),

            'address_region' => array(
                'name' => 'address_region',
                'vname' => 'LBL_ADDRESS_REGION',
                'type' => 'varchar',
            ),
            'currency' => array (        
                'name' => 'currency',
                'vname' => 'LBL_CURRENCY',
                'type' => 'enum',
                'options' => 'realty_currency_list',
            ),
            'presentation_checked' => array(
                'name' => 'presentation_checked',
                'vname' => 'LBL_PRESENTATION_CHECKED',
                'type' => 'varchar',
                'required' => false,
                'source'=>'non-db',
            ),
            'send_presentation' => array( 
                'name' => 'send_presentation',
                'vname' => 'LBL_SEND_PRES',
                'type' => 'bool',
            ),
            //Тип контакта (Accounts, Contacts) 
            'parent_type' => array (
                'name'=>'parent_type',
                'vname'=>'LBL_PARENT_TYPE',
                'type' => 'parent_type',
                'dbType'=>'varchar',
                'required'=>false,
                'group'=>'parent_name',
                'options'=> 'contact_parent_type_display',
                'len'=>255,
                'comment' => 'The Sugar object to which the call is related'
            ),
            'parent_name' => array (
                'name'=> 'parent_name',
                'parent_type'=>'contact_record_type_display' ,
                'type_name'=>'parent_type',
                'id_name'=>'parent_id',
                'vname'=>'LBL_LIST_RELATED_TO',
                'type'=>'parent',
                'group'=>'parent_name',
                'source'=>'non-db',
                'options'=> 'contact_parent_type_display',
            ),
            'parent_id' => array (
                'name'=>'parent_id',
                'vname'=>'LBL_LIST_RELATED_TO_ID',
                'type'=>'id',
                'group'=>'parent_name',
                'reportable'=>false,
                'comment' => 'The ID of the parent Sugar object identified by parent_type'
            ),

),
	'relationships'=>array (

        
),
	'optimistic_locking'=>true,
		'unified_search'=>true,
	);
if (!class_exists('VardefManager')){
        require_once('include/SugarObjects/VardefManager.php');
}
VardefManager::createVardef('Request','Request', array('basic','assignable'));

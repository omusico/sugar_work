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
$module = 'Realty';
$dictionary['Realty'] = array(
	'table'=>'realty',
	'audited'=>true,
	'duplicate_merge'=>true,
	'fields'=>array (
		'request' => array( // из какой за€вки(интересующа€ недвижимость дл€ контактов)
			'name' => 'request',
			'vname' => 'LBL_REQUEST',
			'type' => 'varchar',
			'source' => 'non-db',
		),
		'code_inc' => array(
			'name' => 'code_inc',
			'vname' => 'LBL_CODE',
			'type' => 'int',
			'auto_increment' => true,
			'massupdate' => 0,
			'duplicate_merge' => 'disabled',
			'duplicate_merge_dom_value' => 0,
			'reportable' => 0,
		),
		// презенташка
		'presentation_text' => array(
			'name' => 'presentation_text',
			'vname' => 'LBL_PRESENTATION_TEXT',
			'type' => 'varchar',
			'required' => false,
		), 
		'presentation_checked' => array(
			'name' => 'presentation_checked',
			'vname' => 'LBL_PRESENTATION_CHECKED',
			'type' => 'varchar',
			'required' => false,
			'source'=>'non-db',
		),
		
		'reserved' => array( // зарезервировано
			'name' => 'reserved',
			'vname' => 'LBL_RESERVED',
			'type' => 'bool',
		),
		'last_contact' => array ( //дата последнего контакта   
			'name' => 'last_contact',
			'vname' => 'LBL_LAST_CONTACT',
			'type' => 'date',
		),
		'd_text' => array(
			'name' => 'd_text',
			'vname' => 'LBL_D_TEXT',
			'type' => 'text',
		),
		'd_name' => array(
			'name' => 'd_name',
			'vname' => 'LBL_D_NAME',
			'type' => 'varchar',
		),
		'room_layout' =>	array (// планировка комнат 
			'name' => 'room_layout',
			'vname' => 'LBL_ROOM_LAYOUT',
			'type' => 'enum',
			'options' => 'room_layout_list',
		),
		'for_office' => array ( //под офис          
			'name' => 'for_office',
			'vname' => 'LBL_FOR_OFFICE',
			'type' => 'bool',
		),
		'balcon' => array ( //балкон   
			'name' => 'balcon',
			'vname' => 'LBL_BALCON',
			'type' => 'bool',
		),
		'phone_bool' => array ( //наличие телефона   
			'name' => 'phone_bool',
			'vname' => 'LBL_PHONE_BOOL',
			'type' => 'bool',
		),
		'boiler' => array ( //колонка/бойлер    
			'name' => 'boiler',
			'vname' => 'LBL_BOILER',
			'type' => 'bool',
		),
		'tv' => array ( //“¬     
			'name' => 'tv',
			'vname' => 'LBL_TV',
			'type' => 'bool',
		),
		'fridge' => array ( //’олодильник      
			'name' => 'fridge',
			'vname' => 'LBL_FRIDGE',
			'type' => 'bool',
		),
		'washing_m' => array ( //стиральна€ машина       
			'name' => 'washing_m',
			'vname' => 'LBL_WASHING_M',
			'type' => 'bool',
		),
		'conditioning' => array ( //кондиционер       
			'name' => 'conditioning',
			'vname' => 'LBL_CONDITIONING',
			'type' => 'bool',
		),
		'internet' => array ( //internet
			'name' => 'internet',
			'vname' => 'LBL_INTERNET',
			'type' => 'bool',
		),
		'parking' => array ( //сто€нка дл€ авто 
			'name' => 'parking',
			'vname' => 'LBL_PARKING',
			'type' => 'bool',
		),
		'gaz' => array ( //газ 
			'name' => 'gaz',
			'vname' => 'LBL_GAZ',
			'type' => 'enum',
			'options' => 'gaz_list',
		),
			'gaz_add' => array ( //газ дл€ земельного участка,дома,..
				'name' => 'gaz_add',
				'vname' => 'LBL_GAZ_P',
				'type' => 'enum',
				'options' => 'gaz_add_list',
			),
		'h2o' => array ( //вода 
			'name' => 'h2o',
			'vname' => 'LBL_H2O',
			'type' => 'enum',
			'options' => 'h2o_list',
		),
			'h2o_add' => array ( //вода ƒл€ дачи, дома, земельного участка 
				'name' => 'h2o_add',
				'vname' => 'LBL_H2O_P',
				'type' => 'enum',
				'options' => 'h2o_add_list',
			),
		//
		
		'owner_last_name' => array(
			'name' => 'owner_last_name',
			'vname' => 'LBL_OWNER_LAST_NAME',
			'type' => 'varchar',
			'required' => true,
		),

		'owner_first_name' => array(
			'name' => 'owner_first_name',
			'vname' => 'LBL_OWNER_FIRST_NAME',
			'type' => 'varchar',
		),

		'owner_phone' => array(
			'name' => 'owner_phone',
			'vname' => 'LBL_OWNER_PHONE',
			'type' => 'phone',
			'dbType' => 'varchar',
			'required' => true,
		),

		'realty_status' => array(
			'name' => 'realty_status',
			'vname' => 'LBL_REALTY_STATUS',
			'type' => 'enum',
			'options' => 'realty_status_list'
		),

		'activity_status' => array(
			'name' => 'activity_status',
			'vname' => 'LBL_ACTIVITY_STATUS',
			'type' => 'enum',
			'options' => 'activity_status_list'
		),

		'source_of_income_object' => array(
			'name' => 'source_of_income_object',
			'vname' => 'LBL_SOURCE_OF_INCOME_OBJECT',
			'type' => 'enum',
			'options' => 'source_of_income_object_list'
		),

		'operation' => array(
			'name' => 'operation',
			'vname' => 'LBL_OPERATION',
			'type' => 'enum',
			'options' => 'operation_realty_list',
		),

		'operation_status' => array(
			'name' => 'operation_status',
			'vname' => 'LBL_OPERATION_STATUS',
			'type' => 'enum',
			'options' => 'operation_status_realty_list',
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

		'square' => array(
			'name' => 'square',
			'vname' => 'LBL_SQUARE',
			'type' => 'float',
			'required' => true,
		),
		'living_square' => array(
			'name' => 'living_square',
			'vname' => 'LBL_LIVING_SQUARE',
			'type' => 'float',
		),
		'kitchen_square' => array( // площадь кухни
			'name' => 'kitchen_square',
			'vname' => 'LBL_KITCHEN_SQUARE',
			'type' => 'float',
			//'required' => true,
		),

		'square_unit' => array(
			'name' => 'square_unit',
			'vname' => 'LBL_SQUARE_UNIT',
			'type' => 'enum',
			'options' => 'square_unit_list'
		),

		'rooms_quantity' => array(
			'name' => 'rooms_quantity',
			'vname' => 'LBL_ROOMS_QUANTITY',
			'type' => 'int',
		),

		'floor' => array(
			'name' => 'floor',
			'vname' => 'LBL_FLOOR',
			'type' => 'int',
		),

		'number_of_floors' => array(
			'name' => 'number_of_floors',
			'vname' => 'LBL_NUMBER_OF_FLOORS',
			'type' => 'int',
		),

		'currency' => array(

			'name' => 'currency',
			'vname' => 'LBL_CURRENCY',
			'type' => 'enum',
			'options' => 'realty_currency_list',
		),

		'cost' => array(
			'name' => 'cost',
			'vname' => 'LBL_COST',
			'type' => 'int',
			'required' => true,
		),

		'period' => array(
			'name' => 'period',
			'vname' => 'LBL_PERIOD',
			'type' => 'enum',
			'options' => 'realty_period_list',
		),

		'totalcost' => array(
			'name' => 'totalcost',
			'vname' => 'LBL_TOTALCOST',
			'type' => 'int',
		),
		
		'currency_uah' => array(
			'name' => 'currency_uah',
			'vname' => 'LBL_TOTALCOST_UAH',
			'type' => 'int',
		),
		
		'video_youtube' => array(
			'name' => 'video_youtube',
			'vname' => 'LBL_VIDEO_YOUTUBE',
			'type' => 'varchar',
		),

		'state_of_object' => array(

			'name' => 'state_of_object',
			'vname' => 'LBL_STATE_OF_OBJECT',
			'type' => 'enum',
			'options' => 'state_of_object_list',
		),

	'longitude' => array(
			'name' => 'longitude',
			'vname' => 'LBL_LONGITUDE',
			'type' => 'varchar',
		),

		'latitude' => array(
			'name' => 'latitude',
			'vname' => 'LBL_LATITUDE',
			'type' => 'varchar',
		),
		'map_in_editview' =>
		array (
			'name' => 'map_in_editview',
			'type' => 'varchar',
			'vname'=>'LBL_MAP_IN_EDITVIEW',

		),

		'metro' => array(
			'name' => 'metro',
			'vname' => 'LBL_METRO',
			'type' => 'varchar',
		),

		'way_to_get' => array(
			'name' => 'way_to_get',
			'vname' => 'LBL_WAY_TO_GET',
			'type' => 'enum',
			'options' => 'way_to_get_list',
		),

		'address_city' => array(
			'name' => 'address_city',
			'vname' => 'LBL_ADDRESS_CITY',
			'type' => 'varchar',
		),

		'address_country' => array(
			'name' => 'address_country',
			'vname' => 'LBL_ADDRESS_COUNTRY',
			'type' => 'varchar'
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
		
		'address_apartment' => array(
			'name' => 'address_apartment',
			'vname' => 'LBL_ADDRESS_APARTMENT',
			'type' => 'varchar',
		),

		'address_region' => array(
			'name' => 'address_region',
			'vname' => 'LBL_ADDRESS_REGION',
			'type' => 'varchar'
		),
				
		'address_district' => array(
			'name' => 'address_district',
			'vname' => 'LBL_ADDRESS_DISTRICT',
			'type' => 'varchar'
		),


		'sections_exist' => array(
			'name' => 'sections_exist',
			'vname' => 'LBL_SECTIONS_EXIST',
			'type' => 'enum',
			'options' => 'sections_exist_list'
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


		// Relationship fields START
		'contact_id' =>
		array (
			'required' => false,
			'name' => 'contact_id',
			'vname' => '',
			'type' => 'id',
			'massupdate' => 0,
			'importable' => 'true',
			'audited' => 0,
			'len' => 36,
		),
		'contact_name' =>
		array (
			'required' => false,
			'source' => 'non-db',
			'name' => 'contact_name',
			'vname' => 'LBL_CONTACT_NAME',
			'type' => 'relate',
			'massupdate' => 0,
			'comments' => '',
			'help' => '',
			'audited' => 1,
			'len' => '100',
			'id_name' => 'contact_id',
			'ext2' => 'Contacts',
			'module' => 'Contacts',
			'rname' => 'name',
			'studio' => 'visible',
		),
		'account_id' =>
		array (
			'required' => false,
			'name' => 'account_id',
			'vname' => '',
			'type' => 'id',
			'massupdate' => 0,
			'importable' => 'true',
			'audited' => 0,
			'len' => 36,
		),
		'account_name' =>
		array (
			'required' => false,
			'source' => 'non-db',
			'name' => 'account_name',
			'vname' => 'LBL_ACCOUNT_NAME',
			'type' => 'relate',
			'massupdate' => 0,
			'comments' => '',
			'help' => '',
			'audited' => 1,
			'len' => '100',
			'id_name' => 'account_id',
			'ext2' => 'Accounts',
			'module' => 'Accounts',
			'rname' => 'name',
			'studio' => 'visible',
		),

		'building_id' =>
		array (
			'required' => false,
			'name' => 'building_id',
			'vname' => '',
			'type' => 'id',
			'massupdate' => 0,
			'importable' => 'true',
			'audited' => 0,
			'len' => 36,
		),
		'building_name' =>
		array (
			'required' => false,
			'source' => 'non-db',
			'name' => 'building_name',
			'vname' => 'LBL_BUILDING_NAME',
			'type' => 'relate',
			'massupdate' => 0,
			'comments' => '',
			'help' => '',
			'audited' => 1,
			'len' => '100',
			'id_name' => 'building_id',
			'ext2' => 'Buildings',
			'module' => 'Buildings',
			'rname' => 'name',
			'studio' => 'visible',
		),

		'section_id' =>
		array (
			'required' => false,
			'name' => 'section_id',
			'vname' => '',
			'type' => 'id',
			'massupdate' => 0,
			'importable' => 'true',
			'audited' => 0,
			'len' => 36,
		),
		'section_name' =>
		array (
			'required' => false,
			'source' => 'non-db',
			'name' => 'section_name',
			'vname' => 'LBL_SECTION_NAME',
			'type' => 'relate',
			'massupdate' => 0,
			'comments' => '',
			'help' => '',
			'audited' => 1,
			'len' => '100',
			'id_name' => 'section_id',
			'ext2' => 'Sections',
			'module' => 'Sections',
			'rname' => 'name',
			'studio' => 'visible',
		),

		"realty_calls" =>
			array (
				'name' => 'realty_calls',
				'type' => 'link',
				'relationship' => 'realty_calls',
				'module'=>'Calls',
				'bean_name'=>'Calls',
				'source'=>'non-db',
				'vname'=>'LBL_REALTY_CALLS',
			),

		"realty_meetings" =>
		array (
			'name' => 'realty_meetings',
			'type' => 'link',
			'relationship' => 'realty_meetings',
			'module'=>'Meetings',
			'bean_name'=>'Meetings',
			'source'=>'non-db',
			'vname'=>'LBL_REALTY_MEETINGS',
		),

		"realty_tasks" =>
		array (
			'name' => 'realty_tasks',
			'type' => 'link',
			'relationship' => 'realty_tasks',
			'module'=>'Tasks',
			'bean_name'=>'Tasks',
			'source'=>'non-db',
			'vname'=>'LBL_REALTY_TASKS',
		),
		// Relationship fields END
	),
	'relationships'=>array (

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

        'realty_calls' =>
            array (
                'lhs_module'=> 'Realty',
                'lhs_table'=> 'realty',
                'lhs_key' => 'id',
                'rhs_module'=> 'Calls',
                'rhs_table'=> 'calls',
                'rhs_key' => 'realty_id',
                'relationship_type'=>'one-to-many'
            ),

        'realty_meetings' =>
        array (
            'lhs_module'=> 'Realty',
            'lhs_table'=> 'realty',
            'lhs_key' => 'id',
            'rhs_module'=> 'Meetings',
            'rhs_table'=> 'meetings',
            'rhs_key' => 'realty_id',
            'relationship_type'=>'one-to-many'
        ),

        'realty_tasks' =>
        array (
            'lhs_module'=> 'Realty',
            'lhs_table'=> 'realty',
            'lhs_key' => 'id',
            'rhs_module'=> 'Tasks',
            'rhs_table'=> 'tasks',
            'rhs_key' => 'realty_id',
            'relationship_type'=>'one-to-many'
        ),
	),
	'indices' => array (
		array(
			'name' => 'code_inc',
			'type' => 'unique',
			'fields' => array('code_inc'),
		),
	),
	'optimistic_locking'=>true,
		'unified_search'=>true,
	);
if (!class_exists('VardefManager')){
        require_once('include/SugarObjects/VardefManager.php');
}
VardefManager::createVardef('Realty','Realty', array('basic','assignable'));

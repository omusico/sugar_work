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

$dictionary['Buildings'] = array(
	'table'=>'buildings',
	'audited'=>true,
		'duplicate_merge'=>true,
		'fields'=>array (
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

            'current_square' => array(
                'name' => 'current_square',
                'vname' => 'LBL_CURRENT_SQUARE',
                'type' => 'int',
            ),

            'number_of_floors' => array(
                'name' => 'number_of_floors',
                'vname' => 'LBL_NUMBER_OF_FLOORS',
                'type' => 'int',
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

            'type_of_building' => array(
                'name' => 'type_of_building',
                'vname' => 'LBL_TYPE_OF_BUILDING',
                'type' => 'enum',
                'options' => 'type_of_building_list',
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

	    'address_region' => array(

    		'name' => 'address_region',
    		'vname' => 'LBL_ADDRESS_REGION',
    		'type' => 'varchar',
	    ),

	    
            'flats_quantity' => array(
                'name' => 'flats_quantity',
                'vname' => 'LBL_FLATS_QUANTITY',
                'type' => 'int'
            ),

            'address_street' => array(
                'name' => 'address_street',
                'vname' => 'LBL_ADDRESS_STREET',
                'type' => 'varchar',
            ),

            'address_house' => array(
                'name' => 'address_house',
                'vname' => 'LBL_ADDRESS_HOUSE',
                'type' => 'varchar'
            ),

            'map_in_editview' =>
            array (
                'name' => 'map_in_editview',
                'type' => 'varchar',
                'vname'=>'LBL_MAP_IN_EDITVIEW',

            ),

            "buildings_sections" =>
                array (
                    'name' => 'buildings_sections',
                    'type' => 'link',
                    'relationship' => 'buildings_sections',
                    'module'=>'Sections',
                    'bean_name'=>'Sections',
                    'source'=>'non-db',
                    'vname'=>'LBL_AUCTIONS',
                ),
	),
	'relationships'=>array (

        'buildings_sections' =>
            array (
                'lhs_module'=> 'Buildings',
                'lhs_table'=> 'buildings',
                'lhs_key' => 'id',
                'rhs_module'=> 'Sections',
                'rhs_table'=> 'sections',
                'rhs_key' => 'building_id',
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
VardefManager::createVardef('Buildings','Buildings', array('basic','assignable'));

<?php

$dictionary['Sections'] = array(
	'table'=>'sections',
	'audited'=>true,
		'duplicate_merge'=>true,
		'fields'=>array (

            'flats_quantity' => array(
                'name' => 'flats_quantity',
                'vname' => 'LBL_FLATS_QUANTITY',
                'type' => 'int',
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
                'required' => true,
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
                'rname' => 'code_inc',
                'studio' => 'visible',
            ),

            "realty_sections" =>
                array (
                    'name' => 'realty_sections',
                    'type' => 'link',
                    'relationship' => 'realty_sections',
                    'module'=>'Realty',
                    'bean_name'=>'Realty',
                    'source'=>'non-db',
                    'vname'=>'LBL_REALTY',
                ),
),
	'relationships'=>array (

        'realty_sections' =>
            array (
                'lhs_module'=> 'Sections',
                'lhs_table'=> 'sections',
                'lhs_key' => 'id',
                'rhs_module'=> 'Realty',
                'rhs_table'=> 'realty',
                'rhs_key' => 'section_id',
                'relationship_type'=>'one-to-many'
            ),
),
	'optimistic_locking'=>true,
		'unified_search'=>true,
	);
if (!class_exists('VardefManager')){
        require_once('include/SugarObjects/VardefManager.php');
}
VardefManager::createVardef('Sections','Sections', array('basic','assignable'));
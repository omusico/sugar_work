<?php
/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 */

$dictionary["Buildings"]["fields"]["realty_buildings"] =
    array (
        'name' => 'realty_buildings',
        'type' => 'link',
        'relationship' => 'realty_buildings',
        'module'=>'Buildings',
        'bean_name'=>'Buildings',
        'source'=>'non-db',
        'vname'=>'LBL_REALTY_BUILDINGS',
    );


$dictionary["Buildings"]["fields"]["realtytemplates_buildings"] =
    array (
        'name' => 'realtytemplates_buildings',
        'type' => 'link',
        'relationship' => 'realtytemplates_buildings',
        'module'=>'Buildings',
        'bean_name'=>'Buildings',
        'source'=>'non-db',
        'vname'=>'LBL_REALTYTEMPLATES_BUILDINGS',
    );

$dictionary['Buildings']['relationships']['realty_buildings'] =
    array (
        'lhs_module'=> 'Buildings',
        'lhs_table'=> 'buildings',
        'lhs_key' => 'id',
        'rhs_module'=> 'Realty',
        'rhs_table'=> 'realty',
        'rhs_key' => 'building_id',
        'relationship_type'=>'one-to-many'
    );


$dictionary['Buildings']['relationships']['realtytemplates_buildings'] =
    array (
        'lhs_module'=> 'Buildings',
        'lhs_table'=> 'buildings',
        'lhs_key' => 'id',
        'rhs_module'=> 'RealtyTemplates',
        'rhs_table'=> 'realtytemplates',
        'rhs_key' => 'building_id',
        'relationship_type'=>'one-to-many'
    );
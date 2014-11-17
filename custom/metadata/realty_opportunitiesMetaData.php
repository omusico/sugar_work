<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$dictionary['realty_opportunities'] = array (
    'table' => 'realty_opportunities_table',
    'fields' => array (
        array('name' =>'id', 'type' =>'varchar', 'len'=>'36')
    , array('name' =>'opportunity_id', 'type' =>'varchar', 'len'=>'36', )
    , array('name' =>'realty_id', 'type' =>'varchar', 'len'=>'36', )
    , array ('name' => 'date_modified','type' => 'datetime')
    , array('name' =>'deleted', 'type' =>'bool', 'len'=>'1', 'default'=>'0', 'required'=>false)
    ),

    'indices' => array (
        array('name' =>'realty_opportunitiespk', 'type' =>'primary', 'fields'=>array('id'))
    , array('name' => 'idx_realty_opportunity', 'type'=>'alternate_key', 'fields'=>array('realty_id','opportunity_id'))
    , array('name' => 'idx_realid_del_accid', 'type' => 'index', 'fields'=> array('opportunity_id', 'deleted', 'realty_id'))
    )

,'relationships' => array (
        'realty_opportunities' => array(
            'lhs_module'=> 'Realty',
            'lhs_table'=> 'realty',
            'lhs_key' => 'id',
            'rhs_module'=> 'Opportunities',
            'rhs_table'=> 'opportunities',
            'rhs_key' => 'id',
            'relationship_type'=>'many-to-many',
            'join_table'=> 'realty_opportunities_table',
            'join_key_lhs'=>'realty_id',
            'join_key_rhs'=>'opportunity_id')
    ),
);


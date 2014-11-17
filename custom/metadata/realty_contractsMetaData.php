<?php
/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 */
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$dictionary['realty_contracts'] = array (
    'table' => 'realty_contracts_table',
    'fields' => array (
        array('name' =>'id', 'type' =>'varchar', 'len'=>'36')
    , array('name' =>'realty_id', 'type' =>'varchar', 'len'=>'36', )
    , array('name' =>'contract_id', 'type' =>'varchar', 'len'=>'36', )
    , array ('name' => 'date_modified','type' => 'datetime')
    , array('name' =>'deleted', 'type' =>'bool', 'len'=>'1', 'default'=>'0', 'required'=>false)
    ),

    'indices' => array (
        array('name' =>'realty_contractspk', 'type' =>'primary', 'fields'=>array('id'))
    , array('name' => 'idx_realty_contract', 'type'=>'alternate_key', 'fields'=>array('contract_id','realty_id'))
    , array('name' => 'idx_realid_del_contrid', 'type' => 'index', 'fields'=> array('realty_id', 'deleted', 'contract_id'))
    )

,'relationships' => array (
        'realty_contracts' => array(
            'lhs_module'=> 'Contract',
            'lhs_table'=> 'contract',
            'lhs_key' => 'id',
            'rhs_module'=> 'Realty',
            'rhs_table'=> 'realty',
            'rhs_key' => 'id',
            'relationship_type'=>'many-to-many',
            'join_table'=> 'realty_contracts_table',
            'join_key_lhs'=>'contract_id',
            'join_key_rhs'=>'realty_id')
    ),

);
<?php
/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 */
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$dictionary['realty_accounts_m_to_m'] = array (
    'table' => 'realty_accounts_m_to_m_table',
    'fields' => array (
        array('name' =>'id', 'type' =>'varchar', 'len'=>'36')
    , array('name' =>'realty_id', 'type' =>'varchar', 'len'=>'36', )
    , array('name' =>'account_id', 'type' =>'varchar', 'len'=>'36', )
    , array ('name' => 'date_modified','type' => 'datetime')
    , array('name' =>'deleted', 'type' =>'bool', 'len'=>'1', 'default'=>'0', 'required'=>false)
    ),

    'indices' => array (
        array('name' =>'realty_accounts_m_to_mpk', 'type' =>'primary', 'fields'=>array('id'))
    , array('name' => 'idx_realty_accounts_m_to_m', 'type'=>'alternate_key', 'fields'=>array('account_id','realty_id'))
    , array('name' => 'idx_realid_del_accid', 'type' => 'index', 'fields'=> array('realty_id', 'deleted', 'account_id'))
    )

,'relationships' => array (
        'realty_accounts_m_to_m' => array(
            'lhs_module'=> 'Accounts',
            'lhs_table'=> 'accounts',
            'lhs_key' => 'id',
            'rhs_module'=> 'Realty',
            'rhs_table'=> 'realty',
            'rhs_key' => 'id',
            'relationship_type'=>'many-to-many',
            'join_table'=> 'realty_accounts_m_to_m_table',
            'join_key_lhs'=>'account_id',
            'join_key_rhs'=>'realty_id')
    ),

);
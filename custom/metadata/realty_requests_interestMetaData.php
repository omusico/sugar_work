<?php
/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 */
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$dictionary['realty_requests_interest'] = array (
    'table' => 'realty_requests_interest_table',
    'fields' => array (
      array('name' =>'id', 'type' =>'varchar', 'len'=>'36')
    , array('name' =>'realty_id', 'type' =>'varchar', 'len'=>'36', )
    , array('name' =>'request_id', 'type' =>'varchar', 'len'=>'36', )
    , array('name' =>'presentation_text', 'type' =>'varchar')
    , array('name' =>'presentation_checked', 'type' =>'varchar')
    , array('name' =>'date_modified','type' => 'datetime')
    , array('name' =>'deleted', 'type' =>'bool', 'len'=>'1', 'default'=>'0', 'required'=>false)
    ),

    'indices' => array (
      array('name' =>'realty_requests_interestspk', 'type' =>'primary', 'fields'=>array('id'))
    , array('name' => 'idx_realty_requests_interest', 'type'=>'alternate_key', 'fields'=>array('request_id','realty_id'))
    , array('name' => 'idx_realid_del_reqid', 'type' => 'index', 'fields'=> array('realty_id', 'deleted', 'request_id'))
    )

,'relationships' => array (
        'realty_requests_interest' => array(
            'lhs_module'=> 'Request',
            'lhs_table'=> 'request',
            'lhs_key' => 'id',
            'rhs_module'=> 'Realty',
            'rhs_table'=> 'realty',
            'rhs_key' => 'id',
            'relationship_type'=>'many-to-many',
            'join_table'=> 'realty_requests_interest_table',
            'join_key_lhs'=>'request_id',
            'join_key_rhs'=>'realty_id')
    ),

);
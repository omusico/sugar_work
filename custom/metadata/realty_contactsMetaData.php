<?php
/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 */
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$dictionary['realty_contacts'] = array (
    'table' => 'realty_contacts_table',
    'fields' => array (
        array('name' =>'id', 'type' =>'varchar', 'len'=>'36')
    , array('name' =>'realty_id', 'type' =>'varchar', 'len'=>'36', )
    , array('name' =>'contact_id', 'type' =>'varchar', 'len'=>'36', )
    , array ('name' => 'date_modified','type' => 'datetime')
    , array('name' =>'deleted', 'type' =>'bool', 'len'=>'1', 'default'=>'0', 'required'=>false)
    ),

    'indices' => array (
        array('name' =>'realty_contactspk', 'type' =>'primary', 'fields'=>array('id'))
    , array('name' => 'idx_realty_contact', 'type'=>'alternate_key', 'fields'=>array('contact_id','realty_id'))
    , array('name' => 'idx_realid_del_conid', 'type' => 'index', 'fields'=> array('realty_id', 'deleted', 'contact_id'))
    )

,'relationships' => array (
        'realty_contacts' => array(
            'lhs_module'=> 'Contacts',
            'lhs_table'=> 'contacts',
            'lhs_key' => 'id',
            'rhs_module'=> 'Realty',
            'rhs_table'=> 'realty',
            'rhs_key' => 'id',
            'relationship_type'=>'many-to-many',
            'join_table'=> 'realty_contacts_table',
            'join_key_lhs'=>'contact_id',
            'join_key_rhs'=>'realty_id')
    ),

);
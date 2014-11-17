<?php
/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 */
$dictionary["Contact"]["fields"]["contract_contacts"] =
    array (
        'name' => 'contract_contacts',
        'type' => 'link',
        'relationship' => 'contract_contacts',
        'module'=>'Contract',
        'bean_name'=>'Contract',
        'source'=>'non-db',
        'vname'=>'LBL_CONTRACT',
    );


$dictionary['Contact']['relationships']['contract_contacts'] =
    array (
        'lhs_module'=> 'Contacts',
        'lhs_table'=> 'contacts',
        'lhs_key' => 'id',
        'rhs_module'=> 'Contract',
        'rhs_table'=> 'contract',
        'rhs_key' => 'contact_id',
        'relationship_type'=>'one-to-many'
    );
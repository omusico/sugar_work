<?php
/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 */
$dictionary["Account"]["fields"]["contract_accounts"] =
    array (
        'name' => 'contract_accounts',
        'type' => 'link',
        'relationship' => 'contract_accounts',
        'module'=>'Contract',
        'bean_name'=>'Contract',
        'source'=>'non-db',
        'vname'=>'LBL_CONTRACT',
    );


$dictionary['Account']['relationships']['contract_accounts'] =
    array (
        'lhs_module'=> 'Accounts',
        'lhs_table'=> 'accounts',
        'lhs_key' => 'id',
        'rhs_module'=> 'Contract',
        'rhs_table'=> 'contract',
        'rhs_key' => 'account_id',
        'relationship_type'=>'one-to-many'
    );
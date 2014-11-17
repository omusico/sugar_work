<?php
/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 */


//// Relationship 1:M
$dictionary["Account"]["fields"]["realty_accounts"] =
    array (
        'name' => 'realty_accounts',
        'type' => 'link',
        'relationship' => 'realty_accounts',
        'module'=>'Realty',
        'bean_name'=>'Realty',
        'source'=>'non-db',
        'vname'=>'LBL_REALTY_ACCOUNTS',
    );


$dictionary['Account']['relationships']['realty_accounts'] =
    array (
        'lhs_module'=> 'Accounts',
        'lhs_table'=> 'accounts',
        'lhs_key' => 'id',
        'rhs_module'=> 'Realty',
        'rhs_table'=> 'realty',
        'rhs_key' => 'account_id',
        'relationship_type'=>'one-to-many'
    );
//
//// Relationship M:M
//
//$dictionary['Account']['fields']['realty_accounts_m_to_m'] =
//    array (
//        'name' => 'realty_accounts_m_to_m',
//        'type' => 'link',
//        'relationship' => 'realty_accounts_m_to_m',
//        'source'=>'non-db',
//        'vname'=>'LBL_ACCOUNTS_INVESTOR',
//    );

//Функция
//$dictionary['Account']['fields']['realty_accounts_interest'] =
//    array (
//        'name' => 'realty_accounts_interest',
//        'type' => 'link',
//        'relationship' => 'realty_accounts_interest',
//        'source'=>'non-db',
//        'vname'=>'LBL_REALTY_ACCOUNTS_INTEREST',
//    );

$dictionary['Account']['fields']['realty_accounts_rent'] =
    array (
        'name' => 'realty_accounts_rent',
        'type' => 'link',
        'relationship' => 'realty_accounts_rent',
        'source'=>'non-db',
        'vname'=>'LBL_REALTY_ACCOUNTS_RENT',
    );

$dictionary['Account']['fields']['realty_accounts_buying'] =
    array (
        'name' => 'realty_accounts_buying',
        'type' => 'link',
        'relationship' => 'realty_accounts_buying',
        'source'=>'non-db',
        'vname'=>'LBL_REALTY_ACCOUNTS_BUYING',
    );


$dictionary["Account"]["fields"]["type_module"] = array (
    'required' => false,
    //'source' => 'non-db',
    'name' => 'type_module',
    'vname' => 'LBL_TYPE_MODULE',
    'type' => 'varchar',
    'default'=>'Accounts',
);

$dictionary['Account']['fields']['currency'] =
    array (        
                'name' => 'currency',
                'vname' => 'LBL_CURRENCY',
                'type' => 'enum',
                'options' => 'realty_currency_list',
            );
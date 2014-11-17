<?php
/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 */
$dictionary['Contact']['fields']['realty_contacts'] =
    array (
        'name' => 'realty_contacts',
        'type' => 'link',
        'relationship' => 'realty_contacts',
        'source'=>'non-db',
        'vname'=>'LBL_REALTY_CONTACTS',
        'module'=>'Realty',
        'bean_name'=>'Realty',
    );

$dictionary['Contact']['relationships']['realty_contacts'] =
    array (
        'lhs_module'=> 'Contacts',
        'lhs_table'=> 'contacts',
        'lhs_key' => 'id',
        'rhs_module'=> 'Realty',
        'rhs_table'=> 'realty',
        'rhs_key' => 'contact_id',
        'relationship_type'=>'one-to-many'
    );


$dictionary['Contact']['fields']['realty_contacts_interest'] =
    array (
        'name' => 'realty_contacts_interest',
        'type' => 'link',
        'relationship' => 'realty_contacts_interest',
        'source'=>'non-db',
        'vname'=>'LBL_REALTY_CONTACTS_INTEREST',
    );


$dictionary['Contact']['fields']['realty_contacts_rent'] =
    array (
        'name' => 'realty_contacts_rent',
        'type' => 'link',
        'relationship' => 'realty_contacts_rent',
        'source'=>'non-db',
        'vname'=>'LBL_REALTY_CONTACTS_RENT',
    );


$dictionary['Contact']['fields']['realty_contacts_buying'] =
    array (
        'name' => 'realty_contacts_buying',
        'type' => 'link',
        'relationship' => 'realty_contacts_buying',
        'source'=>'non-db',
        'vname'=>'LBL_REALTY_CONTACTS_BUYING',
    );

$dictionary['Contact']['fields']['currency'] =
    array (        
                'name' => 'currency',
                'vname' => 'LBL_CURRENCY',
                'type' => 'enum',
                'options' => 'realty_currency_list',
            );

$dictionary["Contact"]["fields"]["type_module"] = array (
    'required' => false,
    //'source' => 'non-db',
    'name' => 'type_module',
    'vname' => 'LBL_TYPE_MODULE',
    'type' => 'varchar',
    'default'=>'Contacts',
);

$dictionary['Contact']['fields']['currency'] =
    array (        
                'name' => 'currency',
                'vname' => 'LBL_CURRENCY',
                'type' => 'enum',
                'options' => 'realty_currency_list',
            );
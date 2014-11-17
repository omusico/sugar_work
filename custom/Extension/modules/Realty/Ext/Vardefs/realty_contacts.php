<?php

//$dictionary['Realty']['fields']['realty_contacts'] =
//    array (
//        'name' => 'realty_contacts',
//        'type' => 'link',
//        'relationship' => 'realty_contacts',
//        'source'=>'non-db',
//        'vname'=>'LBL_REALTY_CONTACTS',
//    );

$dictionary['Realty']['fields']['add_to_kXML_list'] =
    array (
    'name' => 'add_to_kXML_list',
    'vname' => 'LBL_ADD_TO_KXML_LIST',
    'type' => 'multienum',
    'isMultiSelect' => true,
    'options' => 'kXML_list',
    );

$dictionary['Realty']['fields']['realty_contacts_interest'] =
    array (
        'name' => 'realty_contacts_interest',
        'type' => 'link',
        'relationship' => 'realty_contacts_interest',
        'source'=>'non-db',
        'vname'=>'LBL_REALTY_CONTACTS_INTEREST',
    );

$dictionary['Realty']['fields']['realty_contacts_rent'] =
    array (
        'name' => 'realty_contacts_rent',
        'type' => 'link',
        'relationship' => 'realty_contacts_rent',
        'source'=>'non-db',
        'vname'=>'LBL_REALTY_CONTACTS_RENT',
    );

$dictionary['Realty']['fields']['realty_contacts_buying'] =
    array (
        'name' => 'realty_contacts_buying',
        'type' => 'link',
        'relationship' => 'realty_contacts_buying',
        'source'=>'non-db',
        'vname'=>'LBL_REALTY_CONTACTS_BUYING',
    );
<?php
/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 */
// Relationship M:M

$dictionary['Realty']['fields']['realty_accounts_m_to_m'] =
    array (
        'name' => 'realty_accounts_m_to_m',
        'type' => 'link',
        'relationship' => 'realty_accounts_m_to_m',
        'source'=>'non-db',
        'vname'=>'LBL_ACCOUNTS_INVESTOR',
    );

$dictionary['Realty']['fields']['realty_accounts_rent'] =
    array (
        'name' => 'realty_accounts_rent',
        'type' => 'link',
        'relationship' => 'realty_accounts_rent',
        'source'=>'non-db',
        'vname'=>'LBL_REALTY_ACCOUNTS_RENT',
    );

$dictionary['Realty']['fields']['realty_accounts_interest'] =
    array (
        'name' => 'realty_accounts_interest',
        'type' => 'link',
        'relationship' => 'realty_accounts_interest',
        'source'=>'non-db',
        'vname'=>'LBL_REALTY_ACCOUNTS_INTEREST',
    );

$dictionary['Realty']['fields']['realty_accounts_buying'] =
    array (
        'name' => 'realty_accounts_buying',
        'type' => 'link',
        'relationship' => 'realty_accounts_buying',
        'source'=>'non-db',
        'vname'=>'LBL_REALTY_ACCOUNTS_BUYING',
    );
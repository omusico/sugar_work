<?php
/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 */
// Relationship M:M

$dictionary['RealtyTemplates']['fields']['realtytemplates_accounts_m_to_m'] =
    array (
        'name' => 'realtytemplates_accounts_m_to_m',
        'type' => 'link',
        'relationship' => 'realtytemplates_accounts_m_to_m',
        'source'=>'non-db',
        'vname'=>'LBL_ACCOUNTS_INVESTOR',
    );

$dictionary['RealtyTemplates']['fields']['realtytemplates_accounts_rent'] =
    array (
        'name' => 'realtytemplates_accounts_rent',
        'type' => 'link',
        'relationship' => 'realtytemplates_accounts_rent',
        'source'=>'non-db',
        'vname'=>'LBL_REALTYTEMPLATES_ACCOUNTS_RENT',
    );

$dictionary['RealtyTemplates']['fields']['realtytemplates_accounts_interest'] =
    array (
        'name' => 'realtytemplates_accounts_interest',
        'type' => 'link',
        'relationship' => 'realtytemplates_accounts_interest',
        'source'=>'non-db',
        'vname'=>'LBL_REALTYTEMPLATES_ACCOUNTS_INTEREST',
    );

$dictionary['RealtyTemplates']['fields']['realtytemplates_accounts_buying'] =
    array (
        'name' => 'realtytemplates_accounts_buying',
        'type' => 'link',
        'relationship' => 'realtytemplates_accounts_buying',
        'source'=>'non-db',
        'vname'=>'LBL_REALTYTEMPLATES_ACCOUNTS_BUYING',
    );
<?php
/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 */
$dictionary['Opportunity']['fields']['type_of_realty'] =
    array (
        'name' => 'type_of_realty',
        'vname' => 'LBL_TYPE_OF_REALTY',
        'type' => 'enum',
        'options' => 'type_of_opportunity_list'
    );

$dictionary['Opportunity']['fields']['custom_currency'] =
    array (
        'name' => 'custom_currency',
        'vname' => 'LBL_CUSTOM_CURRENCY',
        'type' => 'enum',
        'options' => 'realty_currency_list'
    );

$dictionary['Opportunity']['fields']['amount_in_words'] =
    array (
        'name' => 'amount_in_words',
        'vname' => 'LBL_AMOUNT_IN_WORDS',
        'type' => 'varchar',
    );

$dictionary['Opportunity']['fields']['type_of_opportunity'] =
    array (
        'name' => 'type_of_opportunity',
        'vname' => 'LBL_TYPE_OF_OPPORTUNITY',
        'type' => 'enum',
	'options' => 'operation_realty_list',
    );

$dictionary['Opportunity']['fields']['period'] =
    array (
        'name' => 'period',
        'vname' => 'LBL_PERIOD',
        'type' => 'int',
    );
$dictionary['Opportunity']['fields']['cost_for_period'] =
    array (
        'name' => 'cost_for_period',
        'vname' => 'LBL_COST_FOR_PERIOD',
        'type' => 'int',
    );
$dictionary['Opportunity']['fields']['sales_stage']['options'] = "custom_sales_stage_list";
$dictionary['Opportunity']['fields']['account_name']['required'] = false;
$dictionary['Opportunity']['fields']['account_id']['required'] = false;
$dictionary['Opportunity']['fields']['name']['len'] = 500;

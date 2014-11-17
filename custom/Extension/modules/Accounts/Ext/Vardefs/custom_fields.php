<?php
/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 */
//$dictionary['Account']['fields']['operation'] = array(
//
//    'name' => 'operation',
//    'vname' => 'LBL_OPERATION',
//    'type' => 'enum',
//    'options' => 'operation_realty_list',
//);

//$dictionary['Account']['fields']['type_of_realty'] = array(
//
//    'name' => 'type_of_realty',
//    'vname' => 'LBL_TYPE_OF_REALTY',
//    'type' => 'enum',
//    'options' => 'type_of_realty_list',
//);

//$dictionary['Account']['fields']['kind_of_realty'] = array(
//
//    'name' => 'kind_of_realty',
//    'vname' => 'LBL_KIND_OF_REALTY',
//    'type' => 'enum',
//    'options' => 'kind_of_realty_list',
//);

//$dictionary['Account']['fields']['rooms_quantity'] = array(
//
//    'name' => 'rooms_quantity',
//    'vname' => 'LBL_ROOMS_QUANTITY',
//    'type' => 'int',
//);

//$dictionary['Account']['fields']['cost_to'] = array(
//
//    'name' => 'cost_to',
//    'vname' => 'LBL_COST_TO',
//    'type' => 'float',
//    'dbtype' => 'double',
//    'precision' => '2',
//    'required' => true,
//);

//$dictionary['Account']['fields']['square_min'] = array(
//
//    'name' => 'square_min',
//    'vname' => 'LBL_MIN_SQUARE',
//    'type' => 'int',
//);

//$dictionary['Account']['fields']['square_max'] = array(
//
//    'name' => 'square_max',
//    'vname' => 'LBL_MAX_SQUARE',
//    'type' => 'int',
//);

//$dictionary['Account']['fields']['min_floor'] = array(
//
//    'name' => 'min_floor',
//    'vname' => 'LBL_MIN_FLOOR',
//    'type' => 'int',
//);
//
//$dictionary['Account']['fields']['max_floor'] = array(
//
//    'name' => 'max_floor',
//    'vname' => 'LBL_MAX_FLOOR',
//    'type' => 'int',
//);

//$dictionary['Account']['fields']['metro'] = array(
//
//    'name' => 'metro',
//    'vname' => 'LBL_METRO',
//    'type' => 'varchar',
//);
//
//$dictionary['Account']['fields']['layout'] = array(
//
//    'name' => 'layout',
//    'vname' => 'LBL_LAYOUT',
//    'type' => 'varchar',
//);
//
//$dictionary['Account']['fields']['state_of_object'] = array(
//
//    'name' => 'state_of_object',
//    'vname' => 'LBL_STATE_OF_OBJECT',
//    'type' => 'enum',
//    'options' => 'state_of_object_list',
//);
//
//$dictionary['Account']['fields']['address_city'] = array(
//
//    'name' => 'address_city',
//    'vname' => 'LBL_ADDRESS_CITY',
//    'type' => 'varchar',
//);
//
//$dictionary['Account']['fields']['address_country'] = array(
//
//    'name' => 'address_country',
//    'vname' => 'LBL_ADDRESS_COUNTRY',
//    'type' => 'varchar',
//);
//
//$dictionary['Account']['fields']['address_street'] = array(
//
//    'name' => 'address_street',
//    'vname' => 'LBL_ADDRESS_STREET',
//    'type' => 'varchar',
//);
//
//$dictionary['Account']['fields']['address_region'] = array(
//
//    'name' => 'address_region',
//    'vname' => 'LBL_ADDRESS_REGION',
//    'type' => 'varchar',
//);
//
$dictionary['Account']['fields']['main_address_region'] = array(

    'name' => 'main_address_region',
    'vname' => 'LBL_MAIN_ADDRESS_REGION',
    'type' => 'varchar',
);



$dictionary['Account']['fields']['main_address_city'] = array(

    'name' => 'main_address_city',
    'vname' => 'LBL_ADDRESS_CITY',
    'type' => 'varchar',
);

$dictionary['Account']['fields']['main_address_country'] = array(

    'name' => 'main_address_country',
    'vname' => 'LBL_ADDRESS_COUNTRY',
    'type' => 'varchar',
);

$dictionary['Account']['fields']['main_address_street'] = array(

    'name' => 'main_address_street',
    'vname' => 'LBL_ADDRESS_STREET',
    'type' => 'varchar',
);



$dictionary['Account']['fields']['main_address_city_jur'] = array(

    'name' => 'main_address_city_jur',
    'vname' => 'LBL_ADDRESS_CITY',
    'type' => 'varchar',
);

$dictionary['Account']['fields']['main_address_country_jur'] = array(

    'name' => 'main_address_country_jur',
    'vname' => 'LBL_ADDRESS_COUNTRY',
    'type' => 'varchar',
);

$dictionary['Account']['fields']['main_address_street_jur'] = array(

    'name' => 'main_address_street_jur',
    'vname' => 'LBL_ADDRESS_STREET',
    'type' => 'varchar',
);

$dictionary['Account']['fields']['address_house'] = array(

    'name' => 'address_house',
    'vname' => 'LBL_ADDRESS_HOUSE',
    'type' => 'varchar',
);
$dictionary['Account']['fields']['realty_description'] = array(

    'name' => 'realty_description',
    'vname' => 'LBL_REALTY_DESCRIPTION',
    'type' => 'text',
);

$dictionary['Account']['fields']['ogrn'] = array(

    'name' => 'ogrn',
    'vname' => 'LBL_OGRN',
    'type' => 'varchar',
);

$dictionary['Account']['fields']['inn'] = array(

    'name' => 'inn',
    'vname' => 'LBL_INN',
    'type' => 'varchar',
);

$dictionary['Account']['fields']['kpp'] = array(

    'name' => 'kpp',
    'vname' => 'LBL_KPP',
    'type' => 'varchar',
);

$dictionary["Account"]["fields"]["square"] = array (
    'required' => false,
    'source' => 'non-db',
    'name' => 'square',
    'vname' => 'LBL_SQUARE',
    'type' => 'int',
    'options' => 'numeric_range_search_dom',
    'enable_range_search' => '1',
);

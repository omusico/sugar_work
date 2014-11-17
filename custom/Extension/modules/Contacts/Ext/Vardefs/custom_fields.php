<?php
/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 */
 $dictionary['Contact']['fields']['operation'] = array(

     'name' => 'operation',
     'vname' => 'LBL_OPERATION',
     'type' => 'enum',
     'options' => 'operation_realty_list',
 );

$dictionary['Contact']['fields']['type_of_realty'] = array(

    'name' => 'type_of_realty',
    'vname' => 'LBL_TYPE_OF_REALTY',
    'type' => 'enum',
    'options' => 'type_of_realty_list',
);

$dictionary['Contact']['fields']['kind_of_realty'] = array(

    'name' => 'kind_of_realty',
    'vname' => 'LBL_KIND_OF_REALTY',
    'type' => 'enum',
    'options' => 'kind_of_realty_list',
);

$dictionary['Contact']['fields']['rooms_quantity'] = array(

    'name' => 'rooms_quantity',
    'vname' => 'LBL_ROOMS_QUANTITY',
    'type' => 'int',
);

$dictionary['Contact']['fields']['cost_to'] = array(

    'name' => 'cost_to',
    'vname' => 'LBL_COST_TO',
    'type' => 'float',
    'dbtype' => 'double',
    'precision' => '2',
    'required' => true,
);

$dictionary['Contact']['fields']['square_min'] = array(

    'name' => 'square_min',
    'vname' => 'LBL_MIN_SQUARE',
    'type' => 'int',
);

$dictionary['Contact']['fields']['square_max'] = array(

    'name' => 'square_max',
    'vname' => 'LBL_MAX_SQUARE',
    'type' => 'int',
);

$dictionary['Contact']['fields']['min_floor'] = array(

    'name' => 'min_floor',
    'vname' => 'LBL_MIN_FLOOR',
    'type' => 'int',
);

$dictionary['Contact']['fields']['max_floor'] = array(

    'name' => 'max_floor',
    'vname' => 'LBL_MAX_FLOOR',
    'type' => 'int',
);

$dictionary['Contact']['fields']['metro'] = array(

    'name' => 'metro',
    'vname' => 'LBL_METRO',
    'type' => 'varchar',
);

$dictionary['Contact']['fields']['layout'] = array(

    'name' => 'layout',
    'vname' => 'LBL_LAYOUT',
    'type' => 'varchar',
);

$dictionary['Contact']['fields']['state_of_object'] = array(

    'name' => 'state_of_object',
    'vname' => 'LBL_STATE_OF_OBJECT',
    'type' => 'enum',
    'options' => 'state_of_object_list',
);

$dictionary['Contact']['fields']['address_city'] = array(

    'name' => 'address_city',
    'vname' => 'LBL_ADDRESS_CITY',
    'type' => 'varchar',
);

$dictionary['Contact']['fields']['address_country'] = array(

    'name' => 'address_country',
    'vname' => 'LBL_ADDRESS_COUNTRY',
    'type' => 'varchar',
);

$dictionary['Contact']['fields']['address_street'] = array(

    'name' => 'address_street',
    'vname' => 'LBL_ADDRESS_STREET',
    'type' => 'varchar',
);

$dictionary['Contact']['fields']['address_house'] = array(

    'name' => 'address_house',
    'vname' => 'LBL_ADDRESS_HOUSE',
    'type' => 'varchar',
);

$dictionary['Contact']['fields']['address_appartment'] = array(

    'name' => 'address_appartment',
    'vname' => 'LBL_ADDRESS_APPARTMENT',
    'type' => 'varchar',
);

$dictionary['Contact']['fields']['address_region'] = array(

    'name' => 'address_region',
    'vname' => 'LBL_ADDRESS_REGION',
    'type' => 'varchar',
);

$dictionary['Contact']['fields']['main_address_region'] = array(

    'name' => 'main_address_region',
    'vname' => 'LBL_MAIN_ADDRESS_REGION',
    'type' => 'varchar',
);


$dictionary['Contact']['fields']['main_address_city'] = array(

    'name' => 'main_address_city',
    'vname' => 'LBL_ADDRESS_CITY',
    'type' => 'varchar',
);

$dictionary['Contact']['fields']['main_address_country'] = array(

    'name' => 'main_address_country',
    'vname' => 'LBL_ADDRESS_COUNTRY',
    'type' => 'varchar',
);

$dictionary['Contact']['fields']['main_address_street'] = array(

    'name' => 'main_address_street',
    'vname' => 'LBL_ADDRESS_STREET',
    'type' => 'varchar',
);








$dictionary['Contact']['fields']['contact_district'] = array(

    'name' => 'contact_district',
    'vname' => 'LBL_CONTACT_DISTRICT',
    'type' => 'varchar',
);

$dictionary["Contact"]["fields"]["square"] = array (
    'required' => false,
    'source' => 'non-db',
    'name' => 'square',
    'vname' => 'LBL_SQUARE',
    'type' => 'int',
    'options' => 'numeric_range_search_dom',
    'enable_range_search' => '1',
);

$dictionary['Contact']['fields']['realty_description'] = array(

    'name' => 'realty_description',
    'vname' => 'LBL_REALTY_DESCRIPTION',
    'type' => 'text',
);

$dictionary['Contact']['fields']['passport_number'] = array(

    'name' => 'passport_number',
    'vname' => 'LBL_PASSPORT_NUMBER',
    'type' => 'varchar',
);

$dictionary['Contact']['fields']['passport_authority'] = array(

    'name' => 'passport_authority',
    'vname' => 'LBL_PASSPORT_AUTHORITY',
    'type' => 'varchar',
);

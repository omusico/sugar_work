<?php
$module_name = 'Realty';
$searchdefs [$module_name] = 
array (
  'layout' => 
  array (
    'basic_search' => 
    array (
      'type_of_realty' => 
      array (
        'type' => 'enum',
        'label' => 'LBL_TYPE_OF_REALTY',
        'width' => '10%',
        'default' => true,
        'name' => 'type_of_realty',
      ),
      'kind_of_realty' => 
      array (
        'type' => 'enum',
        'label' => 'LBL_KIND_OF_REALTY',
        'width' => '10%',
        'default' => true,
        'name' => 'kind_of_realty',
      ),
      'name' => 
      array (
        'name' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'cost' => 
      array (
        'type' => 'int',
        'label' => 'LBL_COST',
        'width' => '10%',
        'default' => true,
        'name' => 'cost',
      ),
      'rooms_quantity' => 
      array (
        'type' => 'int',
        'label' => 'LBL_ROOMS_QUANTITY',
        'width' => '10%',
        'default' => true,
        'name' => 'rooms_quantity',
      ),
      'square' => 
      array (
        'type' => 'int',
        'label' => 'LBL_SQUARE',
        'width' => '10%',
        'default' => true,
        'name' => 'square',
      ),
      'floor' => 
      array (
        'type' => 'int',
        'label' => 'LBL_FLOOR',
        'width' => '10%',
        'default' => true,
        'name' => 'floor',
      ),
      'address_city' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_ADDRESS_CITY',
        'width' => '10%',
        'default' => true,
        'name' => 'address_city',
      ),
      'metro' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_METRO',
        'width' => '10%',
        'default' => true,
        'name' => 'metro',
      ),
      'operation' => 
      array (
        'type' => 'enum',
        'label' => 'LBL_OPERATION',
        'width' => '10%',
        'default' => true,
        'name' => 'operation',
      ),
    ),
    'advanced_search' => 
    array (
      'address_city' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_ADDRESS_CITY',
        'width' => '10%',
        'default' => true,
        'name' => 'address_city',
      ),
      'account_name' => 
      array (
        'type' => 'relate',
        'studio' => 'visible',
        'label' => 'LBL_ACCOUNT_NAME',
        'id' => 'ACCOUNT_ID',
        'link' => true,
        'width' => '10%',
        'default' => true,
        'name' => 'account_name',
      ),
      'name' => 
      array (
        'name' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'date_modified' => 
      array (
        'type' => 'datetime',
        'label' => 'LBL_DATE_MODIFIED',
        'width' => '10%',
        'default' => true,
        'name' => 'date_modified',
      ),
      'last_contact' => 
      array (
        'type' => 'date',
        'label' => 'LBL_LAST_CONTACT',
        'width' => '10%',
        'default' => true,
        'name' => 'last_contact',
      ),
      'number_of_floors' => 
      array (
        'type' => 'int',
        'label' => 'LBL_NUMBER_OF_FLOORS',
        'width' => '10%',
        'default' => true,
        'name' => 'number_of_floors',
      ),
      'balcon' => 
      array (
        'type' => 'bool',
        'label' => 'LBL_BALCON',
        'width' => '10%',
        'default' => true,
        'name' => 'balcon',
      ),
      'phone_bool' => 
      array (
        'type' => 'bool',
        'label' => 'LBL_PHONE_BOOL',
        'width' => '10%',
        'default' => true,
        'name' => 'phone_bool',
      ),
      'boiler' => 
      array (
        'type' => 'bool',
        'label' => 'LBL_BOILER',
        'width' => '10%',
        'default' => true,
        'name' => 'boiler',
      ),
      'fridge' => 
      array (
        'type' => 'bool',
        'label' => 'LBL_FRIDGE',
        'width' => '10%',
        'default' => true,
        'name' => 'fridge',
      ),
      'tv' => 
      array (
        'type' => 'bool',
        'label' => 'LBL_TV',
        'width' => '10%',
        'default' => true,
        'name' => 'tv',
      ),
      'washing_m' => 
      array (
        'type' => 'bool',
        'label' => 'LBL_WASHING_M',
        'width' => '10%',
        'default' => true,
        'name' => 'washing_m',
      ),
      'conditioning' => 
      array (
        'type' => 'bool',
        'label' => 'LBL_CONDITIONING',
        'width' => '10%',
        'default' => true,
        'name' => 'conditioning',
      ),
      'internet' => 
      array (
        'type' => 'bool',
        'label' => 'LBL_INTERNET',
        'width' => '10%',
        'default' => true,
        'name' => 'internet',
      ),
      'h2o' => 
      array (
        'type' => 'enum',
        'label' => 'LBL_H2O',
        'width' => '10%',
        'default' => true,
        'name' => 'h2o',
      ),
      'gaz' => 
      array (
        'type' => 'enum',
        'label' => 'LBL_GAZ',
        'width' => '10%',
        'default' => true,
        'name' => 'gaz',
      ),
      'parking' => 
      array (
        'type' => 'bool',
        'label' => 'LBL_PARKING',
        'width' => '10%',
        'default' => true,
        'name' => 'parking',
      ),
      'assigned_user_id' => 
      array (
        'name' => 'assigned_user_id',
        'label' => 'LBL_ASSIGNED_TO',
        'type' => 'enum',
        'function' => 
        array (
          'name' => 'get_user_array',
          'params' => 
          array (
            0 => false,
          ),
        ),
        'default' => true,
        'width' => '10%',
      ),
    ),
  ),
  'templateMeta' => 
  array (
    'maxColumns' => '3',
    'maxColumnsBasic' => '4',
    'widths' => 
    array (
      'label' => '10',
      'field' => '30',
    ),
  ),
);
?>

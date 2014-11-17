<?php
$module_name = 'Buildings';
$searchdefs [$module_name] = 
array (
  'layout' => 
  array (
    'basic_search' => 
    array (
      'code_inc' => 
      array (
        'name' => 'code_inc',
        'default' => true,
        'width' => '10%',
      ),
      /*'name' => 
      array (
        'name' => 'name',
        'default' => true,
        'width' => '10%',
      ),*/
      'address_city' => 
      array (
        'type' => 'varchar',
        'default' => true,
        'label' => 'LBL_ADDRESS_CITY',
        'width' => '10%',
        'name' => 'address_city',
      ),
      'current_square' => 
      array (
        'type' => 'int',
        'label' => 'LBL_CURRENT_SQUARE',
        'width' => '10%',
        'default' => true,
        'name' => 'current_square',
      ),
      'type_of_building' => 
      array (
        'type' => 'enum',
        'label' => 'LBL_TYPE_OF_BUILDING',
        'width' => '10%',
        'default' => true,
        'name' => 'type_of_building',
      ),
      'current_user_only' => 
      array (
        'name' => 'current_user_only',
        'label' => 'LBL_CURRENT_USER_FILTER',
        'type' => 'bool',
        'default' => true,
        'width' => '10%',
      ),
    ),
    'advanced_search' => 
    array (
      'code_inc' => 
      array (
        'name' => 'code_inc',
        'default' => true,
        'width' => '10%',
      ),
      'name' => 
      array (
        'name' => 'name',
        'default' => true,
        'width' => '10%',
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
      'date_entered' => 
      array (
        'type' => 'datetime',
        'label' => 'LBL_DATE_ENTERED',
        'width' => '10%',
        'default' => true,
        'name' => 'date_entered',
      ),
      'number_of_floors' => 
      array (
        'type' => 'int',
        'label' => 'LBL_NUMBER_OF_FLOORS',
        'width' => '10%',
        'default' => true,
        'name' => 'number_of_floors',
      ),
      'flats_quantity' => 
      array (
        'type' => 'int',
        'label' => 'LBL_FLATS_QUANTITY',
        'width' => '10%',
        'default' => true,
        'name' => 'flats_quantity',
      ),
      'address_country' => 
      array (
        'type' => 'varchar',
        'default' => true,
        'label' => 'LBL_ADDRESS_COUNTRY',
        'width' => '10%',
        'name' => 'address_country',
      ),
      'address_city' => 
      array (
        'type' => 'varchar',
        'default' => true,
        'label' => 'LBL_ADDRESS_CITY',
        'width' => '10%',
        'name' => 'address_city',
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

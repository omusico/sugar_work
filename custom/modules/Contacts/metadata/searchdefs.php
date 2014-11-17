<?php
$searchdefs ['Contacts'] = 
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
      'type' => 
      array (
        'type' => 'multienum',
        'label' => 'LBL_TYPE',
        'width' => '10%',
        'default' => true,
        'name' => 'type',
      ),
      'search_name' => 
      array (
        'name' => 'search_name',
        'label' => 'LBL_NAME',
        'type' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'phone_mobile' => 
      array (
        'type' => 'function',
        'label' => 'LBL_MOBILE_PHONE',
        'width' => '10%',
        'default' => true,
        'name' => 'phone_mobile',
      ),
      'address_city' => 
      array (
        'name' => 'address_city',
        'label' => 'LBL_CITY',
        'type' => 'name',
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
        'type' => 'name',
        'link' => true,
        'label' => 'LBL_NAME',
        'width' => '10%',
        'default' => true,
        'name' => 'name',
      ),
      'email' => 
      array (
        'name' => 'email',
        'label' => 'LBL_ANY_EMAIL',
        'type' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'phone' => 
      array (
        'name' => 'phone',
        'label' => 'LBL_ANY_PHONE',
        'type' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'address_street' => 
      array (
        'name' => 'address_street',
        'label' => 'LBL_ANY_ADDRESS',
        'type' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'address_city' => 
      array (
        'name' => 'address_city',
        'label' => 'LBL_CITY',
        'type' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'primary_address_country' => 
      array (
        'name' => 'primary_address_country',
        'label' => 'LBL_COUNTRY',
        'type' => 'name',
        'options' => 'countries_dom',
        'default' => true,
        'width' => '10%',
      ),
      'cost_to' => 
      array (
        'type' => 'int',
        'label' => 'LBL_COST_TO',
        'width' => '10%',
        'default' => true,
        'name' => 'cost_to',
      ),
      'square' => 
      array (
        'name' => 'square',
        'label' => 'LBL_SQUARE',
        'type' => 'int',
        'default' => true,
        'width' => '10%',
      ),
      'rooms_quantity' => 
      array (
        'type' => 'int',
        'label' => 'LBL_ROOMS_QUANTITY',
        'width' => '10%',
        'default' => true,
        'name' => 'rooms_quantity',
      ),
      'metro' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_METRO',
        'width' => '10%',
        'default' => true,
        'name' => 'metro',
      ),
      'type_of_realty' => 
      array (
        'type' => 'enum',
        'label' => 'LBL_TYPE_OF_REALTY',
        'width' => '10%',
        'default' => true,
        'name' => 'type_of_realty',
      ),
      'state_of_object' => 
      array (
        'type' => 'enum',
        'label' => 'LBL_STATE_OF_OBJECT',
        'width' => '10%',
        'default' => true,
        'name' => 'state_of_object',
      ),
      'operation' => 
      array (
        'type' => 'enum',
        'label' => 'LBL_OPERATION',
        'width' => '10%',
        'default' => true,
        'name' => 'operation',
      ),
      'assigned_user_id' => 
      array (
        'name' => 'assigned_user_id',
        'type' => 'enum',
        'label' => 'LBL_ASSIGNED_TO',
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

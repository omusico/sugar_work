<?php
$searchdefs ['Accounts'] = 
array (
  'layout' => 
  array (
    'basic_search' => 
    array (
      'name' => 
      array (
        'name' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'main_address_city' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_ADDRESS_CITY',
        'width' => '10%',
        'default' => true,
        'name' => 'main_address_city',
      ),
      'operation' => 
      array (
        'type' => 'enum',
        'label' => 'LBL_OPERATION',
        'width' => '10%',
        'default' => true,
        'name' => 'operation',
      ),
      'type_of_realty' => 
      array (
        'type' => 'enum',
        'label' => 'LBL_TYPE_OF_REALTY',
        'width' => '10%',
        'default' => true,
        'name' => 'type_of_realty',
      ),
    ),
    'advanced_search' => 
    array (
      'name' => 
      array (
        'name' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'website' => 
      array (
        'name' => 'website',
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
      'email' => 
      array (
        'name' => 'email',
        'label' => 'LBL_ANY_EMAIL',
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
      'billing_address_country' => 
      array (
        'name' => 'billing_address_country',
        'label' => 'LBL_COUNTRY',
        'type' => 'name',
        'options' => 'countries_dom',
        'default' => true,
        'width' => '10%',
      ),
      'cost_to' => 
      array (
        'type' => 'float',
        'label' => 'LBL_COST_TO',
        'width' => '10%',
        'default' => true,
        'name' => 'cost_to',
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
      'kind_of_realty' => 
      array (
        'type' => 'enum',
        'label' => 'LBL_KIND_OF_REALTY',
        'width' => '10%',
        'default' => true,
        'name' => 'kind_of_realty',
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

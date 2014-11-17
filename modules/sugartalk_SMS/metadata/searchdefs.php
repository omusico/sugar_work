<?php
$module_name = 'sugartalk_SMS';
$searchdefs [$module_name] = 
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
      'phone_number' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_PHONE_NUMBER',
        'width' => '10%',
        'default' => true,
        'name' => 'phone_number',
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
      'phone_number' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_PHONE_NUMBER',
        'width' => '10%',
        'default' => true,
        'name' => 'phone_number',
      ),
      'api_message' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_API_MESSAGE',
        'width' => '10%',
        'default' => true,
        'name' => 'api_message',
      ),
      'type' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_TYPE',
        'width' => '10%',
        'name' => 'type',
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
    'widths' => 
    array (
      'label' => '10',
      'field' => '30',
    ),
  ),
);
?>

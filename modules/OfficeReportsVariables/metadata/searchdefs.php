<?php
$module_name = 'OfficeReportsVariables';
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
      'friendly_name' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_FRIENDLY_NAME',
        'width' => '10%',
        'default' => true,
        'name' => 'friendly_name',
      ),
      'for_modules' => 
      array (
        'type' => 'multienum',
        'label' => 'LBL_FOR_MODULES',
        'width' => '10%',
        'default' => true,
        'name' => 'for_modules',
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
      'friendly_name' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_FRIENDLY_NAME',
        'width' => '10%',
        'default' => true,
        'name' => 'friendly_name',
      ),
      'for_modules' => 
      array (
        'type' => 'multienum',
        'label' => 'LBL_FOR_MODULES',
        'width' => '10%',
        'default' => true,
        'name' => 'for_modules',
      ),
      'created_by_name' => 
      array (
        'type' => 'relate',
        'link' => 'created_by_link',
        'label' => 'LBL_CREATED',
        'width' => '10%',
        'default' => true,
        'name' => 'created_by_name',
      ),
      'description' => 
      array (
        'type' => 'text',
        'label' => 'LBL_DESCRIPTION',
        'sortable' => false,
        'width' => '10%',
        'default' => true,
        'name' => 'description',
      ),
      'date_entered' => 
      array (
        'type' => 'datetime',
        'label' => 'LBL_DATE_ENTERED',
        'width' => '10%',
        'default' => true,
        'name' => 'date_entered',
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

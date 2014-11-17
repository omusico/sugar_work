<?php
$module_name = 'OfficeReportsMerge';
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
      'report_module' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_REPORT_MODULE',
        'width' => '10%',
        'default' => true,
        'name' => 'report_module',
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
      'report_module' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_REPORT_MODULE',
        'width' => '10%',
        'default' => true,
        'name' => 'report_module',
      ),
      'filename' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_TEMPLATENAME',
        'width' => '10%',
        'default' => true,
        'name' => 'filename',
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

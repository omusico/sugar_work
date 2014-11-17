<?php
$module_name = 'Department';
$viewdefs [$module_name] = 
array (
  'EditView' => 
  array (
    'templateMeta' => 
    array (
      'maxColumns' => '2',
      'widths' => 
      array (
        0 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
        1 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
      ),
      'includes' => 
      array (
        0 => 
        array (
          'file' => 'custom/modules/Department/js/hidefields.js',
        ),
      ),
      'useTabs' => false,
      'tabDefs' => 
      array (
        'DEFAULT' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
      'syncDetailEditViews' => true,
    ),
    'panels' => array (
      'default' => array (
        array (
          'name',
          'assigned_user_name',
        ),
        array (
          'branch_name',
          /* array (
            'name' => 'project',
            'label' => 'LBL_PROJECT',
          ), */
        ),
        array (
          '',
          array (
            'name' => 'type_of_realty',
            'label' => 'LBL_TYPE_OF_REALTY',
          ),
        ),
        array (
          'description',
          'kind_of_realty',
        ),
      ),
    ),
  ),
);
?>

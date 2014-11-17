<?php
$module_name = 'Sections';
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
    'panels' => 
    array (
      'default' => 
      array (
        0 => 
        array (
          0 => 'name',
          1 => 
          array (
            'name' => 'flats_quantity',
            'label' => 'LBL_FLATS_QUANTITY',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'building_name',
            'studio' => 'visible',
            'label' => 'LBL_BUILDING_NAME',
          ),
          1 => '',
        ),
      ),
    ),
  ),
);
?>

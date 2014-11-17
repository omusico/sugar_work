<?php
$module_name = 'OfficeReportsMerge';
$viewdefs [$module_name] = 
array (
  'QuickCreate' => 
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
    ),
    'panels' => 
    array (
      'default' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'name',
            'label' => 'LBL_NAME',
          ),
          1 => 
          array (
            'name' => 'assigned_user_name',
            'label' => 'LBL_ASSIGNED_TO_NAME',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'filename',
            'label' => 'LBL_FILEPATH',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'report_module',
            'label' => 'LBL_REPORT_MODULE',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'report_filename',
            'label' => 'LBL_REPORT_FILENAME',
          ),
          1 => '',
        ),
      ),
      'lbl_panel_vars' =>
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'vars',
            'studio' => 'visible',
            'label' => 'LBL_VARS',
          ),
        ),
      ),
      'lbl_panel_others' =>
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'description',
            'comment' => 'Full text of the note',
            'label' => 'LBL_DESCRIPTION',
          ),
        ),
      ),
    ),
  ),
);
?>

<?php
$module_name = 'OfficeReportsMerge';
$viewdefs [$module_name] = 
array (
  'DetailView' => 
  array (
    'templateMeta' => 
    array (
      'form' => 
      array (
        'buttons' => 
        array (
          0 => 'EDIT',
          1 => 'DELETE',
        ),
      ),
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
        1 => 
        array (
          'file' => 'include/javascript/overlibmws.js',
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
          0 => 'name',
          1 => 'assigned_user_name',
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'filename',
            'label' => 'LBL_TEMPLATENAME',
            'customCode' => '<a href="{$DOWNLOAD_TEMPLATE_LINK}">{$fields.filename.value}</a>'
          ),
          1 => 
          array (
            'name' => 'report_module',
            'label' => 'LBL_REPORT_MODULE',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'report_filename',
            'customLabel' => '{$MOD.LBL_REPORT_FILENAME}&nbsp;{sugar_help text=$MOD.HLP_REPORT_FILENAME WIDTH=500}',
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
            'name' => 'report_vars',
            'studio' => 'visible',
            'label' => 'LBL_VARS',
	        'customCode' => '{$REPORT_VARS_TREE}',
          ),
	      1 => '',
        ),
      ),
      'lbl_panel_others' =>
      array (
        0 => 
        array (
          0 => 'description',
        ),
      ),
    ),
  ),
);
?>

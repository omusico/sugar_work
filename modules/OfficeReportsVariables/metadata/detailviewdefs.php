<?php
$module_name = 'OfficeReportsVariables';
$viewdefs [$module_name] =
array (
  'DetailView' =>
  array (
    'templateMeta' =>
    array (
      'maxColumns' => '1',
      'widths' =>
      array (
        0 =>
        array (
          'label' => '10',
          'field' => '90',
        ),
      ),
      'includes' =>
      array (
        0 =>
        array (
          'file' => 'custom/include/OfficeReportsMerge/Prettify/prettify.js',
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
        ),
        1 =>
        array (
          0 =>
          array (
            'name' => 'friendly_name',
            'label' => 'LBL_FRIENDLY_NAME',
          ),
        ),
        2 =>
        array (
          0 =>
          array (
            'name' => 'code',
            'label' => 'LBL_CODE',
          	'customCode' => '<pre class="prettyprint">{$fields.code.value}</pre>',
          ),
        ),
        3 =>
        array (
          0 =>
          array (
            'name' => 'for_modules',
            'label' => 'LBL_FOR_MODULES',
          ),
        ),
        4 =>
        array (
          0 =>
          array (
            'name' => 'description',
            'comment' => 'Full text of the note',
            'label' => 'LBL_DESCRIPTION',
          ),
        ),
        5 =>
        array (
          0 =>
          array (
            'name' => 'date_entered',
            'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
            'label' => 'LBL_DATE_ENTERED',
          ),
        ),
      ),
    ),
  ),
);
?>

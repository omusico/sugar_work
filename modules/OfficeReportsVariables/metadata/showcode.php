<?php
$module_name = 'OfficeReportsVariables';
$viewdefs [$module_name] =
array (
  'EditView' =>
  array (
    'templateMeta' =>
    array (
      'form' =>
	  array (
	  	 'buttons' =>
	  		array (
	  		0 =>
	  			array(
	  				'customCode' => '<input title="{$MOD.LBL_BUTTON_BACK}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" type="submit" name="button" "onclick=\'this.form.action.value="{$returnAction}";\' value="  {$MOD.LBL_BUTTON_BACK}  ">'
	  			),
	  		),
	  ),
      'maxColumns' => '1',
      'widths' =>
      array (
        0 =>
        array (
          'label' => '10',
          'field' => '70',
        ),
      ),
      'includes' =>
      array (
        1 =>
        array (
          'file' => 'modules/OfficeReportsVariables/javascript/helper.js',
        ),
      ),
    ),
    'panels' =>
    array (
      'default' =>
      array (
        0 =>
        array (
          0 =>
          array (
            'name' => 'report_module',
            'label' => 'LBL_REPORT_MODULE',
            'customCode' => '<select id="select_report_module" name="report_module" onchange="change_report_module();">{$AVAILABLE_MODULES}</select>',
          ),
        ),
		1 =>
        array (
          0 =>
          array (
            'name' => 'related_module',
            'label' => 'LBL_RELATED_MODULE',
          	'customCode' => '<select id="select_related_modules" name="related_modules" onchange="change_relate_module(true);">{$RELATED_MODULES}</select>',
          ),
          1 => '',
        ),
        2 =>
        array (
          0 =>
          array (
            'name' => 'fields_modules',
            'label' => 'LBL_FIELDS_MODULE',
          	'customCode' => '<select id="select_module_fields" name="module_fields" onchange="change_module_fields();">
          					<optgroup label="{$MOD.LBL_MODULE_FIELDS}">
          					{$MODULE_FIELDS}
          					</optgroup>
          					<optgroup label="{$MOD.LBL_CUSTOM_FIELDS}">
							{$CUSTOM_FIELDS}
							</optgroup>
          					</select>',
          ),
          1 => '',
        ),
        3 =>
        array (
          0 =>
          array (
            'name' => 'code',
            'label' => 'LBL_CODE_INSERT',
          	'customCode' => '<input type="text" size="60" id="input_code" name="code" readonly=true>',
          ),
          1 => '',
        ),
      ),
    ),
  ),
);
?>

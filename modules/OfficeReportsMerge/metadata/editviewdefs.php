<?php
$module_name = 'OfficeReportsMerge';
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
      'form' => 
      array (
        'enctype' => 'multipart/form-data',
		'buttons' =>
		array (
		  0 =>
		  array (
		  'customCode' => '<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="button" type="submit" name="button" onclick="this.form.return_action.value=\'{$returnAction}\'; this.form.action.value=\'Save\'; return selectAllFields();" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " >
						   <input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" type="submit" name="button" onclick="this.form.action.value=\'{$returnAction}\';" value="  {$APP.LBL_CANCEL_BUTTON_LABEL}  ">'),
		),
      ),
      'includes' => 
      array (
        0 =>
        array (
          'file' => 'include/javascript/overlibmws.js',
        ),
		1 =>
		array (
		  'file' => 'modules/OfficeReportsMerge/javascript/editview.js',
		),
		2 =>
		array (
		  'file' => 'modules/OfficeReportsVariables/javascript/helper.js',
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
            'customLabel' => '{$MOD.LBL_FILEPATH}&nbsp;{sugar_help text=$MOD.HLP_LBL_FILEPATH WIDTH=500}',
            'customCode' => '<input type="file" name="filename" id="filename" value=""/>
						<br /><div id="loadinfo">{if !empty($fields.filename.value)}{$MOD.LBL_TEMPLATENAME}:&nbsp;{$fields.filename.value}<input type="hidden" name="old_filename" value="{$fields.filename.value}"/>{/if}</div>',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'report_module',
            'label' => 'LBL_REPORT_MODULE',
            'customCode' => '{if !empty($AVAILABLE_MODULES)}<select id="select_report_module"  onchange="change_report_module();" name="report_module">{$AVAILABLE_MODULES}</select>{/if}',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'report_filename',
            'customLabel' => '{$MOD.LBL_REPORT_FILENAME}&nbsp;{sugar_help text=$MOD.HLP_REPORT_FILENAME WIDTH=500}',
            'displayParams' => 
            array (
              'size' => 40,
            ),
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
       		'name' => 'related_module',
       		'label' => 'LBL_RELATED_MODULE',
     		'customCode' => '<select id="select_related_modules" name="related_modules" onchange="change_relate_module(true);"></select>',
    	  ),
          1 => '',
        ),
		1 =>
		array (
		  0 =>
		  array (
			'name' => 'fields_modules',
     		'label' => 'LBL_FIELDS_MODULE',
   			'customCode' => '<select id="select_module_fields" name="module_fields" onchange="change_module_fields();">
   					<optgroup label="{$MOD.LBL_MODULE_FIELDS}">
   					</optgroup>
   					<optgroup label="{$MOD.LBL_CUSTOM_FIELDS}">
					</optgroup>
   					</select>
   					<br/>
   					<input type="text" size="30" id="input_code" name="code" readonly >
   					<br/>
   					<input type="button" onclick="addReportField();" value="{$MOD.LBL_BTN_ADD_FIELD}">
   					',
		  ),
          1 =>
          array (
           	'name' => 'vars',
           	'studio' => 'visible',
           	'label' => 'LBL_VARS',
			'customCode' => '
					<select id="report_vars" name="report_vars[]" multiple size="8">{$REPORT_FIELDS}</select>
					<br/>
					<input type="button" onclick="removeReportField();" value="{$MOD.LBL_BTN_DEL_FIELD}">',
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

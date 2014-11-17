<?php
$module_name = 'OfficeReportsVariables';
$viewdefs [$module_name] =
    array (
        'EditView' =>
        array (
            'templateMeta' =>
            array (
                'form' => array (
                    'buttons' => array (
                        array (
                            'customCode' => '
                <input id="SAVE_HEADER" class="button primary" type="submit" value="{$APP.LBL_SAVE_BUTTON_LABEL}" name="button" onclick="this.form.action.value=\'Save\'; return check_form(\'EditView\')" accesskey="{$APP.LBL_SAVE_BUTTON_KEY}" title="{$APP.LBL_SAVE_BUTTON_TITLE}">',
                        ),
                        'CANCEL'
                    ),
                ),
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
                    1 =>
                    array (
                        'file' => 'custom/include/OfficeReportsMerge/Editarea/edit_area/edit_area_full.js',
                    ),
                    2 =>
                    array (
                        'file' => 'include/javascript/overlibmws.js',
                    ),
                ),
                'javascript' => '
      	<script>
      	YAHOO.util.Event.onDOMReady(function()
		{ldelim}
			editAreaLoader.init({ldelim}
				id: "code",
				start_highlight: true,
				allow_resize: "both",
				allow_toggle: true,
				word_wrap: true,
				language: "{$CURRENT_LANG}",
				syntax: "php"
			{rdelim});
		{rdelim});
		</script>',
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
                            'customCode' => '
          		<input id="name" type="text" name="name" value="{$fields.name.value}"/>
				<script>
					addToValidate("EditView", "name", "DBName", true,"{$MOD.COLUMN_TITLE_NAME} [a-zA-Z_]" );
					addToValidateIsInArray("EditView", "name", "in_array", true, "{$MOD.ERR_RESERVED_FIELD_NAME}", \'{$field_name_exceptions}\', "==");
				</script>',
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
                            'customLabel' => '{$MOD.LBL_CODE}&nbsp;{sugar_help text=$MOD.HLP_CODE WIDTH=500}',
                            'displayParams' =>
                            array (
                                'cols' => 120,
                                'rows' => 15,
                            ),
                        ),
                    ),
                    3 =>
                    array (
                        0 =>
                        array (
                            'name' => 'for_modules',
                            'label' => 'LBL_FOR_MODULES',
                            'displayParams' =>
                            array (
                                'size' => 8,
                            ),
                        ),
                    ),
                    4 =>
                    array (
                        0 =>
                        array (
                            'name' => 'description',
                            'comment' => 'Full text of the note',
                            'label' => 'LBL_DESCRIPTION',
                            'displayParams' =>
                            array (
                                'cols' => 120,
                            ),
                        ),
                    ),
                ),
            ),
        ),
    );
?>

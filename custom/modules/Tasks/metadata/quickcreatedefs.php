<?php
$viewdefs ['Tasks'] = 
array (
  'QuickCreate' => 
  array (
    'templateMeta' => 
    array (
      'form' => 
      array (
        'hidden' => 
        array (
          0 => '<input type="hidden" name="isSaveAndNew" value="false">',
        ),
        'buttons' => 
        array (
          0 => 
          array (
            'customCode' => '{if $bean->aclAccess("save")}<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="button" onclick="disableOnUnloadEditView();this.form.action.value=\'Save\';if(check_form(\'form_SubpanelQuickCreate_Tasks\') )return SUGAR.subpanelUtils.inlineSave(this.form.id, \'Tasks_subpanel_save_button\');return false;" type="submit" name="Tasks_subpanel_save_button" id="Tasks_subpanel_save_button" value="{$APP.LBL_SAVE_BUTTON_LABEL}">{/if}',
          ),
          1 => 'SUBPANELCANCEL',
          2 => 'SUBPANELFULLFORM',
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
        0 => 
        array (
          'file' => 'custom/include/javascript/show_status.js',
        ),
      ),
      'javascript' => '
          <script type="text/javascript">
			$.getScript("custom/include/checkActivity/custom_save.js"); // Kolerts: it`s work fine
			$.getScript("custom/include/javascript/activity_hooks.js"); // Kolerts: it`s work fine
          {literal}
            var parent_type = $("#parent_type");
            var parent_id = $("#parent_id");
            var parent_name = $("#parent_name");
            var module =  $("input[name=relate_to]").val();
            var id =  $("input[name=relate_id]").val();
            if(module == "Contacts")
            {
                var first_name = $("#first_name").text();
                var last_name = $("#last_name").text();
                parent_name.val(first_name+" "+last_name);
                console.log(first_name+" "+last_name);
            }
            else if(module == "Accounts")
            {
                var name = $("#name").text();
                parent_name.val(name);
                console.log(name);
            }
            console.log(module);
            console.log(id);
            parent_type.val(module);
            parent_id.val(id);

            var status_change =  $("#status");
            showStatus( status_change );
            status_change.change(function(){ showStatus( $(this) ) });

            function showStatus( status )
            {
                if( status.val() == "Completed" ) {
                    hideStatus( false );
                } else {
                    hideStatus( true );
                }
            }

            function hideStatus( hide )
            {
                var show_results = $("#show_results");
                if( hide === true ){
                   show_results.css( "display", "none" );
                   show_results.parent().prev().css( "visibility", "hidden" );
                   show_results.replaceWith("<div id=\\"show_results\\">"+show_results.val()+"</div>");
//                   removeFromValidate("form_SubpanelQuickCreate_Tasks", show_results[0].name);
                } else {
                   show_results.css( "display", "" );
                   show_results.parent().prev().css( "visibility", "visible" );
                   show_results.replaceWith("<textarea name=\\"show_results\\" cols=\\"60\\" rows=\\"8\\" id=\\"show_results\\">"+show_results.val()+"</textarea>");
//                   addToValidate("form_SubpanelQuickCreate_Tasks", show_results[0].name, "text", true, "Результат");
                }

            }
            {/literal}
          </script>',
      'useTabs' => false,
      'tabDefs' => 
      array (
        'LBL_TASK_INFORMATION' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_PANEL_ASSIGNMENT' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
    ),
    'panels' => 
    array (
      'lbl_task_information' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'name',
            'displayParams' => 
            array (
              'required' => true,
            ),
          ),
          1 => 
          array (
            'name' => 'status',
            'displayParams' => 
            array (
              'required' => true,
            ),
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'date_start',
            'type' => 'datetimecombo',
            'displayParams' => 
            array (
              'showNoneCheckbox' => true,
              'showFormats' => true,
            ),
          ),
          1 => 
          array (
            'name' => 'parent_name',
            'label' => 'LBL_LIST_RELATED_TO',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'date_due',
            'type' => 'datetimecombo',
            'displayParams' => 
            array (
              'showNoneCheckbox' => true,
              'showFormats' => true,
            ),
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'priority',
            'displayParams' => 
            array (
              'required' => true,
            ),
          ),
          1 => 
          array (
            'name' => 'realty_name',
            'studio' => 'visible',
            'label' => 'LBL_REALTY_NAME',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'description',
            'displayParams' => 
            array (
              'rows' => 8,
              'cols' => 60,
            ),
          ),
          1 => 
          array (
            'name' => 'opportunities_name',
            'label' => 'LBL_OPPORTUNITY_NAME',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'show_results',
            'label' => 'LBL_SHOW_RESULTS',
          ),
        ),
      ),
      'LBL_PANEL_ASSIGNMENT' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'assigned_user_name',
            'label' => 'LBL_ASSIGNED_TO_NAME',
          ),
        ),
      ),
    ),
  ),
);
?>

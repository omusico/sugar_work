<?php
$viewdefs ['Meetings'] = 
array (
  'QuickCreate' => 
  array (
    'templateMeta' => 
    array (
      'maxColumns' => '2',
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
            'customCode' => '{if $bean->aclAccess("save")}<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="button" onclick="disableOnUnloadEditView();this.form.action.value=\'Save\';if(check_form(\'form_SubpanelQuickCreate_Meetings\') && custom_save(\'meetings\'))return SUGAR.subpanelUtils.inlineSave(this.form.id, \'Meetings_subpanel_save_button\');return false;" type="submit" name="Meetings_subpanel_save_button" id="Meetings_subpanel_save_button" value="{$APP.LBL_SAVE_BUTTON_LABEL}">{/if}',
          ),
          1 => 'SUBPANELCANCEL',
          2 => 'SUBPANELFULLFORM',
        ),
      ),
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
      'javascript' => '<script type="text/javascript">{$JSON_CONFIG_JAVASCRIPT}
		$.getScript("custom/include/checkActivity/custom_save.js"); // Kolerts: it`s work fine
		$.getScript("custom/include/javascript/activity_hooks.js"); // Kolerts: it`s work fine
	  </script>
{sugar_getscript file="cache/include/javascript/sugar_grp_jsolait.js"}
<script>toggle_portal_flag();function toggle_portal_flag()  {literal} { {/literal} {$TOGGLE_JS} {literal} }
                    var status_change =  $("#status");
                    showStatus( status_change );
                    status_change.change(function(){ showStatus( $(this) ) });

                    function showStatus( status )
                    {
                        if( status.val() == "Held" || status.val() == "Not Held" ) {
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
//                           removeFromValidate("form_SubpanelQuickCreate_Meetings", show_results[0].name);
                        } else {
                           show_results.css( "display", "" );
                           show_results.parent().prev().css( "visibility", "visible" );
                           show_results.replaceWith("<textarea name=\\"show_results\\" cols=\\"60\\" rows=\\"8\\" id=\\"show_results\\">"+show_results.val()+"</textarea>");
//                         addToValidate("form_SubpanelQuickCreate_Mettings", show_results[0].name, "text", true, "Результат");
                        }

                    }


{/literal} </script>',
      'useTabs' => false,
      'tabDefs' => 
      array (
        'DEFAULT' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
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
            'name' => 'name',
            'displayParams' => 
            array (
              'required' => true,
            ),
          ),
          1 => 
          array (
            'name' => 'status',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'status',
              ),
            ),
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'meeting_type',
            'label' => 'LBL_MEETING_TYPE',
          ),
          1 => '',
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'date_start',
            'type' => 'datetimecombo',
            'displayParams' => 
            array (
              'required' => true,
              'updateCallback' => 'SugarWidgetScheduler.update_time();',
            ),
          ),
          1 => 
          array (
            'name' => 'parent_name',
            'label' => 'LBL_LIST_RELATED_TO',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'date_end',
            'type' => 'datetimecombo',
            'displayParams' => 
            array (
              'required' => true,
              'updateCallback' => 'SugarWidgetScheduler.update_time();',
            ),
          ),
          1 => 
          array (
            'name' => 'location',
            'comment' => 'Meeting location',
            'label' => 'LBL_LOCATION',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'duration',
            'customCode' => '
                @@FIELD@@
                <input id="duration_hours" name="duration_hours" type="hidden" value="{$fields.duration_hours.value}">
                <input id="duration_minutes" name="duration_minutes" type="hidden" value="{$fields.duration_minutes.value}">
                {sugar_getscript file="modules/Meetings/duration_dependency.js"}
                <script type="text/javascript">
                    var date_time_format = "{$CALENDAR_FORMAT}";
                    {literal}
                    SUGAR.util.doWhen(function(){return typeof DurationDependency != "undefined" && typeof document.getElementById("duration") != "undefined"}, function(){
                        var duration_dependency = new DurationDependency("date_start","date_end","duration",date_time_format);
                        initEditView(YAHOO.util.Selector.query(\'select#duration\')[0].form);
                    });


                    {/literal}
                </script>
            ',
          ),
          1 => 
          array (
            'name' => 'reminder_time',
            'customCode' => '{include file="modules/Meetings/tpls/reminders.tpl"}',
            'label' => 'LBL_REMINDER',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'description',
            'comment' => 'Full text of the note',
            'label' => 'LBL_DESCRIPTION',
          ),
          1 => 
          array (
            'name' => 'realty_name',
            'label' => 'LBL_REALTY_NAME',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'opportunities_name',
            'label' => 'LBL_OPPORTUNITY_NAME',
          ),
          1 => 
          array (
            'name' => 'show_results',
            'label' => 'LBL_SHOW_RESULTS',
          ),
        ),
        7 => 
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

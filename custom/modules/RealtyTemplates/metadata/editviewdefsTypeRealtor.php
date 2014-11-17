<?php
$module_name = 'RealtyTemplates';
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
                        'file' => 'custom/modules/RealtyTemplates/js/set_kind_of_realty.js',
                    ),
                    1 =>
                    array (
                        'file' => 'custom/modules/RealtyTemplates/js/setGeocodeByHand.js',
                    ),
                    2 =>
                    array (
                        'file' => 'custom/modules/RealtyTemplates/js/custom_open_popup.js',
                    ),
                ),
                'useTabs' => false,
                'tabDefs' =>
                array (
                    'LBL_EDITVIEW_PANEL1' =>
                    array (
                        'newTab' => false,
                        'panelDefault' => 'expanded',
                    ),
                    'LBL_EDITVIEW_PANEL2' =>
                    array (
                        'newTab' => false,
                        'panelDefault' => 'expanded',
                    ),
                    'LBL_EDITVIEW_PANEL3' =>
                    array (
                        'newTab' => false,
                        'panelDefault' => 'expanded',
                    ),
                ),
                'syncDetailEditViews' => true,
            ),
            'panels' =>
            array (
                'lbl_editview_panel1' =>
                array (
                    0 =>
                    array (
                        0 =>
                        array (
                            'name' => 'owner_last_name',
                            'label' => 'LBL_OWNER_LAST_NAME',
                        ),
                        1 =>
                        array (
                            'name' => 'owner_first_name',
                            'label' => 'LBL_OWNER_FIRST_NAME',
                        ),
                    ),

                    2 =>
                    array (
                        0 =>
                        array (
                            'name' => 'account_name',
                            'studio' => 'visible',
                            'label' => 'LBL_ACCOUNT_NAME',
                        ),
                    ),
                ),
                'lbl_editview_panel2' =>
                array (
                    0 =>
                    array (
                        0 =>
                        array (
                            'name' => 'assigned_user_name',
                            'vname' => 'LBL_ASSIGNED_USER_NAME',
                            'customCode' => '
              <input type="text" name="{$fields.assigned_user_name.name}" class="sqsEnabled" tabindex="0" id="{$fields.assigned_user_name.name}" size="" value="{$fields.assigned_user_name.value}" title="" autocomplete="off"  	 >
                <input type="hidden" name="{$fields.assigned_user_name.id_name}"
                id="{$fields.assigned_user_name.id_name}"
                value="{$fields.assigned_user_id.value}">
                <span class="id-ff multiple">
                <button type="button" name="btn_{$fields.assigned_user_name.name}" id="btn_{$fields.assigned_user_name.name}" tabindex="0" title="{sugar_translate label="LBL_ACCESSKEY_SELECT_USERS_TITLE"}" class="button firstChild" value="{sugar_translate label="LBL_ACCESSKEY_SELECT_USERS_LABEL"}"
                onclick=\'open_popup(
                "{$fields.assigned_user_name.module}",
                    600,
                    400,
                    "",
                    true,
                    false,
                {literal}{"call_back_function":"set_return","form_name":"EditView","field_to_name_array":{"id":"assigned_user_id","user_name":"assigned_user_name"}}{/literal},
                "single&return_module=RealtyTemplates",
                true
                );\' ><img src="{sugar_getimagepath file="id-ff-select.png"}"></button><button type="button" name="btn_clr_{$fields.assigned_user_name.name}" id="btn_clr_{$fields.assigned_user_name.name}" tabindex="0" title="{sugar_translate label="LBL_ACCESSKEY_CLEAR_USERS_TITLE"}"  class="button lastChild"
                onclick="SUGAR.clearRelateField(this.form, \'{$fields.assigned_user_name.name}\', \'{$fields.assigned_user_name.id_name}\');"  value="{sugar_translate label="LBL_ACCESSKEY_CLEAR_USERS_LABEL"}" ><img src="{sugar_getimagepath file="id-ff-clear.png"}"></button>
                </span>
                <script type="text/javascript">
                SUGAR.util.doWhen(
                        "typeof(sqs_objects) != \'undefined\' && typeof(sqs_objects[\'{$form_name}_{$fields.assigned_user_name.name}\']) != \'undefined\'",
                        enableQS
                );
                </script>
              ',
                        ),
                        1 =>
                        array (
                            'name' => 'realty_status',
                            'label' => 'LBL_REALTY_STATUS',
                        ),
                    ),
                    1 =>
                    array (
                        0 =>
                        array (
                            'name' => 'activity_status',
                            'label' => 'LBL_ACTIVITY_STATUS',
                        ),
                        1 =>
                        array (
                            'name' => 'source_of_income_object',
                            'label' => 'LBL_SOURCE_OF_INCOME_OBJECT',
                        ),
                    ),
                ),
                'lbl_editview_panel3' =>
                array (
                    0 =>
                    array (
                        0 => 'name',
                        1 =>
                        array (
                            'name' => 'operation',
                            'label' => 'LBL_OPERATION',
                        ),
                    ),
                    1 =>
                    array (
                        0 =>
                        array (
                            'name' => 'square',
                            'label' => 'LBL_SQUARE',
                        ),
                        1 =>
                        array (
                            'name' => 'operation_status',
                            'label' => 'LBL_OPERATION_STATUS',
                        ),
                    ),
                    2 =>
                    array (
                        0 =>
                        array (
                            'name' => 'square_unit',
                            'label' => 'LBL_SQUARE_UNIT',
                        ),
                        1 =>
                        array (
                            'name' => 'type_of_realty',
                            'label' => 'LBL_TYPE_OF_REALTY',
                        ),
                    ),
                    3 =>
                    array (
                        0 =>
                        array (
                            'name' => 'rooms_quantity',
                            'label' => 'LBL_ROOMS_QUANTITY',
                        ),
                        1 =>
                        array (
                            'name' => 'kind_of_realty',
                            'label' => 'LBL_KIND_OF_REALTY',
                        ),
                    ),
                    4 =>
                    array (
                        0 =>
                        array (
                            'name' => 'currency',
                            'label' => 'LBL_CURRENCY',
                        ),
                        1 =>
                        array (
                            'name' => 'number_of_floors',
                            'label' => 'LBL_NUMBER_OF_FLOORS',
                        ),
                    ),
                    5 =>
                    array (
                        0 =>
                        array (
                            'name' => 'cost',
                            'label' => 'LBL_COST',
                        ),
                        1 =>
                        array (
                            'name' => 'floor',
                            'label' => 'LBL_FLOOR',
                        ),
                    ),
                    6 =>
                    array (
                        0 =>
                        array (
                            'name' => 'totalcost',
                            'label' => 'LBL_TOTALCOST',
                            'type' => 'readonly',
                        ),
                        1 =>
                        array (
                            'name' => 'period',
                            'label' => 'LBL_PERIOD',
                        ),
                    ),
                    7 =>
                    array (
                        0 => 'description',
                        1 =>
                        array (
                            'name' => 'state_of_object',
                            'label' => 'LBL_STATE_OF_OBJECT',
                        ),
                    ),
                    8 =>
                    array (
                        0 =>
                        array (
                            'name' => 'way_to_get',
                            'label' => 'LBL_WAY_TO_GET',
                        ),
                        1 =>
                        array (
                            'name' => 'latitude',
                            'label' => 'LBL_LATITUDE',
                        ),
                    ),
                    9 =>
                    array (
                        0 =>
                        array (
                            'name' => 'address_street',
                            'label' => 'LBL_ADDRESS_REALTY',
                            'customCode' => '
                  {include file="custom/modules/RealtyTemplates/tpls/edit_adress_container.tpl"}
              ',
                        ),
                        1 =>
                        array (
                            'name' => 'longitude',
                            'label' => 'LBL_LONGITUDE',
                        ),
                    ),
                    10 =>
                    array (
                        0 =>
                        array (
                            'name' => 'metro',
                            'label' => 'LBL_METRO',
                        ),
                        1 =>
                        array (
                            'name' => 'building_name',
                            'studio' => 'visible',
                            'label' => 'LBL_BUILDING_NAME',
                        ),
                    ),
                    11 =>
                    array (
                        0 =>
                        array (
                            'name' => 'sections_exist',
                            'label' => 'LBL_SECTIONS_EXIST',
                        ),
                        1 =>
                        array (
                            'name' => 'section_name',
                            'studio' => 'visible',
                            'label' => 'LBL_SECTION_NAME',
                            'customCode' => '
            <input type="text" name="{$fields.section_name.name}" class="sqsEnabled" tabindex="0" id="{$fields.section_name.name}" size="" value="{$fields.section_name.value}" title="" autocomplete="off"  	 >
            <input type="hidden" name="{$fields.section_name.id_name}"
            id="{$fields.section_name.id_name}"
            value="{$fields.section_id.value}">
            <span class="id-ff multiple">
            <button type="button" name="btn_{$fields.section_name.name}" id="btn_{$fields.section_name.name}" tabindex="0" title="{sugar_translate label="LBL_SELECT_BUTTON_TITLE"}" class="button firstChild" value="{sugar_translate label="LBL_SELECT_BUTTON_LABEL"}"
            onclick="custom_open_popup()"><img src="{sugar_getimagepath file="id-ff-select.png"}"></button><button type="button" name="btn_clr_{$fields.section_name.name}" id="btn_clr_{$fields.section_name.name}" tabindex="0" title="{sugar_translate label="LBL_ACCESSKEY_CLEAR_RELATE_TITLE"}"  class="button lastChild"
            onclick="SUGAR.clearRelateField(this.form, \'{$fields.section_name.name}\', \'{$fields.section_name.id_name}\');"  value="{sugar_translate label="LBL_ACCESSKEY_CLEAR_RELATE_LABEL"}" ><img src="{sugar_getimagepath file="id-ff-clear.png"}"></button>
            </span>
            <script type="text/javascript">
            SUGAR.util.doWhen(
            "typeof(sqs_objects) != \'undefined\' && typeof(sqs_objects[\'{$form_name}_{$fields.section_name.name}\']) != \'undefined\'",
            enableQS
            );
            </script>
              ',
                        ),
                    ),
                    12 =>
                    array (
                        0 =>
                        array (
                            'name' => 'map_in_editview',
                            'label' => 'LBL_MAP_IN_EDITVIEW',
                            'customCode' => '
              {literal}
              <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
              <style>
                .ui-autocomplete {
                background-color: white;
                width: 300px;
                border: 1px solid #cfcfcf;
                list-style-type: none;
                padding-left: 0px;}
              </style>
              <input id="address" type="hidden"/>
              <b>Здесь Вы можете корректировать расположение объекта на карте.<br/> Для этого перемещайте индикатор объекта мышью куда Вам нужно, координаты поменяются автоматически</b>
              <div id="map_canvas" style="width:500px; height:500px; border: 1px solid"></div><br>
              {/literal}
              ',
                        ),
                        1 =>
                        array (
                            'name' => 'galleria_c',
                            'studio' => 'visible',
                            'label' => 'LBL_GALLERIA',
                        ),
                    ),
                ),
            ),
        ),
    );
?>

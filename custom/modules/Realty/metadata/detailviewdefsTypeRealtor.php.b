<?php
$module_name = 'Realty';
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
                        1 => 'DUPLICATE',
                        2 => 'DELETE',
                        3 => 'FIND_DUPLICATES',
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
                        'file' => 'custom/modules/Realty/js/hide_subpanel_depending_operation.js',
                    ),
                    1 =>
                    array (
                        'file' => 'custom/modules/Realty/js/setGeocodeByHandDV.js',
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
                        0 => 'assigned_user_name',
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
                  {include file="custom/modules/Realty/tpls/detail_adress_container.tpl"}
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

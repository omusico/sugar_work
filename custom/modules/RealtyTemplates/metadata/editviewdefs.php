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
        3 =>
        array (
          'file' => 'custom/modules/RealtyTemplates/js/dinamic_fields.js',
        ),
        4 =>
        array (
          'file' => 'custom/modules/RealtyTemplates/js/extracting_address.js',
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
        'LBL_EDITVIEW_PANEL5' =>
        array (
          'newTab' => false,
          'panelDefault' => 'collapsed',
        ),
        'LBL_EDITVIEW_PANEL4' =>
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
          0 => 'name',
        ),
        1 =>
        array (
          0 =>
          array (
            'name' => 'contact_name',
            'studio' => 'visible',
            'label' => 'LBL_CONTACT_NAME',
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
            'name' => 'operation',
            'label' => 'LBL_OPERATION',
          ),
          1 =>
          array (
            'name' => 'operation_status',
            'label' => 'LBL_OPERATION_STATUS',
          ),
        ),
        1 =>
        array (
          0 =>
          array (
            'name' => 'assigned_user_name',
          ),
          1 =>
          array (
            'name' => 'realty_status',
            'label' => 'LBL_REALTY_STATUS',
          ),
        ),
        2 =>
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

        3 =>
        array (
          0 => 'reserved',
        ),
        4 =>
        array (
          0 =>
          array (
            'name' => 'date_entered',
            'comment' => 'Date record created',
            'label' => 'LBL_DATE_ENTERED',
          ),
          1 =>
          array (
            'name' => 'last_contact',
            'label' => 'LBL_LAST_CONTACT',
          ),
        ),
      ),
      'lbl_editview_panel3' =>
      array (
        0 =>
        array (
          0 =>
          array (
            'name' => 'type_of_realty',
            'label' => 'LBL_TYPE_OF_REALTY',
          ),
          1 =>
          array (
            'name' => 'kind_of_realty',
            'label' => 'LBL_KIND_OF_REALTY',
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
            'name' => 'square_unit',
            'label' => 'LBL_SQUARE_UNIT',
          ),
        ),
        2 =>
        array (
          0 =>
          array (
            'name' => 'cost',
            'label' => 'LBL_COST',
          ),
          1 =>
          array (
            'name' => 'currency',
            'label' => 'LBL_CURRENCY',
          ),
        ),
        3 =>
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
        4 =>
        array (
		  0 => 'description',
          1 =>
          array (
            'name' => 'state_of_object',
            'label' => 'LBL_STATE_OF_OBJECT',
          ),
        ),
        5 =>
        array (
          0 =>
          array (
            'name' => 'living_square',
            'label' => 'LBL_LIVING_SQUARE',
          ),
          1 => 'kitchen_square',
        ),
        6 =>
        array (
          0 =>
          array (
            'name' => 'rooms_quantity',
            'label' => 'LBL_ROOMS_QUANTITY',
          ),
          1 => 'room_layout',
        ),
        7 =>
        array (
          0 =>
          array (
            'name' => 'floor',
            'label' => 'LBL_FLOOR',
          ),
          1 =>
          array (
            'name' => 'number_of_floors',
            'label' => 'LBL_NUMBER_OF_FLOORS',
          ),
        ),
        8 =>
        array (
          0 =>
          array (
            'name' => 'address_street',
            'label' => 'LBL_ADDRESS_REALTY',
            'customCode' => '
                  {include file="custom/modules/RealtyTemplates/tpls/edit_adress_container.tpl"}
              ',
          ),
        ),
        9 =>
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
        10 =>
        array (
          0 =>
          array (
            'name' => 'way_to_get',
            'label' => 'LBL_WAY_TO_GET',
          ),
          1 =>
          array (
            'name' => 'sections_exist',
            'label' => 'LBL_SECTIONS_EXIST',
          ),
        ),
        11 =>
        array (
          0 => '',
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
              <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=places"></script>
              <style>
                .ui-autocomplete {
                background-color: white;
                width: 300px;
                border: 1px solid #cfcfcf;
                list-style-type: none;
                padding-left: 0px;}
              </style>
              <input id="address" type="hidden" width="100px"/>
               Здесь Вы можете корректировать расположение объекта на карте. Для этого<br/>перемещайте индикатор объекта мышью, координаты поменяются автоматически
              <div id="map_canvas" style="width:440px; height:340px; border: 1px solid"></div><br>
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
        13 =>
        array (
          0 =>
          array (
            'name' => 'latitude',
            'hideLabel' => true,
            'customCode' => '<input type="hidden" name="latitude" id="latitude" size="30" value="{$fields.latitude.value}" title="">',
          ),
          1 =>
          array (
            'name' => 'longitude',
            'hideLabel' => true,
            'customCode' => '<input type="hidden" name="longitude" id="longitude" size="30" value="{$fields.longitude.value}" title="">',
          ),
        ),
        14 =>
        array (
          0 =>
          array (
            'name' => 'video_youtube',
            'studio' => 'visible',
            'label' => 'LBL_VIDEO_YOUTUBE',
          ),
          1 => '',
        ),
      ),
      'lbl_editview_panel5' =>
      array (
        0 =>
        array (
          0 => 'for_office',
        ),
        1 =>
        array (
          0 => 'balcon',
          1 => 'phone_bool',
        ),
        2 =>
        array (
          0 => 'boiler',
          1 => 'tv',
        ),
        3 =>
        array (
          0 => 'fridge',
          1 => 'washing_m',
        ),
        4 =>
        array (
          0 => 'conditioning',
          1 => 'internet',
        ),
        5 =>
        array (
          0 => 'parking',
        ),
        6 =>
        array (
          0 => 'gaz',
          1 => 'h2o',
        ),
        7 =>
        array (
          0 => 'gaz_add',
          1 => 'h2o_add',
        ),
      ),
      'lbl_editview_panel4' =>
      array (
        0 =>
        array (
          0 => 'd_name',
          1 => 'd_text',
        ),
      ),
    ),
  ),
);
?>

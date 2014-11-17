<?php
$module_name = 'Buildings';
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
        array (
          'file' => 'custom/modules/Buildings/js/setGeocodeByHand.js',
        ),
        array (
          'file' => 'custom/modules/Realty/js/get_cladr_code.js',
        ),
      ),
      'useTabs' => false,
      'tabDefs' => 
      array (
        'DEFAULT' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
      'syncDetailEditViews' => true,
    ),
    'panels' => 
    array (
      'default' => 
      array (
        0 => 
        array (
          'name',
          array (
            'name' => 'flats_quantity',
            'label' => 'LBL_FLATS_QUANTITY',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'current_square',
            'label' => 'LBL_CURRENT_SQUARE',
          ),
          1 => 
          array (
            'name' => 'number_of_floors',
            'label' => 'LBL_NUMBER_OF_FLOORS',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'address_street',
            'label' => 'LBL_ADDRESS_STREET',
            'customCode' => '
                  {include file="custom/modules/Buildings/tpls/edit_adress_container.tpl"}
              ',
          ),
          1 => 
          array (
            'name' => 'type_of_building',
            'label' => 'LBL_TYPE_OF_BUILDING',
          ),
        ),
        3 => 
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
              <input id="address" type="hidden"/>
              <b>Здесь Вы можете корректировать расположение объекта на карте.<br/> Для этого перемещайте индикатор объекта мышью куда Вам нужно, координаты поменяются автоматически</b>
              <div id="map_canvas" style="width:500px; height:500px; border: 1px solid"></div><br>
              {/literal}
              ',
          ),
          1 => 
          array (
            'name' => 'galeria_c',
            'studio' => 'visible',
            'label' => 'LBL_GALERIA',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'longitude',
            'hideLabel' => true,
            'customCode' => '<input type="hidden" name="longitude" id="longitude" size="30" value="{$fields.longitude.value}" title="">',
          ),
          1 => 
          array (
            'name' => 'latitude',
            'hideLabel' => true,
            'customCode' => '<input type="hidden" name="latitude" id="latitude" size="30" value="{$fields.latitude.value}" title="">',
          ),
        ),
      ),
    ),
  ),
);
?>

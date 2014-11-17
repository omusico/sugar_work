<?php
$module_name = 'Request';
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
      'includes' => array (
        array (
          'file' => 'custom/modules/Realty/tpls/jquery.geocomplete.min.js',
        ),
        array (
          'file' => 'modules/Request/js/editview.js',
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
        array (
          0 => 'name',
          1 => 
          array (
            'name' => 'parent_name',
            'label' => 'LBL_LIST_RELATED_TO',
          ),
        ),
        array (
			'operation',
			'type_of_realty',
        ),
        array (
			'cost_to',
			'kind_of_realty',
        ),
        array (
			'currency',
			'status',
        ),
        array (
          0 => 
          array (
            'name' => 'rooms_quantity',
            'label' => 'LBL_ROOMS_QUANTITY',
          ),
          1 => 
          array (
            'name' => 'layout',
            'label' => 'LBL_LAYOUT',
          ),
        ),
        array (
			'rooms_quantity_to',
        ),
        array (
          0 => 
          array (
            'name' => 'min_floor',
            'label' => 'LBL_MIN_FLOOR',
          ),
          1 => 
          array (
            'name' => 'square_min',
            'label' => 'LBL_MIN_SQUARE',
          ),
        ),
        array (
          0 => 
          array (
            'name' => 'max_floor',
            'label' => 'LBL_MAX_FLOOR',
          ),
          1 => 
          array (
            'name' => 'square_max',
            'label' => 'LBL_MAX_SQUARE',
          ),
        ),
        array (
          0 => 
          array (
            'name' => 'address_street',
            'label' => 'LBL_ADDRESS_STREET',
            'customCode' => '
                  {include file="custom/modules/Request/tpls/edit_adress_container.tpl"}
              ',
          ),
          1 => 
          array (
            'name' => 'metro',
            'label' => 'LBL_METRO',
          ),
        ),
        array (
          0 => 'description',
          1 => 
          array (
            'name' => 'state_of_object',
            'label' => 'LBL_STATE_OF_OBJECT',
          ),
        ),
		array (
          'assigned_user_name',
        ),
      ),
    ),
  ),
);
?>
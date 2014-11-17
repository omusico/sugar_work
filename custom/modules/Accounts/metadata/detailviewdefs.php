<?php
$viewdefs ['Accounts'] = 
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
		  
		  4 => array (
            'customCode' => '<input title="Отправить презентацию" id="button4" class="button"  onclick="window.open(\'index.php?module=Accounts&action=send_presentation&id={$fields.id.value}\')"  name="arendator"  value="Отправить презентацию"  type="button">',
          ),
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
          'file' => 'modules/Accounts/Account.js',
        ),
        1 => 
        array (
          'file' => 'custom/modules/Realty/js/presentation.js',
        ),
      ),
      'useTabs' => false,
      'tabDefs' => 
      array (
        'LBL_ACCOUNT_INFORMATION' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_PANEL_ADVANCED' => 
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
      'syncDetailEditViews' => true,
    ),
    'panels' => 
    array (
      'lbl_account_information' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'name',
            'comment' => 'Name of the Company',
            'label' => 'LBL_NAME',
            'displayParams' => 
            array (
            ),
          ),
          1 => 
          array (
            'name' => 'phone_office',
            'comment' => 'The office phone number',
            'label' => 'LBL_PHONE_OFFICE',
          ),
        ),
        1 => array (
          'type',
		  'contact_status',
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'email1',
            'studio' => 'false',
            'label' => 'LBL_EMAIL',
          ),
          1 => 
          array (
            'name' => 'website',
            'type' => 'link',
            'label' => 'LBL_WEBSITE',
            'displayParams' => 
            array (
              'link_target' => '_blank',
            ),
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'main_address_street',
            'label' => 'LBL_ADDRESS_STREET_MAIN',
            'customCode' => '
                  {include file="custom/modules/Accounts/tpls/tpls_main/detail_adress_container.tpl"}
              ',
          ),
          1 => 
          array (
            'name' => 'main_address_street_jur',
            'label' => 'LBL_ADDRESS_DISTRICT',
          ),
        ),
      ),
      'LBL_PANEL_ADVANCED' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'ogrn',
            'label' => 'LBL_OGRN',
          ),
          1 => 
          array (
            'name' => 'inn',
            'label' => 'LBL_INN',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'description',
            'comment' => 'Full text of the note',
            'label' => 'LBL_DESCRIPTION',
          ),
          1 => 
          array (
            'name' => 'kpp',
            'label' => 'LBL_KPP',
          ),
        ),
        2 => array (
          0 => 'last_contact',
        ),
      ),
      /*'LBL_PANEL_ASSIGNMENT' => 
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
            'name' => 'type_of_realty',
            'label' => 'LBL_TYPE_OF_REALTY',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'cost_to',
            'label' => 'LBL_COST_TO',
          ),
          1 => 
          array (
            'name' => 'kind_of_realty',
            'label' => 'LBL_KIND_OF_REALTY',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'currency',
            'label' => 'LBL_CURRENCY',
          ),
          1 => '',
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
            'name' => 'square_min',
            'label' => 'LBL_MIN_SQUARE',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'min_floor',
            'label' => 'LBL_MIN_FLOOR',
          ),
          1 => 
          array (
            'name' => 'square_max',
            'label' => 'LBL_MAX_SQUARE',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'max_floor',
            'label' => 'LBL_MAX_FLOOR',
          ),
          1 => 
          array (
            'name' => 'metro',
            'label' => 'LBL_METRO',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'address_street',
            'label' => 'LBL_ADDRESS',
            'customCode' => '
                  {include file="custom/modules/Accounts/tpls/detail_adress_container.tpl"}
              ',
          ),
          1 => 
          array (
            'name' => 'layout',
            'label' => 'LBL_LAYOUT',
          ),
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'realty_description',
            'label' => 'LBL_REALTY_DESCRIPTION',
          ),
          1 => 
          array (
            'name' => 'state_of_object',
            'label' => 'LBL_STATE_OF_OBJECT',
          ),
        ),
		
        8 => array (
          0 => 'last_contact',
        ),
      ),*/
    ),
  ),
);
?>

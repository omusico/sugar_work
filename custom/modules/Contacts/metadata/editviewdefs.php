<?php
$viewdefs ['Contacts'] =
array (
  'EditView' =>
  array (
    'templateMeta' =>
    array (
      'form' =>
      array (
        'hidden' =>
        array (
          0 => '<input type="hidden" name="opportunity_id" value="{$smarty.request.opportunity_id}">',
          1 => '<input type="hidden" name="case_id" value="{$smarty.request.case_id}">',
          2 => '<input type="hidden" name="bug_id" value="{$smarty.request.bug_id}">',
          3 => '<input type="hidden" name="email_id" value="{$smarty.request.email_id}">',
          4 => '<input type="hidden" name="inbound_email_id" value="{$smarty.request.inbound_email_id}">',
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
          'file' => 'custom/modules/Contacts/js/set_kind_of_realty.js',
        ),
        1 =>
        array (
          'file' => 'custom/modules/Realty/js/get_cladr_code.js',
        ),
      ),
      'useTabs' => false,
      'tabDefs' =>
      array (
        'LBL_CONTACT_INFORMATION' =>
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_PANEL_DOV_LICO' =>
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_PANEL_ADVANCED' =>
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
      'syncDetailEditViews' => true,
    ),
    'panels' =>
    array (
      'lbl_contact_information' =>
      array (
        0 =>
        array (
          0 =>
          array (
            'name' => 'first_name',
            'customCode' => '<input name="first_name"  id="first_name" size="30" maxlength="25" type="text" value="{$fields.first_name.value}">',
          ),
          1 =>
          array (
            'name' => 'phone_work',
            'comment' => 'Work phone number of the contact',
            'label' => 'LBL_OFFICE_PHONE',
          ),
        ),
        1 =>
        array (
          0 =>
          array (
            'name' => 'last_name',
          ),
          1 =>
          array (
            'name' => 'phone_home',
            'comment' => 'Home phone number of the contact',
            'label' => 'LBL_HOME_PHONE',
          ),
        ),
        2 =>
        array (
          0 => array(
            'name' => 'type',
            'label' => 'LBL_TYPE',
            'customCode' => '<select id="type" name="type[]" multiple="true" size="2" style="width:150; height:40px;" title="">
                                {html_options options=$fields.type.options selected=$fields.type.value}
                             </select>',
          ),
          1 => array(
             'name' => 'contact_status',
             'label' => 'LBL_CONTACT_STATUS',
          ),
        ),
        3 =>
        array (
          0 =>
          array (
            'name' => 'email1',
            'studio' => 'false',
            'label' => 'LBL_EMAIL_ADDRESS',
          ),
          1 =>
          array (
            'name' => 'phone_mobile',
            'comment' => 'Mobile phone number of the contact',
            'label' => 'LBL_MOBILE_PHONE',
          ),
        ),
        4 =>
        array (
          0 => '',
          1 =>
          array (
            'name' => 'source_contact',
            'label' => 'LBL_SOURCE_CONTACT',
          ),
        ),
        5 =>
        array (
          0 =>
          array (
            'name' => 'account_name',
            'displayParams' =>
            array (
              'key' => 'billing',
              'copy' => 'primary',
              'billingKey' => 'primary',
              'additionalFields' =>
              array (
                'phone_office' => 'phone_work',
              ),
            ),
          ),
          1 =>
          array (
            'name' => 'birthdate',
            'comment' => 'The birthdate of the contact',
            'label' => 'LBL_BIRTHDATE',
          ),
        ),
      ),
      'LBL_PANEL_DOV_LICO' =>
      array (
        0 =>
        array (
          0 => 'dov_lico',
          1 => 'dov_fio',
        ),
        1 =>
        array (
          0 => '',
          1 => 'dov_realship',
        ),
        2 =>
        array (
          0 => '',
          1 => 'dov_phone',
        ),
        3 =>
        array (
          0 => '',
          1 => 'dov_passport',
        ),
        4 =>
        array (
          0 => '',
          1 => 'dov_description',
        ),
      ),
      'LBL_PANEL_ADVANCED' =>
      array (
        0 =>
        array (
          0 =>
          array (
            'name' => 'main_address_street',
            'label' => 'LBL_ADDRESS_STREET_MAIN',
            'customCode' => '
                  {include file="custom/modules/Contacts/tpls/tpls_main/edit_adress_container.tpl"}
              ',
          ),
          1 =>
          array (
            'name' => 'contact_district',
            'label' => 'LBL_CONTACT_DISTRICT',
          ),
        ),
        1 =>
        array (
          0 =>
          array (
            'name' => 'passport_number',
            'label' => 'LBL_PASSPORT_NUMBER',
          ),
          1 =>
          array (
            'name' => 'passport_authority',
            'label' => 'LBL_PASSPORT_AUTHORITY',
          ),
        ),
      ),
    ),
  ),
);
?>

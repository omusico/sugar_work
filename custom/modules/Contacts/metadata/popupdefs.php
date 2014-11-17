<?php
$popupMeta = array (
    'moduleMain' => 'Contact',
    'varName' => 'CONTACT',
    'orderBy' => 'contacts.first_name, contacts.last_name',
    'whereClauses' => array (
  'first_name' => 'contacts.first_name',
  'last_name' => 'contacts.last_name',
  'account_name' => 'accounts.name',
  'account_id' => 'accounts.id',
),
    'searchInputs' => array (
  0 => 'first_name',
  1 => 'last_name',
  2 => 'account_name',
  3 => 'email',
),
    'create' => array (
  'formBase' => 'ContactFormBase.php',
  'formBaseClass' => 'ContactFormBase',
  'getFormBodyParams' =>
  array (
    0 => '',
    1 => '',
    2 => 'ContactSave',
  ),
  'createButton' => 'LNK_NEW_CONTACT',
),
    'searchdefs' => array (
  0 => 'first_name',
  1 => 'last_name',
  2 =>
  array (
    'name' => 'account_name',
    'type' => 'varchar',
  ),
  3 => 'title',
  4 => 'lead_source',
  5 => 'email',
  6 =>
  array (
    'name' => 'campaign_name',
    'displayParams' =>
    array (
      'hideButtons' => 'true',
      'size' => 30,
      'class' => 'sqsEnabled sqsNoAutofill',
    ),
  ),
  7 =>
  array (
    'name' => 'assigned_user_id',
    'type' => 'enum',
    'label' => 'LBL_ASSIGNED_TO',
    'function' =>
    array (
      'name' => 'get_user_array',
      'params' =>
      array (
        0 => false,
      ),
    ),
  ),
),
    'listviewdefs' => array (
//  'ACCEPT_STATUS_ID' =>
//  array (
//    'type' => 'varchar',
//    'studio' =>
//    array (
//      'listview' => false,
//    ),
//    'label' => 'LBL_LIST_ACCEPT_STATUS',
//    'width' => '10%',
//    'default' => true,
//    'name' => 'accept_status_id',
//  ),
  'TYPE' =>
  array (
    'type' => 'multienum',
    'label' => 'LBL_TYPE',
    'width' => '10%',
    'default' => true,
  ),
  'NAME' =>
  array (
    'width' => '20%',
    'label' => 'LBL_LIST_NAME',
    'link' => true,
    'default' => true,
    'related_fields' =>
    array (
      0 => 'first_name',
      1 => 'last_name',
      2 => 'salutation',
      3 => 'account_name',
      4 => 'account_id',
    ),
    'name' => 'name',
  ),
  'PHONE_MOBILE' =>
  array (
    'type' => 'phone',
    'label' => 'LBL_MOBILE_PHONE',
    'width' => '10%',
    'default' => true,
  ),
  'ACCOUNT_NAME' =>
  array (
    'width' => '25%',
    'label' => 'LBL_LIST_ACCOUNT_NAME',
    'module' => 'Accounts',
    'id' => 'ACCOUNT_ID',
    'default' => true,
    'sortable' => true,
    'ACLTag' => 'ACCOUNT',
    'related_fields' =>
    array (
      0 => 'account_id',
    ),
    'name' => 'account_name',
  ),
  'TITLE' =>
  array (
    'width' => '15%',
    'label' => 'LBL_LIST_TITLE',
    'default' => true,
    'name' => 'title',
  ),
  'LAST_CONTACT' =>
  array (
    'type' => 'date',
    'label' => 'LBL_LAST_CONTACT',
    'width' => '10%',
    'default' => true,
    'name' => 'last_contact',
  ),
),
);

<?php
// created: 2013-10-17 13:15:52
$subpanel_layout['list_fields'] = array (
  'name' => 
  array (
    'name' => 'name',
    'vname' => 'LBL_LIST_NAME',
    'sort_by' => 'last_name',
    'sort_order' => 'asc',
    'widget_class' => 'SubPanelDetailViewLink',
    'module' => 'Contacts',
    'width' => '18%',
    'default' => true,
  ),
  'dov_description' => 
  array (
    'type' => 'varchar',
    'vname' => 'LBL_DESCRIPTION',
    'width' => '10%',
    'default' => true,
  ),
  'presentation_checked' => 
  array (
    'vname' => 'LBL_PRESENTATION_CHECKED',
    'width' => '5%',
    'default' => true,
    'sortable' => false,
  ),
  'account_name' => 
  array (
    'name' => 'account_name',
    'module' => 'Accounts',
    'target_record_key' => 'account_id',
    'target_module' => 'Accounts',
    'widget_class' => 'SubPanelDetailViewLink',
    'vname' => 'LBL_LIST_ACCOUNT_NAME',
    'width' => '15%',
    'sortable' => false,
    'default' => true,
  ),
  'email1' => 
  array (
    'name' => 'email1',
    'vname' => 'LBL_LIST_EMAIL',
    'widget_class' => 'SubPanelEmailLink',
    'width' => '15%',
    'sortable' => false,
    'default' => true,
  ),
  'operation' => 
  array (
    'type' => 'enum',
    'vname' => 'LBL_OPERATION',
    'width' => '10%',
    'default' => true,
  ),
  'phone_mobile' => 
  array (
    'type' => 'function',
    'vname' => 'LBL_MOBILE_PHONE',
    'width' => '10%',
    'default' => true,
  ),
  'cost_to' => 
  array (
    'type' => 'float',
    'vname' => 'LBL_COST_TO',
    'width' => '10%',
    'default' => true,
  ),
  'interest_button' => 
  array (
    'vname' => 'LBL_INTEREST',
    'module' => NULL,
    'width' => '5%',
    'widget_class' => 'SubPanelInterestButton',
    'default' => true,
  ),
  'first_name' => 
  array (
    'name' => 'first_name',
    'usage' => 'query_only',
  ),
  'last_name' => 
  array (
    'name' => 'last_name',
    'usage' => 'query_only',
  ),
  'salutation' => 
  array (
    'name' => 'salutation',
    'usage' => 'query_only',
  ),
  'account_id' => 
  array (
    'usage' => 'query_only',
  ),
);
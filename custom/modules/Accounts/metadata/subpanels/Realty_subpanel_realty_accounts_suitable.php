<?php
// created: 2013-10-17 13:16:29
$subpanel_layout['list_fields'] = array (
  'name' => 
  array (
    'vname' => 'LBL_LIST_ACCOUNT_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
    'width' => '23%',
    'default' => true,
  ),
  'industry' => 
  array (
    'type' => 'enum',
    'vname' => 'LBL_INDUSTRY',
    'width' => '10%',
    'default' => true,
  ),
  'website' => 
  array (
    'type' => 'url',
    'vname' => 'LBL_WEBSITE',
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
  'main_address_country_jur' => 
  array (
    'type' => 'varchar',
    'vname' => 'LBL_ADDRESS_COUNTRY',
    'width' => '10%',
    'default' => true,
  ),
  'main_address_city_jur' => 
  array (
    'type' => 'varchar',
    'vname' => 'LBL_ADDRESS_CITY',
    'width' => '10%',
    'default' => true,
  ),
  'phone_office' => 
  array (
    'vname' => 'LBL_LIST_PHONE',
    'width' => '10%',
    'default' => true,
  ),
  'operation' => 
  array (
    'type' => 'enum',
    'vname' => 'LBL_OPERATION',
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
);
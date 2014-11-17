<?php
// created: 2013-10-17 13:34:07
$subpanel_layout['list_fields'] = array (
  'name' => 
  array (
    'vname' => 'LBL_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
    'width' => '10%',
    'default' => true,
  ),
  'totalcost' => 
  array (
    'vname' => 'LBL_TOTALCOST',
    'width' => '10%',
    'default' => true,
  ),
  'currency' => 
  array (
    'vname' => 'LBL_CURRENCY',
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
  'square' => 
  array (
    'vname' => 'LBL_SQUARE',
    'width' => '5%',
    'default' => true,
  ),
  'address_street' => 
  array (
    'vname' => 'LBL_ADDRESS_STREET',
    'width' => '15%',
    'default' => true,
  ),
  'last_contact' => 
  array (
    'type' => 'date',
    'vname' => 'LBL_LAST_CONTACT',
    'width' => '10%',
    'default' => true,
  ),
  'assigned_user_name' => 
  array (
    'link' => true,
    'type' => 'relate',
    'vname' => 'LBL_ASSIGNED_TO_NAME',
    'id' => 'ASSIGNED_USER_ID',
    'width' => '10%',
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'Users',
    'target_record_key' => 'assigned_user_id',
  ),
  'interest_button' => 
  array (
    'vname' => 'LBL_INTEREST',
    'module' => 'Realty',
    'width' => '5%',
    'widget_class' => 'SubPanelInterestButton',
    'default' => true,
  ),
);
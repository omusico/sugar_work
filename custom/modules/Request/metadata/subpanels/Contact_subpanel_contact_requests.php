<?php
// created: 2014-02-12 09:36:17
$subpanel_layout['list_fields'] = array (
  'name' => 
  array (
    'vname' => 'LBL_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
    'width' => '45%',
    'default' => true,
  ),
  'kind_of_realty' => 
  array (
    'type' => 'enum',
    'vname' => 'LBL_KIND_OF_REALTY',
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
  'rooms_quantity' => 
  array (
    'type' => 'int',
    'vname' => 'LBL_ROOMS_QUANTITY',
    'width' => '10%',
    'default' => true,
  ),
  'date_modified' => 
  array (
    'vname' => 'LBL_DATE_MODIFIED',
    'width' => '45%',
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
);
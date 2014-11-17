<?php
// created: 2013-09-07 13:03:44
$subpanel_layout['list_fields'] = array (
  'name' => 
  array (
    'vname' => 'LBL_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
    'width' => '45%',
    'default' => true,
  ),
  'branch_name' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'vname' => 'LBL_BRANCH_NAME',
    'id' => 'BRANCH_ID',
    'link' => true,
    'width' => '10%',
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'Branch',
    'target_record_key' => 'branch_id',
  ),
  'kind_of_realty' => 
  array (
    'type' => 'multienum',
    'vname' => 'LBL_KIND_OF_REALTY',
    'width' => '10%',
    'default' => true,
  ),
  'assigned_user_name' => 
  array (
    'vname' => 'LBL_ASSIGNED_TO_NAME',
    'width' => '45%',
    'default' => true,
  ),
  'edit_button' => 
  array (
    'vname' => 'LBL_EDIT_BUTTON',
    'widget_class' => 'SubPanelEditButton',
    'module' => 'Department',
    'width' => '4%',
    'default' => true,
  ),
  'remove_button' => 
  array (
    'vname' => 'LBL_REMOVE',
    'widget_class' => 'SubPanelRemoveButton',
    'module' => 'Department',
    'width' => '5%',
    'default' => true,
  ),
);
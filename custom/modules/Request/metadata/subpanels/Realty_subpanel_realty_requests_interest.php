<?php
// created: 2014-06-20 16:47:23
$subpanel_layout['list_fields'] = array (
  'name' => 
  array (
    'vname' => 'LBL_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
    'width' => '25%',
    'default' => true,
  ),
  'parent_name' => 
  array (
    'vname' => 'LBL_LIST_RELATED_TO',
    'width' => '25%',
    'target_record_key' => 'parent_id',
    'target_module_key' => 'parent_type',
    'widget_class' => 'SubPanelDetailViewLink',
    'sortable' => false,
    'default' => true,
  ),
  'date_modified' => 
  array (
    'vname' => 'LBL_DATE_MODIFIED',
    'width' => '25%',
    'default' => true,
  ),
  'send_presentation' => 
  array (
    'type' => 'bool',
    'vname' => 'LBL_SEND_PRES',
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
  'edit_button' => 
  array (
    'vname' => 'LBL_EDIT_BUTTON',
    'widget_class' => 'SubPanelEditButton',
    'module' => 'Request',
    'width' => '4%',
    'default' => true,
  ),
  'remove_button' => 
  array (
    'vname' => 'LBL_REMOVE',
    'widget_class' => 'SubPanelRemoveButton',
    'module' => 'Request',
    'width' => '5%',
    'default' => true,
  ),
);
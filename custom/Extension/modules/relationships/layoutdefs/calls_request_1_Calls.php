<?php
 // created: 2014-03-20 17:19:24
$layout_defs["Calls"]["subpanel_setup"]['calls_request_1'] = array (
  'order' => 100,
  'module' => 'Request',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_CALLS_REQUEST_1_FROM_REQUEST_TITLE',
  'get_subpanel_data' => 'calls_request_1',
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubPanelTopButtonQuickCreate',
    ),
    1 => 
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'mode' => 'MultiSelect',
    ),
  ),
);

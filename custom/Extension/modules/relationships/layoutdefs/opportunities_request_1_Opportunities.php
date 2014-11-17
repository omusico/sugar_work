<?php
 // created: 2014-03-20 17:02:05
$layout_defs["Opportunities"]["subpanel_setup"]['opportunities_request_1'] = array (
  'order' => 100,
  'module' => 'Request',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_OPPORTUNITIES_REQUEST_1_FROM_REQUEST_TITLE',
  'get_subpanel_data' => 'opportunities_request_1',
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

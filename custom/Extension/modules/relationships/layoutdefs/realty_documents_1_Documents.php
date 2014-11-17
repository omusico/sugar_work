<?php
 // created: 2013-07-03 14:00:07
$layout_defs["Documents"]["subpanel_setup"]['realty_documents_1'] = array (
  'order' => 100,
  'module' => 'Realty',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_REALTY_DOCUMENTS_1_FROM_REALTY_TITLE',
  'get_subpanel_data' => 'realty_documents_1',
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

<?php
 // created: 2013-09-19 16:38:29
$layout_defs["Buildings"]["subpanel_setup"]['buildings_notes_1'] = array (
  'order' => 100,
  'module' => 'Notes',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_BUILDINGS_NOTES_1_FROM_NOTES_TITLE',
  'get_subpanel_data' => 'buildings_notes_1',
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

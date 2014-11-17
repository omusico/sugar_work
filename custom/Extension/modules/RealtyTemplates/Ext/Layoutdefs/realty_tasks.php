<?php
/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 */
$layout_defs["RealtyTemplates"]["subpanel_setup"]["realtytemplates_tasks"] = array (
    'order' => 2,
    'module' => 'Tasks',
    'subpanel_name' => 'default',
    'sort_order' => 'desc',
    'sort_by' => 'date_entered',
    'title_key' => 'LBL_SUBPANEL_REALTYTEMPLATES_TASKS_TITLE',
    'get_subpanel_data' => 'realtytemplates_tasks', //имя поля link
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
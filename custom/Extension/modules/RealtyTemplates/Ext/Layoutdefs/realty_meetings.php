<?php
/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 */
$layout_defs["Realty"]["subpanel_setup"]["realty_meetings"] = array (
    'order' => 2,
    'module' => 'Meetings',
    'subpanel_name' => 'default',
    'sort_order' => 'desc',
    'sort_by' => 'date_entered',
    'title_key' => 'LBL_SUBPANEL_REALTY_MEETINGS_TITLE',
    'get_subpanel_data' => 'realty_meetings', //имя поля link
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
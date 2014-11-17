<?php
/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 */
$layout_defs["Contacts"]["subpanel_setup"]["realty_contacts"] = array (
    'order' => 2,
    'module' => 'Realty',
    'subpanel_name' => 'default',
    'sort_order' => 'desc',
    'sort_by' => 'date_entered',
    'title_key' => 'LBL_SUBPANEL_REALTY_CONTACTS_TITLE',
    'get_subpanel_data' => 'realty_contacts',
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
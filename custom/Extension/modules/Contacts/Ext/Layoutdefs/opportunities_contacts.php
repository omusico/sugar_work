<?php
/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 */
$layout_defs["Contacts"]["subpanel_setup"]["opportunity_contacts"] = array (
    'order' => 2,
    'module' => 'Opportunities',
    'subpanel_name' => 'default',
    'sort_order' => 'desc',
    'sort_by' => 'date_entered',
    'title_key' => 'LBL_SUBPANEL_OPPORTUNITIES_CONTACTS_TITLE',
    'get_subpanel_data' => 'opportunity_contacts', //имя поля link
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
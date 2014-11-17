<?php
/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 */
$layout_defs["Buildings"]["subpanel_setup"]["realty_buildings"] = array (
    'order' => 2,
    'module' => 'Realty',
    'subpanel_name' => 'default',
    'sort_order' => 'desc',
    'sort_by' => 'date_entered',
    'title_key' => 'LBL_SUBPANEL_REALTY_BUILDINGS_TITLE',
    'get_subpanel_data' => 'realty_buildings',
    'top_buttons' =>
    array (
        0 =>
        array (
            'widget_class' => 'SubPanelTopCreateRealtyButton',
        ),
        1 =>
        array (
            'widget_class' => 'SubPanelTopSelectButton',
            'mode' => 'MultiSelect',
        ),
    ),
);

$layout_defs["Buildings"]["subpanel_setup"]["realtytemplates_buildings"] = array (
    'order' => 2,
    'module' => 'RealtyTemplates',
    'subpanel_name' => 'default',
    'sort_order' => 'desc',
    'sort_by' => 'date_entered',
    'title_key' => 'LBL_SUBPANEL_REALTYTEMPLATES_BUILDINGS_TITLE',
    'get_subpanel_data' => 'realtytemplates_buildings',
    'top_buttons' =>
    array (
        0 =>
        array (
//            'widget_class' => 'SubPanelTopCreateButton',
            'widget_class' => 'SubPanelTopCreateRealtyButton',
        ),
        1 =>
        array (
            'widget_class' => 'SubPanelTopSelectButton',
            'mode' => 'MultiSelect',
        ),
    ),
);

$layout_defs["Buildings"]["subpanel_setup"]["buildings_sections"] = array (
    'order' => 2,
    'module' => 'Sections',
    'subpanel_name' => 'default',
    'sort_order' => 'desc',
    'sort_by' => 'date_entered',
    'title_key' => 'LBL_SUBPANEL_BUILDINGS_SECTIONS_TITLE',
    'get_subpanel_data' => 'buildings_sections',
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

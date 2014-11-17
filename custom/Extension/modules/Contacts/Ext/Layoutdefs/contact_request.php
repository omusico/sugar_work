<?php

$layout_defs["Contacts"]["subpanel_setup"]["contact_requests"] = array (
    'order' => 2,
    'module' => 'Request',
    'subpanel_name' => 'default',
    'sort_order' => 'desc',
    'sort_by' => 'date_entered',
    'title_key' => 'LBL_REQUESTS',
    'get_subpanel_data' => 'requests',
    'top_buttons' =>
    array (
        0 =>
        array (
            'widget_class' => 'SubPanelTopCreateButton',
        ),
    ),
);
<?php

$layout_defs["Accounts"]["subpanel_setup"]["account_request"] = array (
    'order' => 2,
    'module' => 'Request',
    'subpanel_name' => 'default',
    'sort_order' => 'desc',
    'sort_by' => 'date_entered',
    'title_key' => 'LBL_REQUESTS',
    'get_subpanel_data' => 'account_request',
    'top_buttons' =>
    array (
        0 =>
        array (
            'widget_class' => 'SubPanelTopCreateButton',
        ),
    ),
);
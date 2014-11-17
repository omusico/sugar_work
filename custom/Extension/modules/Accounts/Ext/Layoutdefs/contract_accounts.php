<?php
/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 */
$layout_defs["Accounts"]["subpanel_setup"]["contract_accounts"] = array (
    'order' => 2,
    'module' => 'Contract',
    'subpanel_name' => 'default',
    'sort_order' => 'desc',
    'sort_by' => 'date_entered',
    'title_key' => 'LBL_SUBPANEL_CONTRACT_ACCOUNTS_TITLE',
    'get_subpanel_data' => 'contract_accounts',
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
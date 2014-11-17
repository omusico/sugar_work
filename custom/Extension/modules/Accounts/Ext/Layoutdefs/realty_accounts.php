<?php
$layout_defs["Accounts"]["subpanel_setup"]["realty_accounts"] = array (
    'order' => 2,
    'module' => 'Realty',
    'subpanel_name' => 'default',
    'sort_order' => 'desc',
    'sort_by' => 'date_entered',
    'title_key' => 'LBL_SUBPANEL_REALTY_ACCOUNTS_TITLE',
    'get_subpanel_data' => 'realty_accounts',
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

$layout_defs["Accounts"]["subpanel_setup"]["realty_accounts_m_to_m"] = array (
    'order' => 100,
    'module' => 'Realty',
    'subpanel_name' => 'ForAccounts',
    'get_subpanel_data' => 'function:getSubpanelQueryParts',
    'add_subpanel_data' => 'realty_id',
    'title_key' => 'LBL_REALTY_ACCOUNTS',
    'generate_select' => true,
    'function_parameters' => array(
     // File where the above function is defined at
      'import_function_file' => 'custom/application/Ext/Utils/custom_utils.ext.php',
      ),
);
<?php
//
//$layout_defs["Accounts"]["subpanel_setup"]["realty_accounts_interest"] = array (
//    'order' => 100,
//    'module' => 'Realty',
//    'subpanel_name' => 'ForAccountsInterest',
//    'get_subpanel_data' => 'realty_accounts_interest',
//    'add_subpanel_data' => 'realty_id',
//    'title_key' => 'LBL_REALTY_ACCOUNTS_INTEREST',
//    'generate_select' => true,
//     'function_parameters' => array(
//        'import_function_file' => 'custom/application/Ext/Utils/custom_utils.ext.php',
//       ), 
//);
$layout_defs["Accounts"]["subpanel_setup"]["realty_accounts_interest"] = array (
    'order' => 100,
    'module' => 'Realty',
    'subpanel_name' => 'ForAccountsInterest',
    'get_subpanel_data' => 'function:getInterest',//TODO
    'add_subpanel_data' => 'realty_id',
    'title_key' => 'LBL_REALTY_ACCOUNTS_INTEREST',
    'generate_select' => true,
    'function_parameters' => array(
      'import_function_file' => 'custom/application/Ext/Utils/custom_utils.ext.php',//TODO
      ), 
);
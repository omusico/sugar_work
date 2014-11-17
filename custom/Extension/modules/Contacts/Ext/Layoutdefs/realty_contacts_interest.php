<?php

//$layout_defs["Contacts"]["subpanel_setup"]["realty_contacts_interest"] = array (
//    'order' => 100,
//    'module' => 'Realty',
//    'subpanel_name' => 'ForContactsInterest',
//    'get_subpanel_data' => 'realty_contacts_interest',
//    'add_subpanel_data' => 'realty_id',
//    'title_key' => 'LBL_REALTY_CONTACTS_INTEREST',
//    //'generate_select' => true,
////     'function_parameters' => array(
////      // File where the above function is defined at
////        'import_function_file' => 'custom/application/Ext/Utils/custom_utils.ext.php',
////       ), 
//);

$layout_defs["Contacts"]["subpanel_setup"]["realty_contacts_interest"] = array (
    'order' => 100,
    'module' => 'Realty',
    'subpanel_name' => 'ForContactsInterest',
    'get_subpanel_data' => 'function:getInterest',
    'add_subpanel_data' => 'realty_id',
    'title_key' => 'LBL_REALTY_CONTACTS_INTEREST',
    'generate_select' => true,
    'function_parameters' => array(
      'import_function_file' => 'custom/application/Ext/Utils/custom_utils.ext.php',
      ), 
);
<?php


$layout_defs["Request"]["subpanel_setup"]["realty_requests"] = array (
    'order' => 100,
    'module' => 'Realty',
    'subpanel_name' => 'ForRequests',
    'get_subpanel_data' => 'function:getSubpanelQueryParts',//TODO
    'add_subpanel_data' => 'realty_id',
    'title_key' => 'LBL_REALTY_REQUESTS',
    'generate_select' => true,
    'function_parameters' => array(
      'import_function_file' => 'custom/application/Ext/Utils/custom_utils.ext.php',//TODO
     ), 
);
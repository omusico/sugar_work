<?php

$layout_defs["Realty"]["subpanel_setup"]["realty_requests_suitable"] = array (
    'order' => 100,
    'module' => 'Request',
    'subpanel_name' => 'ForRealtySuitable',
    'get_subpanel_data' => 'function:getRequestSuitableQuery',
    'generate_select' => true,
    'function_parameters'=>array(
        'import_function_file' => 'custom/application/Ext/Utils/custom_utils.ext.php',
    ),
    'title_key' => 'LBL_REALTY_REQUEST_SUITABLE',
);

unset($layout_defs["Realty"]["subpanel_setup"]["realty_requests_suitable"]["top_buttons"][0]);
unset($layout_defs["Realty"]["subpanel_setup"]["realty_requests_suitable"]["top_buttons"][1]);
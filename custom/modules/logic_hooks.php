<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['after_ui_frame'] = Array(); 
$hook_array['after_ui_frame'][] = Array(10000, 'Add Button for load form with reports settings', 'modules/OfficeReportsMerge/ReportHook.php','ReportHook', 'addButton'); 
$hook_array['after_ui_frame'][] = Array(13123123, 'add geocomplete lib', 'custom/modules/addGeoLib.php','addGeoLib', 'add'); 
$hook_array['after_ui_frame'][] = Array(1, 'Add new button to listview', 'custom/modules/XlsExport/UpdateListView.php','UpdateListView', 'addCustomButton'); 
$hook_array['after_ui_frame'][] = Array(2, 'Add kXML button to listview', 'modules/kXML/add_action.php','kXMLAction', 'addCustomButtonAction'); 
$hook_array['after_ui_footer'] = Array(); 
$hook_array['after_retrieve'] = Array(); 
$hook_array['after_retrieve'][] = Array(1, 'acl_fields', 'modules/acl_fields/fields_logic.php','acl_fields_logic', 'limit_views'); 
?>
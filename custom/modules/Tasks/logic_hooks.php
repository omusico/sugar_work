<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['after_save'] = Array();
$hook_array['before_save'] = Array();
$hook_array['after_save'][] = Array(1, 'Contacts push feed', 'custom/modules/Tasks/add_subpanel_record.php','AddSubpanelRecordTasks', 'addAfterCreate'); 
$hook_array['before_save'][] = Array(7, 'save_googlecal', 'modules/GoogleSync/Hooks.php','GoogleSyncHooks', 'onSave'); 
$hook_array['after_delete'] = Array(); 
$hook_array['after_delete'][] = Array(8, 'delete_googlecal', 'modules/GoogleSync/Hooks.php','GoogleSyncHooks', 'onAfterDelete'); 
$hook_array['after_restore'] = Array(); 
$hook_array['after_restore'][] = Array(9, 'restore_googlecal', 'modules/GoogleSync/Hooks.php','GoogleSyncHooks', 'onAfterRestore'); 

$hook_array['after_save'][] = Array(1, 'Set last_contact', 'custom/modules/Calls/hooks.php','myHook', 'AfterSave');

$hook_array['process_record'][] = Array(1, 'set color by status', 'custom/modules/Tasks/hooks.php','processRecord', 'statusColorize');

?>
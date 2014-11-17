<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['before_save'] = Array(); 
$hook_array['process_record'] = Array();
// $hook_array['after_ui_frame'] = Array();

$hook_array['before_save'][] = Array(1, 'Contacts push feed', 'modules/Contacts/SugarFeeds/ContactFeed.php','ContactFeed', 'pushFeed'); 

/* $hook_array['after_save'] = Array();
$hook_array['after_save'][] = Array(1, '123', 'custom/modules/Contacts/afterSave.php','addPotential', 'addPotential');
 */

// $hook_array['before_save'] = Array();
$hook_array['before_save'][] = Array(1, 'Create new opportunity', 'custom/modules/Contacts/create_new_opportunity.php','CreateNewOpportunityFromContact', 'create');

$hook_array['process_record'][] = Array(3,'subpanel row', 'custom/modules/Contacts/Presentation.php','Presentation3', 'row');

?>
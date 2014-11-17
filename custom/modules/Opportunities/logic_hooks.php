<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['before_save'] = Array(); 
$hook_array['before_save'][] = Array(1, 'Opportunities push feed', 'modules/Opportunities/SugarFeeds/OppFeed.php','OppFeed', 'pushFeed'); 
$hook_array['after_ui_frame'] = Array();

$hook_array['after_save'] = Array();
$hook_array['after_save'][] = Array(66, 'Exe fields', 'custom/modules/Opportunities/setOpportunityAmount.php','setOpportunityAmount', 'setAmount');

$hook_array['after_retrieve'] = Array();
$hook_array['after_retrieve'][] = Array(66, 'Exe fields', 'custom/modules/Opportunities/after_retrieve.php','retrieve_opp', 'execute');

$hook_array['after_save'] = Array();
$hook_array['after_save'][] = Array(66, 'Exe fields', 'custom/modules/Opportunities/after_save.php','AfterSaveHook', 'execute');



?>

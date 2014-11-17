<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['before_save'] = Array();
$hook_array['before_save'][] = Array(1, 'Add related realty from opportunities', 'custom/modules/Contract/AddRealtyFromOpportunities.php','AddRealtyFromOpportunities', 'addRealty');

$hook_array['after_save'] = Array(); 
$hook_array['after_save'][] = Array(66, 'Set auto name', 'custom/modules/Contract/setAutoNameIncrement.php','setAutoNameIncrement', 'addMnemonik'); 


?>

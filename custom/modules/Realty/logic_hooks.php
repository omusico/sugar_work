<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
$hook_array['before_save'] = Array();
$hook_array['before_save'][] = Array(1, 'Contacts push feed', 'custom/modules/Realty/add_subpanel_record.php','AddSubpanelRecord', 'addAfterCreate');

$hook_array['after_relationship_add'] = Array();
$hook_array['after_relationship_add'][] = Array(1, 'Update date modified after relationships add', 'custom/include/Hooks/updateDateModified.php','updateDateModified', 'updateFromRelationships');

$hook_array['after_relationship_delete'] = Array();
$hook_array['after_relationship_delete'][] = Array(1, 'Update date modified after relationships add', 'custom/include/Hooks/updateDateModified.php','updateDateModified', 'updateFromRelationships');
/*
$hook_array['before_relationship_add'] = Array();
$hook_array['before_relationship_add'][] = Array(1, 'данный объект находится в сделке', 'custom/modules/Realty/beforeRelationship.php','beforeRelationship_hook', 'checkObjects');
*/
//$hook_array['after_save'] = Array();
//$hook_array['after_save'][] = Array(1, '123', 'custom/modules/Realty/afterSave.php','addPotentialClients', 'addPotential');
//$hook_array['after_save'] = Array();
//$hook_array['after_save'][] = Array(3, '123', 'custom/modules/Realty/kxml_update.php','kxml_update', 'kxml_update');

// $hook_array['before_save'] = Array();
$hook_array['before_save'][] = Array(1, 'Убираем 0 в полях: Этажность, Этаж, Кол-во комнат ', 'custom/modules/Realty/Not_zero.php','Not_zero', 'remove_zero');

$hook_array['before_save'][] = Array(1, 'Приводим стоимость к гривнам для сравнения объектов независимо от валюты', 'custom/modules/Realty/Currencies_hook.php','Currencies_hook', 'toUAH');

$hook_array['process_record'] = Array();
$hook_array['process_record'][] = Array(1, 'Убираем 0 в полях: Этажность, Этаж, Кол-во комнат ', 'custom/modules/Realty/Not_zero.php','Not_zero', 'remove_zero');
 
$hook_array['process_record'][] = Array(3,'subpanel row', 'custom/modules/Realty/Presentation.php','Presentation', 'row'); 

$hook_array['after_save'][] = Array(1, 'Публикуем в Assis', 'custom/modules/Realty/publishInAssis.php','Assis', 'send_assis_request');
?>

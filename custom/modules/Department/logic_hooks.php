<?php
/*
*	Created by Kolerts
*/
$hook_version = 1; 
$hook_array = Array(); 
$hook_array['after_save'] = Array();
$hook_array['after_save'][] = Array(999, 'Меняем должность начальнику', 'custom/modules/Department/hooks.php','myHookDep', 'changeUserTitle');
?>
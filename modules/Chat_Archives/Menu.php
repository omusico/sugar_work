<?php
global $mod_strings, $app_strings, $sugar_config;

if(ACLController::checkAccess('Chat_Archives', 'edit', true)) $module_menu[] = Array("index.php?module=Chat_Archives&action=EditView&return_module=Chat_Archives&return_action=index", $mod_strings['LNK_NEW_RECORD'],"CreateChat_Archives", 'Chat_Archives');

if(ACLController::checkAccess('Chat_Archives', 'list', true)) $module_menu[] = Array("index.php?module=Chat_Archives&action=index&return_module=Chat_Archives&return_action=DetailView", $mod_strings['LNK_LIST'],"Chat_Archives", 'Chat_Archives');


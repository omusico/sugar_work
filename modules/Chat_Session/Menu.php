<?php
global $mod_strings, $app_strings, $sugar_config;

if(ACLController::checkAccess('Chat_Session', 'edit', true)) $module_menu[] = Array("index.php?module=Chat_Session&action=EditView&return_module=Chat_Session&return_action=index", $mod_strings['LNK_NEW_RECORD'],"CreateChat_Session", 'Chat_Session');

if(ACLController::checkAccess('Chat_Session', 'list', true)) $module_menu[] = Array("index.php?module=Chat_Session&action=index&return_module=Chat_Session&return_action=DetailView", $mod_strings['LNK_LIST'],"Chat_Session", 'Chat_Session');


<?php
global $mod_strings, $app_strings, $sugar_config;

if(ACLController::checkAccess('Chat_Messages', 'edit', true)) $module_menu[] = Array("index.php?module=Chat_Messages&action=EditView&return_module=Chat_Messages&return_action=index", $mod_strings['LNK_NEW_RECORD'],"CreateChat_Messages", 'Chat_Messages');

if(ACLController::checkAccess('Chat_Messages', 'list', true)) $module_menu[] = Array("index.php?module=Chat_Messages&action=index&return_module=Chat_Messages&return_action=DetailView", $mod_strings['LNK_LIST'],"Chat_Messages", 'Chat_Messages');


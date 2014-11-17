<?php
if(!defined('sugarEntry'))define('sugarEntry', true);
require_once "modules/GoogleSync/GoogleSync.php";

class GoogleSyncHooks {

    function onSave(&$bean, $event, $arguments) {
        if ($bean->from_where != 'GOOGLE')
        {
            GoogleSync::eventSave($bean);
        }
    }
    
    function onAfterDelete(&$bean, $event, $arguments) {
        $bean->deleted = 1;
        GoogleSync::eventSave($bean);
    }
    
    function onAfterRestore(&$bean, $event, $arguments) {
        $bean->deleted = 0;
        GoogleSync::eventSave($bean);
    }
}

?>
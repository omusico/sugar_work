<?php
/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 */
class AddSubpanelRecordTasks{

    function addAfterCreate(&$bean)
    {
        if($_REQUEST['action'] != 'DeleteRelationship' AND $_REQUEST['action'] == 'Save' AND $_REQUEST['return_module'] != 'Tasks')
        {
            //$relate_field = "realty_id";
            $bean->realty_id = $_REQUEST['return_id'];
        }

        global $db;

        $sql = "UPDATE realty SET date_modified = '" . date("Y-m-d H:i:s") . "' WHERE id = '" . $_REQUEST['return_id'] . "'";

        $db->query($sql);
    }
}
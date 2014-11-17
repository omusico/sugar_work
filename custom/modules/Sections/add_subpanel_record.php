<?php
/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 */
class AddSubpanelRecordSections{

    function addAfterCreate(&$bean)
    {
        if($_REQUEST['action'] != 'DeleteRelationship' AND $_REQUEST['action'] == 'Save' AND $_REQUEST['return_module'] == 'Buildings')
        {
            $relate_field = "building_id";
            $bean->$relate_field = $_REQUEST['return_id'];
        }
    }
}
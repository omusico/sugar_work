<?php
/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 */
class AddSubpanelRecordBuildings{

    function addAfterCreate(&$bean)
    {
        if($_REQUEST['action'] != 'DeleteRelationship' AND $_REQUEST['action'] == 'Save' AND $_REQUEST['module'] != 'Realty')
        {
            $relate_field = "account_id";
            $bean->$relate_field = $_REQUEST['return_id'];
        }
    }
}
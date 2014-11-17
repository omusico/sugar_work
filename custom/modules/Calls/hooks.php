<?php
/**
 * Created by Kolerts
 * Protected by SugarTalk.ru
 */
class myHook{

    function afterSave(&$bean)
    {
        if(isset($bean->realty_id) && $bean->realty_id!='')
        {
            $realty = new Realty();
            $realty->retrieve($bean->realty_id);
            if(isset($realty->last_contact)){
                    $realty->last_contact=date('Y-m-d');
                    $realty->save();
            }
        }
        if(isset($bean->parent_id) && $bean->parent_id!='')
        {
            $client = loadBean($bean->parent_type);
            $client->retrieve($bean->parent_id);
            if(isset($client->last_contact)){
                    $client->last_contact=date('Y-m-d');
                    $client->save();
            }
        }
    }
}
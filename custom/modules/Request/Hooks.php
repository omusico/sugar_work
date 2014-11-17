<?php
/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 */

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');


class RequestHooks
{

    function ProcessRecord(&$bean, $event, $arguments)
    {
        $this_fucking_bean = new Request();
        $this_fucking_bean->retrieve($bean->id);
        $parent_bean = BeanFactory::getbean($this_fucking_bean->parent_type,$this_fucking_bean->parent_id);
        if($this_fucking_bean->parent_type == 'Accounts')
            $bean->parent_name = "<a href='index.php?module=".$this_fucking_bean->parent_type."&action=DetailView&record=".$this_fucking_bean->parent_id."'>".$parent_bean->name."</a> - Юр. лицо";
        else if($this_fucking_bean->parent_type == 'Contacts')
            $bean->parent_name = "<a href='index.php?module=".$this_fucking_bean->parent_type."&action=DetailView&record=".$this_fucking_bean->parent_id."'>".$parent_bean->last_name.' '.$parent_bean->first_name."</a> - Физ. лицо";

        // Добавляем чекбокс - презентация
        $bean->presentation_checked = "<input type=checkbox name=done id='{$bean->id}' value='{$bean->id}' class='presentationRec' >"; 
    }
}
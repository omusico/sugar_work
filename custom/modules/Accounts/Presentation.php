<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
 
class Presentation2
{ 
    function row(&$bean, $event, $arguments)
    {
        /*global $current_user;
        if ($current_user->id != $bean->assigned_user_id  && !$current_user->is_admin)
        {
            $bean->phone_office = " ";
        }*/
        
        if ($_REQUEST['return_module'] == "Realty" || $_REQUEST['module'] == "Realty")
        {
            $bean->presentation_checked = "<input type=checkbox name=done id='".$bean->id."' value='".$bean->id."' class='presentationR' >"; 
            $db= DBManagerFactory::getInstance();
            $sql = "SELECT * FROM realty_accounts_m_to_m_table WHERE account_id = '".$bean->id."' AND deleted = 0 AND realty_id = '".$_GET['record']."'";
            $result = $db->query($sql);
            if($row = $db->fetchByAssoc($result))
            {
                $bean->presentation_text = $row['presentation_text'];
            }
        }

    }
}
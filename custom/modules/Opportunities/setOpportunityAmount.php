<?php

class setOpportunityAmount
{

    function setAmount(&$bean)
    {

        $realty_id =  $_COOKIE["RealtyCookie"];

        $db= DBManagerFactory::getInstance(); 
        $opportunity_id = $_REQUEST['record'];
        $date = date('Y-m-d H:i:s');

        if(isset($realty_id) && !empty($realty_id) && $realty_id != 'none'){

           $sql_destroy = "DELETE FROM realty_opportunities_table
                           WHERE opportunity_id = '{$opportunity_id}'" ;

            $result_destroy = $db->query($sql_destroy);

            $sql = "INSERT INTO realty_opportunities_table
                    SET opportunity_id = '{$opportunity_id}',
                    realty_id = '{$realty_id}',                    
                    deleted = 0, 
                    date_modified = '{$date}',
                    id = UUID()";

            $result = $db->query($sql);
            $bean->realty_id = $realty_id;            
        } 

        if($realty_id == 'none'){

           $sql_destroy = "DELETE FROM realty_opportunities_table
                           WHERE opportunity_id = '{$opportunity_id}'" ;

            $result_destroy = $db->query($sql_destroy);
            $bean->realty_id = ''; 
        }

        setcookie("RealtyCookie", " ");
    }
}

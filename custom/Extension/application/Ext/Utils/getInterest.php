<?php

function getInterest()//$params)
{
    $bean = $GLOBALS['app']->controller->bean;
    
    $return_array['select']='SELECT realty.id ';
    $return_array['from']='FROM realty';
    $return_array['where'] = "WHERE realty.id IN (
        SELECT rrit.realty_id 
        FROM realty_requests_interest_table AS rrit
        LEFT JOIN request as r ON r.id = rrit.request_id
        WHERE r.parent_id = '{$bean->id}'
        AND rrit.deleted = 0
        AND r.deleted = 0
) ";//добавить проверку по статусу недвижимости "не активен" 
    
    echo '<small style="color:#ccc;">Запрос подбора:'.$return_array['where'].'</small>';

    return $return_array;
}


//    AND meetings.parent_type = 'Leads' AND meetings.id NOT IN ( SELECT meeting_id FROM meetings_leads ) ";
//    $return_array['join'] = "";
//    $return_array['join_tables'][0] = '';
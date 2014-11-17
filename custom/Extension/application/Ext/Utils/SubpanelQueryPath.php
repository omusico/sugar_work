<?php

function getSubpanelQueryParts()//$params)
{
    $bean = $GLOBALS['app']->controller->bean;
    
    $return_array['select']='SELECT realty.id ';
    $return_array['from']='FROM realty';
    $return_array['where'] = "WHERE realty.operation = '$bean->operation'";//добавить проверку по статусу недвижимости "не активен" 
    
//    if(!empty($bean->currency))
//       $return_array['where'] .="AND realty.currency = '$bean->currency'";
    if(!empty($bean->currency) && !empty($bean->cost_to))
    {
		/* require_once 'custom/modules/Realty/Currencies_hook.php';
		$Currencies_ = new Currencies_hook();
		$cost_to_uah=$Currencies_->to_uah($bean->cost_to, $bean->currency);
		$return_array['where'] .=" AND realty.currency_uah <='$cost_to_uah'";//" AND realty.totalcost <='$bean->cost_to'"; */
		$return_array['where'] .=" AND realty.totalcost <='$bean->cost_to'";
    }
    
    if (!empty($bean->rooms_quantity))
       $return_array['where'] .= " AND (realty.rooms_quantity >= '{$bean->rooms_quantity}' OR realty.rooms_quantity = '0' OR realty.rooms_quantity IS NULL)";
	
	if (!empty($bean->rooms_quantity_to))
       $return_array['where'] .= " AND (realty.rooms_quantity <= '{$bean->rooms_quantity_to}' OR realty.rooms_quantity = '0' OR realty.rooms_quantity IS NULL)";

    if (!empty($bean->square_min))
       $return_array['where'] .= " AND realty.square >= '{$bean->square_min}' ";
	if (!empty($bean->square_max))
       $return_array['where'] .= " AND realty.square <= '{$bean->square_max}' ";

    if (!empty($bean->address_country))
       $return_array['where'] .=  " AND realty.address_country LIKE '{$bean->address_country}'";

    if (!empty($bean->address_region))
       $return_array['where'] .=  " AND realty.address_region LIKE '{$bean->address_region}'";

	if (!empty($bean->address_city))
       $return_array['where'] .=  " AND realty.address_city LIKE '{$bean->address_city}'";


    if (!empty($bean->metro))
       $return_array['where'] .=  " AND realty.metro LIKE '{$bean->metro}'";

    if (!empty($bean->kind_of_realty))
       $return_array['where'] .=  " AND realty.kind_of_realty LIKE '{$bean->kind_of_realty}'";
       
    /* $return_array['where'] .=  " AND realty.id NOT IN (
                                SELECT rrit.realty_id as rid
                                FROM realty_requests_interest_table AS rrit
                                WHERE rrit.request_id = '{$bean->id}'
                                AND rrit.deleted = 0
                            )"; */
    
    echo '<small style="color:#ccc;">Запрос подбора:'.$return_array['where'].'</small>';

    return $return_array;
}


//    AND meetings.parent_type = 'Leads' AND meetings.id NOT IN ( SELECT meeting_id FROM meetings_leads ) ";
//    $return_array['join'] = "";
//    $return_array['join_tables'][0] = '';
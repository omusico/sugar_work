<?php

function getRequestSuitableQuery()//$params)
{
    $bean = $GLOBALS['app']->controller->bean;
    
    $return_array['select']='SELECT request.id ';
    $return_array['from']='FROM request';

    $return_array['where'] = "WHERE request.operation = '{$bean->operation}'";//добавить проверку по статусу недвижимости "не активен"    
    
    if(!empty($bean->totalcost))
        $return_array['where'] .=" AND request.cost_to >= '{$bean->totalcost}'";
    
    if (!empty($bean->rooms_quantity)){
       $return_array['where'] .= " AND (request.rooms_quantity <= '{$bean->rooms_quantity}' OR request.rooms_quantity = '0' OR request.rooms_quantity IS NULL)";
       $return_array['where'] .= " AND (request.rooms_quantity_to >= '{$bean->rooms_quantity}' OR request.rooms_quantity_to = '0' OR request.rooms_quantity_to IS NULL)";
	}
	
	if (!empty($bean->square)){
       $return_array['where'] .= " AND (request.square_min <= '{$bean->square}' OR request.square_min = '0' OR request.square_min IS NULL)";
       $return_array['where'] .= " AND (request.square_max >= '{$bean->rooms_quantity}' OR request.square_max = '0' OR request.square_max IS NULL)";
	}
	
    if (!empty($bean->address_country))
       $return_array['where'] .=  " AND request.address_country LIKE '{$bean->address_country}'";

    if (!empty($bean->address_region))
       $return_array['where'] .=  " AND request.address_region LIKE '{$bean->address_region}'";

    if (!empty($bean->address_city))
       $return_array['where'] .=  " AND request.address_city LIKE '{$bean->address_city}'";

    if (!empty($bean->metro))
       $return_array['where'] .=  " AND request.metro LIKE '{$bean->metro}'";

    if (!empty($bean->kind_of_realty))
       $return_array['where'] .=  " AND request.kind_of_realty LIKE '{$bean->kind_of_realty}'";
    
    echo '<small style="color:#ccc;">Запрос подбора:'.$return_array['where'].'</small>';

    return $return_array;
}

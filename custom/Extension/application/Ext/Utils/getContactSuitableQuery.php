<?php

function getContactSuitableQuery()//$params)
{
    // $args = func_get_args();
    $bean = $GLOBALS['app']->controller->bean;
    
    $return_array['select']='SELECT contacts.id ';
    $return_array['from']='FROM contacts';
    
    $subselect = "SELECT parent_id 
                  FROM request
                  WHERE operation = '{$bean->operation}' 
                        AND parent_type = 'Contacts' ";
    
    if(!empty($bean->totalcost))
        $subselect .=" AND cost_to >= '{$bean->totalcost}'";
    
    if (!empty($bean->rooms_quantity)){
       $subselect .= " AND (rooms_quantity <= '{$bean->rooms_quantity}' OR rooms_quantity = '0' OR rooms_quantity IS NULL)";
       $subselect .= " AND (rooms_quantity_to >= '{$bean->rooms_quantity}' OR rooms_quantity_to = '0' OR rooms_quantity_to IS NULL)";
	}
	
	if (!empty($bean->square)){
       $return_array['where'] .= " AND (request.square_min <= '{$bean->square}' OR request.square_min = '0' OR request.square_min IS NULL)";
       $return_array['where'] .= " AND (request.square_max >= '{$bean->rooms_quantity}' OR request.square_max = '0' OR request.square_max IS NULL)";
	}
	
    if (!empty($bean->address_country))
       $subselect .=  " AND address_country LIKE '{$bean->address_country}'";

    if (!empty($bean->address_region))
       $subselect .=  " AND address_region LIKE '{$bean->address_region}'";

    if (!empty($bean->address_city))
       $subselect .=  " AND address_city LIKE '{$bean->address_city}'";

    if (!empty($bean->metro))
       $subselect .=  " AND metro LIKE '{$bean->metro}'";

/*	if (!empty($bean->state_of_object))
       $subselect .=  " AND state_of_object LIKE '{$bean->state_of_object}'"; */

    if (!empty($bean->kind_of_realty))
       $subselect .=  " AND kind_of_realty LIKE '{$bean->kind_of_realty}'";
    
    
    $return_array['where'] = "WHERE contacts.id IN ({$subselect})";
    
	echo '<small style="color:#ccc;">Запрос подбора:'.$return_array['where'].'</small>'; 

    return $return_array;
}

<?php
/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 */

function setPotentialRecords (&$bean, $massUpdate = false) {

    if ($massUpdate) {
        set_time_limit(0);
    }

    $bean->load_relationship('realty_contacts');
    $bean->realty_contacts->delete($bean->id);

    require_once('include/utils/db_utils.php');

    $db = DBManagerFactory::getInstance();

    $query = "SELECT *
            FROM realty
            WHERE operation = '{$bean->operation}' ";

    if (!empty($bean->cost_to))
    {
        $query .= "AND totalcost <= '{$bean->cost_to}'";
    }

    if (!empty($bean->rooms_quantity))
    {
        $query .= " AND rooms_quantity = '{$bean->rooms_quantity}'";
    }

    if (!empty($bean->square_min) and !empty($bean->square_max))
    {
        $query .= " AND square BETWEEN '{$bean->square_min}' AND '{$bean->square_max}' ";
    }

    if (!empty($bean->address_country))
    {
       $query .=  " AND address_country LIKE '{$bean->address_country}'";
    }

    if (!empty($bean->address_city))
    {
       $query .=  " AND address_city LIKE '{$bean->address_city}'";
    }

    if (!empty($bean->metro))
    {
       $query .=  " AND metro LIKE '{$bean->metro}'";
    }

    if (!empty($bean->kind_of_realty))
    {
       $query .=  " AND kind_of_realty LIKE '{$bean->kind_of_realty}'";
    }

    $query .= " AND deleted = 0";

    $result = $db->query($query);

    $row = $db->fetchByAssoc($result);

    $contacts = array();

    while($row != null)
    {

            $contacts[] = $row;
            $row = $db->fetchByAssoc($result);
    }

    foreach ($contacts as $value)
    {
        $bean->realty_contacts->add($value['id']);
    }
}

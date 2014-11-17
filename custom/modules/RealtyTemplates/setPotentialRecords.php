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
    global $db;
    $db = DBManagerFactory::getInstance();

    $query = "SELECT *
            FROM contacts
            WHERE operation = '{$bean->operation}' ";

    $query2 = "SELECT *
            FROM accounts
            WHERE operation = '{$bean->operation}' ";

    if (!empty($bean->cost))
    {
        $query .= "AND cost_to >= '{$bean->totalcost}'";
        $query2 .= "AND cost_to >= '{$bean->totalcost}'";
    }

    if (!empty($bean->kind_of_realty))
    {
       $query .=  " AND kind_of_realty LIKE '{$bean->kind_of_realty}'";
       $query2 .=  " AND kind_of_realty LIKE '{$bean->kind_of_realty}'";
    }

    if (!empty($bean->address_street))
    {
       $query .=  " OR address_street LIKE '{$bean->address_street}'";
       $query2 .=  " OR address_street LIKE '{$bean->address_street}'";
    }

    $query .= " AND deleted = 0";
    $query2 .= " AND deleted = 0";

    $result = $db->query($query);
    $result2 = $db->query($query2);


    $row = $db->fetchByAssoc($result);
    $row2 = $db->fetchByAssoc($result2);

    $contacts = array();
    $accounts = array();

    while($row != null)
    {
        $contacts[] = $row;
        $row = $db->fetchByAssoc($result);
    }

    while($row2 != null)
    {
        $accounts[] = $row2;
        $row2 = $db->fetchByAssoc($result2);
    }

    foreach ($contacts as $value)
    {

        if (!empty($value['square_min']) and !empty($value['square_max']))
        {
            if ($bean->square >= $value['square_min'] and $bean->square_value <= $value['square_max'])
            {
                $bean->realty_contacts->add($value['id']);
            }
        }
    }

    if (!empty($accounts) )
    {
	$bean->load_relationship('realty_accounts_m_to_m');
	$bean->realty_accounts_m_to_m->delete($bean->id);
	
	foreach ($accounts as $value)
	    {
		if (!empty($value['square_min']) and !empty($value['square_max']))
		{
		    if ($bean->square >= $value['square_min'] and $bean->square <= $value['square_max'])
		    {		        
		        $bean->realty_accounts_m_to_m->add($value['id']);
		    }
		}
	    }
    }

if($_REQUEST['return_action'] == 'chess_table')
    {
        $url = "http://" . $_SERVER['HTTP_HOST'] . "/index.php?module=Buildings&action=chess_table&record=" . $_REQUEST['return_id'];
        header("Location: {$url}");
    }



}

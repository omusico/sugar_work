<?php

class Not_zero 
{

    function remove_zero(SugarBean $bean, $event, $arguments)
    {
        if($bean->number_of_floor == '' || $bean->number_of_floor == 0)
        {
            $bean->number_of_floor = '';
        }
        
        if($bean->floor == '' || $bean->floor == 0)
        {
            $bean->floor = '';
        }
        
        if($bean->rooms_quantity == '' || $bean->rooms_quantity == 0)
        {
            $bean->rooms_quantity = '';
        }
        
        if($bean->living_square == '' || $bean->living_square == 0)
        {
            $bean->living_square = '';
        }

        if($event=='process_record')
		{
			// из какой заявки(интересующая недвижимость для контактов)
			
			if($_REQUEST['module']=='Contacts' && $_REQUEST['action']=='DetailView'){
				global $db;
				$q="SELECT rrit.request_id as id,  r.name as name
					FROM realty_requests_interest_table AS rrit
					LEFT JOIN request as r ON r.id = rrit.request_id
					WHERE 
						rrit.realty_id = '{$bean->id}'
						AND rrit.deleted = 0
						AND r.deleted = 0";
				$res=$db->query($q);
				if($r=$db->fetchByAssoc($res))
					$bean->request="<a href='index.php?module=Request&action=DetailView&record={$r['id']}'>{$r['name']}</a>";
			}
			
			//
			if($_REQUEST['action']=='index'){
				$realty = loadBean('Realty');
				$realty->retrieve($bean->id);
				if($realty->reserved)//бронь
					$bean->name .= "<img style='display:none;' src='themes/default/images/help.gif' width='0' height='0' onload=\"this.parentNode.parentNode.parentNode.parentNode.style.backgroundColor = '#ccc';\" />";
			}
		}

    }
 
}
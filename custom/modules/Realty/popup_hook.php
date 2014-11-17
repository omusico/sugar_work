<?php
/**
 * Created by Kolerts
 * Protected by SugarTalk.ru
 */

$action=$_GET['action_'];
$id=$_GET['id'];
switch($action)
{
	case 'alredy_in_op':
		
		require_once('include/utils/db_utils.php');
		$db = DBManagerFactory::getInstance();

		$query = "SELECT opportunities.id as id, opportunities.name as name
				FROM opportunities_realty_table
				left join opportunities on opportunities.id=opportunities_realty_table.opportunity_id
				where realty_id='$id'";
		$result = $db->query($query);
		if($row = $db->fetchByAssoc($result))
			echo "{$row['name']}";//add link
		else
			echo"false";
	break;
	
	case 'alredy_status':
		//$_SERVER['DOCUMENT_ROOT'].
		require_once('modules/Realty/Realty.php');
		$realty = new Realty();
		$realty->retrieve($id);
		if($realty->operation_status=='in_rent')
			echo 'арендован';
		else if($realty->operation_status=='bought')
			echo 'куплен';
		else
			echo 'false';
	break;
	
	default:
		echo"<b>Несанкционный доступ или ошибка запроса!</b>";
	break;
}

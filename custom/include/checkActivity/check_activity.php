<?php
/**
 * Created by Kolerts
 * Protected by SugarTalk.ru
 */

if(isset($_GET['check_id']))
{
	require_once('include/utils/db_utils.php');
	$db = DBManagerFactory::getInstance();
	/*$bean = loadBean($_GET['module']);
	$bean->retrieve($_GET['check_id']);*/
	global $timedate;
	$date=$timedate->to_db($_GET['d_s']);
	
	$query = "	SELECT id
					FROM {$_GET['module']}
					WHERE
						deleted = 0
						AND date_start='{$date}'
				";
	if($_GET['assigned_user_id']!='')
		$query.= "			AND assigned_user_id='{$_GET['assigned_user_id']}'";
	if($_GET['id']!='')
		$query .= "		AND id <> '{$_GET['check_id']}'";

	$result = $db->query($query);
	if($row = $db->fetchByAssoc($result))
	{
		echo json_encode(array('result' => 'false'));
	}
	else
		echo json_encode(array('result' => 'true'));
		
	//echo $query;
}
?>
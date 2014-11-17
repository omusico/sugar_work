<?php

$realty_id = $_REQUEST['realty_id'];
$db= DBManagerFactory::getInstance();

if(isset($realty_id) && !empty($realty_id)){

	setcookie("RealtyCookie", $realty_id);
}

else{
	setcookie("RealtyCookie", 'none');
}

$sql = "SELECT totalcost
		FROM realty
		WHERE id = '{$realty_id}'
		AND deleted = 0";

$result = $db->query($sql);
$row = $db->fetchByAssoc($result);
$cost = $row['totalcost'];

$totalcost = json_encode($cost);
echo $totalcost;




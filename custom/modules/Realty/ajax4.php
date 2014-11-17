<?php
$db= DBManagerFactory::getInstance();
$id = $_GET['id'];
$bean_id = $_GET['bean_id'];
$checked = $_GET['checked'];

$sq = "SELECT id FROM realty_requests_interest_table WHERE realty_id = '{$bean_id}' AND request_id='{$id}'";
$result = $db->query($sq);
if($row = $db->fetchByAssoc($result)) {
    $sql = "UPDATE realty_requests_interest_table
		SET presentation_checked = {$checked}
		WHERE request_id = '{$id}'
			AND realty_id = '{$bean_id}'
			AND deleted = 0";
    $db->query($sql);
	echo 'updated';
}
else{
	$sql = "INSERT INTO realty_requests_interest_table
		SET presentation_checked = {$checked},
			realty_id = '{$bean_id}',
			request_id = '{$id}',
			deleted = 0,
			id = UUID()";
    $db->query($sql);
	echo 'inserted';
}
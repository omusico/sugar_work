<?php
$db= DBManagerFactory::getInstance();
$id = $_GET['id'];
$bean_id = $_GET['bean_id'];
$checked = $_GET['checked'];

$sq = "SELECT id FROM realty_contacts_table WHERE realty_id = '{$id}' AND contact_id='{$bean_id}'";
$result = $db->query($sq);
if( $row = $db->fetchByAssoc($result) ) {
    $sql = "UPDATE realty_contacts_table
		SET presentation_checked = {$checked}
		WHERE contact_id = '{$bean_id}'
			AND realty_id = '{$id}'
			AND deleted = 0";
    $db->query($sql);
	echo 'updated';
} else {
	$sql = "INSERT INTO realty_contacts_table
		SET presentation_checked = {$checked},
			realty_id = '{$id}',
			contact_id = '{$bean_id}',
			deleted = 0,
			id = UUID()";
    $db->query($sql);
	echo 'inserted';
}
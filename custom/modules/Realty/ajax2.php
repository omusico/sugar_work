<?php
$db= DBManagerFactory::getInstance();
$id = $_GET['id'];
$bean_id = $_GET['bean_id'];
$checked = $_GET['checked'];

$sq = "SELECT id FROM realty_accounts_m_to_m_table WHERE account_id = '{$bean_id}' AND realty_id= '{$id}'";
$result = $db->query($sq);
if( $row = $db->fetchByAssoc($result) ){
    $sql = "UPDATE realty_accounts_m_to_m_table
		SET presentation_checked = {$checked}
		WHERE account_id = '{$bean_id}'
			AND realty_id = '{$id}'
			AND deleted = 0";
    $db->query($sql);
	echo 'updated';
} else {
	$sql = "INSERT INTO realty_accounts_m_to_m_table
		SET presentation_checked = {$checked},
			realty_id = '{$id}'
			account_id = '{$bean_id}',
			deleted = 0,
			id = UUID()";
    $db->query($sql);
	echo 'inserted';
}

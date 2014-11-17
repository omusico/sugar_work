<?php
$db= DBManagerFactory::getInstance();
$id = $_GET['id'];
$realty_id = $_GET['realty_id'];
$checked = $_GET['checked'];

//Contacts
$sq = "SELECT id FROM realty_contacts_table WHERE contact_id = '{$id}' AND realty_id= '{$realty_id}'";
$result = $db->query($sq);
if($row = $db->fetchByAssoc($result))
{
    $sql = "UPDATE realty_contacts_table
		SET presentation_checked = {$checked}
		WHERE contact_id = '{$id}'
			AND realty_id= '{$realty_id}'
			AND deleted = 0";
    $db->query($sql);
}
else{
	$sql = "INSERT INTO realty_contacts_table
		SET presentation_checked = {$checked},
			contact_id = '{$id}',
			realty_id= '{$realty_id}'
			deleted = 0,
			id = UUID()";
    $db->query($sql);
}

//Accounts
$sq = "SELECT id FROM  realty_accounts_m_to_m_table WHERE account_id = '".$id."' AND realty_id= '".$realty_id."'";
$result = $db->query($sq);
if($row = $db->fetchByAssoc($result))
{
    $sql = "UPDATE  realty_accounts_m_to_m_table
		SET presentation_checked = {$checked}
		WHERE account_id = '{$id}'
			AND realty_id= '{$realty_id}'
			AND deleted = 0";
    $db->query($sql);
}
else{
	$sql = "INSERT INTO realty_accounts_m_to_m_table
		SET presentation_checked = {$checked},
			account_id = '{$id}',
			realty_id= '{$realty_id}'
			deleted = 0,
			id = UUID()";
    $db->query($sql);
}

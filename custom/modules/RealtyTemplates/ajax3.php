<?php
$db= DBManagerFactory::getInstance();
$id = $_GET['id'];
$checked = $_GET['checked'];
$realty_id = $_GET['realty_id'];

$sq = "SELECT id FROM realty_contacts_table WHERE contact_id = '".$id."' AND realty_id= '".$realty_id."'";
$result = $db->query($sq);
if($row = $db->fetchByAssoc($result))
{
    $sql = "UPDATE realty_contacts_table SET presentation_checked = ".$checked." WHERE contact_id = '".$id."' AND realty_id= '".$realty_id."'";
    $db->query($sql);
}
$sq = "SELECT id FROM  realty_accounts_m_to_m_table WHERE account_id = '".$id."' AND realty_id= '".$realty_id."'";
$result = $db->query($sq);
if($row = $db->fetchByAssoc($result))
{
    $sql = "UPDATE  realty_accounts_m_to_m_table SET presentation_checked = ".$checked." WHERE account_id = '".$id."' AND realty_id= '".$realty_id."'";
    $db->query($sql);
}

?>

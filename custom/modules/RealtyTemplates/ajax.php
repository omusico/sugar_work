<?php
$db= DBManagerFactory::getInstance();
$id = $_GET['id'];
$checked = $_GET['checked'];
//$sq = "SELECT id FROM realty_contacts_table WHERE realty_id = '".$id."'";
//$result = $db->query($sq);
//if($row = $db->fetchByAssoc($result) AND $_SESSION['MAILMERGE_MODULE'] == 'Contacts')
//{
    $sql = "UPDATE realty_contacts_table SET presentation_checked = ".$checked." WHERE realty_id = '".$id."'";
    $db->query($sql);
//}
//$sq = "SELECT id FROM  realty_accounts_m_to_m_table WHERE realty_id = '".$id."'";
//$result = $db->query($sq);
//if($row = $db->fetchByAssoc($result) AND $_SESSION['MAILMERGE_MODULE'] == 'Accounts')
//{
//    $sql = "UPDATE  realty_accounts_m_to_m_table SET presentation_checked = ".$checked." WHERE realty_id = '".$id."'";
//    $db->query($sql);
//}
//$g=3;
?>

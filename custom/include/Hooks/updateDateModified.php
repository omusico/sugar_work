<?php
/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 */
 class updateDateModified{

     function updateFromRelationships(&$bean)
     {
         global $db;

         $sql = "UPDATE realty SET date_modified = '" . date("Y-m-d H:i:s") . "' WHERE id = '" . $bean->id . "'";

         $db->query($sql);
//
//
//         // Add record to related contract
//
//         $res = $db->query("SELECT contract_id FROM opportunities WHERE id = '" . $_REQUEST['record'] . "'");
//         $row = $db->fetchByAssoc($res);
//
//         $contract = new Contract();
//         $contract->retrieve($row['contract_id']);


     }
 }
<?php


class setAutoNameIncrement
{
    function addMnemonik(&$bean)
    {
        if($_REQUEST['action'] != 'Delete')
        {
            global $db;
            $db = DBManagerFactory::getInstance();

            $result = $db->query("SELECT auto_name FROM contract WHERE id = '{$bean->id}' AND contract.deleted = 0");

            $row = $db->fetchByAssoc($result);

            $mnemonic = array(
                'rent' => '/А',
                'buying' => '/П',
            );

            $temp = isset($mnemonic[$bean->type_of_contract]) ? $mnemonic[$bean->type_of_contract] : $mnemonic['rent'];

            $name = $row['auto_name'] . $temp;

            $db->query("UPDATE contract SET name='{$name}' WHERE id = '{$bean->id}'");
        }
    }
}

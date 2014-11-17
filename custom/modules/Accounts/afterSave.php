<?php
/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 */

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');


class addPotentialRealty
{

    function addPotential(&$bean, $event, $arguments)
    {
        require_once('custom/modules/Accounts/setPotentialRecords.php');

        setPotentialRecords($bean);
    }
}
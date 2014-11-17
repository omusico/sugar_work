<?php
/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 */
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/MVC/View/views/view.popup.php');

class UsersViewPopup extends ViewPopup{

    function __construct(){
        parent::__construct();
    }

    function preDisplay(){
        parent::preDisplay();
    }

    function display(){

        global $popupMeta, $db;

        require_once('modules/Users/metadata/popupdefs.php');

        $query = "SELECT user_id FROM acl_roles_users WHERE role_id = '29cb925f-aa55-9c4a-dfe5-50f69e476e61' ";

        $result = $db->query($query);

        $users = array();

        while($row = $db->fetchByAssoc($result) ){

            $users[] = $row['user_id'];
        }

        if (($_REQUEST['return_module'] == 'Realty') || ($_REQUEST['return_module'] == 'Contract'))
        {
            $popupMeta['whereStatement'] = " users.id = '{$users[0]}' ";

            if (count($users) > 1)
            {
                foreach ($users as $id)
                {
                    $popupMeta['whereStatement'] .= " OR users.id = '{$id}' ";
                }
            }
        } else {
            $popupMeta['whereStatement'] = "";
        }
        parent::display();
    }


}
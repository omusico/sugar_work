<?php

global $current_user;
$time_now = date("Y-m-d H:i:s");
$my_user_id = $current_user -> id;

$db = DBManagerFactory::getInstance();

$sql ="SELECT uu.id, uu.last_name, uu.first_name, uu.auth_action
               FROM users AS uu
               WHERE deleted = 0
               AND id <> '{$my_user_id}'
            ";
$query = $db->query($sql);
$users_list = array();

while($row = $db->fetchByAssoc($query)){
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];

    if($first_name == null){
        $first_name = '';
    }
    if( $last_name == null){
        $last_name = '';
    }

    $users_list[$row['id']] = array("auth_action"=>$row['auth_action'], "first_name"=>$first_name, "last_name"=>$last_name);
}
echo json_encode($users_list);
<?php


global $current_user;

$my_user_id = $current_user -> id;
$db = DBManagerFactory::getInstance();

$sql_session = "SELECT id AS session_id
                        FROM chat_session
                        WHERE deleted = 0
                        AND user_2_id = '{$my_user_id}'
                       ";

$query_session = $db->query($sql_session);

$massage_list = array();
$session_list = array();


while($row_session = $db->fetchByAssoc($query_session)){

    $session_list[] = ($row_session['session_id']);

}
foreach ($session_list as $list){

    $sql_message = "SELECT id, cm.sender_id, cm.message, cm.date_time
                        FROM chat_messages AS cm
                        WHERE deleted = 0
                        AND session_id = '{$list}'
                        AND status_message = 1
                    ";

    $query_message = $db->query($sql_message);

    while($row_message = $db->fetchByAssoc($query_message)){

        $time_mess_key = strtotime($row_message['date_time']);

        $massage_list[$time_mess_key] = array("sender_id"=>$row_message['sender_id'], "time_mess"=>$row_message['date_time'], "message"=>$row_message['message']);

    }}

ksort($massage_list);
$ret = json_encode($massage_list);
echo $ret;



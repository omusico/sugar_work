<?php

global $current_user;
$db = DBManagerFactory::getInstance();
$my_user_id = $current_user -> id;
$friend_id = $_REQUEST['friend_session'];

    $sql_find_session = "SELECT id AS session_id
                                FROM chat_session AS cs
                                WHERE deleted = 0
                                AND (user_1_id = '{$friend_id}' OR user_1_id = '{$my_user_id}')
                                AND (user_2_id = '{$my_user_id}' OR user_2_id = '{$friend_id}')
                                ";

    $query_find_session = $db->query($sql_find_session);
    $session_id = array();
    while($row_find_session = $db->fetchByAssoc($query_find_session)){

        $session_id[] = $row_find_session['session_id'];
    };
    $massage_list = array();
    foreach($session_id AS $session){
        $sql_session = "SELECT id, cmess.message, cmess.date_time, cmess.sender_id, cmess.status_message
                               FROM chat_messages AS cmess
                               WHERE deleted = 0
                               AND session_id = '{$session}'
                               ";

        $query_session = $db->query($sql_session);
        while($row_session = $db->fetchByAssoc($query_session)){

            $time_mess_key = strtotime($row_session['date_time']);

            $massage_list[$time_mess_key] = array("sender_id"=>$row_session['sender_id'], "time_mess"=>$row_session['date_time'], "message"=>$row_session['message'], );
        }
    }

    ksort($massage_list);
    $mess_chat = json_encode($massage_list);
    echo $mess_chat;





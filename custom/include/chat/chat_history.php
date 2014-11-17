<?php

global $current_user;
$db = DBManagerFactory::getInstance();

$friend_id = $_REQUEST['history_id'];
$my_user_id = $current_user -> id;

    $sql_check = "SELECT cs.id AS session_id
                      FROM chat_session AS cs
                      WHERE deleted = 0
                      AND (user_1_id = '{$friend_id}' OR user_1_id = '{$my_user_id}')
                      AND (user_2_id = '{$my_user_id}' OR user_2_id = '{$friend_id}')
                        ";

    $query_check = $db->query($sql_check);
    $session_id = array();

    while($row_check = $db->fetchByAssoc($query_check)){

        $session_id[] = $row_check['session_id'];
    };
    $massage_list = array();
    foreach($session_id AS $session){

        $sql_session = "SELECT id, cmess.message, cmess.date_time, cmess.sender_id
               FROM chat_archives AS cmess
               WHERE deleted = 0
               AND session_id = '{$session}'
               ";

        $query_session = $db->query($sql_session);

        while($row_session = $db->fetchByAssoc($query_session)){

            $time_mess_key = strtotime($row_session['date_time']);

            $massage_list[$time_mess_key] = array("sender_id"=>$row_session['sender_id'], "time_mess"=>$row_session['date_time'], "message"=>$row_session['message']);

        }
    }
ksort($massage_list);

$ret = json_encode($massage_list);

echo($ret);




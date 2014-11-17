<?php

global $current_user;
$db = DBManagerFactory::getInstance();

$friend_id = $_REQUEST['user_clear'];
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


    foreach($session_id AS $session){

        $sql_session = "SELECT id AS mess_id, cmess.message, cmess.date_time, cmess.sender_id
                       FROM chat_messages AS cmess
                       WHERE deleted = 0
                       AND session_id = '{$session}'
                       ";

        $query_session = $db->query($sql_session);


        while($row_session = $db->fetchByAssoc($query_session)){

            $chat_archives = new Chat_Archives;
            $chat_archives -> date_time = $row_session['date_time'];
            $chat_archives -> message = $row_session['message'];
            $chat_archives -> session_id = $session;
            $chat_archives -> sender_id = $row_session['sender_id'];
            $chat_archives -> save();

            $mess_id = $row_session['mess_id'];

            $sql_delete_mess = "DELETE FROM  chat_messages
                                WHERE id = '{$mess_id}'
                                ";

            $query_delete_mess = $db->query($sql_delete_mess);
        }
}









////$date_record = date('Y-m-d H:i:s', strtotime('- 1 days' ));
//
//$sql_find_mess = "SELECT id AS mess_id, cm.date_time, cm.message, cm.session_id, cm.sender_id
//                     FROM chat_messages AS cm
//                     WHERE deleted = 0
//                     AND
//                     ";
//
//$query_find_mess = $db->query($sql_find_mess);
//
//while($row_find_mess = $db->fetchByAssoc($query_find_mess)){
//
//    $chat_archives = new Chat_Archives;
//    $chat_archives -> date_time = $row_find_mess['date_time'];
//    $chat_archives -> message = $row_find_mess['message'];
//    $chat_archives -> session_id = $row_find_mess['session_id'];
//    $chat_archives -> sender_id = $row_find_mess['sender_id'];
//    $chat_archives -> save();
//
//    $mess_id = $row_find_mess['mess_id'];
//
//    $sql_delete_mess = "DELETE FROM  chat_messages
//                        WHERE id = '{$mess_id}'
//                        ";
//
//    $query_delete_mess = $db->query($sql_delete_mess);
//}
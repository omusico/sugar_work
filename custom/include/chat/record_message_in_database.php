<?php

global $current_user;

$send_text = $_REQUEST['send_text'];
$sender_id = $current_user -> id;
$time_now = date("Y-m-d H:i:s");
$db = DBManagerFactory::getInstance();

    $sql_session = "SELECT id AS session_id
                    FROM chat_session
                    WHERE deleted = 0
                    AND open_session = 1
                    AND user_1_id = '{$sender_id}'
                   ";

    $query_session = $db->query($sql_session);
    $row_session = $db->fetchByAssoc($query_session);
    $session_id = $row_session['session_id'];

    $chat_messages = new Chat_Messages;
    $chat_messages -> sender_id = $sender_id;
    $chat_messages -> session_id = $session_id;
    $chat_messages -> message = $send_text;
    $chat_messages -> date_time = $time_now;
    $chat_messages -> status_message = 1;
    $chat_messages -> save();


echo ($time_now);
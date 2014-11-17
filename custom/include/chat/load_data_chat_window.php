<?php

global $current_user;
$db = DBManagerFactory::getInstance();
$my_user_id = $current_user -> id;

    $sql_find_session = "SELECT id AS active_session_id, cs.user_1_id, cs.user_2_id
                        FROM chat_session AS cs
                        WHERE deleted = 0
                        AND user_1_id = '{$my_user_id}'
                        AND open_session = 1
                        ";

    $query_find_session = $db->query($sql_find_session);
    $row_find_session = $db->fetchByAssoc($query_find_session);

       $friend_id = $row_find_session['user_2_id'];

    echo json_encode($friend_id);
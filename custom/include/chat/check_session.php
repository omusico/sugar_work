<?php

global $current_user;
$db = DBManagerFactory::getInstance();

$friend_id = $_REQUEST['friend_id'];
$my_user_id = $current_user -> id;

    $sql_my_check = "SELECT cs.id AS current_session_id
                     FROM chat_session AS cs
                     WHERE deleted = 0
                     AND user_1_id = '{$my_user_id}'
                     AND user_2_id = '{$friend_id}'
                     ";
    $query_my_check = $db->query($sql_my_check);
    if($row_my_check = $db->fetchByAssoc($query_my_check)){

        $current_session_id = $row_my_check['current_session_id'];

        $sql_open = "UPDATE chat_session
                           SET open_session = 1
                           WHERE deleted = 0
                           AND id = '{$current_session_id}'
                       ";

        $query_open = $db->query($sql_open);

        $sql_close = "UPDATE chat_session
                           SET open_session = 0
                           WHERE deleted = 0
                           AND id <> '{$current_session_id}'
                           AND user_1_id = '{$my_user_id}'
                       ";

        $query_close = $db->query($sql_close);

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

           $sql_session = "SELECT id, cmess.message, cmess.date_time, cmess.sender_id, cmess.status_message
           FROM chat_messages AS cmess
           WHERE deleted = 0
           AND session_id = '{$session}'
           ";

            $query_session = $db->query($sql_session);

            while($row_session = $db->fetchByAssoc($query_session)){

            $time_mess_key = strtotime($row_session['date_time']);

            $massage_list[$time_mess_key] = array("sender_id"=>$row_session['sender_id'], "time_mess"=>$row_session['date_time'], "message"=>$row_session['message']);


            if($row_session['status_message'] == 1 and $row_session['sender_id'] != $my_user_id){

                $message_id = $row_session['id'];
                $sql_close_mess = "UPDATE chat_messages
                                   SET status_message = 0
                                   WHERE deleted = 0
                                   AND id = '{$message_id}'
                        ";
                $query_close_mess = $db->query($sql_close_mess);
            }
           }
        }
           ksort($massage_list);

           $ret = json_encode($massage_list);
           echo $ret;
    }
    else{

        $sql_friend_check = "SELECT cs.id AS session_id
                     FROM chat_session AS cs
                     WHERE deleted = 0
                     AND user_1_id = '{$friend_id}'
                     AND user_2_id = '{$my_user_id}'
                     ";

        $query_friend_check = $db->query($sql_friend_check);

        if($row_friend_check = $db->fetchByAssoc($query_friend_check)){

           $session = $row_session['session_id'];
           $sql_session = "SELECT id, cmess.message, cmess.date_time, cmess.sender_id, cmess.status_message
           FROM chat_messages AS cmess
           WHERE deleted = 0
           AND session_id = '{$session}'
           ";

            $query_session = $db->query($sql_session);
            $massage_list = array();

            while($row_session = $db->fetchByAssoc($query_session)){

                $time_mess_key = strtotime($row_session['date_time']);

                $massage_list[$time_mess_key] = array("sender_id"=>$row_session['sender_id'], "time_mess"=>$row_session['date_time'], "message"=>$row_session['message']);


                if($row_session['status_message'] == 1 and $row_session['sender_id'] != $my_user_id){

                    $message_id = $row_session['id'];
                    $sql_close_mess = "UPDATE chat_messages
                                   SET status_message = 0
                                   WHERE deleted = 0
                                   AND id = '{$message_id}'
                        ";
                    $query_close_mess = $db->query($sql_close_mess);
                }
            }
        }

        $sql_close = "UPDATE chat_session
                           SET open_session = 0
                           WHERE deleted = 0
                           AND user_1_id = '{$my_user_id}'
                       ";

        $query_close = $db->query($sql_close);

        ksort($massage_list);

        $ret = json_encode($massage_list);
        echo $ret;

        $chat_session = new Chat_Session();
        $chat_session -> user_1_id = $my_user_id;
        $chat_session -> user_2_id = $friend_id;
        $chat_session -> open_session = 1;
        $chat_session -> save();
        }
























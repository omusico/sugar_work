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
$session_list = array();

while($row_session = $db->fetchByAssoc($query_session)){

    $session_list[] = ($row_session['session_id']);

}
foreach ($session_list as $list){

    $sql_message = "SELECT COUNT(*) AS count_mess
                        FROM chat_messages
                        WHERE deleted = 0
                        AND session_id = '{$list}'
                        AND status_message = 1
                    ";

    $query_message = $db->query($sql_message);
    $row_message = $db->fetchByAssoc($query_message);

    $massage_count = $row_message['count_mess'];
}

echo $massage_count;


<?php
//TODO: добавить валидацию
$assis_id = json_decode($_POST['id']);

$assisObj = Array(
    'method' => 'GetStatus',
    'login' => $_SESSION['assis_login'],
    'password' => $_SESSION['assis_password'],
    'request' => Array(
        'requestType' => 'GetStatusRequestType',
        'id' => $assis_id,
    )
);

 $options = array(
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode($assisObj),
                'header'=>  "Content-Type: application/json\r\n" ."Accept: application/json\r\n")
        );

        $context     = stream_context_create($options);
        $result      = file_get_contents("https://assis.ru/ws/json", false, $context);   
echo $result;

<?php

global $current_user;
$time_now = date("Y-m-d H:i:s");
$my_user_id = $current_user -> id;

$user = new User();
$user -> retrieve($current_user->id);
$user -> auth_time = $time_now;
$user -> auth_action = 1;
$user -> save();





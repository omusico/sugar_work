<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

array_push($job_strings, 'NoActiveRealtyNotifier');

function NoActiveRealtyNotifier()
{
    global $db;

    $sql = "SELECT name, date_modified, id, assigned_user_id FROM realty WHERE deleted = 0";

    $result = $db->query($sql);

    $realty_arr = array();

    while($row = $db->fetchByAssoc($result))
    {
        $realty_arr[$row['id']] = array(
            'date' => $row['date_modified'],
            'name' => $row['name'],
            'assigned_user_id' => $row['assigned_user_id'],
        );
    }

    $time_interval = 5;
    $current_date = time();

    foreach($realty_arr as $id => $var)
    {
        $unix_time_date_entered = strtotime($var['date']);
        $interval = $current_date - $unix_time_date_entered;

        if ($interval >= $time_interval AND $interval > 0)
        {
            $querry = "UPDATE realty SET activity_status = 'no_active' WHERE id = '{$id}'";
            $db->query($querry);

            require_once("custom/include/send_mail/send_mail.php");

            $user = new User();
            $user->retrieve($var['assigned_user_id']);

            $link = "http://" . $_SERVER['HTTP_HOST'] . "/index.php?module=Realty&action=DetailView&record=" . $id;

            $body = "Здравствуйте {$user->last_name} {$user->first_name} ! <br/>
                 Из-за того, что c недвижимостью <a href='{$link}'>" . $var['name'] . "</a>
                 не проводилось никаких действий 2 недели, ее статус в системе стал неактивным.";

            sendSugarPHPMail(
                array('0' => 'ilya.berzin@sugartalk.ru',),
                'Недвижимость перешла в статус "неактивна"',
                $body);
        }
    }
    return true;
}


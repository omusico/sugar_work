<?php

global $sugar_config, $db, $timedate;

$type_report = $_REQUEST['type_report'];

if($type_report == 'users_list'){

    $users_array = array();

    $sql_user="SELECT last_name, first_name, id
               FROM users
               WHERE deleted = 0
    ";

    $results_user = $db->query($sql_user);
    while($row_user = $db->fetchByAssoc($results_user)){
       
        $massage_list[] = array("user_id"=>$row_user['id'], "user_name"=>$row_user['last_name'].' '.$row_user['first_name']);        
    }    
    echo json_encode($massage_list);
}

if($type_report == 'source_list'){

    global $current_language;
    $source_array = array();

    foreach ($GLOBALS['app_list_strings']['source_contact_list'] as $key => $value) {

     $source_list[] = array("source_id"=>$key, "source_name"=>$value);
    }
 
    echo json_encode($source_list);
} 

if($type_report == 'diagramm_source'){

    if($_REQUEST['date_time_start'] == 1){
        $_REQUEST['date_time_start'] = '2000-07-03 11:00';
    }
    if($_REQUEST['date_time_end'] == 1){
        $_REQUEST['date_time_end'] = date("Y-m-d H:i:s");
    }

    $source_array = array();
    $source_list = $_REQUEST['dataUsers'];
    $date_time_start = gmdate('Y-m-d H:i:s', strtotime($_REQUEST['date_time_start']));
    $date_time_end = gmdate('Y-m-d H:i:s', strtotime($_REQUEST['date_time_end']));
    $source = explode(",", $source_list);
    $source_list = str_replace(",","','", $source_list);
    

    $sql_sum ="SELECT COUNT(*) AS sum_source
                FROM contacts
                WHERE deleted = 0
                AND source_contact IN ('{$source_list}')  
                AND DATE_FORMAT( contacts.date_entered, '%Y-%m-%d' )
                     BETWEEN (DATE_FORMAT( '{$date_time_start}', '%Y-%m-%d' ) )
                AND (DATE_FORMAT( '{$date_time_end}', '%Y-%m-%d' ) )               
                "; 

   $query_sum = $db->query($sql_sum);
   $row_sum = $db->fetchByAssoc($query_sum);
   $sum = $row_sum['sum_source']; 

    foreach ($source as $source_id) {
     
    if($source_id != ''){

      $sql_source ="SELECT COUNT(*) AS count_source
                 FROM contacts
                 WHERE deleted = 0
                 AND source_contact = '{$source_id}'  
                 AND DATE_FORMAT( contacts.date_entered, '%Y-%m-%d' )
                      BETWEEN (DATE_FORMAT( '{$date_time_start}', '%Y-%m-%d' ) )
                 AND (DATE_FORMAT( '{$date_time_end}', '%Y-%m-%d' ) )                 
               ";  
       
        $query_source = $db->query($sql_source);
        $row_source = $db->fetchByAssoc($query_source);
        $count_source = $row_source['count_source'];  

        if($count_source != 0){

          $source_name = $GLOBALS['app_list_strings']['source_contact_list'][$source_id];
          $source_color = '#'.dechex(rand(125, 255)).dechex(rand(125, 255)).dechex(rand(125, 255));
          $source_result = ($count_source * 100)/$sum;
          $source_array[] = array("source_res"=>$source_result, "source_name"=>$source_name, "source_color"=>$source_color); 
        }
      }
    } 
    echo json_encode($source_array);
} 

if($type_report == 'quality_source'){

    if($_REQUEST['date_time_start'] == 1){
        $_REQUEST['date_time_start'] = '2000-07-03 11:00';
    }
    if($_REQUEST['date_time_end'] == 1){
        $_REQUEST['date_time_end'] = date("Y-m-d H:i:s");
    }

    $source_list = $_REQUEST['dataUsers'];
    $date_time_start = gmdate('Y-m-d H:i:s', strtotime($_REQUEST['date_time_start']));
    $date_time_end = gmdate('Y-m-d H:i:s', strtotime($_REQUEST['date_time_end']));
    $source = explode(",", $source_list);

    // Формирование шапки документа
    $return_html = "<table class='CallCenterTable' cellspacing='0' cellpadding='0' border='0' width='350px'>";

    $return_html.= "<tr class='headerTR'>";
    $return_html.= "<td>";
    $return_html.= "<span title='Источники поступления контакта'>Источники поступления контакта</span>";
    $return_html.= "</td>";

    $return_html.= "<td>";
    $return_html.= "<span title='Количество клиентов'>Количество клиентов</span>";
    $return_html.= "</td>";   

    $return_html.= "</tr>";

    foreach ($source as $source_id) {
     
    if($source_id != ''){
      $sql_source ="SELECT COUNT(*) AS count_source
             FROM contacts
             WHERE deleted = 0
             AND source_contact = '{$source_id}'  
             AND DATE_FORMAT( contacts.date_entered, '%Y-%m-%d' )
                  BETWEEN (DATE_FORMAT( '{$date_time_start}', '%Y-%m-%d' ) )
             AND (DATE_FORMAT( '{$date_time_end}', '%Y-%m-%d' ) )                 
           ";   
    }   
    
    else{
      $sql_source ="SELECT COUNT(*) AS count_source
                     FROM contacts
                     WHERE deleted = 0
                     AND source_contact IS NULL  
                     AND DATE_FORMAT( contacts.date_entered, '%Y-%m-%d' )
                          BETWEEN (DATE_FORMAT( '{$date_time_start}', '%Y-%m-%d' ) )
                     AND (DATE_FORMAT( '{$date_time_end}', '%Y-%m-%d' ) )                 
                   ";        
    }


    $query_source = $db->query($sql_source);
    $row_source = $db->fetchByAssoc($query_source);
    $count_source = $row_source['count_source'];  

    $source_name = $GLOBALS['app_list_strings']['source_contact_list'][$source_id];

    if($source_name == ''){
      $source_name = 'Источник не выбран';
    }
    $return_html.="<tr>
        <td>{$source_name}</td>
        <td>{$count_source}</td> 
        </tr>"; 
    }

    $return_html.= "</table>";
    echo $return_html;    
}

if($type_report == 'quality_manager'){

    if($_REQUEST['date_time_start'] == 1){
        $_REQUEST['date_time_start'] = '2000-07-03 11:00';
    }
    if($_REQUEST['date_time_end'] == 1){
        $_REQUEST['date_time_end'] = date("Y-m-d H:i:s");
    }

    $date_time_start = gmdate('Y-m-d H:i:s', strtotime($_REQUEST['date_time_start']));
    $date_time_end = gmdate('Y-m-d H:i:s', strtotime($_REQUEST['date_time_end']));
    $users_list = $_REQUEST['dataUsers'];
    $user = explode(",", $users_list);

    // Формирование шапки документа
    $return_html = "<table class='CallCenterTable' cellspacing='0' cellpadding='0' border='0'>";

    $return_html.= "<tr class='headerTR'>";
    $return_html.= "<td>";
    $return_html.= "<span title='Сотрудник'>Сотрудник</span>";
    $return_html.= "</td>";

    $return_html.= "<td>";
    $return_html.= "<span title='Заявки'>Заявки</span>";
    $return_html.= "</td>";

    $return_html.= "<td>";
    $return_html.= "<span title='Встречи'>Встречи</span>";
    $return_html.= "</td>";

    $return_html.= "<td>";
    $return_html.= "<span title='Показы'>Показы</span>";
    $return_html.= "</td>";

    $return_html.= "<td>";
    $return_html.= "<span title='Эксклюзив. договоры'>Договоры</span>";
    $return_html.= "</td>";

    $return_html.= "<td>";
    $return_html.= "<span title='Договоры'>Эксклюзив. договоры</span>";
    $return_html.= "</td>";

    $return_html.= "<td>";
    $return_html.= "<span title='Сумма договоров'>Сумма договоров</span>";
    $return_html.= "</td>";

    $return_html.= "<td>";
    $return_html.= "<span title='Эф-ть показов'>Эф-ть показов</span>";
    $return_html.= "</td>";    

    $return_html.= "</tr>";

    foreach ($user as $user_id) {

    $sql="SELECT last_name, first_name
    FROM users
    WHERE deleted = 0
    AND id = '{$user_id}'
    ";
    $results1 = $db->query($sql);
    $row1 = $db->fetchByAssoc($results1);
    $user_name = $row1['last_name'].' '.$row1['first_name'];
        
    $sql_reruest ="SELECT COUNT(*) AS count_request
                   FROM request
                   WHERE deleted = 0
                   AND assigned_user_id = '{$user_id}'
                   AND status = 'closed_with_sell'  
                   AND DATE_FORMAT( request.date_entered, '%Y-%m-%d' )
                        BETWEEN (DATE_FORMAT( '{$date_time_start}', '%Y-%m-%d' ) )
                   AND (DATE_FORMAT( '{$date_time_end}', '%Y-%m-%d' ) )                 
                 ";

    $query_reruest = $db->query($sql_reruest);
    $row_reruest = $db->fetchByAssoc($query_reruest);
    $count_reruest = $row_reruest['count_request'];

    $sql_meeting ="SELECT COUNT(*) AS count_meeting
                       FROM meetings
                       WHERE deleted = 0
                       AND assigned_user_id = '{$user_id}'
                       AND meeting_type = 'meeting'
                       AND status = 'Held'
                       AND DATE_FORMAT( meetings.date_entered, '%Y-%m-%d' )
                        BETWEEN (DATE_FORMAT( '{$date_time_start}', '%Y-%m-%d' ) )
                       AND ( DATE_FORMAT( '{$date_time_end}', '%Y-%m-%d' ) ) 
                     ";

    $query_meeting = $db->query($sql_meeting);
    $row_meeting = $db->fetchByAssoc($query_meeting);
    $count_meeting = $row_meeting['count_meeting'];

    $sql_pokaz ="SELECT COUNT(*) AS count_pokaz
                       FROM meetings
                       WHERE deleted = 0
                       AND assigned_user_id = '{$user_id}'
                       AND meeting_type = 'pokaz'
                       AND status = 'Held'
                       AND DATE_FORMAT( meetings.date_entered, '%Y-%m-%d' )
                        BETWEEN (DATE_FORMAT( '{$date_time_start}', '%Y-%m-%d' ) )
                        AND ( DATE_FORMAT( '{$date_time_end}', '%Y-%m-%d' ) )
                     ";

    $query_pokaz = $db->query($sql_pokaz);
    $row_pokaz = $db->fetchByAssoc($query_pokaz);
    $count_pokaz = $row_pokaz['count_pokaz'];

    $sql_rent ="SELECT COUNT(*) AS count_contract_rent
                       FROM contract
                       WHERE deleted = 0
                       AND assigned_user_id = '{$user_id}'
                       AND type_of_contract = 'rent'
                       AND DATE_FORMAT( contract.date_entered, '%Y-%m-%d' )
                        BETWEEN ( DATE_FORMAT( '{$date_time_start}', '%Y-%m-%d' ) )
                       AND ( DATE_FORMAT( '{$date_time_end}', '%Y-%m-%d' ) ) 
                     ";

    $query_rent = $db->query($sql_rent);
    $row_rent = $db->fetchByAssoc($query_rent);
    $count_rent = $row_rent['count_contract_rent'];


    $sql_buying ="SELECT COUNT(*) AS count_contract_buying
                       FROM contract
                       WHERE deleted = 0
                       AND assigned_user_id = '{$user_id}'
                       AND type_of_contract = 'buying'  
                       AND DATE_FORMAT( contract.date_entered, '%Y-%m-%d' )
                        BETWEEN ( DATE_FORMAT( '{$date_time_start}', '%Y-%m-%d' ) )
                       AND ( DATE_FORMAT( '{$date_time_end}', '%Y-%m-%d' ) )                     
                     ";

    $query_buying = $db->query($sql_buying);
    $row_buying = $db->fetchByAssoc($query_buying);
    $count_buying = $row_buying['count_contract_buying'];   

    $result_user = (($count_rent+$count_buying)/$count_pokaz)*100;    


    $sql_sum = "SELECT SUM(opportunities.amount) AS sum_contract
                  FROM opportunities
                  LEFT JOIN contract
                  ON opportunities.contract_id=contract.id
                  WHERE contract.assigned_user_id = '{$user_id}'
                  AND contract.deleted = 0
                  AND DATE_FORMAT( contract.date_entered, '%Y-%m-%d' )
                      BETWEEN ( DATE_FORMAT( '{$date_time_start}', '%Y-%m-%d' ) )
                  AND ( DATE_FORMAT( '{$date_time_end}', '%Y-%m-%d' ) ) ";

    $query_sum = $db->query($sql_sum);
    $row_sum = $db->fetchByAssoc($query_sum);
    $sum = $row_sum['sum_contract'];

    $return_html.="<tr>
        <td>{$user_name}</td>
        <td>{$count_reruest}</td>
        <td>{$count_meeting}</td>
        <td>{$count_pokaz}</td>
        <td>{$count_rent}</td>
        <td>{$count_buying}</td>
        <td>{$sum}</td>
        <td>{$result_user} %</td>   
        </tr>"; 
    }

    $return_html.= "</table>";
    echo $return_html;    
}




<?php

require_once('include/MVC/Controller/SugarController.php');
require_once('modules/Realty/Realty.php');
require_once('modules/Users/User.php');


class CustomRealtyController extends SugarController {
    private $assis_url = "https://assis.ru/ws/json";
    private $assisObj = Array();

    function action_SignInAssis() {
       
       $assis['method'] = 'GetInfo';
       $assis['login'] = $_POST['assis_login'];
       $assis['password'] = $_POST['assis_password'];
        $this->assisObj = $assis;       
        $response    = $this->_sendObj();

        if ($response->resultCode == "OK") {
            session_start();
            $_SESSION["assis_login"] = $assis['login'];
            $_SESSION["assis_password"] = $assis["password"];
            $_SESSION['assis_sign_in'] = 'OK';
            $redirect = '/index.php?module=Realty';
            header('Location: '.$redirect);
        } else {
            $ErrorMsg = 'Неправильный логин или пароль!';
            $redirect = '/index.php?module=Realty&action=LoginAssis&ErrorMsg='
                    .$ErrorMsg."{$response->resultCode}";
            header('Location: '.$redirect);
        }
    }
    function _createAssisObj() {
        $db = DBManagerFactory::getInstance();
        $query ="SELECT value FROM config WHERE category='system' AND name='name'";

        $company = $db->query($query);
        $company = mysqli_fetch_object($company)->value;

        
        $record_id = "850941a9-d078-faf4-9402-5464fe1a7fcd";//$_POST['record_id'];
        
        $realty = new Realty();
        $realty->retrieve($record_id);
        
        $user = new User();
        $user->retrieve($realty->assigned_user_id);
        
        $primary_email=$user->emailAddress->getPrimaryAddress($user);
        
        global $app_list_strings;
        

        //echo $app_list_strings['type_of_realty_list'][$realty->type_of_realty];
        
        //подгоняем enum значения
        if ($realty->kind_of_realty == "room") {
            $kind_of_realty = 'flat';
        } else {
            $kind_of_realty = $realty->kind_of_realty;
        }
        $kind_of_realty = ucfirst($kind_of_realty);
        
        if ($realty->operation == "buying") {
            $realty_operation = 'sell';
        } else {
            $realty_operation = $realty->operation;
        }
        $realty_operation = ucfirst($realty_operation);
        
        $phone = explode("^", $user->phone_work); 
        $phone = $phone[0];
       
        if ($realty->way_to_get == 'avto') {
            $way_to_get = 'TRANSPORT';
        } else {
            $way_to_get = 'WALK';
        }
        switch ($realty->state_of_object) {
            case 'euroremenot': $renovation = 'EURO';
                break;
            case 'mojor_repair': $renovation = 'NONE';
                break;
            case 'cosmetic_repair': $renovation = 'COSMETIC';
                break;
            case 'perfect': $renovation = 'AUTHOR';
                break;
            default:
                break;
        }
        
        switch ($realty->period) {
            case 'day': $period = 'LONG';
                break;
            case 'month': $period = 'MORE_THAN_MONTH';
                break;
            case 'year': $period = 'LONG';
                break;
            default:
                break;
        }
        
        // Создание объявления по продаже квартиры
$assis = Array(
  "method" => "CreateProperty",
  // Авторизация по логину и паролю 
  "login"=> $_SESSION['assis_login'],
  "password" => $_SESSION['assis_password'],
  "request" => array( 
    "requestType" => "{$kind_of_realty}{$realty_operation}RequestType",
    "common" => Array(
      "address" => Array(
        "street" => Array(
          "type" => "SimpleStreetType",
          "name" => "{$realty->address_region},"
          . " г. {$realty->address_city}, "
                  . "ул. {$realty->address_street}",
          "allowWeak" => true
        ),
        "dom" => $realty->address_house,
      ),
      "contactInfo" => Array(
        "name" => $user->name,
        "phone" => $phone,
        "email" => $primary_email,
        "company" => $company,
      ),
      "ownership" => "AGENT", //всегда агент
      "commission" => 0, // всегда 0%
      "commissionType" => "PERCENT",
      "name" => $realty->d_name,
      "description" => $realty->d_text,
      "price" => $realty->cost,
      "currency" => $realty->currency,
      "square" => $realty->square,
      // Дополнительные поля блока common
      "distanceToMetro" => $realty->metro,
      "distanceType" => $way_to_get,
      "videoUrl" => $realty->video_youtube, // Видео с сервиса youtube
      "url" => '',
    ),
    "specific" => Array(
      "type" => strtoupper($kind_of_realty),
      "roomsCount" => $realty->rooms_quantity,
      "roomsCountTotal" => $realty->rooms_quantity,
      "separatedRoomsCount" => $realty->rooms_quantity,
      "floorNumber" => $realty->floor,
      "floorsNumber" => $realty->number_of_floors,
      "material" => $realty->wall_material_c, //дабвить поле
      // Дополнительные поля блока specific
      "usefulSquare" => $realty->living_square,
      "kitchenSquare" => $realty->kitchen_square,
      "renovation" => $renovation,
      ),
    ),
  );
//В случае если аренда добавляем два обязательных поля
                  if ($kind_of_realty == 'Flat') {
                      $assis['request']['common']['priceType'] = $realty->price_type_c;
                      $assis['request']['common']['period'] = $period;
                  }
;
       $this->assisObj = $assis;
    }
    function action_PublishAssisObj() {
               
        $response    = $this->sendObj($this->assisObj);
        
        print_r($response);
        
    }
    function _updateAssisObj($assis_id) {
        $this->_createAssisObj();
        echo $assis_id;die;
       $db = DBManagerFactory::getInstance();

       $this->assisObj['method'] = 'UpdateProperty';
       $this->assisObj['id'] = $assis_id;
       var_dump($this->assisObj);
    }
    function action_GetAssisStatistic() {
       echo "123";
    }
    function _sendObj() {
        $obj = $this->assisObj;

         $options = array(
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode($obj),
                'header'=>  "Content-Type: application/json\r\n" ."Accept: application/json\r\n")
        );
        $context     = stream_context_create($options);
        $result      = file_get_contents($this->assis_url, false, $context);   
        $response    = json_decode($result);
        return $response;
       // var_dump( $response );
    }
    
    
    
    function action_createAssisObj() {
        $this->_createAssisObj();
        $this->sendObj();
    }
    
    function action_updateAssisObj() {
//        $ok = 'OK';
//        $ok = json_encode($ok);
        echo 'false';
        die();
        $this->_updateAssisObj($assis_id);
        $this->_sendObj();
    }

}


<?php
class AssisJSON
{
    const URL = "https://assis.ru/ws/json";
    private $_assisObj = Array();
    public $response = '';
    private $_error = Array();
    private $_db;
    private $_record_id;

    public function __construct(SugarBean $bean)
    {

        $this->_db = DBManagerFactory::getInstance();
        $query ="SELECT value FROM config WHERE category='system' AND name='name'";
        $company = $this->_db->query($query);
        $company = mysqli_fetch_object($company)->value;

        //TODO record_id replace to this->record_id;
        $record_id = $bean->id;
        $this->_record_id = $record_id;

        $realty = new Realty();
        $realty->retrieve($record_id);
        
        $user = new User();
        $user->retrieve($realty->assigned_user_id);
        
        $primary_email=$user->emailAddress->getPrimaryAddress($user);
        
        //echo $app_list_strings['type_of_realty_list'][$realty->type_of_realty];
        
        //подгоняем enum значения
        switch ($realty->kind_of_realty) {
            case 'room': $kind_of_realty = 'flat';
                break;
            case 'stock': $kind_of_realty = 'warehouse';
                break;
            default:
            $kind_of_realty = $realty->kind_of_realty;
                break;
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
// TODO: Подогнать обязательные specific значения
                  switch ($kind_of_realty) {
                      case 'Warehouse':
                          $assis['request']['specific']['warehouseType'] = $realty->warehouse_type_c;
                          break;

                      default:
                          break;
                  }
       $this->_assisObj = $assis;
    }
    
    public function sendObj($obj) {
         $options = array(
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode($obj),
                'header'=>  "Content-Type: application/json\r\n" ."Accept: application/json\r\n")
        );
         print_r($obj);
        $context     = stream_context_create($options);
        $result      = file_get_contents(self::URL, false, $context);   
        $this->response    = json_decode($result);
        echo '<pre>';
//        echo $this->response->result->packet[1]->id;
        print_r($this->response);
        echo '</pre>';
    }
    public function createObj() {
        $this->sendObj($this->_assisObj);
        $this->processResponse();
    }
    public function updateObj($assis_id) {
       $this->_assisObj['method'] = 'UpdateProperty';
       $this->_assisObj['id'] = $assis_id;
       $this->sendObj($this->_assisObj);
    }
    public function publishObj() {
        $assisObj = Array(
            'method' => 'Publish',
            'login' => $_SESSION['assis_login'],
            'password' => $_SESSION['asssis_password'],
            'request' => Array(
                'requestType' => 'SimplePublishRequestType',
                'objectId' => '',
                'packetId' => '',   //33,34,35
                'weeks' => '', // 4 weeks - 1 month
                'autoProlong' => true, //автоматически продлевать
            )
        );
        $assisObj['method'] = 'Publish';
        $assisObj['login'] = $_SESSION['assis_login'];
        $assisObj['password'] = $_SESSION['assis_password'];
        $assisObj['request'] = Array();
        $assisObj['request']['requestType'] = 'SimplePublishRequestType';
        
    }
    public function getPlans() {
        // Получение списка тарифов
        $assisObj = Array(
          "method" => "GetPlans",
          // Авторизация по логину и паролю 
          "login" => "user_login",
          "password" => "user_password",
          "request" => Array(
            "requestType" => "GetPlansRequestType",
            "objectType" => "FLAT",
            "dealType" => "RENT",
            // Указание местонахождения публикуемого объекта в любом из вариантов
            "region" => "Московская область",
              //В зависимости от региона меняется цена
            "regionId" => 1, // id региона на assis.ru
//            "cityId" => 3453, // id города на assis.ru
//            "streetId" => 30753 // id улицы на assis.ru
          )
        );
        $this->sendObj($assisObj);
        die;
    }
    
    public function processResponse() {
        if ($this->response->resultCode == 'OK') {
            //обрабатываем ок
            $assis_id = $this->response->result->id; //obj id on the assis board
            $query = "UPDATE realty_cstm SET assis_id_c = '$assis_id' WHERE id_c = '{$this->_record_id}'";
            print_r($this->_db->query($query));
            echo $this->_db->query($query);
            echo $query;
        } else {
            $this->_error['message'] = $this->response->error[0]->defaultMessage;//Присвоить значение ошибки
            $this->_error['status'] = $this->reponse->ErrorPropertyResponseType;
            print_r($this->_error);die;
        }
    }
}

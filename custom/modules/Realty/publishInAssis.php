<?php 
require_once 'AssisJSON.php';
class Assis
{
    
    function send_assis_request(SugarBean $bean, $event, $arguments)
    {
        $assisJSON = new AssisJSON($bean);

        //коннектимся к контроллеру
        if ((isset($_SESSION['assis_sign_in'])) &&
            ($_SESSION['assis_sign_in'] == 'OK') && 
                ($bean->publich_assis_c == 1)) {
            
            $db = DBManagerFactory::GetInstance();
            
            $query = "SELECT assis_id_c FROM realty_cstm WHERE id_c='{$bean->id}'";
            $resource = $db->query($query);
            
            $assis_id = mysqli_fetch_object($resource)->assis_id_c;
            if ($assis_id == NULL) {
                //объект новый
                $assisJSON->createObj();die;
            } else {
                //старый объект
                $assisJSON->updateObj($assis_id);die;
//                $assisJSON->getPlans();
            }
        }
    }
    
   
}

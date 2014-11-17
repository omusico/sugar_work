<?php

$tpl_id = $_REQUEST['tpl_id'];
$floor = $_REQUEST['floor'];
$building_id = $_REQUEST['building_id'];
$sec_id = "";
if( isset($_REQUEST['section_id']) && !empty($_REQUEST['section_id']) ) $sec_id = $_REQUEST['section_id'];

$db = DBManagerFactory::getInstance();

if(!empty($tpl_id) && !empty($floor) && !empty($building_id) ){
    $realty_new = new Realty();
    $realty_tpl = new RealtyTemplates();
    $realty_tpl->retrieve($tpl_id);
    foreach($realty_new->field_defs as $key=>$val){
        if($key != "id" && $key != "floor" && isset($realty_tpl->field_defs[$key])){
            $realty_new->$key =  $realty_tpl->$key;
        } elseif($key=="floor"){
            $realty_new->floor = $floor;
        } elseif($key=="floor"){
            $realty_new->floor = $floor;
        }
    }
    if( !empty($sec_id) ) {
        $realty_new->sections_exist = "yes";
        $realty_new->section_id = $sec_id;
    }
    $id = $realty_new->save();
    if(!empty($id)) echo "Объект успешно создан!";
} else {
    echo "Объект не создан!";
}

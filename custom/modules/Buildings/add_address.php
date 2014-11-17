<?php

// $building_id = 'd9ed3abb-ee58-d0f0-59d1-524a896bbb54';

 $building_id = $_REQUEST['building_id'];

$db= DBManagerFactory::getInstance();
$address_array = array();

$sql ="SELECT address_city, address_country, 
	   address_street, address_house, address_region
	   FROM  buildings
	   WHERE id = '{$building_id}'
	   ";

$result = $db->query($sql);
$row = $db->fetchByAssoc($result);

$address_array[] = array("city"=>$row['address_city'], "country"=>$row['address_country'], "street"=>$row['address_street'], "house"=>$row['address_house'], "region"=>$row['address_region']);


$address = json_encode($address_array);

echo $address;







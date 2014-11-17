<?php

$address = $_REQUEST['address_code'];
$type_code = $_REQUEST['type_code'];

// Получение улицы из базы КЛАДР
if($type_code == 'street'){

	$address_array = array();

	$address_code = "https://assis.ru/kladr/address?term=".urlencode($address); 

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $address_code);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
	$final = curl_exec($curl);
	curl_close($curl);
//file_put_contents('1.txt', 'l');
	$final = json_decode($final, true);

	foreach ($final as $key => $value) {
		
		$final_str = explode(", ", $value['label']);
		$address_array[] = $final_str[0];
	}
	//$address_array = array_unique($address_array);
	echo (json_encode($address_array));	
}

// Получение города из базы КЛАДР
if($type_code == 'city'){

	$address_array = array();

	$address_code = "https://assis.ru/kladr/city?term=".urlencode($address);

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $address_code);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
	$final = curl_exec($curl);
	curl_close($curl);

	$final = json_decode($final, true);
	//$final = array_unique($final);

	foreach ($final as $key => $value) {
		
		$final_str = explode(", ", $value['label']);
		$city_clean = explode(" ", $final_str[0]);
		array_pop($city_clean);
		$city_string = implode(" ",$city_clean);

		$address_array[] = $city_string;
	}
	
	echo (json_encode($address_array));	
}

// Получение региона из базы КЛАДР
if($type_code == 'region'){

	$address_array = array();

	$address_code = "https://assis.ru/kladr/address?term=".urlencode($address);

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $address_code);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
	$final = curl_exec($curl);
	curl_close($curl);

	$final = json_decode($final, true);

	foreach ($final as $key => $value) {
		
		$final_str = explode(", ", $value['label']);
		$address_array[] = $final_str[2];
	}

	//$address_array = array_unique($address_array);
	echo (json_encode($address_array));	
}


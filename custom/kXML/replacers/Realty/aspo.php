<?php
/*
*	Created by Kolerts
*/
include_once('modules/kXML/replacer.php');

class Replacer_aspo extends BasicReplacer
{
	//var $custom_values = Array();
	//var $bean = null;
	
	//function r($text)		// парсер текста
	//function bean($bean)	// получаем bean
	//function customSearch($for_delete, $records) // пользовательский поиск
	
	function customCode($element, $dom_parent)
	{
		if($element=='photos'){

			global $sugar_config;
			if($this->bean->galleria_c!=''){
				$photos_a=explode('^|^',$this->bean->galleria_c);
				$i=0;
				if(count($photos_a)>0){

// перемещаем изображенеи с пометкой main на первое место общего массива
					$photos_b = array();

					foreach($photos_a as $photo_a)
					{

						if(stripos($photo_a, 'main')){

							$main_photo = $photo_a;
						}
						else{

							$photos_b[] = $photo_a;
						}	
					}

					if(isset($main_photo))	
						array_unshift($photos_b, $main_photo);
				
					foreach($photos_b as $photo_a)
					{
						$photo_a=explode('^,^',$photo_a);
						$path=$_SERVER[DOCUMENT_ROOT]."/upload/gallery_images/".$this->bean->id."/".$photo_a[1];
						$path_dest=$_SERVER[DOCUMENT_ROOT]."/custom/kXML/xml/Realty/";
						$url="{$sugar_config['site_url']}/upload/gallery_images/".$this->bean->id."/".$photo_a[1];
						$element = 'photo';

						$dom[$element.$i] = $dom_parent->appendChild($this->dom_root->createElement($element));
						$dom['url_photo'.$i] = $dom[$element.$i]->appendChild($this->dom_root->createTextNode($url));						
						
						$i++;						
					}
				}					
			}
		}

		/*	Вы можете вносить свой собственный код добавления элементов в xml, для этого при создании
		*	вместо текста указываем "#название_индекса", по индексу определяем что именно выполнять
		*	в $element возвращает название_индекса, $dom_parent - родительский элемент, к которому
		*	будем добавлять свои элементы
		*/
	}
	
	function Replacer()
    {
		/*	Вы можете вносить любой свой текст через переменную в массиве, для этого при создании
		*	вместо текста указываем "$название_вашей_переменной" и вносим текст здесь записью вида:
		*	$this->custom_values['название_вашей_переменной']=любой текст;
		*
		*	если вернуть *empty* - то элемент отображен не будет
		*/
    }

	function getBeanValues($variable)
	{
		$value=$this->bean->$variable;

		$file_sity = 'http://aspo.biz/xmldata/in/libs/settles.xml';
		$xml_sity= simplexml_load_file($file_sity);

		if($variable =='id')
		{
			$value=$this->uuid($this->bean->id); // случай генерации id обьекта
		}

		// Время  обновления фида
		if($variable =='time'){

			$value = date("y_m_d-H_i_s");
		} 

		// Тип оплаты 
		if($variable =='cost_type'){

			if($this->bean->operation == 'buying'){
				$value = "sell";
			}

			if($this->bean->operation == 'rent'){

				if($this->bean->period == 'day')
					$value = "day";
				else
					$value = "month";
			}
		}

		if($variable =='cost_list'){

			if($this->bean->operation == 'buying'){
				$value = "cost";
			}
			if($this->bean->operation == 'rent'){
				$value = "costmonth";			
			}
		}  

		if($variable =='currency'){
			$currency = $this->bean->currency;

			if($currency == "USD"){
				$value = "USD";
			}

			if($currency == "EUR"){
				$value = "EUR";			
			}

			if($currency == "UAH"){
				$value = "UAH";			
			}
		} 
		
		if($variable =='realty_type'){
			$realty_type = $this->bean->type_of_realty;
			$kind_of_realty = $this->bean->kind_of_realty;

			if($realty_type == "living" && in_array($kind_of_realty, array("flat", "room"))){
				$value = "apartments";
			}

			if($realty_type == "living" && $kind_of_realty == "house"){
				$value = "homes";
			}

			if($realty_type == "parcel"){
				$value = "land";
			}

			if($realty_type == "not_living" && $kind_of_realty == "office"){
				$value = "office";
			}

			if($realty_type == "not_living" && in_array($kind_of_realty, array("stock", "gost", "poly", "torg", "sto"))){
				$value = "industry";
			}

			// if($realty_type == ""){
			// 	$value = "garages-parking ";			
			// }
		} 

		if($variable =='type_of_realty_detail'){
			$kind_of_realty = $this->bean->kind_of_realty;

			if($kind_of_realty == "flat"){
				$value = "apartment";
			}

			if($kind_of_realty == "room"){
				$value = "room";
			} 

			if($kind_of_realty == "house"){
				$value = "home";
			} 

			if($kind_of_realty == "office"){
				$value = "office-space";
			} 

			if($kind_of_realty == "parcel"){
				$value = "land-for-building";
			} 

			if($kind_of_realty == "stock"){ 
				$value = "warehouses";
			} 

			if($kind_of_realty == "gost"){ 
				$value = "hotel";
			} 

			if($kind_of_realty == "poly"){  
				$value = "recreation-center";
			} 

			if($kind_of_realty == "torg"){
				$value = "sevice";
			} 

			if($kind_of_realty == "sto"){ 
				$value = "recreation-center";
			} 
		} 

		if($variable =='property'){

			if($this->bean->operation == 'buying'){
				$value = "sell";
			}

			if($this->bean->operation == 'rent'){

				if($this->bean->period == 'day')
					$value = "rent";

				else
					$value = "long-term-lease";
			}
		}		

		if($variable =='material'){

			$value = "brick"; 
		} 

		if($variable == 'city_code'){
			$city = $this->bean->address_city;
			$region = $this->bean->address_region;

			foreach ($xml_sity->object as $item) {
			    
				if($item->settle_name_ru == $city && $item->region_name_ru == $region)
				    $value = $item->settle_code;
			}
		}
		
		if($variable == 'area_code'){
			$city = $this->bean->address_city;
			$region = $this->bean->address_region;

			foreach ($xml_sity->object as $item) {
			    
				if($item->settle_name_ru == $city && $item->region_name_ru == $region)
				    $value = $item->district_code;
			}
		}

		if($variable == 'area_name'){
			$city = $this->bean->address_city;
			$region = $this->bean->address_region;

			foreach ($xml_sity->object as $item) {
			    
				if($item->settle_name_ru == $city && $item->region_name_ru == $region)
				    $value = $item->district_name_ru;
			}
		}

		if($variable == 'region_code'){
			$region = $this->bean->address_region;

			foreach ($xml_sity->object as $item) {
			    
				if($item->region_name_ru == $region)
				    $value = $item->region_code;
			}
		}

		if($variable == 'subsettle_name'){
			$region = $this->bean->address_city;

			if($region != 'Киев')
				$value = "*empty*";
		}

		if($variable == 'rooms_count'){
			$realty_type = $this->bean->type_of_realty;
			$kind_of_realty = $this->bean->kind_of_realty;

			if($realty_type == "living" && $kind_of_realty == "house"){
				$value = "bedroomscount";
			}
			elseif($realty_type == "not_living" && in_array($kind_of_realty, array("stock", "gost", "poly", "torg", "sto"))){
				$value = "roomscount";
			}						
			else
			  $value = "*empty*";
		} 

		if($variable == 'rooms_quantity'){
			$realty_type = $this->bean->type_of_realty;
			$kind_of_realty = $this->bean->kind_of_realty;

			if($realty_type == "living" && $kind_of_realty == "house"){
				$value = $this->bean->rooms_quantity;
			}
			elseif($realty_type == "not_living" && in_array($kind_of_realty, array("stock", "gost", "poly", "torg", "sto"))){
				$value = $this->bean->rooms_quantity;
			}
			else
			  $value = "*empty*";
		}

		if($variable == 'rooms'){
			$realty_type = $this->bean->type_of_realty;
			$kind_of_realty = $this->bean->kind_of_realty;

			if($realty_type == "living" && $kind_of_realty == "house"){
				$value = "rooms";
			}
			elseif($realty_type == "living" && in_array($kind_of_realty, array("flat", "room"))){
				$value = "rooms";
			}						
			else
			  $value = "*empty*";
		} 

		if($variable == 'rooms_quantity_flat'){
			$realty_type = $this->bean->type_of_realty;
			$kind_of_realty = $this->bean->kind_of_realty;

			if($realty_type == "living" && $kind_of_realty == "house"){
				$value = $this->bean->rooms_quantity;
			}
			elseif($realty_type == "living" && in_array($kind_of_realty, array("flat", "room"))){
				$value = $this->bean->rooms_quantity;
			}						
			else
			  $value = "*empty*";
		}

		if($variable == 'squarefull'){
			$realty_type = $this->bean->type_of_realty;
			$kind_of_realty = $this->bean->kind_of_realty;

			if($realty_type == "not_living" && in_array($kind_of_realty, array("stock", "gost", "poly", "torg", "sto"))){
				$value = "squarefull";
			}
			elseif($realty_type == "parcel"){
				$value = "squareland";
			}	
			elseif($realty_type == "living"){
				$value = "squarefull";
			}					
			else
			  $value = "*empty*";
		} 

		if($variable == 'full_square'){
			$realty_type = $this->bean->type_of_realty;
			$kind_of_realty = $this->bean->kind_of_realty;

			if($realty_type == "not_living" && in_array($kind_of_realty, array("stock", "gost", "poly", "torg", "sto"))){
				$value = $this->bean->square;
			}
			elseif($realty_type == "parcel"){
				$value = $this->bean->square;
			}
			elseif($realty_type == "living"){
				$value = $this->bean->square;
			}							
			else
			  $value = "*empty*";
		}

		if($variable == 'squarelive'){
			$realty_type = $this->bean->type_of_realty;
			
			if($realty_type == "living"){
				$value = "squarelive";
			}					
			else
			  $value = "*empty*";
		} 

		if($variable == 'living_square'){
			$realty_type = $this->bean->type_of_realty;
			
			if($realty_type == "living"){
				$value = $this->bean->living_square;
			}					
			else
			  $value = "*empty*";
		} 

		if($variable == 'squarekitchen'){
			$realty_type = $this->bean->type_of_realty;
			
			if($realty_type == "living"){
				$value = "squarekitchen";
			}					
			else
			  $value = "*empty*";
		} 

		if($variable == 'kitchen_square'){
			$realty_type = $this->bean->type_of_realty;
			
			if($realty_type == "living"){
				$value = $this->bean->kitchen_square;
			}					
			else
			  $value = "*empty*";
		} 

		if($variable == 'square_land_unit'){
			$realty_type = $this->bean->type_of_realty;
			
			if($realty_type == "parcel"){
				$value = "squarelandunit";
			}					
			else
			  $value = "*empty*";
		} 

		if($variable == 'square_unit'){
			$realty_type = $this->bean->type_of_realty;
			
			if($realty_type == "parcel"){
				$value = "ga";
			}					
			else
			  $value = "*empty*";
		} 

		if($variable == 'floor_list'){
			$realty_type = $this->bean->type_of_realty;
			$kind_of_realty = $this->bean->kind_of_realty;

			if($realty_type == "living" && in_array($kind_of_realty, array("flat", "room"))){
				$value = "floor";
			}								
			else
			  $value = "*empty*";
		}

		if($variable == 'floor'){
			$realty_type = $this->bean->type_of_realty;
			$kind_of_realty = $this->bean->kind_of_realty;

			if($realty_type == "living" && in_array($kind_of_realty, array("flat", "room"))){
				$value = $this->bean->floor;
			}								
			else
			  $value = "*empty*";
		}

		if($variable == 'floors_list'){
			$realty_type = $this->bean->type_of_realty;

			if($realty_type == "living"){
				$value = "floors";
			}								
			else
			  $value = "*empty*";
		}

		if($variable == 'number_of_floors'){
			$realty_type = $this->bean->type_of_realty;

			if($realty_type == "living"){
				$value = $this->bean->number_of_floors;
			}								
			else
			  $value = "*empty*";
		}

		if($variable == 'number_floors_list'){
			$realty_type = $this->bean->type_of_realty;

			if($realty_type == "living"){
				$value = "numberoffloors";
			}								
			else
			  $value = "*empty*";
		}

		if($variable == 'floors_count'){
			$realty_type = $this->bean->type_of_realty;

			if($realty_type == "living"){
				$value = $this->bean->number_of_floors;
			}								
			else
			  $value = "*empty*";
		}

		if($variable == 'type_cost'){
			$realty_type = $this->bean->type_of_realty;

			if($realty_type == "not_living"){
				$value = "costtypeobject";
			}
			elseif($realty_type == "parcel"){
				$value = "costtypeplot";
			}
			elseif($realty_type == "living"){
				$value = "costtypeobject";
			}
		}

		if($variable == 'type_cost_real'){
			$realty_type = $this->bean->type_of_realty;

			if($realty_type == "not_living"){
				$value = "cost-for-object";
			}
			elseif($realty_type == "parcel"){
				$value = "cost-for-plot";
			}
			elseif($realty_type == "living"){
				$value = "cost-for-object";
			}
		} 

		if($variable =='type_of_offer'){  
			$type_of_offer = $this->bean->realty_status;
			
			if($type_of_offer == 'realtor'){
				$value = "agent";
			}
			if($type_of_offer == 'owner'){
				$value = "owner";			
			}
		}  

		if($variable =='operating_business'){  
			$type_of_offer = $this->bean->realty_status;
			
			if($type_of_offer == 'realtor'){
				$value = "operatingbusiness";
			}
			if($type_of_offer == 'owner'){
				$value = "*empty*";			
			}
		}  

		if($variable =='operating_business_cost'){  
			$type_of_offer = $this->bean->realty_status;
			
			if($type_of_offer == 'realtor'){
				$value = "0";
			}
			if($type_of_offer == 'owner'){
				$value = "*empty*";			
			}
		} 
		 
		if($variable =='street_code'){  
			$address_street = $this->bean->address_street;
			 $file_street = 'http://aspo.biz/xmldata/in/libs/streets.xml';
			 $xml_street= simplexml_load_file($file_street);
			
			$address_street = "Пирятинская"; 

			foreach ($xml_street->STREETS as $item) {
			    
			 	if($item->street == $address_street){

					//$value = $item->getAttribute('code');
				    $value = $item->street;	
				}		
			}
		} 
		
		

		/*	Вы можете заменить возвращаемое значение с использованием Вашей собственной логики
		*	if switch ($variable)
		*	$value = ...
		*
		*	если вернуть *empty* - то элемент отображен не будет
		*/
		
		return $value;
	}
	
	
	//используем для генерации id объявления(этот же метод используется для поиска записей)
	function returnNumber($letter)
    {
        switch($letter){
			case 'a':
				return 10;	break;
			case 'b':
				return 11;	break;
			case 'c':
				return 12;	break;
			case 'd':
				return 13;	break;
			case 'e':
				return 14;	break;
			case 'f':
				return 15;	break;
			default:
				return ((int)$letter);
			break;
		}
		return ((int)$letter);
    }

	function uuid($id){
		$value=0;
		$real_id=$id;
		for ($i = 1; $i <= strlen($real_id); $i++){
			$value+=($this->returnNumber($real_id[$i]))*($i+1);
		} 
		return $value;
	}
	
}
?>
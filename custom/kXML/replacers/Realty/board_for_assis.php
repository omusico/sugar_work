<?php
/*
*	Created by Kolerts
*/
include_once('modules/kXML/replacer.php');

$url = 'https://assis.ru';
$url_name = 'Assis';

class Replacer_board_for_assis extends BasicReplacer
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

						$description = $photo_a[0];
						$dom[$element.$i] = $dom_parent->appendChild($this->dom_root->createElement($element));

						$dom['description_photo'.$i] = $dom[$element.$i]->appendChild($this->dom_root->createAttribute('description'));

						if(strlen($description) != 0)
							$dom['description_photo'.$i]->appendChild($this->dom_root->createTextNode($description));
						else
							$dom['description_photo'.$i]->appendChild($this->dom_root->createTextNode('Фото'));

						$dom['url_photo'.$i] = $dom[$element.$i]->appendChild($this->dom_root->createAttribute('url'));
						$dom['url_photo'.$i]->appendChild($this->dom_root->createTextNode($url));
						
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
// Время  обновления фида
		if($variable =='time')
		{
			$value = time();
		}

// id объекта в базе assis
		if($variable =='id')
		{
			$value=$this->uuid($this->bean->id); // случай генерации id обьекта
		}

// Активное или нет обьявление
		if($variable =='activity_status')
		{
			if($this->bean->activity_status == 'active')
				$value = 'true';
			else 
				$value = 'false';		
		}

// Тип объявления
		if($variable == 'request_type')
		{
			$type_realty = $this->bean->type_of_realty;
			$kind_of_realty = $this->bean->kind_of_realty;
			$operation = $this->bean->operation;

// Квартирa
			if($kind_of_realty == 'flat' || $kind_of_realty == 'room'){

				if($operation == 'buying')
					$value = 'FlatSellRequestType';

				if($operation == 'rent')
					$value = 'FlatRentRequestType';
			}
// Дома
			if($kind_of_realty == 'house'){

				if($operation == 'buying')
					$value = 'HouseSellRequestType';

				if($operation == 'rent')
					$value = 'HouseRentRequestType';
			}
// Земля
			if($type_realty == 'parcel'){

				if($operation == 'buying')
					$value = 'LandSellRequestType';
			}	

// Коммерческая
			if($kind_of_realty == 'not_living'){

				if($operation == 'buying')
					$value = 'BusinessSellRequestType';

				if($operation == 'rent')
					$value = 'BusinessRentRequestType';
			}	
		}

// Статус в нашей базе 
		if($variable =='ownership_type')
		{
			$ownership_type = $this->bean->realty_status;

			if($ownership_type == 'realtor')
				$value = 'AGENT';
			else 
				$value = 'OWNER';		
		}

// Период оплаты аренды 
		if($variable =='priceType')
		{
			$operation = $this->bean->operation;
			
			if($operation == 'rent')
				$value = 'priceType';
			else 
				$value = "*empty*";			
		}

		if($variable =='price_period')
		{
			$price_period = $this->bean->period;

			if($price_period == 'day')
				$value = 'DAY';
			else 
				$value = 'MONTH';		
		}

// Срок аренды 
		if($variable =='period')
		{
			$operation = $this->bean->operation;
			
			if($operation == 'rent')
				$value = 'period';
			else 
				$value = "*empty*";			
		}

		if($variable =='term_period')
		{
			$term_period = $this->bean->period;

			if($term_period == 'day')
				$value = 'SHORT';

			else
				$value = 'LONG';
		}

// Контактные данные агенства
		if($variable == 'name_charge'){

			$value = "Realty";
		}

		if($variable == 'phone_charge'){

			$value = "+7(7777) 777-777";
		}

		if($variable == 'email_charge'){

			$value = "info@gmail.com";
		}

// Вид коммисии в случае если есть посредник
		if($variable == 'commission')
		{
			$ownership_type = $this->bean->realty_status;
			
			if($ownership_type == 'realtor')
				$value = 'commission';
			else 
				$value = "*empty*";			
		}

// Сумма коммисии
		if($variable == 'commissionType')
		{
			$ownership_type = $this->bean->realty_status;
			
			if($ownership_type == 'realtor')
				$value = 'commissionType';
			else 
				$value = "*empty*";			
		}	
// Тип квартиры
		if($variable == 'type_flat')
		{
			$kind_of_realty = $this->bean->kind_of_realty;
			
			if($kind_of_realty == 'flat' || $kind_of_realty == 'room')
				$value = 'type';			
			else 
				$value = "*empty*";			
		}
// Количество комнат
		if($variable == 'roomsCount')
		{
			$kind_of_realty = $this->bean->kind_of_realty;
			
			if($kind_of_realty == 'flat' || $kind_of_realty == 'room')
				$value = 'roomsCount';			
			else 
				$value = "*empty*";			
		}

		if($variable == 'roomsCountTotal')
		{
			$kind_of_realty = $this->bean->kind_of_realty;
			
			if($kind_of_realty == 'flat' || $kind_of_realty == 'room')
				$value = 'roomsCountTotal';			
			else 
				$value = "*empty*";			
		}

		if($variable == 'separatedRoomsCount')
		{
			$kind_of_realty = $this->bean->kind_of_realty;
			
			if($kind_of_realty == 'flat' || $kind_of_realty == 'room')
				$value = 'separatedRoomsCount';			
			else 
				$value = "*empty*";			
		}

//  Номер этажа
		if($variable == 'floorNumber')
		{
			$kind_of_realty = $this->bean->kind_of_realty;
			
			if($kind_of_realty == 'flat' || $kind_of_realty == 'room')
				$value = 'floorNumber';			
			else 
				$value = "*empty*";			
		}
// Этажность
		if($variable == 'floorsNumber')
		{
			$kind_of_realty = $this->bean->kind_of_realty;
			
			if($kind_of_realty == 'flat' || $kind_of_realty == 'room')
				$value = 'floorsNumber';			
			else 
				$value = "*empty*";			
		}
// Материал стен
		if($variable == 'material')
		{
			$type_of_realty = $this->bean->type_of_realty;
			
			if($type_of_realty == 'living')
				$value = 'material';			
			else 
				$value = "*empty*";			
		}
// Рассрочка
		if($variable == 'credit')
		{
			$type_of_realty = $this->bean->type_of_realty;
			
			if($type_of_realty == 'living')
				$value = 'credit';			
			else 
				$value = "*empty*";			
		}
// Ипотека
		if($variable == 'mortgage')
		{
			$type_of_realty = $this->bean->type_of_realty;
			
			if($type_of_realty == 'living')
				$value = 'mortgage';			
			else 
				$value = "*empty*";			
		}
// Расстояние до города
		if($variable == 'distance')
		{
			$kind_of_realty = $this->bean->kind_of_realty;
			
			if($kind_of_realty == 'house' || $kind_of_realty == 'parcel')
				$value = 'distance';			
			else 
				$value = "*empty*";			
		}
// Газификация
		if($variable == 'gas' || $kind_of_realty == 'parcel')
		{
			$kind_of_realty = $this->bean->kind_of_realty;
			
			if($kind_of_realty == 'house')
				$value = 'gas';			
			else 
				$value = "*empty*";			
		}
// Водоснабжение
		if($variable == 'plumbing')
		{
			$kind_of_realty = $this->bean->kind_of_realty;
			
			if($kind_of_realty == 'house' || $kind_of_realty == 'parcel')
				$value = 'plumbing';			
			else 
				$value = "*empty*";			
		}
// Канализация
		if($variable == 'sewerage')
		{
			$kind_of_realty = $this->bean->kind_of_realty;
			
			if($kind_of_realty == 'house' || $kind_of_realty == 'parcel')
				$value = 'sewerage';			
			else 
				$value = "*empty*";			
		}
// Рельеф
		if($variable == 'relief' || $kind_of_realty == 'parcel')
		{
			$kind_of_realty = $this->bean->kind_of_realty;
			
			if($kind_of_realty == 'house')
				$value = 'relief';			
			else 
				$value = "*empty*";			
		}
// Мебель в доме
		if($variable == 'furniture')
		{
			$kind_of_realty = $this->bean->kind_of_realty;
			
			if($kind_of_realty == 'house')
				$value = 'furniture';			
			else 
				$value = "*empty*";			
		}
// Отопление
		if($variable == 'heating')
		{
			$kind_of_realty = $this->bean->kind_of_realty;
			
			if($kind_of_realty == 'house')
				$value = 'heating';			
			else 
				$value = "*empty*";			
		}
// Наличие обременения
		if($variable == 'burden')
		{
			$kind_of_realty = $this->bean->kind_of_realty;
			$operation = $this->bean->operation;
			
			if($kind_of_realty == 'house' || $kind_of_realty == 'parcel' && $operation == 'buying')
				$value = 'burden';			
			else 
				$value = "*empty*";			
		}
// Форма участка
		if($variable == 'shape')
		{
			$kind_of_realty = $this->bean->kind_of_realty;
			
			if($kind_of_realty == 'house' && $operation == 'buying')
				$value = 'shape';			
			else 
				$value = "*empty*";			
		}
// Назчение земли
		if($variable == 'purpose')
		{
			$kind_of_realty = $this->bean->kind_of_realty;
			
			if($kind_of_realty == 'house')
				$value = 'purpose';			
			else 
				$value = "*empty*";			
		}
// Электрофикация
		if($variable == 'electricity')
		{
			$kind_of_realty = $this->bean->kind_of_realty;
			
			if($kind_of_realty == 'house' || $kind_of_realty == 'parcel')
				$value = 'electricity';			
			else 
				$value = "*empty*";			
		}
// Тип дома
		if($variable == 'houseType')
		{
			$kind_of_realty = $this->bean->kind_of_realty;
			
			if($kind_of_realty == 'house')
				$value = 'houseType';			
			else 
				$value = "*empty*";			
		}
// Ремонт
		if($variable == 'renovation')
		{
			$kind_of_realty = $this->bean->kind_of_realty;
			
			if($kind_of_realty == 'house')
				$value = 'renovation';			
			else 
				$value = "*empty*";			
		}

// Тип здания
		if($variable == 'buildingType')
		{
			$type_of_realty = $this->bean->type_of_realty;
			
			if($type_of_realty == 'not_living')
				$value = 'buildingType';			
			else 
				$value = "*empty*";			
		}

// Субаренда
		if($variable == 'sublease')
		{
			$type_of_realty = $this->bean->type_of_realty;
			
			if($type_of_realty == 'not_living')
				$value = 'sublease';			
			else 
				$value = "*empty*";			
		}

// НДС
		if($variable == 'vatIncluded')
		{
			$type_of_realty = $this->bean->type_of_realty;
			
			if($type_of_realty == 'not_living')
				$value = 'vatIncluded';			
			else 
				$value = "*empty*";			
		}

//Тип использования коммерческого помещения
		if($variable == 'businessUsageType')
		{
			$type_of_realty = $this->bean->type_of_realty;
			
			if($type_of_realty == 'not_living')
				$value = 'businessUsageType';			
			else 
				$value = "*empty*";			
		}

// Адрес - область
		if($variable == 'address_region'){

			$adress_unit = $this->bean->address_region;
			$adress_unit_array = explode(" ", $adress_unit);

			if(isset($adress_unit_array[1]) && !empty($adress_unit_array[1]))
				array_pop($adress_unit_array);

			$adress_unit_new = '';

			foreach ($adress_unit_array as $value) {
				
				$adress_unit_new .= $value.' ';
			}

			trim($adress_unit_new);
			
			$value = $adress_unit_new;
		}

// Адрес - город
		if($variable == 'address_city'){

			$adress_unit = $this->bean->address_city;
			$adress_unit_array = explode(" ", $adress_unit);

			if(isset($adress_unit_array[1]) && !empty($adress_unit_array[1]))
				array_pop($adress_unit_array);

			$adress_unit_new = '';

			foreach ($adress_unit_array as $value) {
				
				$adress_unit_new .= $value.' ';
			}

			trim($adress_unit_new);
			
			$value = $adress_unit_new;
		}

// Адрес - улица
		if($variable == 'address_street'){

			$adress_unit = $this->bean->address_street;
			$adress_unit_array = explode(" ", $adress_unit);

			if(isset($adress_unit_array[1]) && !empty($adress_unit_array[1]))
				array_pop($adress_unit_array);

			$adress_unit_new = '';

			foreach ($adress_unit_array as $value) {
				
				$adress_unit_new .= $value.' ';
			}

			trim($adress_unit_new);
			
			$value = $adress_unit_new;
		}
			
		/*	Вы можете заменить возвращаемое значение с использованием Вашей собственной логики
		*	if switch ($variable)
		*	$value = ...
		*
		*	если вернуть *empty* - то элемент отображен не будет
		*/
		
		return $value;
	}
	
	
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
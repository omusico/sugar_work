<?php
/*
*	Created by Kolerts
*/
include('modules/kXML/replacer.php');

class Replacer extends BasicReplacer
{
	//var $custom_values = Array();
	//var $bean = null;
	
	//function r($text)		// парсер текста
	//function bean($bean)	// получаем bean
	//function customSearch($for_delete, $records) // пользовательский поиск
	
	function customCode($element, $dom_parent)
	{
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

		/*	Вы можете заменить возвращаемое значение с использованием Вашей собственной логики
		*	if switch ($variable)
		*	$value = ...
		*
		*	если вернуть *empty* - то элемент отображен не будет
		*/
		
		return $value;
	}
	
	
	//используем для генерации id объявления(этот же метод используется для поиска записей)
	function uuid($id){
		return $id;
	}
	
}
?>
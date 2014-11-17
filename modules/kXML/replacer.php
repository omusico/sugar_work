<?php
/*
*	Created by Kolerts
*/
class BasicReplacer
{
	var $custom_values = Array();
	var $bean = null;
	var $dom_root = null;

// Укажите URL доски и отображаемую надпись
//	$url = 'https://test.ru';
//	$url_name = 'Доска объявлений';
	
	function BasicReplacer()
    {
		/*	Вы можете вносить любой свой текст через переменную в массиве, для этого при создании
		*	вместо текста указываем "$название_вашей_переменной" и вносим текст здесь записью вида:
		*	$this->custom_values['название_вашей_переменной']=любой текст;
		*
		*	если присвоить *empty* - то элемент отображен не будет
		*/
    }
	
	function customCode($element, $dom_parent)
	{
		/*	Вы можете вносить свой собственный код добавления элементов в xml, для этого при создании
		*	вместо текста указываем "#название_индекса", по индексу определяем что именно выполнять
		*	в $element возвращает название_индекса, $dom_parent - родительский элемент, к которому
		*	будем добавлять свои элементы
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
	
	function customSearch($for_delete, $records)
	{
		/*	Тут можно прописать пользовательский поиск для удаления
		*	раннее заведенных записей и обновления их
		*/
	}
	
	function r($text, $dom_parent)
	{
		if($text[0]=='$')
			return $this->custom_values[substr($text,1)];
		elseif($text[0]=='*')
			return $this->getBeanValues(substr($text,1));
		elseif($text[0]=='@')
		{
			$this->customCode(substr($text,1), $dom_parent);
			return '*empty*';
		}
		else
			return $text;
	}
	
	function uuid($id){
		return $id;
	}
	
	function bean($bean)
	{
		$this->bean=$bean;
	}
	function ru($text)
	{
		return iconv('CP1251', 'UTF-8', $text);
	}
}
?>

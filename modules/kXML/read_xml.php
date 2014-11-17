<?php
/*
*	Created by Kolerts
*/
echo "<h1>Редактор XML</h1><br/>";
if(isset($_REQUEST['record'])){
	global $sugar_config;
	$path="custom/kXML/xml/{$_REQUEST['return_module']}/{$_REQUEST['record']}.xml";
	echo "<b>Путь к xml-файлу: <a href='{$sugar_config['site_url']}/{$path}' target='_blank'>{$path}</a></b><br/>";
	if(file_exists($path)){
		echo"<table cellpadding='0' cellspacing='0' width='50%' style='width:50%' border='0' class='list view'>
			<th scope='col' style='width:10px;text-align:center;'>
				#
			</th>
			<th scope='col' style='width:10px;text-align:center;'>
				Действия
			</th>
			<th scope='col' style='width:auto;text-align:center;'>
				ID элемента
			</th>";
		read_id_elements("{$_REQUEST['return_module']}/{$_REQUEST['record']}");
	}else
		echo"Error: can't access to file!";
}else
	echo"Error: bad request!";

function read_id_elements($path){
	$elements=array();
	$f = fopen("custom/kXML/templates/{$path}", "r");
	$line = fgets($f);
	$search = explode(' ; ', $line);
	$search[0]=trim($search[0]);
	// print_r($search);
	fclose($f);
	$dom['root_'] = new DOMDocument('1.0', $encoding);
	$dom['root_']->load("custom/kXML/xml/{$path}.xml", LIBXML_NOBLANKS);
	$for_delete=$dom['root_']->documentElement;
	$entries=$dom['root_']->getElementsByTagName($search[0]);
	for($i=0;$i<$entries->length;$i++){
		if( strpos($search[1],'=')!=false){
			$param=explode('=',$search[1]);
			if(isset($_REQUEST['remove_record']) && $entries->item($i)->getAttribute($param[0])==$_REQUEST['remove_record']){
				$old=$for_delete->removeChild($entries->item($i));
			}
		}else{
			if(isset($_REQUEST['remove_record']) &&  $entries->item($i)->nodeValue==$_REQUEST['remove_record']){
				$old=$for_delete->removeChild($entries->item($i)->parentNode);
			}
		}
	}
	$entries=$dom['root_']->getElementsByTagName($search[0]);
	for($i=0;$i<$entries->length;$i++){
		if( strpos($search[1],'=')!=false){
			$param=explode('=',$search[1]);
			$elements[]=$entries->item($i)->getAttribute($param[0]);
		}else{
			$elements[]=$entries->item($i)->nodeValue;
		}
	}
	$count_elements=count($elements);
	if($count_elements>0){
		for($i=0;$i<$count_elements;$i++)
		echo "<tr  style='text-align:center'>
				<td>".($i+1)."</td>
				<td>
					<a href='index.php?module=kXML&action=read_xml&return_module={$_REQUEST['return_module']}&record={$_REQUEST['record']}&remove_record={$elements[$i]}'>
						<img src='themes/default/images/close_inline.gif' alt='Удалить' title='Удалить' border='0' style='cursor:pointer' />
					</a>
				</td>
				<td>{$elements[$i]}</td>";
	}
	else{
		echo '<td colspan=3>Error: неудалось получить элементы файла</td>';
	}
	echo"</table><hr/>";
	/* echo"<pre>";
			print_r($elements);
	echo"</pre>"; */
	if(isset($_REQUEST['remove_record'])){
		if($dom['root_']->save("custom/kXML/xml/{$path}.xml")){
			echo "Элемент '{$_REQUEST['remove_record']}' успешно удален из файла";
		}else
			echo "Error: произошла ошибка обновления файла";
	}
}
?>
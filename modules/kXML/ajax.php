<?php
/*
*	Created by Kolerts
*/
if(!isset($_REQUEST['func'])){
	echo"Error: bad request!";
	exit();
}
switch($_REQUEST['func']){
	case 'detail_xml':
		if(isset($_REQUEST['record'])){
			$path="custom/kXML/xml/{$_REQUEST['path']}/{$_REQUEST['record']}.xml";
			if(file_exists($path)){
				echo"<b>Имя файла</b>: {$_REQUEST['record']}.xml";
				echo"<br/><b>Размер файла</b>: ".file_size($path);
				if(!$_REQUEST['custom_generate'])
					echo"<br/><b>Кол-во элементов</b>: ".count_elements("{$_REQUEST['path']}/{$_REQUEST['record']}");
				echo"<br/><b>Дата изменения файла</b>: ".date("d/m/Y H:i:s.", filemtime($path));
			}else
				echo"Error: can't access to file!";
		}else
			echo"Error: bad request!";
	break;
	case 'delete_xml':
		include_once('modules/kXML/add_functions.php');
		$_REQUEST['record']=str_replace('.php', '', $_REQUEST['record']);
		$path="custom/kXML/xml/{$_REQUEST['path']}/{$_REQUEST['record']}.xml";
		if(file_exists($path)){
			if(unlink($path)){
				echo"Файл успешно удален";
				add2log($_REQUEST['path'], $_REQUEST['record'], "delete xml");
			}else
				echo"Error: can't delete the file!";
		}else
			echo"Error: can't access to file!";
	break;
	case 'delete_tpl':
		include_once('modules/kXML/add_functions.php');
		$path="{$_REQUEST['path']}/{$_REQUEST['record']}";
		if(file_exists($path)){
			add2log($_REQUEST['path'], $_REQUEST['record'], "delete template");
		}else
			echo"Error: can't access to file!";
	break;
	default:
		echo"Error: bad request!";
	break;
}

function count_elements($path){
	$f = fopen("custom/kXML/templates/{$path}", "r");
	$line = fgets($f);
	$search = explode(' ; ', $line);
	$search[0]=trim($search[0]);
	fclose($f);
	$dom = new DOMDocument('1.0', $encoding);
	$dom->load("custom/kXML/xml/{$path}.xml", LIBXML_NOBLANKS);
	return $dom->getElementsByTagName($search[0])->length;
}
function file_size($path){
	$size=filesize($path);
	if($size>1024){
		$size=round($size/1024,2);
		if($size>1024){
			$size=round($size/1024,2);
			if($size>1024){
				$size=round($size/1024,2);
				$size.=' Gb';
			}else
				$size.=' Мb';
		}else
			$size.=' Kb';
	}else
		$size.=' b';
	return $size;
}
?>
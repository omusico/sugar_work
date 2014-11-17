<?php
/*
*	Created by Kolerts
*/
include_once('modules/kXML/add_functions.php');

if ($_REQUEST['select_entire_list'] == '1')
{
    $_POST['records'] = '';
    global $db;
    
    // $sql=" SELECT id FROM {$module} where deleted = 0 ";
    // $res=$db->query($sql);
    // while($row = $db->fetchByAssoc($res)){
   	// 	$_POST['records'] .= "{$row[id]},";
    // }
    // $_POST['records'] = trim($_POST['records'], ',');

	$query_parts = generate_query_parts($_SESSION['Realty2_QUERY']);
	$qq = "SELECT realty.id FROM {$query_parts['search_from']} ";

	$qq.= $query_parts['search_where'];

	$query = $db->query($qq);
	while($row = $db->fetchByAssoc($query)){
	    $id_realty[] = $row['id']; // массив с realty_id
	}

	$_POST['records'] = implode(",", $id_realty);
    //echo $_POST['records'];
    
// $i++;
}

function generate_query_parts($search_query){
    $query_parts=array();

    $from_pos=strpos($search_query, 'FROM ');
    $where_pos=strpos($search_query, ' WHERE ');
    $order_pos=strpos($search_query, ' ORDER ');
    if(!$from_pos)  $from_pos=strpos($search_query, 'from ');
    if(!$where_pos) $where_pos=strpos($search_query, 'where ');
    if(!$order_pos) $order_pos=strpos($search_query, 'order ');
    $from_pos+=4;

    $query_parts['search_from']=    substr($search_query, $from_pos, $where_pos-$from_pos);
    $query_parts['search_where']=   substr($search_query, $where_pos, $order_pos-$where_pos);
    return $query_parts;
}

$ids=explode(",", $_POST['records']);
add2log($_REQUEST['module'], $_REQUEST['name'], "start update xml [".count($ids)." objects processed]");

if(isset($_POST['custom_generate']) && $_POST['custom_generate']=='1'){
	$path="custom/kXML/custom_generate/{$_REQUEST['module']}/{$_REQUEST['name']}";
	if(file_exists($path))
	{		
		$name_this = str_replace('.php', '', $_REQUEST['name']);
		$name_this = 'generate_xml_'.$name_this;
		include_once($path);
		foreach($ids as $id)
			generate_xml($id);
	}
	//echo "Объявления добавлены в файл выбранной Вами доски. \n Обработано объектов: ".count($ids);
	echo "Объявления добавлены в файл выбранной Вами доски.";
	return false;
}

$first_line=true;
//$bean=loadBean($_POST['module']);
$n_='
';
$encoding = 'UTF-8';
$search = array();
$elements = array();
$elements_h = array();
$path=$_POST['module'];
if(!file_exists("custom/kXML/xml/".$path))
	mkdir("custom/kXML/xml/".$path);

$path.="/".$_POST['name'];
$f = fopen("custom/kXML/templates/{$path}", "r");
while (!feof($f)) {
	$line = fgets($f);
	if($line && ($line[0]!='#' && $line[0]!='/' && $line[0]!='*' && $line[0]!=';'))
	{
		$element = explode(' ; ', $line);
		if($first_line)
		{
			if(isset($element[3])){
				$encoding=str_replace($n_,'',$element[3]);
				unset($element[3]);
			}
			$search=$element;
			$first_line=false;
		}else{
			if($element[3][0]=='1')
				$elements_h[$element[0]][$element[1]]=trim($element[2]);
			else
				$elements[$element[0]][$element[1]]=trim($element[2]);
		}
	}
}
fclose($f);


gen_xml($elements, $elements_h, $path, $search, $encoding);

function gen_xml($elements, $elements_h, $path, $search, $encoding)
{
	include("custom/kXML/replacers/{$_POST['module']}/{$_POST['name']}.php");
	global $sugar_config;
	
	$records=explode(',',$_POST['records']);
	$bean=loadBean($_POST['module']);
	
	$name_this = str_replace('.php', '', $_POST['name']);
	//$name_this = str_replace('.', '', $name_this);
	$replacer_class = 'Replacer_'.$name_this;
	$r = new $replacer_class;
	
	if (!file_exists("custom/kXML/xml/{$path}.xml"))
	{
		$dom['root_'] = new DOMDocument('1.0', $encoding);
		$r->dom_root=$dom['root_'];
		if(count($elements_h)>0)
			foreach($elements_h as $parent => $indexes){
				foreach($indexes as $index => $name)
				{
					if(strpos($index,'node')===0)
					{
						$e_text=$r->r($name, $dom[$parent]);
						if($e_text!='*empty*')
							$dom[$parent]->appendChild($dom['root_']->createTextNode($e_text));
					}elseif(strpos($index,'cdata')===0){
						$e_text=$r->r($name, $dom[$parent]);
						if($e_text!='*empty*')
							$dom[$parent]->appendChild($dom['root_']->createCDATASection($e_text));
					}elseif(strpos($index,'prop')===0){
						$param=explode('=',$name);
						$e_text=$r->r($param[0], $dom[$parent]);
						if($e_text!='*empty*')
							$dom[$parent]->setAttribute($e_text, $r->r($param[1], null));
					}else{
						$e_text=$r->r($name, $dom[$parent]);
						if($e_text!='*empty*')
							$dom["{$parent}{$index}_"] = $dom[$parent]->appendChild($dom['root_']->createElement($e_text));
					}
				}
			}
		if(count($elements)>0)
			foreach($records as $record_id)
			{
				$bean->retrieve($record_id);
				$r->bean($bean);
				foreach($elements as $parent => $indexes){
					foreach($indexes as $index => $name)
					{
						//echo $index." \n";
						if(strpos($index,'node')===0)
						{
							$e_text=$r->r($name, $dom[$parent]);
							if($e_text!='*empty*')
								$dom[$parent]->appendChild($dom['root_']->createTextNode($e_text));
						}elseif(strpos($index,'cdata')===0){
							$e_text=$r->r($name, $dom[$parent]);
							if($e_text!='*empty*')
								$dom[$parent]->appendChild($dom['root_']->createCDATASection($e_text));
						}elseif(strpos($index,'prop')===0){
							$param=explode('=',$name);
							$e_text=$r->r($param[0], $dom[$parent]);
							if($e_text!='*empty*')
								$dom[$parent]->setAttribute($e_text, $r->r($param[1], null));
						}else{
							$e_text=$r->r($name, $dom[$parent]);
							if($e_text!='*empty*')
								$dom["{$parent}{$index}_"] = $dom[$parent]->appendChild($dom['root_']->createElement($e_text));
						}
					}
				}
			}
		
	}
	else
	{
		$dom['root_'] = new DOMDocument('1.0', $encoding);
		$dom['root_']->load("custom/kXML/xml/{$path}.xml", LIBXML_NOBLANKS);
		$r->dom_root=$dom['root_'];
		$for_delete=$dom['root_']->documentElement;
		$search[0]=trim($search[0]);
		
		if($search[2]!='true')
		{
			$entries = $dom['root_']->getElementsByTagName($search[0]);
			if(count($elements)>0)
				foreach($records as $record_id){
					/* $bean->retrieve($record_id);
					$r->bean($bean); */
					for($i=0;$i<$entries->length;$i++){
						if( strpos($search[1],'=')!=false){
					       $param=explode('=',$search[1]);
					       if($entries->item($i)->getAttribute($param[0])==$r->uuid($record_id))//$param[1]
						$old=/* $for_delete */$entries->item($i)->parentNode->removeChild($entries->item($i));
					      }else
					       if($entries->item($i)->nodeValue==$r->uuid($record_id))//$search[1]
						$old=/* $for_delete */$entries->item($i)->parentNode->parentNode->removeChild($entries->item($i)->parentNode);
     }
				}
		}
		else
			$r->customSearch($for_delete, $records);
			
		if(count($elements_h)>0)
			foreach($elements_h as $parent => $indexes){
				foreach($indexes as $index => $name){
					if(strpos($index,'node')===0){
						$e_text=$r->r($name, $dom[$parent]);
						if($e_text!='*empty*')
							$dom["{$parent}{$index}_"] = $dom[$parent]->nodeValue=$e_text;
					}elseif(strpos($index,'cdata')===0){
						$e_text=$r->r($name, $dom[$parent]);
						if($e_text!='*empty*')
							$dom["{$parent}{$index}_"] = $dom[$parent]->textContent=$e_text;
					}elseif(strpos($index,'prop')===0){
						$param=explode('=',$name);
						$e_text=$r->r($param[0], $dom[$parent]);
						if($e_text!='*empty*')
							$dom[$parent]->setAttribute($e_text, $r->r($param[1]));
					}else{
						$e_text=$r->r($name, $dom[$parent]);
						if($e_text!='*empty*')
							$dom["{$parent}{$index}_"] = $dom[$parent]->getElementsByTagName($e_text)->item(0);
					}
				}
			}
		
		if(count($elements)>0)
			foreach($records as $record_id){
				$bean->retrieve($record_id);
				$r->bean($bean);
				foreach($elements as $parent => $indexes){
					foreach($indexes as $index => $name){
						//echo $index." \n";
						if(strpos($index,'node')===0){
							$e_text=$r->r($name, $dom[$parent]);
							if($e_text!='*empty*')
								$dom[$parent]->appendChild($dom['root_']->createTextNode($e_text));
						}elseif(strpos($index,'cdata')===0){
							$e_text=$r->r($name, $dom[$parent]);
							if($e_text!='*empty*')
								$dom[$parent]->appendChild($dom['root_']->createCDATASection($e_text));
						}elseif(strpos($index,'prop')===0){
							$param=explode('=',$name);
							$e_text=$r->r($param[0], $dom[$parent]);
							if($e_text!='*empty*')
							$dom[$parent]->setAttribute($e_text, $r->r($param[1], $dom[$parent]));
						}else{
							$e_text=$r->r($name, $dom[$parent]);
							if($e_text!='*empty*')
								$dom["{$parent}{$index}_"] = $dom[$parent]->appendChild($dom['root_']->createElement($e_text));
						}
					}
				}
			}
		
		/*$xml_generation_date = $dom['root_']->getElementsByTagName('generation_date')->item(0)->nodeValue=$date;
		
		$xml_root = $dom['root_']->getElementsByTagName('realties')->item(0);
		$xml_realty = $dom['root_']->createElement('realty');
		$xml_root->insertBefore( $xml_realty/*, $xml_root->lastChild*/ //);*/
		
		//createRealtyChildren($dom['root_'], $xml_realty, $realty, $real_id_out);
	}
	
	$dom['root_']->formatOutput = true;

	//echo "Обработано объектов: ".count($records)." \n";
	//echo "Всего объектов в файле: ".$dom['root_']->getElementsByTagName($search[0])->length." \n";
	if($dom['root_']->save("custom/kXML/xml/{$path}.xml")){
		echo "Объявления добавлены в файл выбранной Вами доски.";
		//echo "Файл успешно сохранён и доступен по адресу: \n";
		//echo "{$sugar_config['site_url']}/custom/kXML/xml/{$path}.xml";
	}else
		echo "Error! Произошла ошибка сохранения файла {$path}.xml";
}

?>

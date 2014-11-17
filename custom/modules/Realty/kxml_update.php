<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
include_once('modules/kXML/generate_xml_realty.php');
//include_once('modules/kXML/add_functions.php');
class kxml_update
{

    function kxml_update(&$bean, $event, $arguments)
    {

global $db;
                if ($_REQUEST['action'] == 'MassUpdate')
                {
                    return;
                }
			$templates= Array();
			$path="custom/kXML/templates/{$_REQUEST['module']}";
			if(file_exists($path))
			{
				$dir=opendir($path);
				while ($template = readdir($dir))
				{
					if ($template!="." && $template!="..")
					{
						//echo $this->$template;
						//$templates .= ','.$template;
						array_push($templates, $template);

						//$template_url="{$sugar_config['site_url']}/custom/kXML/xml/{$_REQUEST['module']}/{$template}.xml";
					}
				}
			}
/*			$path="custom/kXML/custom_generate/{$_REQUEST['module']}";
			if(file_exists($path))
			{
				$dir=opendir($path);
				while ($template_file = readdir($dir))
				{
					if ($template_file!="." && $template_file!="..")
					{

						$template=str_replace('.php','',$template_file);
						$template=$template.'_cstm_';
						//echo $this->$template;
						//$templates .= ','.$template;
						//$template_url="{$sugar_config['site_url']}/custom/kXML/xml/{$_REQUEST['module']}/{$template}.xml";


						array_push($templates, $template);
					}
				}
			}*/
//print_r($templates);
//exit();


        	$query1 = "SELECT add_to_kXML_list FROM realty where id = '$bean->id'"; //exit;
        	$res1 = $db->query($query1);
        	$row1 = $db->fetchByAssoc($res1);

        	$row1['add_to_kXML_list'] = str_replace('^', '', $row1['add_to_kXML_list']);
        	$row1['add_to_kXML_list'] = explode(",", $row1['add_to_kXML_list']);
        	//echo "<pre>"; print_r($row1['add_to_kXML_list']); echo "</pre>";
        	//exit();
//        	print_r($templates);
        	foreach ($row1['add_to_kXML_list'] as &$value) {
				if (in_array($value, $templates)) {
//					echo $value." -присутствует в списке выбранных<br>";
					while(($key = array_search($value, $templates)) !== false) {
					    unset($templates[$key]);
					}
				}
//        		echo '<br>Зашел в Цикл<br>';
			   $_POST['records'] = $bean->id;
			   $_REQUEST['module'] = 'Realty';
			   $_POST['custom_generate'] = 0;
			   $_POST['module'] = 'Realty';
			   $_REQUEST['name'] = $value;
			   $_POST['name'] = $value;
				   if (strpos($value, "_cstm_"))
				   {
					   $_POST['custom_generate'] = 1;
					   $_REQUEST['name'] = str_replace('_cstm_', '', $value);
					   $_POST['name'] = str_replace('_cstm_', '', $value);
					   $_REQUEST['name'] = $_REQUEST['name'].'.php';
					   $_POST['name'] = $_POST['name'].'.php';
				   }

//				echo '<br>Подключаем generate_xml<br>';
				if ($bean->add_to_kXML_list != ''){
				generate_realty();
				}
				//include('modules/kXML/generate_xml.php');

//				echo '<br>Вышел из Цикла<br>';
    		}



//    		echo '<br>Отсутствуют доски:<br>';
    		foreach ($templates as $key => $value)
    		{
// 				echo $value.' - отсутствует<br>';

    		   $_POST['records'] = $bean->id;
			   $_REQUEST['module'] = 'Realty';
			   $_POST['custom_generate'] = 0;
			   $_POST['module'] = 'Realty';
			   $_REQUEST['name'] = $value;
			   $_POST['name'] = $value;



				if (strpos($value, "_cstm_"))
				   {
					   $_POST['custom_generate'] = 1;
					   $_REQUEST['name'] = str_replace('_cstm_', '', $value);
					   $_POST['name'] = str_replace('_cstm_', '', $value);
				   }
				else
					{
					include("custom/kXML/replacers/{$_POST['module']}/{$_POST['name']}.php");

				   	$replacer_class = 'Replacer_'.$_POST['name'];
					$r = new $replacer_class;
					}

				$first_line=true;

				$n_='
				';
				$encoding = 'UTF-8';
				$search = array();
				$elements = array();
				$elements_h = array();
				$path=$_POST['module'];


				if(file_exists("custom/kXML/xml/".$path)){
//				echo ' В цикле на удаление<br>';

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
				}
//				echo ' В цикле на удаление_2<br>';

						$dom['root_'] = new DOMDocument('1.0', $encoding);
						$dom['root_']->load("custom/kXML/xml/{$path}.xml", LIBXML_NOBLANKS);
						$r->dom_root=$dom['root_'];
						$for_delete=$dom['root_']->documentElement;
						//print_r($dom['root_']);
						//print_r($search[2]);
						//exit();
						$search[0]=trim($search[0]);
						if($search[2]!='true')
						{
//							echo ' В цикле на удаление_3<br>';
							$entries = $dom['root_']->getElementsByTagName($search[0]);
							if(count($elements)>0)
									$bean->retrieve($bean->id);
									$r->bean($bean);
//									echo ' В цикле на удаление_4<br>';
									for($i=0;$i<$entries->length;$i++){
//										print_r($entries->item($i)->getAttribute($param[0]).'<br>');

										if( strpos($search[1],'=')!=false){
											$param=explode('=',$search[1]);
											if($entries->item($i)->getAttribute($param[0])==$r->uuid($bean->id)){
//											echo $r->uuid($bean->id).'№1'.'<br>';
											$entries->item($i)->parentNode->removeChild($entries->item($i));
											//echo $entries->item($i);
											//$old=$entries->item($i)->parentNode->removeChild($entries->item($i));

												echo '-ok<br>';
												//exit();
											}
										}else
											if($entries->item($i)->nodeValue==$r->uuid($bean->id)){
//												echo $r->uuid($bean->id).'№2'.'<br>';
												//echo $entries->item($i)->parentNode;
												$entries->item($i)->parentNode->parentNode->removeChild($entries->item($i)->parentNode);

//												echo '-ok<br>';
												//exit();
											}
									}

						}
						else
							$r->customSearch($for_delete, $records);
						if(count($elements_h)>0)
							foreach($elements_h as $parent => $indexes){
								foreach($indexes as $index => $name){
									//echo '--'.$index.'--';
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




							$dom['root_']->save("custom/kXML/xml/{$path}.xml");

    		}

    		//exit();



	}
}

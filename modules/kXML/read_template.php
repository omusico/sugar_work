<?php
/*
*	Created by Kolerts
*/

if(!isset($_GET['record']))
	return false;
$elements = array();
$first_line=true;
$path=$_GET['return_module']."/".$_GET['record'];
if(file_exists("custom/kXML/templates/{$path}"))
	if($f = fopen("custom/kXML/templates/{$path}", "r")){
		while (!feof($f)) {
			$line = fgets($f);
			if($line){
				$element = explode(' ; ', $line);
				if($first_line){
					echo "	 <input type='hidden' id='s_name' name='s_name' value='{$element[0]}'>".
							"<input type='hidden' id='s_text' name='s_text' value='{$element[1]}'>";
					$first_line=false;
				}else{
					$elements[$element[0]][$element[1]]=array(trim($element[2]), $element[3][0]);
				}
			}
		}
		fclose($f);
	}

if(count($elements)>0){
	// ksort($elements);
	echo"<script>";
		echo"$(document).ready(function(){";
			foreach($elements as $parent => $indexes){
				foreach($indexes as $index => $element){
					$parent_t=explode('_', $parent);
					$parent_idx=$parent_t[count($parent_t)-2];
					if(strpos($index,'node')===0){
						$index=substr($index,4);
						echo"add_item($('#add_{$parent_idx}')[0], '{$element[0]}', 'node', 'border:1px solid #000;', '{$index}', '{$element[1]}');";
					}elseif(strpos($index,'prop')===0){
						$index=substr($index,4);
						echo"add_item($('#add_{$parent_idx}')[0], '{$element[0]}', 'prop', 'border:1px solid #b00;', '{$index}', '{$element[1]}');";
					}elseif(strpos($index,'cdata')===0){
						$index=substr($index,5);
						echo"add_item($('#add_{$parent_idx}')[0], '{$element[0]}', 'cdata', 'border:1px solid #b80;', '{$index}', '{$element[1]}');";
					}else{
						if($parent_idx=='root')
							echo"add_item($('#add')[0], '{$element[0]}', 'item', 'border:1px solid #0b0;', '{$index}', '{$element[1]}');";
						else
							echo"add_item($('#add_{$parent_idx}')[0], '{$element[0]}', 'item', 'border:1px solid #00b;', '{$index}', '{$element[1]}');";
					}
				}
			}
		echo"});";
	echo"</script>";
}
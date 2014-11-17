<?php
/*
*	Created by Kolerts
*/
$elemns=utf8_encode(stripslashes($_POST['elements'])); // fix json
$elements=json_decode($elemns, true );
/*
echo $_POST['elements'];
var_dump($elements);
exit();*/

$output="{$_POST['s_name']} ; {$_POST['s_text']} ; {$_POST['s_custom']} ; {$_POST['encoding']} ; 
";
foreach($elements as $element)
	$output.=utf8_decode("{$element[0]} ; {$element[1]} ; {$element[2]} ; {$element[3]}
");
$path="../../custom/kXML/replacers/".$_POST['module']; // готовим реплейсер шаблона
if(!file_exists($path))
	mkdir($path);
$path.="/{$_POST['name']}.php";
if(!file_exists($path))
	copy("basic_replacer.php",$path);
$path="../../custom/kXML/templates/".$_POST['module']; // готовим директорию для шаблона
if(!file_exists($path))
	mkdir($path);
$f = fopen("{$path}/{$_POST['name']}", "w");
if(fwrite($f, $output))
	echo "succes";
else
	echo "error";
fclose($f);
	
?>
<?php
//include 'modules/kXML/add_action.php';
//include 'custom/modules/include/language/ru_ru.lang.php';

//$_REQUEST['module'] = 'Realty';
$kxml_list=array();
/*if(empty($current_language)) {
	$current_language = $sugar_config['default_language'];
}
 
$app_list_strings = return_app_list_strings_language($current_language);*/
//$GLOBALS['app_list_strings']['kXML_list'] = array();
//echo "<pre>"; print_r($GLOBALS['app_list_strings']['kXML_list']); echo "</pre>";
if ($_REQUEST['module'] == 'Realty')
{
			$templates='';
			$path="custom/kXML/templates/{$_REQUEST['module']}";
			$GLOBALS['app_list_strings']['kXML_list']=array();
			if(file_exists($path))
			{
				$dir=opendir($path); 
				while ($template = readdir($dir)) 
				{
					if ($template!="." && $template!="..")
					{

					$kxml_list[$template]=$template;  

						//array_push($kxml_list, $template);
					}
				}
			}
			$path="custom/kXML/custom_generate/{$_REQUEST['module']}";
			if(file_exists($path))
			{
				$dir=opendir($path); 
				while ($template_file = readdir($dir)) 
				{
					if ($template_file!="." && $template_file!="..")
					{
					//$GLOBALS['app_list_strings']['kXML_list'] = 'Привет';
						$template=str_replace('.php','',$template_file);
						//echo $template.'_cstm';
						//array_push($kxml_list, $template.'_cstm');
						$kxml_list[$template.'_cstm_']=$template;  
					}
				}
			}
			//print_r($GLOBALS['app_list_strings']['kXML_list']);
			//echo json_encode($kxml_list);
$GLOBALS['app_list_strings']['kXML_list']=$kxml_list;
//print_r($_REQUEST['module']);
}


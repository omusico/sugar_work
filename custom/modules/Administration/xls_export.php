<?php
/**
 * Upgraded By Kolerts
 */
require_once('custom/modules/XlsExport/utils.php');

if(!isset($_REQUEST['func'])){
	$fields = json_decode(htmlspecialchars_decode($_POST['param'])); // Получаем сериаллизованный массив
	set_time_limit(600);
	ini_set('memory_limit', '1024M');

	global $app_list_strings, $current_user, $db;
	// Start preparing data from SugarCRM

	$data = array();
	$sql_ids = "";
	$sql_fields = array();
	$rel_fields = array();
	$ln_fields = array();
	$ln_fields_data = array();
	$rel_fields_data = array();
	$sql_module = "";

	$sheetData = array();

	foreach ($fields as $field)
	{


		if ($field[0] == 'module') // Получаем имя модуля в нижнем регистре
		{
			$module_name = $field[1];
			$sql_module = mb_strtolower($field[1]);
		}
		elseif ($field[0] == 'records') // Получаем список ID записей и преобразуем в формат для чтения MySQL
		{
			if($field[1] != "all_items"){
				$ids = explode(",", $field[1]);
				foreach($ids as $id)
				{
					$sql_ids .= "'" . $id . "',";
				}
			}
			else //выбор всех полей
			{
				$module = strtolower($module_name);
				$query = "SELECT {$module}.id FROM {$module} ";
				if(!empty($field[2])){
					$where = html_entity_decode($field[2], ENT_QUOTES);
					$query .= " WHERE {$where} AND {$module}.deleted = 0 ";
				}else $query .= " WHERE {$module}.deleted = 0 ";

				$resource = $db->query($query);
				while($row = $db->fetchByAssoc($resource) )
				{
					$sql_ids .= "'" . $row['id'] . "',";
					$ids[]=$row['id'];
				}

			}
		}
		else {
			if(isset($field[2])){
				$field[0].="[{$field[4]}]";
			}
			
			if(!isset($field[2])){
				$sql_fields[] = $field[1];
				$sheetData['cols'][] = $field[0]; // Получаем список заголовков для столбцов документа
			}
			elseif($field[2]=='rel'){
				$rel_fields[$field[3]]['data']=$field;
				$rel_fields[$field[3]]['fields'][]=$field[1];
				$rel_fields[$field[3]]['lbls'][]=$field[0];
			}
			elseif($field[2]=='ln'){
				$ln_fields[$field[3]]['data']=$field;
				$ln_fields[$field[3]]['fields'][]=$field[1];
				$ln_fields[$field[3]]['lbls'][]=$field[0];
			}
		}
	}

	//$sql_fields = trim($sql_fields, ","); // Убираем последние запятые
	$sql_ids = trim($sql_ids, ","); // Убираем последние запятые

	$filename = 'upload/xls_tmp/'.$module_name.'/'.strtotime('now').rand().'.json';

	$focus = BeanFactory::getBean($module_name);

	$where = "";
	//if($_GET['all_list'] == 0)
	//{
		$where_ids = "{$sql_module}.id IN ({$sql_ids})";
	//}

	if(is_subclass_of($focus, "SugarBean") && !$current_user->is_admin) {
		if($focus->bean_implements('ACL')) {
			if(!ACLController::checkAccess($focus->module_dir, 'export', false)) {
				// if ($where) {
					// $where .= " AND ";
				// }
				$where .= " AND {$sql_module}.assigned_user_id = '" . $current_user->id . "'";
			}
		}
	}
	// if(count($ln_fields)>0){
		// /*this.text,
		// this.value,
		// 'ln',
		// cur_multiselect.data('module'),
		// cur_multiselect.data('module_lbl'),
		// cur_multiselect.data('rel'),
		// cur_multiselect.data('rtype')*/
	// }
	// if(count($rel_fields)==0 && count($ln_fields)==0)
		$query = $focus->create_new_list_query("", $where_ids.$where, $sql_fields, array(), 0, '', false, $focus, true, true);
	
	/* if(count($ln_fields)>0){
		$query_sel_add = '';
		$query_from_add = '';
		foreach($ln_fields as $sub_focus => $sub_data){
			$table = strtolower($module_name);
			$sub_table = strtolower($sub_focus);
			$query_from_add.= " LEFT JOIN `{$sub_table}` as `ln_{$sub_table}` ON `{$table}`.`{$sub_data['data'][5]}` = `ln_{$sub_table}`.`id` ";
			foreach($sub_data['fields'] as $field){
				$query_sel_add.=" `ln_{$sub_table}`.`{$field}` as ln_{$sub_table}_{$field},";
			}
		}
		$query = str_replace('SELECT ','SELECT '.$query_sel_add, $query);
		$query = str_replace('where ',$query_from_add.' where ', $query);
	} */
	if(count($ln_fields)>0){
		foreach($ln_fields as $sub_module_name => $sub_data){
			foreach($ids as $r_id){
				$ln_fields_data[$r_id][$sub_module_name] = array();
				foreach($sub_data['fields'] as $field){
					$ln_fields_data[$r_id][$sub_module_name][]='';
				}
			}
			foreach($sub_data['lbls'] as $lbl){
				$sheetData['cols'][] = $lbl; // Получаем список заголовков для столбцов документа
			}
			$sub_table = strtolower($sub_module_name);
			$sub_where = " `{$sub_table}`.`id` IN (";
			$sub_focus = BeanFactory::getBean($sub_module_name);
			$ln_data = array();
			$sub_fields=$sub_data['fields'];
			if(!in_array('id',$sub_fields))
				$sub_fields[]='id';
			if(is_subclass_of($sub_focus, "SugarBean") && !$current_user->is_admin) {
				if($sub_focus->bean_implements('ACL')) {
					if(!ACLController::checkAccess($sub_focus->module_dir, 'export', false)) {
						// if ($where) {
							// $where .= " AND ";
						// }
						$acl_subwhere = " AND `{$sub_table}`.`assigned_user_id` = '" . $current_user->id . "'";
					}
				}
			}
			// if($sub_data['data'][6]=='relate'){
				$q = 'SELECT id, `'.$sub_data['data'][5].'` FROM '.$sql_module.' WHERE '.$where_ids.$where;
			// }elseif($sub_data['data'][6]=='parent'){
				// $q = 'SELECT id, `'.$sub_data['data'][5].'` FROM '.$sql_module.' WHERE parent_type="'.$sub_module_name.'" AND '.$where_ids.$where;
			// }
			$r = $db->query($q);
			while($row=$db->fetchByAssoc($r)){
				if($row[$sub_data['data'][5]]!=''){
					$ln_data[$row['id']] = $row[$sub_data['data'][5]];
					$sub_where.= "'{$ln_data[$row['id']]}',";
				}
			}
			$sub_where = trim($sub_where, ',').')';
			$query_sub = $sub_focus->create_new_list_query("", $sub_where.$acl_subwhere, $sub_fields, array(), 0, '', false, $sub_focus, true, true);
			$r = $db->query($query_sub);
			$rows = array();
			while($row=$db->fetchByAssoc($r)){
				foreach($ln_data as $r_id => $ln_id){
					if($ln_id==$row['id'] && !in_array($r_id, array_keys($rows))){
						$row['r_id'] = $r_id;
						$rows[$r_id]=$row;
					}
				}
			}
			foreach($rows as $row){
				$fields = array();
				$r_id = $row['r_id'];
				foreach ($sub_data['fields'] as $field_name){
					$fields[] = XlsExUtils::getStandartField($sub_focus, $field_name, $row[$field_name])/* ."[{$field_name}] " */;
				}
				$ln_fields_data[$r_id][$sub_module_name] = $fields;
			}
		}
	}
	// print_r($ln_fields_data);
	
	if(count($rel_fields)>0){
		foreach($rel_fields as $sub_module_name => $sub_data){
			foreach($sub_data['lbls'] as $lbl){
				$sheetData['cols'][] = $lbl; // Получаем список заголовков для столбцов документа
			}
			$rel_id = $sub_data['data'][6];
			$sub_table = $sub_data['data'][5];
			$sub_focus = BeanFactory::getBean($sub_module_name);
			$sub_fields=$sub_data['fields'];
			if(!in_array('id',$sub_fields))
				$sub_fields[]=$rel_id;
			if(is_subclass_of($sub_focus, "SugarBean") && !$current_user->is_admin) {
				if($sub_focus->bean_implements('ACL')) {
					if(!ACLController::checkAccess($sub_focus->module_dir, 'export', false)) {
						// if ($where) {
							// $where .= " AND ";
						// }
						$acl_subwhere = " AND `{$sub_table}`.`assigned_user_id` = '" . $current_user->id . "'";
					}
				}
			}
			/*0this.text,
				1this.value,
				2'rel',
				3cur_multiselect.data('module'),
				4cur_multiselect.data('module_lbl'),
				5cur_multiselect.data('table'),
				6cur_multiselect.data('key'),
				7cur_multiselect.data('ext_where')*/
			if($ext_where!=''){
				$ext_where.=' AND ';
				$ext_where = str_replace('|','=',$sub_data['data'][7]);
			}
			
			$sub_where =  "`{$sub_table}`.`{$rel_id}` IN ({$sql_ids})";

			$query_sub = $sub_focus->create_new_list_query("", $ext_where.$sub_where.$acl_subwhere, $sub_fields, array(), 0, '', false, $sub_focus, true, true);
			$r = $db->query($query_sub);
			while($row=$db->fetchByAssoc($r)){
				$fields = array();
				foreach ($sub_data['fields'] as $field_name){
					$fields[$field_name] = XlsExUtils::getStandartField($sub_focus, $field_name, $row[$field_name])/* ."[{$field_name}] " */;
				}
				$rel_fields_data[$row[$rel_id]][$sub_module_name][] = $fields;
			}
		}
	}
	
// echo $query."\n\n";
// echo $query_sub;
// print_r($ln_fields_data);
// print_r($rel_fields_data);
// exit; 
	$result = $db->query($query);

	$data = array();

	while($row = $db->fetchByAssoc($result))
	{
		$data[$row['id']] = $row;
	}

	$data_fields = $sql_fields;

	$sheetData['data'] = array();
	$color_Arr = array(
		'FF8888',
		'88FF88',
		'FF88FF',
		'FFFF88',
	);
	
	foreach($data as $r_id=>$item)
	{
		$fields = array();
		$col_index=0;

		foreach ($data_fields as $field_name)
		{
			$field = XlsExUtils::getStandartField($focus, $field_name, $item[$field_name]);
			$fields[] = array($field, 'FFFFFF');
		}
		if(count($ln_fields)>0){
			foreach(array_keys($ln_fields) as $sub_module_name){
				$color = $color_Arr[$col_index];
				foreach($ln_fields_data[$r_id][$sub_module_name] as $field){
					$fields[]=array($field,$color);
					// array_merge($fields,$field);
				}
				$col_index++;if($col_index>3)$col_index=0;
			}
		}
		if(count($rel_fields)>0){
			foreach(array_keys($rel_fields) as $sub_module_name){
				if(isset($rel_fields_data[$r_id][$sub_module_name])){
					foreach($rel_fields_data[$r_id][$sub_module_name] as $sub_fields){
						$tmp_fields=$fields;
						foreach($sub_fields as $field){
							$tmp_fields[]=array($field,'8888FF');
							// array_merge($tmp_fields,$field);
						}
						$sheetData['data'][] = $tmp_fields;
					}
				}
				else{
					foreach($sub_fields as $field){
						$fields[]=array('', '8888FF');
						// array_merge($tmp_fields,$field);
					}
					$sheetData['data'][] = $fields;
				}
			}
		}
		else{
			$sheetData['data'][] = $fields;
		}
	}
	file_put_contents($filename,json_encode($sheetData));
	
	$res = array();
	$res['num']=count($data);
	echo json_encode($res);
}
else if($_REQUEST['func']=='save_file'){
	require_once("custom/modules/XlsExport/Classes/PHPExcel.php");
	set_time_limit(600);
	ini_set('memory_limit', '1024M');
	
	$sheetData = array();
	$json_arr = array();
	
	$m_name=$_REQUEST['m_name'];
	$json_mask = 'upload/xls_tmp/'.$m_name.'/*.json';
	foreach (glob($json_mask) as $json_file) {
		$json_arr=json_decode(file_get_contents($json_file), 1);
		$sheetData['cols'] = $json_arr['cols'];
		foreach($json_arr['data'] as $data){
			$sheetData['data'][]=$data;
		}
		unlink($json_file);
	}
	
	$filename = 'upload/'.$m_name.'.xls';
	
	// Caching must be enabled/configured before you load or instantiate any PHPExcel object
	$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized;
	$cacheSettings = array('cacheTime' => 600, 'memoryCacheSize' => '1024MB');
	PHPExcel_Settings::setCacheStorageMethod($cacheMethod);
	$objPHPExcel = new PHPExcel();
	$width = 0;
	$height = 0;

	$header = array();
	$footer = array();

	$type = "Excel";
	$file_extension = ".xls";

	$objPHPExcel->setActiveSheetIndex(0);

	$styleArray = array(
		'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array('rgb' => 'FFFFFF')
		),
		'borders' => array(
			'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN,
				'color' => array('rgb' => '000000')
			)
		),
		'wrap' => true,
		'indent' => 5,
	);

	$boldFont = array(
		'font'=>array(
			'name'=>'Arial Cyr',
			'size'=>'10',
			'bold'=>true,
			'color' => array('rgb' => 'FFFFFF'),
		),
		'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array('rgb' => '000000'),
		),
	);

	$center = array(
		'alignment'=>array(
			'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER
		)
	);

	$notBoldFont = array(
		'font'=>array(
			'name'=>'Arial Cyr',
			'size'=>'10',
			'bold'=>false
		)
	);

	$center_vertical = array(
		'alignment'=>array(
			'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER
		)
	);


	$letter_num = count($sheetData['cols']);
	$letter = XlsExUtils::getLetter($letter_num);

	//Adding Columns Names
	$columnLetter = 'A';
	foreach($sheetData['cols'] as $colIndex => $colDef){
		$cl = $columnLetter++;

		$objPHPExcel->getActiveSheet()->getColumnDimension($cl)->setAutoSize(true);

		$objPHPExcel->getActiveSheet()->getCell($cl . '1')->setValue($colDef);

		$objPHPExcel->getActiveSheet()->getStyle('A1:'. $letter .'1')->applyFromArray($styleArray);

		$objPHPExcel->getActiveSheet()->getStyle('A1:'. $letter .'1')->applyFromArray($boldFont);

		$objPHPExcel->getActiveSheet()->getStyle('A1:'. $letter .'1')->applyFromArray($center);
	}

	$currentRow = 2;

	//Adding data rows
	foreach($sheetData['data'] as $rowIndex => $row){
		$columnLetter = 'A';
		foreach($row as $colIndex => $colValue_data)
		{
			$styleArray['fill']['color']['rgb']=$colValue_data[1];
			$colValue = $colValue_data[0];
			$colValue = trim(html_entity_decode($colValue, ENT_QUOTES));
			$order = array("\r\n", "\n", "\r");
			$colValue = str_replace($order, ' ', $colValue);

			$objPHPExcel->getActiveSheet()->getCell($columnLetter . $currentRow)->setValue($colValue);
			// $objPHPExcel->getActiveSheet()->getStyle('A'.$currentRow . ":" . $letter . $currentRow)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$currentRow . ":" . $letter . $currentRow)->applyFromArray($notBoldFont);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$currentRow . ":" . $letter . $currentRow)->applyFromArray($center_vertical);
			
			$objPHPExcel->getActiveSheet()->getStyle($columnLetter . $currentRow)->applyFromArray($styleArray);
			$columnLetter++;
		}
		$currentRow++;
	}

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save($filename);

	$filename_arr = array();
	$filename_arr['num'] = $currentRow-2;
	$filename_arr['link'] = $filename;

	echo json_encode($filename_arr);
	exit;
}
else if($_REQUEST['func']=='get_fields'){
	$res = array();
	$i=0;
	$field_list = XlsExUtils::get_field_list($_REQUEST['module_name']);
	if (count($field_list) > 0){
		foreach ($field_list as $field){
			$res[$i]=array();
			$res[$i]['val']=$field['name'];
			$res[$i]['lbl']=$field['label'];
			$i++;
		}
	}
	echo json_encode($res);
	exit;
}
else if($_REQUEST['func']=='get_ids'){
	global $db;
	$res = '';
	$module = strtolower($_REQUEST['m_name']);
	
	$q = "SELECT {$module}.id FROM {$module} ";
	if(!empty($_REQUEST['filter'])){
		$where = html_entity_decode($_REQUEST['filter'], ENT_QUOTES);
		$q .= " WHERE {$where} AND {$module}.deleted = 0 ";
	}
		else $q .= " WHERE {$module}.deleted = 0 ";
	$r = $db->query($q);
	while($row = $db->fetchByAssoc($r) ){
		$res.=$row['id'].',';
	}
	echo trim($res,',');
	exit;
}
else if($_REQUEST['func']=='prepare'){
	$m_name=$_REQUEST['m_name'];
	$path = 'upload/xls_tmp';
	mkdir($path);
	$path.='/'.$m_name;
	mkdir($path);
	$json_mask = $path.'/*.json';
	foreach (glob($json_mask) as $json_file) {
		unlink($json_file);
	}
	echo 'ok';
}
else if($_REQUEST['func']=='save_config'){
	global $db, $current_user;
	$config_name    = $_POST['config_name'];
	$all_visible    = $_POST['all_visible'];
	$current_module = $_POST['current_module'];
	$user_id        = $current_user->id;//$_POST['user_id'];
	$fields_list    = html_entity_decode($_POST['fields_list']);

	//echo $all_visible;
	$resource = $db->query("SELECT name FROM xls_user_data WHERE name LIKE '{$config_name}' AND deleted = 0");
	if($resource->num_rows != 0)
		echo "name_error";
	else{
		$db->query("INSERT
					INTO xls_user_data
					(
						config_id,
						user_id,
						name,
						fields_list,
						module,
						all_visible,
						deleted
					 )
					 VALUES
					 (
						UUID(),
						'{$user_id}',
						'{$config_name}',
						'{$fields_list}',
						'{$current_module}',
						'{$all_visible}',
						0
					 )");

		echo "1";
	}
}
else if($_REQUEST['func']=='open_config_select'){
	global $current_user, $db;
	$module = $_GET['m_name'];
	
	//Вытыгиваем конфигурации пользователей и конфигурации которые видны всем
	$resource = $db->query("SELECT config_id, name FROM xls_user_data WHERE deleted=0 AND( user_id ='".$current_user->id."' OR all_visible=1 ) AND module='{$module}' ");
	$config_option = "<option value='' label=''> </option>";
	while($row = $db->fetchByAssoc($resource) )
	{
		$config_option .= "<option value='{$row['config_id']}' label='{$row['name']}'>{$row['name']}</option>";
	}
	echo $config_option;
}
else if($_REQUEST['func']=='get_config_data'){
	global $db;

	$config_id = $_REQUEST['config_id'];
	$resource = $db->query("SELECT fields_list FROM xls_user_data WHERE config_id ='".$config_id."' AND deleted = 0");
	$fields_list_array = $db->fetchByAssoc($resource);
	$fields_list = html_entity_decode($fields_list_array['fields_list']);
	echo $fields_list;
}

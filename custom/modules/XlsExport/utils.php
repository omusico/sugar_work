<?php
/**
 * Created By Kolerts
 */
class XlsExUtils
{
	public static function get_field_list($module, $translate=true)
	{
		$value = BeanFactory::getBean($module); // Получаем bean текущего модуля

        $list = array();

        if(!empty($value->field_defs)){
			foreach($value->field_defs as $var){
				if($var['type'] != 'id' && $var['name'] != 'assigned_user_id' &&
					$var['name'] != 'modified_user_id' && $var['name'] != 'account_id' &&
					$var['name'] != 'created_by'
				){
					if(isset($var['source']) && ($var['source'] != 'db' &&
						$var['source'] != 'custom_fields') && $var['name'] != 'email1' &&
						$var['name'] != 'email2' && (!isset($var['type'])|| $var['type'] != 'relate')
						&& $var['type'] != 'id'
					) continue;
					
					$required = 0;
					$options_dom = array();
					$options_ret = array();
					// Apparently the only purpose of this check is to make sure we only return fields
					//   when we've read a record.  Otherwise this function is identical to get_module_field_list
					if(!empty($var['required'])) {
						$required = 1;
					}
					if(isset($var['options'])){
						$options_dom = translate($var['options'], $value->module_dir);
						if(!is_array($options_dom)) $options_dom = array();
							foreach($options_dom as $key=>$oneOption)
								$options_ret[] = self::get_name_value($key,$oneOption);
					}

					if(!empty($var['dbType']) && $var['type'] == 'bool') {
						$options_ret[] = self::get_name_value('type', $var['dbType']);
					}

					$entry = array();
					$entry['name'] = $var['name'];
					$entry['type'] = $var['type'];
					if($translate) {
						$entry['label'] = isset($var['vname']) ? translate($var['vname'], $value->module_dir) : $var['name'];
					}
					else {
						$entry['label'] = isset($var['vname']) ? $var['vname'] : $var['name'];
					}
					$entry['required'] = $required;
					$entry['options'] = $options_ret;
					if(isset($var['default'])) {
						$entry['default_value'] = $var['default'];
					}

					$list[$var['name']] = $entry;
				}
			} //foreach
		} //if

		if($value->module_dir == 'Bugs'){
			$seedRelease = new Release();
			$options = $seedRelease->get_releases(TRUE, "Active");
			$options_ret = array();
			foreach($options as $name=>$value){
				$options_ret[] =  array('name'=> $name , 'value'=>$value);
			}
			if(isset($list['fixed_in_release'])){
				$list['fixed_in_release']['type'] = 'enum';
				$list['fixed_in_release']['options'] = $options_ret;
			}
			if(isset($list['release'])){
				$list['release']['type'] = 'enum';
				$list['release']['options'] = $options_ret;
			}
			if(isset($list['release_name'])){
				$list['release_name']['type'] = 'enum';
				$list['release_name']['options'] = $options_ret;
			}
		}
		if($value->module_dir == 'Emails'){
			$fields = array('from_addr_name', 'reply_to_addr', 'to_addrs_names', 'cc_addrs_names', 'bcc_addrs_names');
			foreach($fields as $field){
				$var = $value->field_defs[$field];

				$required = 0;
				$entry = array();
				$entry['name'] = $var['name'];
				$entry['type'] = $var['type'];
				if($translate) {
					$entry['label'] = isset($var['vname']) ? translate($var['vname'], $value->module_dir) : $var['name'];
				} else {
					$entry['label'] = isset($var['vname']) ? $var['vname'] : $var['name'];
				}
				$entry['required'] = $required;
				$entry['options'] = array();
				if(isset($var['default'])) {
					$entry['default_value'] = $var['default'];
				}
				$list[$var['name']] = $entry;
			}
		}

		if(isset($value->assigned_user_name) && isset($list['assigned_user_id'])) {
			$list['assigned_user_name'] = $list['assigned_user_id'];
			$list['assigned_user_name']['name'] = 'assigned_user_name';
		}
		if(isset($list['modified_user_id'])) {
			$list['modified_by_name'] = $list['modified_user_id'];
			$list['modified_by_name']['name'] = 'modified_by_name';
		}
		if(isset($list['created_by'])) {
			$list['created_by_name'] = $list['created_by'];
			$list['created_by_name']['name'] = 'created_by_name';
		}
		return $list;
	}

	public static function get_name_value($field,$value)
	{
		return array('name'=>$field, 'value'=>$value);
	}
	
	public static function get_related($module_name)
	{
		global $dictionary;

		$module = BeanFactory::newBean($module_name);
		$linked_fields = $module->get_linked_fields();
		//$linked_fields = $module->get_related_fields();
		$object_name = $module->object_name;
		$related = array();
		foreach($linked_fields as $name=>$properties)
		{
			$relationship_name = $properties['relationship'];
			$relationship_array = $dictionary[$object_name]['relationships'][$relationship_name];
			if($relationship_array == null)
			{
				$relationship_array = $dictionary[$relationship_name]['relationships'][$relationship_name];
			}
			if(
				$relationship_array['lhs_module'] == $module_name    
				&& $relationship_array['rhs_module'] != $module_name 
				&& !in_array($relationship_array['rhs_module'], array_keys($related))
				&& (
					$relationship_array['relationship_type'] == 'one-to-many'
					|| (// фикс для стандартной связи с контактами
						$relationship_array['relationship_type'] == 'many-to-many'
						&& $relationship_array['rhs_module'] == 'Contacts'
					)
				)
			  )
			{
				$related[$relationship_array['rhs_module']] = $relationship_array;
			}
		}
		return $related;
	}
	
	public static function get_linked($module_name)
	{
		$linked = array();
		$rel_module = BeanFactory::newBean($module_name);
		foreach ($rel_module->field_defs as $field_name => $field_value)
		{
			if(!in_array($field_name,array(
			  'modified_user_name',
			  ))){
				if($field_value['type'] == 'relate' && $field_value['source'] == 'non-db') {
					$linked[$field_value['module']] = array(
						'field' => $field_name,
						'type' => 'relate',
						'label' => translate($field_value['vname'], $field_value['module']), 
						'rel' => $field_value['id_name'],
						'module' => $field_value['module'],
						// 'params' => $field_value,
					); 
				}
				else if($field_value['type'] == 'parent') {
					$app_list = $app_list_strings[$field_value['options']];
					foreach (array_keys($app_list) as $module){
						$linked[$module] = array(
							'field' => $field_name,
							'type' => 'parent',
							'label' => translate($field_value['vname'], $module), 
							'rel' => $field_value['id_name'],
							'module' => $module,
							// 'params' => $field_value,
						);
					}
				}
			}
		}
		return $linked;
	}
	
	public static function mod_translate($name)
	{
		return $GLOBALS['app_list_strings']['moduleList'][$name];
	}

	public static function getStandartField($bean, $field_name, $field_value)
	{
		global $app_list_strings, $mod_strings;
		global $timedate, $current_user;

		if (isset($bean->field_defs[$field_name]['type'])) //check for special type
		{
			$target_type = $bean->field_defs[$field_name]['type'];
			if ($target_type == 'bool')
			{
				if ($field_value == true)
					return 'Да';
				else
					return 'Нет';
			}
			elseif ($target_type == "datetime" || $target_type == "date")
			{
				 if (!empty($field_value))
				 {
					 if ($target_type == "datetime")
						return $timedate->to_display_date_time($field_value, TRUE, TRUE, $current_user);
					 else
						 return $timedate->to_display_date($field_value, TRUE, TRUE, $current_user);
				 }
				 else
				 {
					 return '';
				 }
			}
			elseif ($target_type == "enum" OR $target_type == "multienum")
			{
				if (!empty($bean->field_defs[$field_name]['options']))
				{
					$option_array_name = $bean->field_defs[$field_name]['options'];
				}
				else
				{
					return $field_value;
				}

				if ($target_type == "multienum")
				{
					$field_value = trim($field_value, '^');
					$items = explode("^,^", $field_value);
					$vals = array();
					foreach($items as $item) {
						if (!empty($app_list_strings[$option_array_name][$item]))
						{
							$vals[] = $app_list_strings[$option_array_name][$item];
						}
						else
						{
							$vals[] = $field_value;
						}
					}
					return implode(", ", $vals);
				}
				elseif (!empty($app_list_strings[$option_array_name][$field_value]))
				{
					return $app_list_strings[$option_array_name][$field_value];
				}
				else
				{
					return $field_value;
				}
			}
		}
		return $field_value;
	}
	
	
	// Get letter
	public static function getLetter($num)
	{
		$Abc = array(
			'A','B','C','D','E','F',
			'G','H','I','J','K','L',
			'M','N','O','P','Q','R',
			'S','T','U','V','W','X',
			'Y','Z','AA','AB','AC','AD',
			'AE','AF','AG','AH','AI','AJ',
			'AK','AL','AM','AN','AO','AP',
			'AQ','AR','AS','AT','AU','AV',
			'AW','AX','AY','AZ','BA','BB',
			'BC','BD','BE','BF','BG','BH',
			'BI','BJ','BK','BL','BM','BN',
			'BO','BP','BQ','BR','BS','BT',
			'BU','BV','BW','BX','BY','BZ',
		);
		return $Abc[$num - 1];
	}
}

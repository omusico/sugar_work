<?php
header('Content-type: text/html; charset=utf-8');
global $sugar_config, $moduleList, $dictionary;

if (isset($_REQUEST['modules']))
{
	if (isset($_REQUEST['mode']))
    {
		if ($_REQUEST['mode'] == 'sub')
        {
			$module_name = $_REQUEST['modules'];
			
			require_once('modules/ModuleBuilder/views/view.modulefields.php');
			$viewmodfields = new ViewModulefields();
			$objectName = BeanFactory::getObjectName($module_name);
			VardefManager::loadVardef($module_name, $objectName, true);
			global $dictionary;
			
			$str = '<option value=""></option>';
			
			$fieldsData = array();
			foreach($dictionary[$objectName]['fields'] as $def) 
            {
				if ($viewmodfields->isValidStudioField($def))
				{
					$str .= '<option value="' . $def['name'] . '">' . translate($def['vname'], $module_name) . '</option>';
				}
			}
			echo json_encode($str);
		}
		else if ($_REQUEST['mode'] == 'rel')
        {
			$str = '';
			$module_name = $_REQUEST['modules'];
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
                if( (  $relationship_array['relationship_type'] == 'one-to-many'
                    && $relationship_array['lhs_module'] == $module_name    
                    && $relationship_array['rhs_module'] != $module_name 
                    && (strpos($str, $relationship_array['rhs_module']) == false)
                    )
                  )
                {
                    $str .= '<option value="' . $relationship_array['rhs_module'] . '" data-key="'.$relationship_array['rhs_key'].'" data-parent="'.$module_name.'" data-child="self">' . $GLOBALS['app_list_strings']['moduleList'][$relationship_array['rhs_module']] . '</option></br>';
                    $related[$relationship_array['rhs_module']] = array();
                }
                else if(
                    $relationship_array['relationship_type'] == 'many-to-many'
                    && $relationship_array['lhs_module'] == $module_name 
                    && $relationship_array['rhs_module'] != $module_name
                    && (strpos($str, $relationship_array['rhs_module']) == false
                    && $relationship_array['rhs_module'] == 'Contacts'
                    )
                  )
                {
                    $str .= '<option value="' . $relationship_array['rhs_module'] . '" data-key="'.$relationship_array['rhs_key'].'" data-parent="'.$module_name.'" data-child="self">' . $GLOBALS['app_list_strings']['moduleList'][$relationship_array['rhs_module']] . '</option></br>';
                    $related[$relationship_array['rhs_module']] = array();
                }
			}
            foreach ($related as $key => $value)
            {
                $rel_module = BeanFactory::newBean($key);
                foreach ($rel_module->field_defs as $field_name => $field_value)
                {
                    if($field_value['type'] == 'relate' && $field_value['source'] == 'non-db')
                    {
                        $related[$key][] = array(
                            'name' => $field_name,
                            'rel' => $field_value['id_name'],
                            'module' => $field_value['module'],
                            'label' => translate($field_value['vname'], $field_value['module']), 
                        ); 
                    }
                    else if($field_value['type'] == 'parent')
                    {
                        $modules = array();
                        //$id_name = $field_value['id_name']
                        $app_list = $app_list_strings[$field_value['options']];
                        foreach ($app_list as $keya => $valuea)
                        {
                            $modules[] = array(
                                'modname' => $keya,
                                'label' => translate($valuea, $keya)
                            );
                        }
                        $related[$key][] = array(
                            'name' => $field_name,
                            'rel' => $field_value['id_name'],
                            'parent' => 'parent',
                            'label' => translate($field_value['vname'], $field_value['module']), 
                            'modules' => $modules
                        ); 
                    }
                }
                //'type' => 'relate',
            }
            $return_data = array(
                'main' => $str,
                'additional' => $related
            );
			echo json_encode($return_data);
		}
        else if($_REQUEST['mode'] == 'alt')
        {
            $str = '';
			$module_name = $_REQUEST['modules'];
			$module = BeanFactory::newBean($module_name);
			//$linked_fields = $module->get_linked_fields();
            $linked_fields = $module->get_related_fields();
            $related = array();
			foreach($linked_fields as $name=>$properties)
			{
                $linked_fields[$name]['label'] = translate($properties['vname'], $properties['module']);
//                if($linked_fields[$name]['label'] != $linked_fields[$name]['vname'])
//                {
//                    $related
//                }
            }
            echo json_encode($linked_fields);
        }
	}
}

?>
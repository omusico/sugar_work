<?php

global $db, $moduleList;

$map = $_POST['map'];
$file = $_POST['file'];
$module = $_POST['modu'];
$delimiter = $_POST['delimiter'];
$type = $_POST['type'];
$map_order = $_POST['map_order'];
$add_rel = $_POST['add_rel'];
$encode = $_POST['encode'];

if(file_exists (__DIR__."/upload.sql"))
{
    $file_deleted = unlink(__DIR__."/upload.sql");
}

require_once 'modules/Import/ImportUtils.php';

if ((!isset($map)) || (!isset($file)) || (!isset($module))) 
{ 
    echo json_encode('error'); 
    exit;
}

$used_modules = array();//Сюда помещаем все модули, которые участвуют в нашем импорте

$used_modules[$module] = array(
    'module_name' => $module,
    'table_name' => strtolower($module),
    'module_type' => 'main',
    'relate_id' => 'id',
    'parent' => $module,
    'child' => 'self',
    'fields' => array()
);

$field_map = array();
$success_inserted = array();
$success_updated = array();
$failure = array();
//Сначало разбираем, какое поле куда относится

foreach ($map as $element)
{
    //Тут напихиваем наши модули в массив $used_modules
    if(   $element['modulename'] != $module
       && !in_array($element['modulename'], array_keys($used_modules) ) 
    )
    {
        $used_modules[$element['modulename']] = array(
            'module_name' => $element['modulename'],
            'table_name' => strtolower($element['modulename']),
            'module_type' => 'related',
            'relate_id' => $element['relfield'],
            'parent' => $element['relmodule'],
            'child' => $element['relchild'],
            'fields' => array()
        );
    }
    
    //Заносим наше поле
    $used_modules[$element['modulename']]['fields'][$element['fieldname']] = array(
        'name' => $element['fieldname'],
        'uploadbool' => $element['uploadbool'],
        'searchbool' => $element['searchbool'],
        'column' => $element['index'],
        'func' => $element['func'],
        'str_func' => $element['str_func'],
        'str_func_val' => $element['str_func_val'],
    );
    
    $field_map[$element['index']] = array(
        'module' => $element['modulename'],
        'name' => $element['fieldname']
    );
}

$first = true;
$f = fopen($file, "r");
$line_number=0;

$delimiter = ($delimiter == 'tab')?("\t"):($delimiter);

while (!feof ($f))
{ 
    $lin = fgets ($f, 2048);
    $lin = str_replace ("\n",'',$lin);
    $line = explode($delimiter, $lin);
    if (!$first)
    {
        $parent_id = array();
        $imported_modules = array();
        $parent_module = strtolower($module);

        foreach ($map_order as $value)
        {
            $key = $value['modulename'];
            $fields = array(
                'fields_in_module' => array(),
                'join_fields' => array(),
                'search_fields' => array(),
                'join_search_fields' => array(),
            );

            $cell_number = 0; 
            $current_table = strtolower($key);

            foreach ($line as $cell) 
            { 
                //Смотрим, данное поле относится к текущему модулю или нет
                if($field_map[$cell_number]['module'] == $key)
                {
                    if($encode == 'Windows-1251')
                    {
                        $cell = mb_convert_encoding($cell, 'utf-8', $encode);
                        //$cell =  iconv ('CP1251', 'utf-8',$cell);
                    }
                    $cell = str_replace ('"','',$cell);
                    $cell = str_replace ('
','',$cell);
                    $cell = trim($cell);
                    $cell_func = $cell;
                    if($used_modules[$key]['fields'][$field_map[$cell_number]['name']]['str_func'] == 'concat')
                    {
                        $concat_string = explode('^|^', $used_modules[$key]['fields'][$field_map[$cell_number]['name']]['str_func_val']);
                        $cell_func = $concat_string[0].$cell.$concat_string[1];
                    }
                    else if($used_modules[$key]['fields'][$field_map[$cell_number]['name']]['str_func'] != 'no_func')
                    {
                        $str_func = $used_modules[$key]['fields'][$field_map[$cell_number]['name']]['str_func'];
                        $str_func_val = $used_modules[$key]['fields'][$field_map[$cell_number]['name']]['str_func_val'];
                        if($str_func_val && is_numeric($str_func_val))
                        {
                            $str_func_val = $str_func_val + 0;
                            if($str_func == 'add')
                            {
                                $cell_func += $str_func_val;
                            }
                            else if($str_func == 'subtract')
                            {
                                $cell_func -= $str_func_val;
                            }
                            else if($str_func == 'multiply')
                            {
                                $cell_func *= $str_func_val;
                            }
                            else if($str_func == 'div' && $str_func_val != 0)
                            {
                                $cell_func = $cell / $str_func_val;
                            }
                        }
                    }
                    
                    $last2 = substr($field_map[$cell_number]['name'], -2);
                    if($last2 != '_c')
                    {
                        if($used_modules[$key]['fields'][$field_map[$cell_number]['name']]['uploadbool'] == 'true')
                        {
                            $fields['fields_in_module'][$field_map[$cell_number]['name']] = array(
                                'cell' => $cell_func,
                                'func' => $used_modules[$key]['fields'][$field_map[$cell_number]['name']]['func']
                            );
                        }
                        if($used_modules[$key]['fields'][$field_map[$cell_number]['name']]['searchbool'] == 'true')
                        {
                            $fields['search_fields'][$field_map[$cell_number]['name']] = array(
                                'cell' => $cell,
                                'func' => $used_modules[$key]['fields'][$field_map[$cell_number]['name']]['func']
                            );
                        }
                    }
                    else
                    {
                        //TODO ?? надо бы джоинить
                        if($used_modules[$key]['fields'][$field_map[$cell_number]['name']]['uploadbool'] == 'true')
                        {
                            $fields['join_fields'][$field_map[$cell_number]['name']] = array(
                                'cell' => $cell_func,
                                'func' => $used_modules[$key]['fields'][$field_map[$cell_number]['name']]['func']
                            );
                        }
                        if($used_modules[$key]['fields'][$field_map[$cell_number]['name']]['searchbool'] == 'true')
                        {
                            $fields['join_search_fields'][$field_map[$cell_number]['name']]= array(
                                'cell' => $cell,
                                'func' => $used_modules[$key]['fields'][$field_map[$cell_number]['name']]['func']
                            );
                        }
                    }
                }
                $cell_number++;
            }

            if($key != $module)
            {
                $is_related = true;
            }
            else
            {
                $is_related = false;
            }
            
            //Доп связи
            $this_module_rel = array();
            foreach ($add_rel as $keyrel => $valuerel)
            {
                if(($valuerel['module'] == $key) && in_array($valuerel['modulerel'], $imported_modules))
                {
                    $this_module_rel[] = array(
                        'modulerel' => $valuerel['modulerel'],
                        'rel' => $valuerel['rel'],
                        'rel_id' => $parent_id[$valuerel['modulerel']],
                    );
                            
                }
            }
            
            if($used_modules[$key]['child'] == 'self')
            {
                //Проверям тип 
                if($type == 'create')
                {
                    $result = ImportUtils::insertNewObject($current_table,$fields, $is_related,$parent_id,$module, $used_modules[$key]['relate_id'], $this_module_rel);
                }
                else if($type == 'update')
                { 
                    $result = ImportUtils::updateObject($current_table, $fields, $is_related,$parent_id,$module, $used_modules[$key]['relate_id'], $this_module_rel);
                }
                else
                {
                    $result = ImportUtils::mixedUpdate($current_table, $fields, $is_related, $parent_id,$module, $used_modules[$key]['relate_id'], $this_module_rel);
                }
            }
            else
            {
                //TODO

                $result = ImportUtils::mixedUpdateParent($current_table, $fields, $is_related, $parent_id,$used_modules[$key]['child'], $used_modules[$key]['relate_id'], $this_module_rel);

            }
            

//            if($key == $module)//Значит сейчас основной модуль
//            {
            $parent_id[$key] = $result['id'];
            $imported_modules[] = $key;
//            }
            if($result['old_value'] && !$result['already_updated'] && !$result['update_failure'])
            {

                if(!array_key_exists($result['id'], $success_updated[$key])) 
                {
                    $success_updated[$key][$result['id']]['old_value'] = $result['old_value'];
                    if($result['result']) 
                    {
                        $success_updated[$key][$result['id']]['result'] = $result['result'];
                    } 
                    if($result['result']['joined']['result']) 
                    {
                        $success_updated[$key][$result['id']]['joined'] = $result['result']['joined']['old'];
                    }
                }
            }
            else if($result['result'])
            {
                if(!array_key_exists($result['id'], $success_inserted[$key])) 
                {
                    $success_inserted[$key][$result['id']] = $result['result'];
                    if($result['result']['joined']['result']) 
                    {
                        $success_inserted[$key][$result['id']]['joined'] = $result['result']['joined']['result'];
                    }
                }  
            }
            else
            {
                $failure[$key][] = $result;
            }
            
            
            
        }
        
    } 
    else 
    {
        $first = false;
    }
    $line_number++;
    
}
fclose($f);
$sql_dump ="";
$table_list = array();
foreach ($success_inserted as $inserted_module => $inserted_object)
{
    if(!empty($success_inserted[$inserted_module]))
    {
        $sql_dump_c_ids = "";
        $inserted_table = strtolower($inserted_module);
        $sql_dump .= " DELETE FROM {$inserted_table} WHERE id IN (";
        
        if($db->query(" SHOW TABLES LIKE '{$inserted_table}_cstm';"))
            $sql_dump_c = " DELETE FROM {$inserted_table}_cstm WHERE id_c IN (";
        else
            $sql_dump_c = false;    
        foreach ($inserted_object as $object_id => $object_value)
        {
            $sql_dump .= "'{$object_id}',";
            if($sql_dump_c)
                $sql_dump_c_ids .= "'{$object_id}',";
        }
        $sql_dump = trim($sql_dump, ',');
        $sql_dump .= "); \n";
        if($sql_dump_c && $sql_dump_c_ids != "")
        {
            $sql_dump_c_ids = trim($sql_dump_c_ids, ',');
            $sql_dump_c .= $sql_dump_c_ids."); \n";
            $sql_dump .= $sql_dump_c;
        }
    }
}
foreach ($success_updated as $updated_module => $updated_object)
{
    if(!empty($success_updated[$updated_module]))
    {
        $sql_dump_c_ids = "";
        $updated_table = strtolower($updated_module);
        $sql_dump .= " DELETE FROM {$updated_table} WHERE id IN (";
        
        if($db->query(" SHOW TABLES LIKE '{$inserted_table}_cstm';"))
            $sql_dump_c = " DELETE FROM {$inserted_table}_cstm WHERE id_c IN (";
        else
            $sql_dump_c = false;
        foreach ($updated_object as $object_id => $object_value)
        {
            $sql_dump .= "'{$object_id}',";
            //TODO удалять только те кастомные записи, которые были удалены!
            if($object_value['joined'])
                $sql_dump_c_ids .= "'{$object_id}',";
        }
        $sql_dump = trim($sql_dump, ',');
        $sql_dump .= "); \n";
        if($sql_dump_c && $sql_dump_c_ids != "")
        {
            $sql_dump_c_ids = trim($sql_dump_c_ids, ',');
            $sql_dump_c .= $sql_dump_c_ids."); \n";
            $sql_dump .= $sql_dump_c;
        }
    }
}
//TODO!!!!! INSERT
foreach ($success_updated as $updated_module => $updated_object)
{
    if(!empty($success_updated[$updated_module]))
    {
        $sql_dump_c_ids = "";
        $updated_table = strtolower($updated_module);
        $sql_dump_ins = " INSERT INTO {$updated_table} \n";
        $sql_dump_ins_set = "";
        $sql_dump_ins_set_cstm = "";
        $set_filled = false;
        $set_filled_cstm = false;
        $add_cstm = true;
        
        if($db->query(" SHOW TABLES LIKE '{$inserted_table}_cstm';"))
            $sql_dump_ins_cstm = " INSERT INTO {$inserted_table}_cstm \n";
        else
            $sql_dump_ins_cstm = false;
        
        foreach ($updated_object as $object_id => $object_value)
        {
            $sql_dump_ins_values = "";
            $sql_dump_ins_values_cstm = "";
            foreach ($object_value['old_value'] as $object_value_key => $object_value_value)
            {
                if(!$set_filled)
                {
                    $sql_dump_ins_set .= " `{$object_value_key}`,";
                }
                $sql_dump_ins_values .= " '{$object_value_value}',";
            }
            if(!$set_filled)
            {
                $sql_dump_ins_set = trim($sql_dump_ins_set, ',');
                $sql_dump_ins_set = " (".$sql_dump_ins_set.") ";
                $sql_dump_ins .= $sql_dump_ins_set." VALUES \n";
                $set_filled = true;
            }
            
            $sql_dump_ins_values = trim($sql_dump_ins_values, ',');
            $sql_dump_ins_values = " (".$sql_dump_ins_values."), \n";
            $sql_dump_ins .= $sql_dump_ins_values;

            if($sql_dump_ins_cstm && isset($object_value['joined']))
            {
                foreach ($object_value['joined'] as $object_value_key => $object_value_value)
                {
                    if(!$set_filled_cstm)
                    {
                        $sql_dump_ins_set_cstm .= " `{$object_value_key}`,";
                    }
                    $sql_dump_ins_values_cstm .= " '{$object_value_value}',";
                }
                if(!$set_filled_cstm)
                {
                    $sql_dump_ins_set_cstm = trim($sql_dump_ins_set_cstm, ',');
                    $sql_dump_ins_set_cstm = " (".$sql_dump_ins_set_cstm.") ";
                    $sql_dump_ins_cstm .= $sql_dump_ins_set_cstm." VALUES \n";
                    $set_filled_cstm = true;
                }
                $sql_dump_ins_values_cstm = trim($sql_dump_ins_values_cstm, ',');
                $sql_dump_ins_values_cstm = " (".$sql_dump_ins_values_cstm."), \n";
                $sql_dump_ins_cstm .= $sql_dump_ins_values_cstm;
            }
            else
            {
                $add_cstm = false;
            }
        }
        $sql_dump_ins = trim($sql_dump_ins, ", \n");
        $sql_dump_ins .= "; \n";
        $sql_dump .= $sql_dump_ins;
        if($add_cstm)
        {
            $sql_dump_ins_cstm = trim($sql_dump_ins_cstm, ", \n");
            $sql_dump_ins_cstm .= "; \n";
            $sql_dump .= $sql_dump_ins_cstm;
        }
    }
}
$rew = 0;
file_put_contents(__DIR__."/upload.sql", $sql_dump);
$result = array(
    'success_updated' => $success_updated,
    'success_inserted' => $success_inserted,
    'failure' => $failure,
);
echo json_encode($result);

unlink($file);
?>
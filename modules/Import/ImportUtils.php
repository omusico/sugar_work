<?php
/**
 * Description of ImportUtils
 *
 * @author ivan
 */
class ImportUtils extends SugarBean
{

    static public function insertNewObject($current_table, $fields, $is_related, $parent_id,$parent_module, $relate_id, $this_module_rel)
    {
        global $db, $current_user;
        
        $date_now = date('Y-m-d H:i:s');
        $current_u = $current_user->id;
        
        $uuid = create_guid();
        $sql = "INSERT INTO `{$current_table}` SET `id` = '{$uuid}',";
        foreach ($fields['fields_in_module'] as $keyf => $valuef)
        {
            //$sql .= " `{$keyf}` = '{$valuef['cell']}',";
            if($keyf !== 'email' && $keyf !== 'email1' && $keyf !== 'email2')
            {
                $sql .= " `{$keyf}` = '{$valuef['cell']}',";
            }
            else
            {
                self::updateEmail($uuid, $valuef['cell'], $current_table);
            }
        }
        if($current_table != 'contacts' && $is_related && $relate_id != 'id')
        {
            $sql .= " `{$relate_id}` = '{$parent_id[$parent_module]}',";
            if($relate_id == 'parent_id')
            {
                $sql .= " `parent_type` = '{$parent_module}',";
            }
        }
        else if($current_table == 'contacts' && $is_related && $relate_id == 'id')
        {
            //TODO - вставить связь
            self::insertRelationship($uuid,$current_table,$parent_id[$parent_module],$parent_module);
        }
        if(!empty($this_module_rel))
        {
            foreach ($this_module_rel as $keyrel => $valuerel)
            {
                $sql .= " `{$valuerel['rel']}` = '{$valuerel['rel_id']}',";
                if($valuerel['rel'] == 'parent_id')
                {
                    $sql .= " `parent_type` = '{$valuerel['modulerel']}',";
                }
            }
        }
        $sql .= " `date_entered` = '{$date_now}',";
        $sql .= " `date_modified` = '{$date_now}',";
        $sql .= " `modified_user_id` = '{$current_u}',";
        $sql .= " `created_by` = '{$current_u}',";
        $sql .= " `assigned_user_id` = '{$current_u}',";
        $sql = trim($sql, ',');
        $result = $db->query($sql);
        if($result)
        {
            $row = self::returnCreated($current_table,$uuid);
            if($current_table == 'contacts' || $current_table == 'leads' )
                $name = $row['first_name'].' '.$row['last_name'];
            else
                $name = $row['name'];
            if(!empty($fields['join_fields']))
            {
                $joined = self::update_cstm($current_table,$uuid,$fields['join_fields']);
            }
            
            $return = array(
                'id' => $uuid,
                'result' => $row,
                'name' => $name,
            );
            if($joined)
            {
                $return['joined'] = $joined;
            }
            return $return;
        }
        else
        {
            return array();
        }
        
    }
    
    static public function update_cstm($current_table,$uuid,$join_fields)
    {
        $cstm_table = $current_table.'_cstm';
        global $db, $current_user;
        
        $date_now = date('Y-m-d H:i:s');
        $current_u = $current_user->id;
        
        $sql = "SELECT * "
             . "FROM `{$cstm_table}` "
             . "WHERE `id_c` = '{$uuid}' ";
        $result = $db->query($sql);
        if($row = $db->fetchByAssoc($result))
        {
            //return $row;
            $sql_upd = "UPDATE `{$cstm_table}` "
                 . "SET ";
            foreach ($join_fields as $keyf => $valuef)
            {
                $sql_upd .= " `{$keyf}` = '{$valuef['cell']}',";
            }
            $sql_upd = trim($sql_upd, ',');
            $sql_upd .= " WHERE `id_c` = '{$sql_upd}'";
            $result_upd = $db->query($sql_upd);
            if($result_upd)
            {
                $rowc = self::returnCreated($cstm_table,$uuid, 'id_c');
                return array(
                    'id_c' => $uuid,
                    'result' => $rowc,
                    'old' => $row
                );
            }
            else
                return array();
        }
        else
        {
            $sql_ins = "INSERT INTO `{$cstm_table}` SET `id_c` = '{$uuid}',";
            foreach ($join_fields as $keyf => $valuef)
            {
                $sql_ins .= " `{$keyf}` = '{$valuef['cell']}',";
            }
            $sql_ins = trim($sql_ins, ',');
            $result_ins = $db->query($sql_ins);
            if($result_ins)
            {
                $rowc = self::returnCreated($cstm_table,$uuid, 'id_c');
                return array(
                    'id_c' => $uuid,
                    'result' => $rowc,
                );
            }
            else
                return array();
        }
    }
    
    static public function updateObject($current_table, $fields, $is_related, $parent_id,$parent_module, $relate_id, $this_module_rel)
    {
        if($current_table == 'contacts' && $is_related && $relate_id = 'id')
        {
            $exists = self::checkIfContactExists($current_table,  $fields, $is_related, $parent_id,$parent_module, $relate_id, $this_module_rel);
        }
        else
        {
            $exists = self::checkIfExists($current_table,  $fields, $is_related, $parent_id,$parent_module, $relate_id, $this_module_rel);
        }
        if($exists)
        {
            if($current_table == 'contacts' || $current_table == 'leads' )
                $name = $exists['first_name'].' '.$exists['last_name'];
            else
                $name = $exists['name'];
            $return = self::updateExistingObject($exists, $name, $current_table, $fields, $is_related, $parent_id,$parent_module, $relate_id, $this_module_rel);
            if(empty($return))
                $return['update_failure'] == true;
            else
                $return['update_failure'] == false;
            $return['old_value'] = $exists;
            return $return;
        }
        else
        {
            return false;
        }
    }
    
    static public function mixedUpdate($current_table, $fields, $is_related, $parent_id,$parent_module, $relate_id, $this_module_rel)
    {
        if($current_table == 'contacts' && $is_related && $relate_id = 'id')
        {
            $exists = self::checkIfContactExists($current_table,  $fields, $is_related, $parent_id,$parent_module, $relate_id, $this_module_rel);
        }
        else
        {
            $exists = self::checkIfExists($current_table,  $fields, $is_related, $parent_id,$parent_module, $relate_id, $this_module_rel);
        }
        
        if($exists)
        {
            if($current_table == 'contacts' || $current_table == 'leads' )
                $name = $exists['first_name'].' '.$exists['last_name'];
            else
                $name = $exists['name'];
            $return = self::updateExistingObject($exists, $name, $current_table, $fields, $is_related, $parent_id,$parent_module, $relate_id, $this_module_rel);
            if(empty($return))
                $return['update_failure'] == true;
            else
                $return['update_failure'] == false;
            $return['old_value'] = $exists;
            return $return;
        }
        else
        {
            return self::insertNewObject($current_table,$fields,$is_related,$parent_id,$parent_module, $relate_id, $this_module_rel);
        }
    }
    
    static public function updateExistingObject($exists,$name, $current_table, $fields, $is_related, $parent_id,$parent_module, $relate_id, $this_module_rel)
    {
        global $db, $current_user;
        $id = $exists['id'];
        $joined = false;
        $date_now = date('Y-m-d H:i:s');
        $current_u = $current_user->id;
        $need_to_upadate = false;
        
        $sql = "UPDATE `{$current_table}` "
                 . "SET ";
        foreach ($fields['fields_in_module'] as $keyf => $valuef)
        {
            if($keyf !== 'email' && $keyf !== 'email1' && $keyf !== 'email2')
            {
                $sql .= " `{$keyf}` = '{$valuef['cell']}',";
            }
            else
            {
                self::updateEmail($exists['id'], $valuef['cell'], $current_table);
            }
                
            $need_to_upadate = true;
            //Если полей нет - то нет смысла обновлять?
        }
        if($current_table != 'contacts' && $is_related && $relate_id != 'id')
        {
            //Если он уже связан с тем же объектом - то нет смысла обновлять
            if($exists[$relate_id] != $parent_id[$parent_module])
            {
                $sql .= " `{$relate_id}` = '{$parent_id[$parent_module]}',";
                if($relate_id == 'parent_id')
                {
                    $sql .= " `parent_type` = '{$parent_module}',";
                }
                $need_to_upadate = true;
            }
        }
        if(!empty($this_module_rel))
        {
            foreach ($this_module_rel as $keyrel => $valuerel)
            {
                //Если он уже связан с тем же объектом - то нет смысла обновлять
                if($exists[$valuerel['rel']] != $valuerel['rel_id'])
                {
                    $sql .= " `{$valuerel['rel']}` = '{$valuerel['rel_id']}',";
                    if($valuerel['rel'] == 'parent_id')
                    {
                        $sql .= " `parent_type` = '{$valuerel['modulerel']}',";
                    }
                    $need_to_upadate = true;
                }
            }
        }
        //Если ничег оне изменилось выше -то нет смысла вообще что-то обновлять
        $sql .= " `date_modified` = '{$date_now}',";
        $sql .= " `modified_user_id` = '{$current_u}',";
        $sql = trim($sql, ',');
        $sql .= " WHERE id = '{$id}' AND deleted = '0'";
        if($need_to_upadate)
        {
            $result = $db->query($sql);
            if($result)
            {
                $row = self::returnCreated($current_table,$id);
                if(!empty($fields['join_fields']))
                {
                    $joined = self::update_cstm($current_table,$id,$fields['join_fields']);
                }
                $return = array(
                    'id' => $id,
                    'result' => $row,
                    'name' => $name,
                );
                if($joined)
                {
                    $return['joined'] = $joined;
                }
                $return['already_updated'] = false;
                return $return;
            }
            else
            {
                return array();
            }
        }
        else
        {
            return array('already_updated' => true);
        }
//        return array(
//            'id' => $id,
//            'result' => $result,
//            'name' => $name,
//        );
    }
    
    static public function checkIfExists($current_table, $fields, $is_related, $parent_id,$parent_module, $relate_id, $this_module_rel)
    {
        global $db, $current_user;
        
        $date_now = date('Y-m-d H:i:s');
        $current_u = $current_user->id;
        $left_join = "";
        $joined_fields = "";
        if(!empty($fields['join_search_fields']))
        {
            $left_join = " LEFT JOIN `{$current_table}_cstm` ON `{$current_table}`.id = `{$current_table}_cstm`.id_c ";
            foreach ($fields['join_search_fields'] as $keyj => $valuej)
            {
                //$joined_fields .= " AND `{$keyj}` = '{$valuej['cell']}' ";
                if($valuej['func'] == 'eq')
                    $joined_fields .= " AND `{$current_table}_cstm`.`{$keyj}` = '{$valuej['cell']}' ";
                else
                    $joined_fields .= " AND `{$current_table}_cstm`.`{$keyj}` LIKE '%{$valuej['cell']}%' ";
            }
        }
        
        $sql = "SELECT `{$current_table}`.* "
             . "FROM `{$current_table}` "
             . $left_join
             . "WHERE 1=1 ";
        foreach ($fields['search_fields'] as $keyf => $valuef)
        {
            if($valuef['func'] == 'eq')
                $sql .= " AND `{$keyf}` = '{$valuef['cell']}' ";
            else
                $sql .= " AND `{$keyf}` LIKE '%{$valuef['cell']}%' ";
            //$sql .= " AND `{$keyf}` = '{$valuef}' ";
        }
        if($is_related)
        {
            $sql .= " AND `{$relate_id}` = '{$parent_id[$parent_module]}' ";
        }
        if(!empty($this_module_rel))
        {
            foreach ($this_module_rel as $keyrel => $valuerel)
            {
                $sql .= " AND `{$valuerel['rel']}` = '{$valuerel['rel_id']}' ";
            }
        }
        $sql .= "AND `deleted` = '0' {$joined_fields} LIMIT 1";
        //file_put_contents ( __DIR__."/log.txt", $sql, FILE_APPEND );
        $result = $db->query($sql);
        if($row = $db->fetchByAssoc($result))
        {
            return $row;
        }
        else
        {
            return false;
        }
    }
    
    static public function returnCreated($current_table, $id, $id_field = 'id')
    {
        global $db;
        $sql = "SELECT * "
             . "FROM `{$current_table}` "
             . "WHERE `{$id_field}` = '{$id}' ";
        $result = $db->query($sql);
        if($row = $db->fetchByAssoc($result))
        {
            return $row;
        }
        else
        {
            return false;
        }
    }
    
    static public function updateEmail($bean_id, $email, $module)
    {
        global $db;
        $module[0] = strtoupper($module[0]);
        $sql = " SELECT * "
             . " FROM email_addresses AS ea "
             . " LEFT JOIN email_addr_bean_rel AS eabr "
             . "        ON ea.id = eabr.email_address_id "
             . "       AND eabr.deleted = 0 "
             . " WHERE ea.email_address = '{$email}' "
             . "   AND eabr.bean_id = '{$bean_id}' "
             . "   AND eabr.bean_module = '{$module}' "
             . "   AND ea.deleted = 0 ";
        $result = $db->query($sql);
        if($row = $db->fetchByAssoc($result))
        {
            //Нашли - ничего не делаем?
        }
        else
        {
            //Не нашли - нужно вставить
            //Сначало проверяем, нет ли в системе уже такого email (не связанного с текущим объектом)
            $sql_2 = " SELECT id "
                   . " FROM email_addresses AS ea "
                   . " WHERE ea.email_address = '{$email}' "
                   . "   AND ea.deleted = 0 ";
            $result_2 = $db->query($sql_2);
            if($row_2 = $db->fetchByAssoc($result_2))
            {
                $id = $row_2['id'];
            }
            else
            {
                //Не существует - создаем
                $id = create_guid();
                $email_address_caps = strtoupper($email);
                $date_now = date('Y-m-d H:i:s');
                $sql_insert_ea = " INSERT INTO email_addresses "
                               . " SET id                 = '{$id}', "
                               . "     email_address      = '{$email}', "
                               . "     email_address_caps = '{$email_address_caps}', "
                               . "     invalid_email      = 0, "
                               . "     opt_out            = 0, "
                               . "     date_created       = '{$date_now}', "
                               . "     date_modified      = '{$date_now}', "
                               . "     deleted            = 0 ";
                $result_insert_ea = $db->query($sql_insert_ea);
            }
            
            //Теперь создаем связь с нашим объектом
            $eabr_id = create_guid();
            $email_address_caps = strtoupper($email);
            $date_now = date('Y-m-d H:i:s');
            $sql_insert_eabr = " INSERT INTO  email_addr_bean_rel "
                           . " SET id               = '{$eabr_id}', "
                           . "     email_address_id = '{$id}', "
                           . "     bean_id          = '{$bean_id}', "
                           . "     bean_module      = '{$module}', "
                           . "     primary_address  = 0, "
                           . "     reply_to_address = 0, "
                           . "     date_created     = '{$date_now}', "
                           . "     date_modified    = '{$date_now}', "
                           . "     deleted          = 0 ";
            $result_insert_eabr = $db->query($sql_insert_eabr);
        }
    }
    
    static public function checkIfContactExists($current_table, $fields, $is_related, $parent_id,$parent_module, $relate_id, $this_module_rel)
    {
        global $db, $current_user;
        
        $date_now = date('Y-m-d H:i:s');
        $current_u = $current_user->id;
        $left_join = "";
        $joined_fields = "";

        if(!empty($fields['join_search_fields']))
        {
            $left_join = " LEFT JOIN `{$current_table}_cstm` ON `{$current_table}`.id = `{$current_table}_cstm`.id_c ";
            foreach ($fields['join_search_fields'] as $keyj => $valuej)
            {
                //$joined_fields .= " AND `{$keyj}` = '{$valuej['cell']}' ";
                if($valuej['func'] == 'eq')
                    $joined_fields .= " AND `{$current_table}_cstm`.`{$keyj}` = '{$valuej['cell']}' ";
                else
                    $joined_fields .= " AND `{$current_table}_cstm`.`{$keyj}` LIKE '%{$valuej['cell']}%' ";
            }
        }
        
        $parent_table = strtolower($parent_module);
        $join_table = $parent_table.'_'.$current_table;
        $current_table_id = substr_replace($current_table, '_id', -1);
        $parent_table_id = substr_replace($parent_table, '_id', -1);
        
        $sql = " SELECT `{$current_table}`.* "
             . " FROM `{$current_table}` "
             . " LEFT JOIN {$join_table} AS jt ON {$current_table}.id = jt.{$current_table_id} "
             . $left_join
             . " WHERE 1=1 "
             . " AND jt.{$parent_table_id} = '{$parent_id[$parent_module]}' "
             . " AND jt.deleted = 0 ";
        foreach ($fields['search_fields'] as $keyf => $valuef)
        {
            if($valuef['func'] == 'eq')
                $sql .= " AND {$current_table}.`{$keyf}` = '{$valuef['cell']}' ";
            else
                $sql .= " AND {$current_table}.`{$keyf}` LIKE '%{$valuef['cell']}%' ";
            //$sql .= " AND `{$keyf}` = '{$valuef}' ";
        }
        if(!empty($this_module_rel))
        {
            foreach ($this_module_rel as $keyrel => $valuerel)
            {
                $sql .= " AND {$current_table}.`{$valuerel['rel']}` = '{$valuerel['rel_id']}' ";
            }
        }
        $sql .= "AND {$current_table}.`deleted` = '0' {$joined_fields} LIMIT 1";
        //file_put_contents ( __DIR__."/log.txt", $sql, FILE_APPEND );
        $result = $db->query($sql);
        if($row = $db->fetchByAssoc($result))
        {
            return $row;
        }
        else
        {
            return false;
        }
    }
    
    static public function insertRelationship($uuid,$current_table,$parent_id,$parent_module)
    {
        global $db, $current_user;
        $parent_table = strtolower($parent_module);
        $join_table = $parent_table.'_'.$current_table;
        $current_table_id = substr_replace($current_table, '_id', -1);
        $parent_table_id = substr_replace($parent_table, '_id', -1);
        $date_now = date('Y-m-d H:i:s');
        
        $rel_id = create_guid();
        
        $sql = " INSERT INTO {$join_table} "
             . " SET `id` = '{$rel_id}', "
             . "     `{$current_table_id}` = '{$uuid}', "
             . "     `{$parent_table_id}` = '{$parent_id}', "
             . "     `date_modified` = '{$date_now}',"
             . "     `deleted` = 0 ";
        $result = $db->query($sql);
    }
    
    static public function mixedUpdateParent($current_table, $fields, $is_related, $parent_id,$parent_module, $relate_id, $this_module_rel)
    {
        global $db;
        $exists = self::checkIfExists($current_table,  $fields, false, $parent_id,$parent_module, $relate_id, $this_module_rel);

        
        if($exists)
        {
            if($current_table == 'contacts' || $current_table == 'leads' )
                $name = $exists['first_name'].' '.$exists['last_name'];
            else
                $name = $exists['name'];
            $return = self::updateExistingObject($exists, $name, $current_table, $fields, false, $parent_id,$parent_module, $relate_id, $this_module_rel);
            if(empty($return))
                $return['update_failure'] == true;
            else
                $return['update_failure'] == false;
            $return['old_value'] = $exists;
        }
        else
        {
            $return = self::insertNewObject($current_table,$fields,false,$parent_id,$parent_module, $relate_id, $this_module_rel);
        }
        $child_table = strtolower($parent_module);
        $sql = "SELECT `{$child_table}`.* "
             . "FROM `{$child_table}` "
             . "WHERE id = '{$parent_id[$parent_module]}' ";
        $result = $db->query($sql);
        $child_object = $db->fetchByAssoc($result);
        if($child_table == 'contacts' || $child_table == 'leads' )
            $name = $child_object['first_name'].' '.$child_object['last_name'];
        else
            $name = $child_object['name'];
        $child_fields = array(
            'fields_in_module' => array(
                $relate_id => array(
                    'cell' => $return['id'],
                    'func' => 'like',
                ),
            ),
        );
        self::updateExistingObject($child_object, $name, $child_table, $child_fields, false, $parent_id,$parent_module, $relate_id, array());
        return $return;
    }
}

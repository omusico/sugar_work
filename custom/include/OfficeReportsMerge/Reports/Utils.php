<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class Reports_Utils
{

    /** @var array with not available for merge reports module */
    static private $ban_modules = array('Activities', 'iFrames', 'Dashboard', 'Reports', 'Feeds', 'Home', 'Calendar', 'OfficeReportsMerge', 'Administration', 'OfficeReportsVariables', 'Emails');

    /** @var array - available template format for uploaded file */
    static private $available_template_formats = array('DOCX', 'XLSX', 'ODT', 'ODS', 'PPTX', 'ODF', 'ODG', 'ODM', 'ODP', );

    /** @var bool
     * if set in TRUE not be checked rigths to access for generate report for record
     * if set in FALSE user need rights for export (NOT for detail)
     * */
    static public $allowAccessForAll = FALSE;

    static private $prefixReportField = '_LRM_';

    static private $officeConfigFields = array('officeDocxHistorySave', 'officeDocxHistorySaveReport', 'officeDocxSaveEmail', 'officeDocxDebugMode', 'officeDocxExcludeModules');

    /**
     * Get OfficeReports settings
     * @return array
     */
    static public function get_config()
    {
        global $sugar_config;

        $officeConfig = array();
        foreach (self::$officeConfigFields as $key)
        {
            if (isset($sugar_config[$key]))
            {
                $officeConfig[$key] = $sugar_config[$key];
            }
            else
            {
                $officeConfig[$key] = '';
            }
        }

        return $officeConfig;
    }


    /**
     * Save sugar_config with OfficeReports settings
     * @param array $config
     */
    static public function set_config($config)
    {
        global $sugar_config;

        foreach (self::$officeConfigFields as $key)
        {
            if (isset($config[$key]))
            {
                if (strtolower($config[$key]) == 'true') $config[$key] = true;
                if (strtolower($config[$key]) == 'false') $config[$key] = false;

                $sugar_config[$key] = $config[$key];
            }
            elseif (!isset($sugar_config[$key]))
            {
                $sugar_config[$key] = '';
            }
        }

        ksort($sugar_config);

        write_array_to_file('sugar_config', $sugar_config, 'config.php');
    }

    /**
     * When uninstall module delete our config
     */
    static public function del_config()
    {
        global $sugar_config;

        foreach (self::$officeConfigFields as $key)
        {
            if (isset($sugar_config[$key]))
            {
                unset($sugar_config[$key]);
            }
        }

        ksort($sugar_config);

        write_array_to_file('sugar_config', $sugar_config, 'config.php');

    }

    /**
     * Get list of modules which available for merge reports
     * @return array
     */
    static public function available_modules()
    {
        global $moduleList;
        $module_map = array();

        foreach($moduleList as $module)
        {
            $module_map[$module] = $module;
        }

        foreach (self::$ban_modules as $ban_mod)
        {
            if (isset($module_map[$ban_mod])) unset($module_map[$ban_mod]);
        }

        $config = Reports_Utils::get_config();
        if (is_array($config['officeDocxExcludeModules']) AND count($config['officeDocxExcludeModules'] >= 1))
        {
            foreach ($config['officeDocxExcludeModules'] as $dis_mod)
            {
                if (isset($module_map[$dis_mod])) unset($module_map[$dis_mod]);
            }
        }

        asort($module_map);
        return $module_map;
    }

    /**
     * Check extension file for possibility download as template
     * @param string $format
     * @return bool
     */
    static public function check_extension_template($format)
    {
        return in_array(strtoupper($format), self::$available_template_formats);
    }

    /**
     * Get list of formats which available for uploaded reports
     * @return array
     */
    static public function available_upload_template_formats()
    {
        return self::$available_template_formats;
    }

    /**
     * Check user access for generate report for current record module
     * @param string $module_name
     * @param string $id  record id for check access
     * @param $action
     * @return bool
     */
    static public function check_access_report($module_name, $id, $action)
    {
        if (self::$allowAccessForAll === TRUE)
            return TRUE;

        global $moduleList, $beanList, $beanFiles;

        if (!in_array($module_name, $moduleList))
        {
            return FALSE;
        }

        if (!isset($beanList[$module_name]))
        {
            return FALSE;
        }

        require_once $beanFiles[$beanList[$module_name]];
        $bean = new $beanList[$module_name];
        /** @var SugarBean $bean */
        $bean->retrieve($id);

        return self::check_acl_action($bean, $action);
    }

    /**
     * Check ACL access for action
     * @param SugarBean $bean
     * 	bean class for check access
     * @param string $action
     * 	acl action (read, write, edit, delete, export, import)
     * @return bool
     */
    static public function check_acl_action($bean, $action)
    {
        global $current_user, $beanList, $beanFiles;

        $is_owner = false;
        if(is_admin($current_user))
        {
            return TRUE;
        }

        $module_name = array_search($bean->object_name, $beanFiles);

        if(!empty($bean->assigned_user_id))
        {
            $is_owner = $current_user->id == $bean->assigned_user_id;
            if(!ACLController::moduleSupportsACL($module_name) || ACLController::checkAccess($module_name, $action, $is_owner))
            {
                return TRUE;
            }
        }

        return TRUE;
    }

    /**
     * Main function for generate report (generate value of fields for current record).
     * Return values of all fields in $fields_name array
     * @param SugarBean $bean
     * 	bean class for get value fields
     * @param array $fields_name
     *  array with name of fields (supported format ModuleName::FieldName or simple FieldName)
     * @return string[]
     *  array with keys - name of fields, values - value of this fields
     */
    static public function define_fields_value($bean, $fields_name)
    {
        global $beanList;

        $fields = array();

        if (empty($bean->id))
            return $fields;

        foreach ($fields_name as $key)
        {
            // in template can be reused variable, don't generate value again
            if (isset($fields[$key])) continue;

            /** it's value of related field */
            if (strpos($key, '.') !== FALSE)
            {
                list($module_name, $field_name) = explode('.', $key, 2);

                if (!isset($beanList[$module_name])) continue;

                if (!isset($fields[$module_name]))
                {
                    $fields[$module_name] = array();
                }

                require_once('modules/Relationships/RelationshipHandler.php');
                $rel_handler = new RelationshipHandler($bean->db, $bean->module_dir);
                $rel_handler->base_bean = &$bean;
                $rel_handler->process_by_rel_bean($module_name);

                foreach($bean->field_defs as $field => $attribute_array)
                {
                    if(!empty($attribute_array['relationship']) && $attribute_array['relationship'] == $rel_handler->rel1_relationship_name)
                    {
                        $rel_handler->base_vardef_field = $field;
                        break;
                    }
                }

                $rel_list = $rel_handler->build_related_list("base");

                if (empty($rel_list))
                {
                    $rel_list = self::searchOneToManyInOneModule($rel_handler);
                }

                if (!empty($rel_list[0]))
                {
                    foreach ($rel_list as $seed)
                    {
                        $value = self::getValueBean($seed, $field_name);

                        if (!isset($fields[$module_name][$seed->id]))
                        {
                            $fields[$module_name][$seed->id] = array();
                        }
                        $fields[$module_name][$seed->id][$field_name] = $value;
                    }
                }
                else
                {
                    $fields[$module_name][0][$field_name] = '';
                }
            }
            else
            {
                $value = self::getValueBean($bean, $key);
                $fields[$key] = $value;
            }

        }

        return $fields;
    }

    private static function searchOneToManyInOneModule($rel_handler)
    {
        $relates = array();
        $current_module_name = $rel_handler->base_module;
        $target_module_name = $rel_handler->rel1_module;
        $rel_array = $rel_handler->retrieve_by_sides($current_module_name, $target_module_name, $rel_handler->db);
        if ($rel_array['relationship_name'] == $rel_handler->rel1_relationship_name AND
            $rel_array['relationship_type'] == 'one-to-many' AND
                empty($rel_array['relationship_role_column']) AND
                    $rel_array['rhs_module'] == $target_module_name AND
                        $rel_array['lhs_module'] == $current_module_name)
        {
            $rel_handler->rel1_bean->retrieve($rel_handler->base_bean->$rel_array['lhs_key']);
            $relates[0] = $rel_handler->rel1_bean;
        }
        return $relates;
    }

    /**
     * Get value of bean class (well as support href_link, invite_link, non-db fields, special fields such as full_name)
     * @param SugarBean $bean
     * 	bean class for get value fields
     * @param string $key
     *  name of field
     * @return string
     * return value if field as string, if this field not exist return empty string
     */
    static public function getValueBean($bean, $key)
    {
        if ($key == 'href_link')
        {
            return self::getHrefLink($bean);
        }
        elseif ($key == 'invite_link')
        {
            return self::getInviteLink($bean);
        }
        elseif (strpos($key, self::$prefixReportField) !== FALSE)
        {
            return self::getReportCustomVariable($bean, $key);
        }
        else
        {
            return self::getStandartField($bean, $key);
        }
    }

    /**
     * Return href link to this bean
     * @param SugarBean $bean
     * @return string
     */
    static private function getHrefLink($bean)
    {
        global $sugar_config;

        $link = "{$sugar_config['site_url']}/index.php?module={$bean->module_dir}&record={$bean->id}&action=DetailView";
        return $link;
    }

    /**
     * Return link for accept invite to Meetings
     * @param SugarBean $bean
     * @return string
     */
    static private function getInviteLink($bean)
    {
        global $sugar_config;

        // invite link support only Meetings module
        if ($bean->module_dir != 'Meetings') return '';

        $link = "{$sugar_config['site_url']}/acceptDecline.php?module={$bean->module_dir}&record={$bean->id}&user_id=";
        return $link;
    }


    /**
     * Return value of Bean field
     * @param SugarBean $bean
     * @param string $field_name
     * @return string
     */
    static private function getStandartField($bean, $field_name)
    {
        global $app_list_strings, $mod_strings;
        global $timedate, $current_user;

        $field_value = '';

        if (isset($bean->$field_name))
        {
            $field_value = $bean->$field_name;
        }

        if (isset($bean->field_defs[$field_name]['type'])) //check for special type
        {
            if ($bean->field_defs[$field_name]['type'] == "relate")
            {
                if (!empty($bean->field_defs[$field_name]['dbType']))
                {
                    $target_type = $bean->field_defs[$field_name]['dbType'];
                }
                else
                {
                    return $field_value;
                }
            }
            else
            {
                $target_type = $bean->field_defs[$field_name]['type'];
            }

            if ($target_type == "assigned_user_name")
            {
                $user_array = get_user_array(TRUE, "Active", $field_value, true);
                return $user_array[$field_value];
            }

            elseif ($target_type == 'bool')
            {
                if ($field_value === true)
                    return $mod_strings['OTH_YES'];
                else
                    return $mod_strings['OTH_NO'];
            }

           /* elseif ($target_type == "datetime")
            {
                if (!empty($field_value))
                {
                    return $timedate->to_display_date_time($field_value, TRUE, TRUE, $current_user);
                }
                else
                {
                    return '';
                }
            }*/

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
                    return str_replace("^,^",", ",$field_value);
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

        if ($field_value == NULL) $field_value = '';

        return $field_value;
    }

    /**
     * Get value of internal office report variable
     * @param SugarBean $bean
     * @param string $key
     * 	name of office report variable
     * @return string
     * 	return result of execute code
     */
    static private function getReportCustomVariable($bean, $key)
    {
        $field_value = '';
        $key = substr($key, strlen(self::$prefixReportField));
        $seed = new OfficeReportVariable();
        $response = $seed->get_list("", $where = "{$seed->table_name}.name = '$key'", 0, 1);
        $list = $response['list'];
        if (count($list) > 0)
        {
            ob_start();
            try {
                $code = html_entity_decode($list[0]->code, ENT_QUOTES);
                eval($code);
            } catch(Exception $e) {
                return 'Error: '.$e->getMessage().'.';
            }

            $field_value = ob_get_contents();
            ob_end_clean();
        }
        if(isset($return_obj)) return $return_obj;
        else return $field_value;
    }

    /**
     * Return list of templates for module or all templates
     * @param string $module
     * @return SugarBean[]
     * return array with SugarBeans of OfficeReportMerge
     */
    static public function getListTemplate($module = NULL)
    {

        $seed = new OfficeReportMerge();
        if (!empty($module))
        {
            $where = "{$seed->table_name}.report_module = '$module'";
        }
        else
        {
            $where = '';
        }

        $template_objects = $seed->get_list("{$seed->table_name}.name ASC", $where);
        if (!empty($template_objects['list']))
        {
            return $template_objects['list'];
        }
        else
        {
            return array();
        }

    }

    /**
     * Send Email with attachment Report to specified emails
     * @param string $attachFileName
     *  name of report file
     * @param string $attachFilePath
     *  path to report file for read it and attach to email
     * @param array $toAddresses
     *  array with email and names of contacts for send him this email
     *  array( array('email' => EMAIL_ADDR, 'display' => DISPLAY_NAME) )
     * @param string $templateId
     *  optional argument. Id of Email template
     * @param SugarBean $bean
     * 	optional argument, uses for parse template with values of this bean
     * @return array
     * return array with status send email in this format: array('status' => TRUE_OR_FALSE, 'error' => ERROR_MSG)
     */
    static public function sendEmailTemplate($attachFileName, $attachFilePath, $toAddresses, $templateId = '', $bean = NULL)
    {
        global $locale, $current_user, $app_strings;

        $sea = new SugarEmailAddress();
        $answer = array('status' => true, 'error' => '');

        $email = new Email();
        $email->email2init();
        $email->type = 'out';
        $email->status = 'sent';
        $email->id = create_guid();
        $email->new_with_id = true;

        $emailTemplate = new EmailTemplate();
        $emailTemplate->retrieve($templateId);

        if (empty($emailTemplate->subject))
        {
            $emailTemplate->subject = $attachFileName; //set file name as subject
        }

        $email->name = $emailTemplate->subject;
        $email->description = $emailTemplate->body;
        $email->description_html = '&lt;html&gt;&lt;body&gt;' . $emailTemplate->body_html . '&lt;/body&gt;&lt;/html&gt;';

        $mail = new SugarPHPMailer();
        $mail = $email->setMailer($mail, '', '');

        if (empty($mail->Host))
        {
            if ($mail->oe->type == 'system')
                $answer['error'] = $app_strings['LBL_EMAIL_ERROR_PREPEND'] . $app_strings['LBL_EMAIL_INVALID_SYSTEM_OUTBOUND'];
            else
                $answer['error'] = $app_strings['LBL_EMAIL_ERROR_PREPEND'] . $app_strings['LBL_EMAIL_INVALID_PERSONAL_OUTBOUND'];

            $answer['status'] = false;
            return $answer;
        }


        $object_arr = array();

        if ($bean !== NULL)
            $object_arr[$bean->module_dir] = $bean->id;

        foreach($toAddresses as $addrMeta)
        {
            $addr = $addrMeta['email'];
            $beans = $sea->getBeansByEmailAddress($addr);
            foreach($beans as $bean)
            {
                if (!isset($object_arr[$bean->module_dir]))
                {
                    $object_arr[$bean->module_dir] = $bean->id;
                }
            }
        }

        $object_arr['Users'] = $current_user->id;

        $email->description_html = $email->decodeDuringSend(from_html(EmailTemplate::parse_template($email->description_html, $object_arr)));
        $email->description = $email->decodeDuringSend(html_entity_decode(EmailTemplate::parse_template($email->description, $object_arr), ENT_COMPAT, 'UTF-8'));
        $email->name = from_html(EmailTemplate::parse_template($email->name, $object_arr));

        $mail->Body = $email->description_html;
        $mail->AltBody = $email->description;
        $mail->Subject = $email->name;

        $replyToAddress = $current_user->emailAddress->getReplyToAddress($current_user);
        $defaults = $current_user->getPreferredEmail();
        $mail->From = $defaults['email'];
        $mail->FromName = $defaults['name'];
        $mail->Sender = $mail->From; /* set Return-Path field in header to reduce spam score in emails sent via Sugar's Email module */
        $replyToName = $mail->FromName;

        $OBCharset = $locale->getPrecedentPreference('default_email_charset');
        if (!empty($replyToAddress))
        {
            $mail->AddReplyTo($replyToAddress, $locale->translateCharsetMIME(trim($replyToName), 'UTF-8', $OBCharset));
        }
        else
        {
            $mail->AddReplyTo($mail->From, $locale->translateCharsetMIME(trim($mail->FromName), 'UTF-8', $OBCharset));
        }

        foreach ($toAddresses as $addr_arr)
        {
            if(empty($addr_arr['email'])) continue;

            if(empty($addr_arr['display']))
            {
                $mail->AddAddress($addr_arr['email'], "");
            }
            else
            {
                $mail->AddAddress($addr_arr['email'], $locale->translateCharsetMIME(trim($addr_arr['display']), 'UTF-8', $OBCharset));
            }
        }

        $mail->AddAttachment($attachFilePath, $attachFileName, 'base64', self::getMimeType($attachFileName));

        $mail->prepForOutbound();
        $mail->Body = $email->decodeDuringSend($mail->Body);
        $mail->AltBody = $email->decodeDuringSend($mail->AltBody);

        if (!$mail->Send())
        {
            ob_clean();
            $answer['error'] = $app_strings['LBL_EMAIL_ERROR_PREPEND'] . $mail->ErrorInfo;
            $answer['status'] = false;
            return $answer;
        }

        //TODO check settings if email need save, save $email bean class

        return $answer;

    }


    /** @var array with some uses mime types. More types in http://www.sfsu.edu/training/mimetype.htm */
    static public $extMimeTypes = array(
        'txt' => 'text/plain',
        'htm' => 'text/html',
        'html' => 'text/html',
        'xml' => 'application/xml',
        'pdf' => 'application/pdf',
        'doc' => 'application/msword',
        'docx' => 'application/msword',
        'rtf' => 'application/rtf',
        'xls' => 'application/vnd.ms-excel',
        'ppt' => 'application/vnd.ms-powerpoint',
        'odt' => 'application/vnd.oasis.opendocument.text',
        'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
    );

    /**
     * Get mime types of file if function mime_content_type dont exist or not recognize type
     * @param string $filename
     * @return string
     * 	return mime type of file
     */
    static public function getMimeType($filename)
    {
        if(function_exists('mime_content_type'))
        {
            $mime = mime_content_type($filename);
        }
        elseif(function_exists('ext2mime'))
        {
            $mime = ext2mime($filename);
        }

        if (empty($mime))
        {
            $ext = strtolower(array_pop(explode('.', $filename)));
            if (array_key_exists($ext, self::$extMimeTypes))
            {
                $mime = self::$extMimeTypes[$ext];
            }
            else
            {
                $mime = 'application/octet-stream';
            }
        }

        return $mime;
    }


    /**
     * Get list of related module for $module_name
     * @param string $module_name
     * @return array
     * 	return list of related module. Array keys - system modules name, array values - translated modules name
     */
    static public function getRelatedModules($module_name)
    {
        require_once 'include/VarDefHandler/VarDefHandler.php';

        global $beanList, $app_list_strings;

        $seed = new $beanList[$module_name];

        $options_array = array();

        foreach($seed->field_defs as $key => $value_array)
        {
            if($value_array['type'] == 'link')
            {
                $name = $value_array['name'];
                $seed->load_relationship($name);

                if (!isset($seed->$name)) continue;
                if (!method_exists($seed->$name, 'getRelatedModuleName')) continue;

                $relate_module = $seed->$name->getRelatedModuleName();

                if(!empty($app_list_strings['moduleList'][$relate_module]))
                {
                    $label = $app_list_strings['moduleList'][$relate_module];
                }
                else
                {
                    $label = $relate_module;
                }

                $label = trim($label, ':');

                if (!isset($options_array[$relate_module])) $options_array[$relate_module] = $label;
            }
        }

        $options_array = convert_module_to_singular($options_array);

        return $options_array;
    }

    /** @var array with excluded types. This special types withou values, such as link, relate and other */
    protected static $exclude_var_types = array('link', ); //'relate'); @todo analyze and exclude needed type fields

    /**
     * Get field for $module_name
     * Excludes some fields type as link, relate and other
     * @param string $module_name
     * @return array
     */
    static public function getModuleFields($module_name)
    {
        global $beanList, $current_language;

        $seed = new $beanList[$module_name];

        $options_array = array();

        $module_strings = return_module_language($current_language, $seed->module_dir);

        foreach ($seed->field_defs as $value_array)
        {
            if (!in_array($value_array['type'], self::$exclude_var_types))
            {
                if (!empty($value_array['vname']))
                {
                    $label_tag = $value_array['vname'];
                }
                else
                {
                    $label_tag = $value_array['name'];
                }

                $label = get_label($label_tag, $module_strings);
                $label = trim($label, ':');

                if (!isset($options_array[$value_array['name']])) $options_array[$value_array['name']] = $label;

            }
        }

        $options_array = array_merge($options_array, self::add_extra_types($module_name));
        return $options_array;
    }

    /**
     * Get custom (users) report field for $module_name
     * @param string $module_name
     * @return array
     */
    static public function getReportCustomFields($module_name)
    {
        $options_array = array();

        $seed = new OfficeReportVariable();
        $response = $seed->get_list($order_by = "{$seed->table_name}.friendly_name ASC", $where = "{$seed->table_name}.for_modules LIKE '%^$module_name^%'");
        $list = $response['list'];
        if (count($list) > 0)
        {
            foreach ($list as $focus)
            {
                $name = self::$prefixReportField . $focus->name;
                $options_array[$name] = $focus->friendly_name;
            }
        }

        return $options_array;
    }

    /**
     * Translate system field back to label
     * @static
     * @param string $field_name
     * @param string $module_name
     * @param mixed|bool $moduleToLabel
     * @return string
     */
    static public function translateField($field_name, $module_name = '', $moduleToLabel = null)
    {
        global $beanList, $current_language;

        if (strpos($field_name, '.') !== false)
        {
            $field_name = explode('.', $field_name, 2);
            $module_name = $field_name[0];
            $field_name = $field_name[1];

            if ($moduleToLabel === null) $moduleToLabel = true;
        }

        if (isset($beanList[$module_name]))
        {
            $seed = new $beanList[$module_name];

            $module_strings = return_module_language($current_language, $seed->module_dir);

            foreach ($seed->field_defs as $value_array)
            {
                if (!in_array($value_array['type'], self::$exclude_var_types))
                {
                    if ($value_array['name'] == $field_name)
                    {
                        if (!empty($value_array['vname']))
                        {
                            $label_tag = $value_array['vname'];
                        }
                        else
                        {
                            $label_tag = $value_array['name'];
                        }

                        $label = get_label($label_tag, $module_strings);
                        $label = trim($label, ':');

                        if ($moduleToLabel)
                            $label = $module_name . '::' . $label;

                        return $label;
                    }

                }
            }
        }

        if ($moduleToLabel)
            $label = $module_name . '::' . $label;
        return $field_name;
    }

    /**
     * Add some special fields type, which don't isset in core sugar
     * but recognized OfficeReport module
     * such as invite_link, href_link - exactly the same as in email template module
     * @param string $module_name
     * @return array
     */
    static private function add_extra_types($module_name)
    {
        global $mod_strings;

        $ext_types = array();

        if($module_name == 'Meetings' || $module_name == 'Calls' )
        {
            $ext_types['invite_link'] = $mod_strings['LBL_INVITE_LINK'];
        }

        $ext_types['href_link'] = $mod_strings['LBL_LINK_RECORD'];

        return $ext_types;
    }

    static public function create_cache_directory($file)
    {
        $paths = explode('/',$file);
        $dir = 'cache';
        if(!file_exists($dir))
        {
            sugar_mkdir($dir, 0755);
        }
        for($i = 0; $i < sizeof($paths) - 1; $i++)
        {
            $dir .= '/' . $paths[$i];
            if(!file_exists($dir))
            {
                sugar_mkdir($dir, 0755);
            }
        }
        return $dir . '/'. $paths[sizeof($paths) - 1];
    }

    /**
     * get array with reserved keys (Used for field name which must not be an SQL keyword)
     * @return string[]
     */
    static public function getNameException()
    {
        // this array from /modules/ModuleBuilder/views/view.modulefield.php
        $field_name_exceptions = array(
            //Taken from SQL Server's list of reserved keywords; http://msdn.microsoft.com/en-us/library/aa238507(SQL.80).aspx
            'ADD','EXCEPT','PERCENT','ALL','EXEC','PLAN','ALTER','EXECUTE','PRECISION','AND','EXISTS','PRIMARY',
            'ANY','EXIT','PRINT','AS','FETCH','PROC','ASC','FILE','PROCEDURE','AUTHORIZATION','FILLFACTOR','PUBLIC',
            'BACKUP','FOR','RAISERROR','BEGIN','FOREIGN','READ','BETWEEN','FREETEXT','READTEXT','BREAK','FREETEXTTABLE',
            'RECONFIGURE','BROWSE','FROM','REFERENCES','BULK','FULL','REPLICATION','BY','FUNCTION','RESTORE',
            'CASCADE','GOTO','RESTRICT','CASE','GRANT','RETURN','CHECK','GROUP','REVOKE','CHECKPOINT','HAVING','RIGHT','CLOSE',
            'HOLDLOCK','ROLLBACK','CLUSTERED','IDENTITY','ROWCOUNT','COALESCE','IDENTITY_INSERT','ROWGUIDCOL','COLLATE','IDENTITYCOL',
            'RULE','COLUMN','IF','SAVE','COMMIT','IN','SCHEMA','COMPUTE','INDEX','SELECT','CONSTRAINT','INNER','SESSION_USER',
            'CONTAINS','INSERT','SET','CONTAINSTABLE','INTERSECT','SETUSER','CONTINUE','INTO','SHUTDOWN','CONVERT','IS','SOME',
            'CREATE','JOIN','STATISTICS','CROSS','KEY','SYSTEM_USER','CURRENT','KILL','TABLE','CURRENT_DATE','LEFT','TEXTSIZE',
            'CURRENT_TIME','LIKE','THEN','CURRENT_TIMESTAMP','LINENO','TO','CURRENT_USER','LOAD','TOP','CURSOR','NATIONAL','TRAN',
            'DATABASE','NOCHECK','TRANSACTION','DBCC','NONCLUSTERED','TRIGGER','DEALLOCATE','NOT','TRUNCATE','DECLARE','NULL','TSEQUAL',
            'DEFAULT','NULLIF','UNION','DELETE','OF','UNIQUE','DENY','OFF','UPDATE','DESC','OFFSETS','UPDATETEXT',
            'DISK','ON','USE','DISTINCT','OPEN','USER','DISTRIBUTED','OPENCONNECTOR','VALUES','DOUBLE','OPENQUERY','VARYING',
            'DROP','OPENROWSET','VIEW','DUMMY','OPENXML','WAITFOR','DUMP','OPTION','WHEN','ELSE','OR','WHERE',
            'END','ORDER','WHILE','ERRLVL','OUTER','WITH','ESCAPE','OVER','WRITETEXT',
            //Mysql Keywords from http://dev.mysql.com/doc/refman/5.0/en/reserved-words.html (those not in MSSQL's list)
            'ANALYZE', 'ASENSITIVE', 'BEFORE', 'BIGINT', 'BINARY', 'BOTH', 'CALL', 'CHANGE', 'CHARACTER',
            'CONDITION', 'DATABASES', 'DAY_HOUR', 'DAY_MICROSECOND', 'DAY_MINUTE', 'DAY_SECOND', 'DEC', 'DECIMAL', 'DELAYED',
            'DESCRIBE', 'DETERMINISTIC', 'DISTINCTROW', 'DIV', 'DUAL', 'EACH', 'ELSEIF', 'ENCLOSED', 'ESCAPED', 'EXPLAIN',
            'FALSE', 'FLOAT', 'FLOAT4', 'FLOAT8', 'FORCE', 'FULLTEXT', 'HIGH_PRIORITY', 'HOUR_MICROSECOND', 'HOUR_MINUTE',
            'HOUR_SECOND', 'IGNORE', 'INFILE', 'INOUT', 'INSENSITIVE', 'INT', 'INT1', 'INT2', 'INT3', 'INT4', 'INT8',
            'INTEGER', 'ITERATE', 'KEYS', 'LEADING', 'LEAVE', 'LIMIT', 'LINES', 'LOCALTIME', 'LOCALTIMESTAMP', 'LOCK',
            'LONGBLOB', 'LONGTEXT', 'LOOP', 'LOW_PRIORITY', 'MATCH', 'MEDIUMBLOB', 'MEDIUMINT', 'MEDIUMTEXT', 'MIDDLEINT',
            'MINUTE_MICROSECOND', 'MINUTE_SECOND', 'MOD', 'MODIFIES', 'NATURAL', 'NO_WRITE_TO_BINLOG', 'NUMERIC', 'OPTIMIZE',
            'OPTIONALLY', 'OUT', 'OUTFILE', 'PURGE', 'READS', 'REAL', 'REGEXP', 'RELEASE', 'RENAME', 'REPEAT', 'REPLACE',
            'REQUIRE', 'RLIKE', 'SCHEMAS', 'SECOND_MICROSECOND', 'SENSITIVE', 'SEPARATOR', 'SHOW', 'SMALLINT', 'SONAME',
            'SPATIAL', 'SPECIFIC', 'SQL', 'SQLEXCEPTION', 'SQLSTATE', 'SQLWARNING', 'SQL_BIG_RESULT', 'SQL_CALC_FOUND_ROWS',
            'SQL_SMALL_RESULT', 'SSL', 'STARTING', 'STRAIGHT_JOIN', 'TERMINATED', 'TINYBLOB', 'TINYINT', 'TINYTEXT',
            'TRAILING', 'TRUE', 'UNDO', 'UNLOCK', 'UNSIGNED', 'USAGE', 'USING', 'UTC_DATE', 'UTC_TIME', 'UTC_TIMESTAMP',
            'VARBINARY', 'VARCHARACTER', 'WRITE', 'XOR', 'YEAR_MONTH', 'ZEROFILL', 'CONNECTION', 'LABEL', 'UPGRADE',
            //Oracle datatypes
            'DATE','VARCHAR','VARCHAR2','NVARCHAR2','CHAR','NCHAR','NUMBER','PLS_INTEGER','BINARY_INTEGER','LONG','TIMESTAMP',
            'INTERVAL','RAW','ROWID','UROWID','MLSLABEL','CLOB','NCLOB','BLOB','BFILE','XMLTYPE',
            //SugarCRM reserved
            'ID', 'ID_C',
        );

        return $field_name_exceptions;
    }


}

?>

<?php
/*
*	Created by Kolerts
*/

class kXMLAction {
    var $strings=array();
    function addCustomButtonAction()
    {
        global $sugar_config, $current_user;
        global $current_language;
        $path="custom/kXML/language/{$current_language}.php";
        if(!file_exists($path))
            $path="custom/kXML/language/en_en.php";
        if(file_exists($path))
        {
            include_once($path);
            $this->strings=$kxml_strings;
        }

        $seed = BeanFactory::getBean($_REQUEST['module']);
        if(is_subclass_of($seed, "SugarBean")) {
            if($seed->bean_implements('ACL')) {
                if(!ACLController::checkAccess($seed->module_dir,'export',true)) {
                    $sugar_config['disable_export']= true;
                }
            }
        }

        if(($_REQUEST['action'] == "ListView" || $_REQUEST['action'] == "index")
            /* && $_REQUEST['module'] != "Home"
             && $_REQUEST['module'] != "Administration"
             && $_REQUEST['module'] != "Import"
             && $_REQUEST['module'] != "Calendar"*/
            && $_REQUEST['module'] == "Realty"
            && $sugar_config['disable_export'] !== true
            && ($sugar_config['admin_export_only'] == false || ($sugar_config['admin_export_only'] == true && $current_user->is_admin))
        )
        {
            $templates='';
            $path="custom/kXML/templates/{$_REQUEST['module']}";


            if(file_exists($path))
            {
                $dir=opendir($path);
                while ($template = readdir($dir))
                {

                    if ($template!="." && $template!="..")
                    {

                        //$files_url="custom/kXML/replacers/{$_REQUEST['module']}"."/".$this->translate($template).".php";
                        //include($files_url);


                        $template_url="{$sugar_config['site_url']}/custom/kXML/xml/{$_REQUEST['module']}/{$template}.xml";
                        $templates.="
						<tr class='oddListRowS1'>";
                        if(isset($url))
                            $templates.="<td><a href='{$url}' target='blank'>{$url_name}</td>
";
                        if(!isset($url))
                            $templates.="<td>".$this->translate($template)."</td>";
                        if($current_user->is_admin)
                            $templates.="<td><a href='{$template_url}' target='blank'>{$template_url}</td>
";
                        $templates.="<td style='text-align:right;'>";
                        if($current_user->is_admin){
                            $templates.="<img  style='display:none' align='left' border='0' id='img_2_sa' src='themes/default/images/img_loading.gif'/>&nbsp;&nbsp<img id='buton_img_sa' onclick='generate_xml(this, \"{$_REQUEST['module']}\", \"{$template}\", 0);' src='themes/default/images/Rebuild.gif' alt='Сгенерировать' title='Сгенерировать' border='0' style='cursor:pointer' />";}

                        if(!$current_user->is_admin)
                            $templates.="<button id='buton_sa' onclick='generate_xml(this, \"{$_REQUEST['module']}\", \"{$template}\", 0);this.disabled=true;'>Создать</button><img style='display:none' id='img_sa' src='themes/default/images/img_loading.gif'/>";
                        if($current_user->is_admin)
                            $templates.="<img onclick='detail_xml(\"{$_REQUEST['module']}\", \"{$template}\", 0)' src='themes/default/images/info_inline.gif' alt='Детали' title='Детали' border='0' style='cursor:pointer' />&nbsp;&nbsp;
							<div onclick='this.style.display=\"none\";' id='detail_{$template}' class='xmlDetail'></div>
								<img onclick='view_log(\"{$_REQUEST['module']}\", \"{$template}\", 0)' src='themes/default/images/view_inline.gif' alt='Лог' title='Лог' border='0' style='cursor:pointer' />&nbsp;&nbsp;<img onclick='edit_xml(\"{$_REQUEST['module']}\", \"{$template}\")' src='themes/default/images/edit_inline.gif' alt='Редактировать' title='Редактировать' border='0' style='cursor:pointer' />&nbsp;&nbsp;";
                        if($current_user->is_admin)
                            $templates.="<img onclick='delete_xml(\"{$_REQUEST['module']}\", \"{$template}\")' src='themes/default/images/close_inline.gif' alt='Удалить' title='Удалить' border='0' style='cursor:pointer' />&nbsp;&nbsp;";
                        if($current_user->is_admin)
                            $templates.="</td><td style='text-align:center;'>";
                        if($current_user->is_admin)
                            $templates.="
								<img onclick='edit_tpl(\"{$_REQUEST['module']}\", \"{$template}\")' src='themes/default/images/edit_inline.gif' alt='Редактировать' title='Редактировать' border='0' style='cursor:pointer' />&nbsp;&nbsp;";
                        if($current_user->is_admin)
                            $templates.="
								<img onclick='delete_tpl(\"{$_REQUEST['module']}\", \"{$template}\")' src='themes/default/images/close_inline.gif' alt='Удалить' title='Удалить' border='0' style='cursor:pointer' />&nbsp;&nbsp;";
                        if($current_user->is_admin)
                            $templates.="
							</td>";
                        $templates.="</tr>";
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
                        $template=str_replace('.php','',$template_file);
///////////////////////////////////////////
                        if ($template=='baza-winner.ru'){

                            $template_url="{$sugar_config['site_url']}/custom/kXML/xml/{$_REQUEST['module']}/baza/";
                            $templates.="
                            <tr class='oddListRowS1'>
                                <td><a href='http://".$this->translate($template)."', target='_blank'>".$this->translate($template)."</a></td>";
                            $templates.="
                                <td><a href='{$template_url}' target='blank'>{$template_url}</td>
                                <td>
    <img onclick='generate_xml(this, \"{$_REQUEST['module']}\", \"{$template_file}\", 1)' src='themes/default/images/Rebuild.gif' alt='Сгенерировать' title='Сгенерировать' border='0' style='cursor:pointer' />&nbsp;&nbsp;
                                    <img onclick='detail_xml(\"{$_REQUEST['module']}\", \"{$template}\", 1)' src='themes/default/images/info_inline.gif' alt='Детали' title='Детали' border='0' style='cursor:pointer' />
                                        <div onclick='this.style.display=\"none\";' id='detail_{$template}' class='xmlDetail'></div>&nbsp;&nbsp;";
                            if($current_user->is_admin)
                                $templates.="
                                        <img onclick='delete_xml(\"{$_REQUEST['module']}\", \"{$template_file}\")' src='themes/default/images/delete_inline.gif' alt='Удалить' title='Удалить' border='0' style='cursor:pointer' />&nbsp;&nbsp;";
                            $templates.="</td>
                                <td></td>
                                </tr>";



                            $handle = opendir("custom/kXML/xml/{$_REQUEST['module']}/baza/");

                            while ($file = readdir($handle)) {
                                if ($file != "." && $file != "..") {
                                    $template_url="{$sugar_config['site_url']}/custom/kXML/xml/{$_REQUEST['module']}/baza/".$file;
                                    $file_del = str_replace('.xml','',$file);
                                    $templates.="
                                <tr class='oddListRowS1'>
                                <td></td>
                                <td><a href='{$template_url}' target='blank'>{$template_url}</td>
                                <td>
    <img onclick='generate_xml(this, \"{$_REQUEST['module']}\", \"{$template_file}\", 1)' src='themes/default/images/Rebuild.gif' alt='Сгенерировать' title='Сгенерировать' border='0' style='cursor:pointer' />&nbsp;&nbsp;
                                    <img onclick='detail_xml(\"{$_REQUEST['module']}/baza\", \"{$file_del}\", 1)' src='themes/default/images/info_inline.gif' alt='Детали' title='Детали' border='0' style='cursor:pointer' />
                                        <div onclick='this.style.display=\"none\";' id='detail_{$file_del}' class='xmlDetail'></div>&nbsp;&nbsp;";
                                    if($current_user->is_admin)
                                        $templates.="
                                        <img onclick='delete_xml(\"{$_REQUEST['module']}/baza\", \"{$file_del}\")' src='themes/default/images/delete_inline.gif' alt='Удалить' title='Удалить' border='0' style='cursor:pointer' />&nbsp;&nbsp;";

                                    $templates.="</td>
                                <td></td>
                                </tr>";
                                }
                            }


////////////////////////////////////
                        }else{
                            $template_url="{$sugar_config['site_url']}/custom/kXML/xml/{$_REQUEST['module']}/{$template}.xml";
                            $templates.="
                            <tr class='oddListRowS1'>
                                <td>".$this->translate($template)."</td>
                                <td><a href='{$template_url}' target='blank'>{$template_url}</td>
                                <td>
    <img onclick='generate_xml(this, \"{$_REQUEST['module']}\", \"{$template_file}\", 1)' src='themes/default/images/Rebuild.gif' alt='Сгенерировать' title='Сгенерировать' border='0' style='cursor:pointer' />&nbsp;&nbsp;
                                    <img onclick='detail_xml(\"{$_REQUEST['module']}\", \"{$template}\", 1)' src='themes/default/images/info_inline.gif' alt='Детали' title='Детали' border='0' style='cursor:pointer' />
                                        <div onclick='this.style.display=\"none\";' id='detail_{$template}' class='xmlDetail'></div>&nbsp;&nbsp;";
                            if($current_user->is_admin)
                                $templates.="
                                        <img onclick='delete_xml(\"{$_REQUEST['module']}\", \"{$template_file}\")' src='themes/default/images/delete_inline.gif' alt='Удалить' title='Удалить' border='0' style='cursor:pointer' />&nbsp;&nbsp;";
                            $templates.="</td>
                                <td></td>
                                </tr>";
                        }
                    }
                }
            }

            $html = "
				<script src='modules/kXML/js/add_button.js'></script>
				<script src='modules/kXML/js/send_post.js'></script>
				<link rel='stylesheet' type='text/css' href='modules/kXML/css/menu.css'>

				<div id='xmlMenu' class='xmlMenu'>
					<p align='right'><img onclick='$(\"#xmlMenu\").hide();' src='themes/default/images/close_inline.gif' alt='Закрыть' title='Закрыть' border='0' style='cursor:pointer' /></p>
					<h3>Доски объявлений</h3><br/>";
            if($current_user->is_admin)
                $html.="<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>";
            if(!$current_user->is_admin)
                $html.="<table cellpadding='0' cellspacing='0' width='300px' border='0' class='list view'>";
            if($current_user->is_admin)
                $html.= "<th scope='col' style='width:100px;text-align:center;'>
								Название доски
							</th>
							<th scope='col' style='width:auto;text-align:center;'>
								Ссылка на сгенерированный XML
							</th>
							<th scope='col' style='width:120px;text-align:center;'>
								Файл XML
							</th>
							<th scope='col' style='width:40px;text-align:center;'>
								Шаблон
							</th>";
            //{$templates}
            $html.= $templates."</table>";
            if($current_user->is_admin)
                $html.="
					<button style='width:100%' onclick='window.location=\"index.php?module=kXML&action=index&return_module={$_REQUEST['module']}\";'>Создать новый шаблон</button>";
            $html.="
				</div>
			";
            echo $html;
        }
    }
    function translate($text)
    {
        $text=str_replace('.php', '',$text);
        if(isset($this->strings[$text]))
            return $this->strings[$text];
        else
            return $text;
    }
}

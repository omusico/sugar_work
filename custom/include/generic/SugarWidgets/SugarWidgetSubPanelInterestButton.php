<?php

class SugarWidgetSubPanelInterestButton extends SugarWidgetField
{

    function displayList(&$layout_def)
    {

        global $app_strings;
        global $subpanel_item_count;

        $refresh_page = 1;//выставляем перезагрузку страницы иначе шапка шуги будет висеть в субпанели
        if(!empty($layout_def['refresh_page']))
        {
            $refresh_page = 1;
        }

        $unique_id = $layout_def['subpanel_id']."_save_".$subpanel_item_count; //bug 51512

        /*$request = new Request();
        $request->retrieve($_REQUEST['record']);*/

        $parent_record_id = $_REQUEST['record']; //id записи карточки
        $parent_module = $_REQUEST['module']; //модуль в котором лежит этот id-шник
        $record = $layout_def['fields']['ID']; //id каждой записи в субпанели
        $record_module = $layout_def['module']; // модуль этой записи
        $name_record = $layout_def['fields']['NAME'];//имя записи            

        $return_module = $_REQUEST['module'];
        $return_action = 'SubPanelViewer';          
        $subpanel = $layout_def['subpanel_id'];
        $return_id = $_REQUEST['record'];


        if($parent_module == 'Realty') 
        {
            $textbutton = 'Закрепить';
        }
        else 
        {
            $textbutton = 'Интересует!';
        }

        if (isset($layout_def['linked_field_set']) && !empty($layout_def['linked_field_set'])) 
        {
            $linked_field= $layout_def['linked_field_set'] ;
        } 
        else 
        {
            $linked_field = $layout_def['linked_field'];
        }

        $return_url = "index.php?module=$return_module&action=$return_action&subpanel=$subpanel&record=$return_id&sugar_body_only=1&inline=1";

        $icon_remove_text = strtolower($app_strings['LBL_ID_FF_REMOVE']);

        if($linked_field == 'get_emails_by_assign_or_link')
           $linked_field = 'emails';
        if($layout_def['ListView']) 
        {
			$json_data = json_encode(array(
				'subpanel'			=> $subpanel,
				'record'			=> $record,
				'parent_record_id'	=> $parent_record_id,
				'record_module'		=> $record_module,
				'parent_module'		=> $parent_module));
			$retStr = "<a 
					  href=\"javascript:ajaxButton('$subpanel', '$record', '$parent_record_id', '$record_module', '$parent_module', true);\"" 
					  . ' class="listViewTdToolsS1"'
					  . "id=$unique_id"
					  . " onclick=\"return inform('".$name_record."', '$parent_module', '$record_module');\""
					  . ">$textbutton
				  </a> <input type='checkbox' class='interest_but' value='{$json_data}' />";

            return $retStr;

        }

        else
        {
            return '';
        }
    }
}


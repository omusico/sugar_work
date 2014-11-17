<?php
/*
*	Created by Kolerts
*/

function echo_modules()
{
	$disabled=(isset($_GET['record'])) ? 'disabled=disabled' : '';
	global $app_list_strings;
	asort($app_list_strings['moduleList']);
	echo "<table><tr>";
	echo "<td>Выберите модуль:</td><td><select id='tpl_module' {$disabled}>";
	foreach($app_list_strings['moduleList'] as $module=>$name)
	{
		if(!in_array($module, array(
			'Home', 'Sugar_Favorites', 'SNIP', 'FAQ', 'KBDocuments', 'Library', 'Feeds', 'TaxRates', 'TrackerPerfs', 'Administration', 'Currencies', 'OAuthTokens',
			'Releases', 'DocumentRevisions', 'TrackerQueries', 'SugarFavorites', 'Calendar', 'OAuthKeys', 'SugarFeed', 'Newsletters', 'TrackerSessions',
			'UpgradeWizard', 'iFrames', 'SavedSearch', 'Bugs', 'Schedulers', 'ACLRoles', 'Roles', 'Sync', 'Trackers', 'EmailTemplates', 'CampaignLog',
			'OfficeReportsVariables', 'OfficeReportsHistory',
		)))
		{
			$selected=(isset($_GET['return_module']) && $_GET['return_module']==$module) ? 'selected=true' : '';
			echo"<option value='{$module}' {$selected}>{$name}</option>";
		}
	}
	echo"</select></td>";
	
	echo"		<td>Введите название шаблона:</td>
		<td><input type='text' id='tpl_name' value='{$_GET['record']}' {$disabled} /></td>";
	echo"</tr><tr>";
	echo"<td>Элемент с ID записи:</td>
		<td><input type='text' id='tpl_s_name' value=''/></td>";
	echo"<td>Текст ID записи:</td>
		<td><input type='text' id='tpl_s_text' value=''/></td>";
	echo"</tr><tr>";
	echo"<td>Пользовательский поиск:</td>
		<td><input type='checkbox' id='tpl_s_custom'/></td>";
	echo"<td>Кодировка:</td>
		<td><input type='text' id='tpl_encoding' value='UTF-8'/></td>";
	echo"</tr></table>";
}
function echo_description()
{
	echo "<b>Специальные символы:</b> <br/>";
	echo "$ - для вставки переменной;<br/>";
	echo "* - для использования поля модуля;<br/>";
	echo "@ - для вставки пользовательского кода;<br/>";

	$module=isset($_REQUEST['return_module'])?$_REQUEST['return_module']:'Realty';
	echo_module_fields($module);
}
function echo_module_fields($module)
{
	global $current_language, $app_list_strings;
	$bean=loadBean($module);
	$mod_strings = return_module_language($current_language, $bean->module_dir);
	echo "<div class='container' style='font-size:110%;'><center style='font-weight:bold;'>Поля модуля {$app_list_strings['moduleList'][$module]}:</center>
		<br/><table style='width:100%;font-size:100%;'>";
	foreach($bean->field_defs as $field)
		echo "<tr><td style='background-color:#596971;color:#fff;text-align:right;padding-right:5px;' width='60%'>
			<b>{$mod_strings[$field['vname']]}</b> [{$field['type']}]:</td>
		<td style='background-color:#FFF'>
			{$field['name']}</td></tr>";
	echo "</table></div>";
}
function add2log($module, $template, $action){
	global $current_user, $timedate, $db;
	$_MAX_LOG_ROWS_FOR_TEMPLATE_ = 20;
	
	$date = $timedate->nowDB();
	$user_id = $current_user->id;
	$user_name = $current_user->full_name;
	$sql_insert="INSERT INTO kxml_log
		(`date`,`module`,`template`,`action`,`user_id`,`user_name`) VALUES('{$date}','{$module}','{$template}','{$action}','{$user_id}','{$user_name}')";
		
	$sql_check="SELECT id FROM kxml_log WHERE `module`='{$module}' AND `template`='{$template}'";
	
	$db->query($sql_insert);
	$num_row = $db->getRowCount($db->query($sql_check));
	if($num_row>$_MAX_LOG_ROWS_FOR_TEMPLATE_){
		$sql_truncate="DELETE FROM kxml_log WHERE `module`='{$module}' AND `template`='{$template}' ORDER BY `date` ASC LIMIT ".($num_row-$_MAX_LOG_ROWS_FOR_TEMPLATE_);
		$db->query($sql_truncate);
	}
}
?>

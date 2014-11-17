<?php
/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 * Upgraded By Kolerts
 */
class UpdateListView
{
	function addCustomButton()
	{
		require_once('custom/modules/XlsExport/utils.php');
		
		global $sugar_config, $current_user;
		$seed = BeanFactory::getBean($_REQUEST['module']);
		if(is_subclass_of($seed, 'SugarBean')) {
			if($seed->bean_implements('ACL')) {
				if(!ACLController::checkAccess($seed->module_dir,'export',true)) {
					$sugar_config['disable_export']= true;
				}
			}
		}

		if(($_REQUEST['action'] == 'ListView' || $_REQUEST['action'] == 'index') &&
			!in_array($_REQUEST['module'], array(
				'Home',
				'Administration',
				'Import',
				'Calendar',
			)) &&
			$sugar_config['disable_export'] !== true &&
			(
				$sugar_config['admin_export_only'] == false ||
				($sugar_config['admin_export_only'] == true && $current_user->is_admin)
			)
		){
			$field_list = XlsExUtils::get_field_list($_REQUEST['module']); // Получаем список всех полей, текущего модуля
			$rel_array = XlsExUtils::get_related($_REQUEST['module']); // Получаем список связанных модулей(субпанели), текущего модуля
			$ln_array = XlsExUtils::get_linked($_REQUEST['module']); // Получаем список связанных модулей, текущего модуля
			// echo '<pre>';
			// print_r($rel_array);
			// echo '</pre>';
			// echo '<hr/><pre>';
			// print_r($ln_array);
			// echo '</pre>'; 
			
			$options = "";
			$rel_options = "<option value=''></option>";
			$ln_options = "<option value=''></option>";

			if (count($field_list) > 0){
				foreach ($field_list as $field){
					$options .= "<option value='{$field['name']}'>{$field['label']}</option>"; // Подготавливаем options для мультиселекта
				}
			}
			if (count($rel_array) > 0){
				foreach ($rel_array as $data){
					$label = XlsExUtils::mod_translate($data['rhs_module']);
					$ext_where = (isset($data['relationship_role_column']))?"{$data['relationship_role_column']}|{$data['relationship_role_column_value']}":'';
					$rel_options .= "<option value='{$data['rhs_module']}' data-table='{$data['rhs_table']}' data-key='{$data['rhs_key']}' data-ext_where='{$ext_where}'>{$label}</option>"; // Подготавливаем options для мультиселекта
				}
			}
			if (count($ln_array) > 0){
				foreach ($ln_array as $data){
					$ln_options .= "<option value='{$data['module']}' data-rel='{$data['rel']}' data-type='{$data['type']}'>{$data['label']}</option>"; // Подготавливаем options для мультиселекта
				}
			}

			 $description_message = "Для того, чтобы начать работу по экспорту данных, Вам необходимо
								выбрать необходимые поля из колонки 'Доступные поля' и переместить их
								 в колонку 'Поля для экспорта'. Далее, Вы можете выставить порядок полей,
								 путем нажатия кнопок 'вверх' и 'вниз', которые располагаются справа от колонки
								 'Поля для экспорта'. По окончанию всех манипуляций нажмите на кнопку 'Экспорт'.";

			$html = <<<EOQ

			<script src="custom/modules/XlsExport/js/scripts.js"></script>
			<link rel="stylesheet" type="text/css" href="custom/modules/XlsExport/css/styles.css">

			<div id="pop-up">
			   <input type="hidden" id="selected_ids">
			   <input type="hidden" id="module_name" value="{$_REQUEST['module']}">

				<div id="popup_header">Xls Export</div>
				<div id="title_of_popup">Добро пожаловать в настройки экспорта XLS</div>
				<div id="config" class="config_mode">
                    <h3> Сохранение текущего выбора полей </h3>
                    <input type="hidden" name="id_current_user" value="{$current_user->id}">
                    <input type="hidden" name="current_module_config" value="{$_REQUEST['module']}">
                    <table>
                        <tr>
                            <td> <label> Название: </label> </td>
                            <td><input type="text" id="config_name" /> </td>
                        </tr>
                        <tr>
                            <td> <label> Видно всем: </label> </td>
                            <td> <input type="checkbox" id="all_visible" /> </td>
                        </tr>
                        <tr>
                            <td> </td>
                            <td> <br/>
								<input type="button" value="Отмена" id="cancel_config" style="text-decoration:none; color:white;" class="submit_button" />
								<input type="button" value="Сохранить" id="save_config" style="text-decoration:none; color:white;" class="submit_button" />
							</td>
                        </tr>
                    </table>
                </div>
				<div id="description_of_popup">{$description_message}</div>
				<div id="__xls_config_block">
					<label>Связанные модули(субпанели):</label> <select id="__xls_relate_modules">
						{$rel_options}
					</select><br/>
					<label>Связанные модули(поля):</label> <select id="__xls_linked_modules">
						{$ln_options}
					</select>
				</div>
				<div class="multiselects">
					<div class="select_block" id="__xls_left_block">
						<div class="header_select">Доступные поля</div>
						<select id="left_multiselect" multiple class="__xls_left_multiselect">
						{$options}
						</select>
					</div>

					<div id="buttons_left_right_up_down">
						<div><img src="custom/modules/XlsExport/img/right.jpg" id="to_right"></div>
						<div><img src="custom/modules/XlsExport/img/left.jpg" id="to_left" style="margin:5px auto;"></div>
					</div>

					<div class="select_block" id="__xls_right_block">
						<div class="header_select">Поля на экспорт</div>
						<select id="right_multiselect" multiple class="__xls_right_multiselect">
						</select>
					</div>
					<div id="buttons_left_right_up_down">
						<div><img src="custom/modules/XlsExport/img/up.jpg" id="up"></div>
						<div><img src="custom/modules/XlsExport/img/down.jpg" id="down" style="margin:5px auto;"></div>
						</div>
					</div>
					
					<div class="config_mode" id="user_config">
                        <h2> Выберите конфигурацию </h2>
                        <select style="margin-top:10px; width:100%;" id="user_config_select">
                        <option value="" label=""></option>
                        </select><br/><br/>
                        <a href="#" onclick="return false;" style="text-decoration:none; color:white;margin-left:42px" class="submit_button" id="ok_user_config"> ok </a>
                    </div>
					<span class="btn-group">
						<a href="#" id="cancel_button_" class="cancel_button" style="text-decoration:none; color:white;" onclick="return false;">Отмена</a>
						<a href="#" id="submit_button" class="submit_button" style="text-decoration:none; color:white;" onclick="return false;">Экспорт</a>
						&nbsp;&nbsp;<b>Конфигурация:</b>
						<a href="#" id="select_button" class="submit_button" style="text-decoration:none; color:white;" onclick="return false;">Выбрать</a>
						<a href="#" id="save_config_button" class="submit_button" style="text-decoration:none; color:white;" onclick="return false;">Сохранить</a>
					</span>
				</div>

			<div id="overlay"></div>
			<div id="success_end">
			<div id="success_end_title">Xls Export</div>
				<div id="loading_message">Генерация документа...</div>
				<div id="success_end_message"></div>
				<div id="fountainG">
					<div id="fountainG_1" class="fountainG">
					</div>
					<div id="fountainG_2" class="fountainG">
					</div>
					<div id="fountainG_3" class="fountainG">
					</div>
					<div id="fountainG_4" class="fountainG">
					</div>
					<div id="fountainG_5" class="fountainG">
					</div>
					<div id="fountainG_6" class="fountainG">
					</div>
					<div id="fountainG_7" class="fountainG">
					</div>
					<div id="fountainG_8" class="fountainG">
					</div>
				</div>
				<div id="close_success_box_button"><a href="#" class="close_success_box_button" style="text-decoration:none; color:white;" onclick="return false;">Закрыть</a></div>
			</div>
EOQ;
			echo $html;
		}
	}
}

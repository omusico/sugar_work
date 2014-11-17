<?php
/*
*	Created by Kolerts
*/

include('modules/kXML/add_functions.php');
echo '<style>';
include('modules/kXML/css/style.css');
echo'</style>
<script src="modules/kXML/js/konstruktor.js"></script>
<script src="modules/kXML/js/send_post.js"></script>';
echo "<h1>Конструктор XML</h1><br/>";
echo "<table border=0 width='100%'><tr><td width='50%' valign='top'>";
echo_modules();
echo "<div id='root' name='container' class='container'>
<button id='add' onclick='add_item(this,\"element\", \"item\", \"border:1px solid #0b0;\")'>Add</button>";
include('modules/kXML/read_template.php');
echo "</div>
<br/><button id='save' onclick='save_template();'>Сохранить шаблон</button>";
//<button id='generate' onclick='generate_xml();'>Сгенерировать XML</button>";
echo"</td><td width='50%' valign='top'>";
echo_description();
echo"</td></tr></table>";

/*
$mod = new UpdateListView();
		 $field_list = $mod->get_field_list($focus); // Получаем список всех полей, текущего модуля

		 if (count($field_list) > 0)
		 {
			 foreach ($field_list as $field)
			 {
				 $options .= "<option value='{$field['name']}'>{$field['label']}</option>"; // Подготавливаем options для мультиселекта
			 }
		 }*/
?>
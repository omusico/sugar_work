<?php
/*
*	Created by Kolerts
*/

global $db, $timedate, $current_user;
$_MAX_LOG_ROWS_FOR_TEMPLATE_ = 50;

$title="Лог";
$title.=isset($_REQUEST['return_module'])? " по модулю '{$_REQUEST['return_module']}'" : '';
$where=isset($_REQUEST['return_module'])? "WHERE module='{$_REQUEST['return_module']}'" : '';
if($_REQUEST['record']){
	$title.=", шаблону '{$_REQUEST['record']}'";
	$where.=" AND template='{$_REQUEST['record']}'";
}
echo"<h3>{$title}</h3><br/><br/>";
echo"<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'><tbody>
	<th>Дата</th>
	<th>Действие</th>
	<th>Пользователь</th>
";
$sql="SELECT `date`,`action`,`user_id`,`user_name` FROM kxml_log {$where} ORDER BY `date` DESC LIMIT {$_MAX_LOG_ROWS_FOR_TEMPLATE_}";
$res=$db->query($sql);
while($row=$db->fetchByAssoc($res)){
	echo"	<tr class='oddListRowS1'>
		<td>".$timedate->to_display_date_time($row['date'], true, true, $current_user)."</td>
		<td>{$row['action']}</td>
		<td><a href='index.php?module=Users&action=DetailView&record={$row['user_id']}'>{$row['user_name']}</a></td>
	</tr>";
}
echo"</tbody></table>";
?>
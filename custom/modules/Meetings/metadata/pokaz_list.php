<?php
/**
 * Created by Kolerts
 * Protected by SugarTalk.ru
 */
/*global $current_language;
$app_list_strings = return_app_list_strings_language($current_language);*/
require_once('include/utils/db_utils.php');
$db = DBManagerFactory::getInstance();

if(isset($_GET['date']))
{
	global $timedate;
	$date=explode('-',$_GET['date']);
	$data = array ('Январь','Февраль','Март','Апрель','Май','Июнь','Июль',
					'Август','Сентябрь','Октябрь','Ноябрь','Декабрь');
	$date_check="{$date[0]}-".str_pad($date[1], 2, "0", STR_PAD_LEFT)."-".str_pad($date[2], 2, "0", STR_PAD_LEFT)."";
	echo "<h3 style='text-align:center;'>Список показов на {$date[2]} {$data[$date[1]]} {$date[0]}<h3>";
	echo '<table cellpadding="0" cellspacing="0" width="100%" border="0" class="list view">
			<tbody>
			<th scope="col"><span sugar="slot0" style="white-space:normal;">Название показа</span></th>
			<th scope="col"><span sugar="slot0" style="white-space:normal;">Статус показа</span></th>
			<th scope="col"><span sugar="slot0" style="white-space:normal;">Дата начала</span></th>
			<th scope="col"><span sugar="slot0" style="white-space:normal;">Дата окончания</span></th>';
	
	
	$where_users='';
	global $current_user;
	if(!is_admin($current_user))
		$where_users="assigned_user_id='{$current_user->id}' AND";
		
	$query = "SELECT id, name, date_start, date_end, status
			FROM meetings
			WHERE deleted <> 1 AND
				$where_users
				meeting_type <> 'meeting' AND
				DATE(date_start) <= '$date_check' AND '$date_check' <= DATE(date_end)
			ORDER BY date_start";
	$result = $db->query($query);
	
	$date_check=$timedate->to_display_date_time($date_check); // формат дата - время
	
	$td_style="style='cursor:pointer;'";
	$prosmotr_ids=false;
	while($row = $db->fetchByAssoc($result)) {
		$row['date_start']=$timedate->to_display_date_time($row['date_start'], true, true, $current_user);
		$row['date_end']=$timedate->to_display_date_time($row['date_end'], true, true, $current_user);
		$onclick=" onclick='view_pokaz(\"{$row['id']}\");' ";
		echo"<tr class='oddListRowS1' $onclick style='cursor:pointer;'>
		<td $td_style>{$row['name']}</td>
		<td $td_style>{$GLOBALS['app_list_strings']['meeting_status_dom'][$row['status']]}</td>
		<td $td_style>{$row['date_start']}</td>
		<td $td_style>{$row['date_end']}</td></tr>";
		$prosmotr_ids.="{$row['id']}_";
	}
	echo "</tbody></table>";
	
	echo "<button style='width:100%;height:25px;' onclick=\"
		window.open('index.php?module=Meetings&action=EditView&date_start={$date_check}&date_end={$date_check}&meeting_type=pokaz&duration=',
		'Создать показ на {$date[2]} {$data[$date[1]]} {$date[0]}',
		'width=800,height=600,resizable=yes,scrollbars=yes');
		return false;
		\">Создать показ на {$date[2]} {$data[$date[1]]} {$date[0]}</button><br/><br/>";
	if($prosmotr_ids){
		$prosmotr_ids=trim($prosmotr_ids, "_");
		echo "<button style='width:100%;height:20px;' onclick=\"
		window.location = 'index.php?module=Meetings&action=prosmotr&record={$prosmotr_ids}&date={$_GET['date']}';
		return false;
		\">Создать просмотровый лист по этому дню</button>";
	}
}
else if(isset($_GET['id']))
{
	global $timedate, $current_user;
	$id=$_GET['id'];
	$query = "SELECT id, name, date_start, date_end, description, status,
				location, parent_id, parent_type, realty_id, result,
				why_not_held, disable_next, meeting_type, assigned_user_id
			FROM meetings
			WHERE deleted <> 1 AND
				id='$id'
			ORDER BY date_start";//
	$result = $db->query($query);
	$style="style='border:1px solid #bbf;padding:2px;margin:0px;'";
	if($row = $db->fetchByAssoc($result))
	{
		$client = loadBean($row['parent_type']);
		$client->retrieve($row['parent_id']);
		// $client = loadBean('Contacts');
		// $client->retrieve($row['contact_id']);
		$realty = loadBean('Realty');
		$realty->retrieve($row['realty_id']);
		$user = loadBean('Users');
		$user->retrieve($row['assigned_user_id']);
		
		if($row['disable_next']==1)	$cheked='checked=checked';else	$cheked='';
		$options='';
		$status_keys=array_keys($GLOBALS['app_list_strings']['meeting_status_dom']);
		foreach($status_keys as $status_key)
		{
			$selected='';
			if($status_key==$row['status'])
				$selected='selected';
			$options.="<option value='$status_key' $selected>".$GLOBALS['app_list_strings']['meeting_status_dom'][$status_key]."</option>";
		}
		
		echo"<h1 style='text-align:center'>{$row['name']}</h1><br/><table style='font-size:12px;' width='100%' cellspacing='1'>";
		echo"<tr><td $style width=35%><b>Тип показа:</b></td><td $style>{$GLOBALS['app_list_strings']['meeting_type_list'][$row['meeting_type']]}</td></tr>";
		echo"<tr><td $style><b>Статус:</b></td>
			<td $style><select id='status' name='status' onchange='set_pokaz_status();'>$options</select></td></tr>";
		echo"<tr><td $style><b>Дата начала:</b></td><td $style>".$timedate->to_display_date_time($row['date_start'], true, true, $current_user)."</td></tr>";
		echo"<tr><td $style><b>Дата окончания:</b></td><td $style>".$timedate->to_display_date_time($row['date_end'], true, true, $current_user)."</td></tr>";
		echo"<tr><td $style><b>Место показа:</b></td><td $style>{$row['location']}</td></tr>";
		echo"<tr><td $style><b>Клиент:</b></td>
			<td $style><a target='_blanck' title='просмотреть информацию по клиенту' href='index.php?action=DetailView&module={$row['parent_type']}&record={$row['parent_id']}'>{$client->first_name} {$client->last_name}</a></td></tr>";
		echo"<tr><td $style><b>Объект:</b></td>
			<td $style><a target='_blanck' title='просмотреть информацию по объекту' href='index.php?action=DetailView&module=Realty&record={$row['realty_id']}'>{$realty->name}</a></td></tr>";
		echo"<tr><td $style><b>Описание:</b></td><td $style>{$row['description']}</td></tr>";
		echo"<tr><td $style><b>Агент:</b></td>
		<td $style><a target='_blanck' title='просмотреть информацию по агенту' href='index.php?action=DetailView&module=Users&record={$row['assigned_user_id']}'>{$user->first_name} {$user->last_name}</a></td></tr>";
		echo"<tr><td $style><b>Результат показа:</b></td>
			<td $style><input type='text' id='result' name='result' value='{$row['result']}' style='width:99%;'></td></tr>";
		echo"<tr><td $style><b>Причина:</b></td>
			<td $style><input type='text' id='why_not_held' name='why_not_held' value='{$row['why_not_held']}' style='width:99%;'></td></tr>";
		echo"<tr><td $style><b>Не назначать следующий показ:</b></td>
			<td $style><input type='checkbox' id='disable_next' name='disable_next' $cheked></td></tr>";
			
		echo"<tr><td><button style='width:100%;height:20px;' onclick=\"
			save_pokaz('$id');
			return false;
			\">Сохранить изменения</button></td><td>";
		echo"<button style='width:100%;height:20px;' onclick=\"
			window.open('index.php?module=Meetings&action=EditView&record=$id',
			'Редактировать все поля',
			'width=800,height=600,resizable=yes,scrollbars=yes');
			return false;
			\">Редактировать все поля</button></td></tr>";
		echo"</table>";
	}
}
else if(isset($_GET['id_c']))
{
	/*$meet = loadBean('Meetings');
	$meet->retrieve($_GET['id_c']);
	$meet->status=$_GET['status'];
	if($meet->status=='Held'){
		$meet->result=$_GET['res'];
	}else if($meet->status=='Not Held'){
		$meet->why_not_held=$_GET['why'];
		if($_GET['d_next']=='true')
			$meet->disable_next=1;
		else
			$meet->disable_next=0;
	}
	$meet->save();*/
	
	global $timedate;
	$date = date("Y-m-d H:i:s", strtotime($timedate->nowDB().' +1 day'));
	
	$bean = loadBean('Meetings');
	$bean->retrieve($_GET['id_c']);
	
	$link="index.php?module=Meetings&action=EditView";
	$link.="&date_start=$date&date_end=$date";
	$link.="&meeting_type={$bean->meeting_type}";
	$link.="&location={$bean->location}";
	$link.="&parent_type={$bean->parent_type}";
	$link.="&parent_id={$bean->parent_id}";
	$link.="&parent_name={$bean->parent_name}";
	// $link.="&parent_type=Contacts";
	// $link.="&parent_id={$bean->contact_id}";
	// $link.="&parent_name={$bean->contact_name}";
	$link.="&realty_id={$bean->realty_id}";
	$link.="&realty_name={$bean->realty_name}";
	$link.="&assigned_user_id={$bean->assigned_user_id}";
	//SugarApplication::redirect($link);
	
	$query = "UPDATE meetings SET status = '{$_GET['status']}'";
	
	switch($_GET['status'])
	{
		case 'Held':
			$query .= ", result = '{$_GET['res']}'";
			echo "ok";
		break;
		
		case 'Not Held':
			if($_GET['d_next']=='true'){
				$disable_next=1;
				echo "ok";
			}else{
				$disable_next=0;
				echo $link;
			}
			$query .= ", disable_next = $disable_next";
			$query .= ", why_not_held = '{$_GET['why']}'";
		break;
		default:
			echo'ok';
		break;
	}
	$query .= "WHERE
				id='{$_GET['id_c']}'";
	//echo $query;
	$result = $db->query($query);
}
else if(isset($_GET['check_id']))
{
	$bean = loadBean('Meetings');
	$bean->retrieve($_GET['check_id']);
	global $timedate;
	$date=$timedate->to_db($_GET['d_s']);
	
	$query = "	SELECT id
					FROM meetings
					WHERE
						id <> '{$_GET['check_id']}' AND
						deleted <> 1 AND
						meeting_type <> 'meeting' AND
						date_start='{$date}' AND
						(
							realty_id='{$_GET['r_id']}' OR
							(
								parent_id='{$_GET['p_id']}' 
								AND parent_type='{$_GET['p_t']}'
							)
						)
				";// parent_id // AND parent_type='{$_GET['p_t']}'
		$result = $db->query($query);
		if($row = $db->fetchByAssoc($result))
		{
			echo'false';
		}
		else
			echo'true';
}
?>
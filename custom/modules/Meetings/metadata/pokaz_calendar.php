<?php
/**
 * Created by Kolerts
 * Protected by SugarTalk.ru
 */

	$day=0;
	$month=isset($_GET['month']) ? $_GET['month'] : date('n');
	$year=isset($_GET['year']) ? $_GET['year'] :date ("Y");
	if($month<=0)
	{
		$month=11;
		$year--;
	}
	if($month>11)
	{
		$month=0;
		$year++;
	}
	
	$n_month=$month+1;
	$p_month=$month-1;

	$data = array (
		'Январь',
		'Февраль',
		'Март',
		'Апрель',
		'Май',
		'Июнь',
		'Июль',
		'Август',
		'Сентябрь',
		'Октябрь',
		'Ноябрь',
		'Декабрь',
	);
	$week_day = array("Пн","Вт","Ср","Чт","Пт","Сб","Вс");
	
	// Вычисляем число дней в текущем месяце
	$dayofmonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);//date('t');
	
//
	$month_events=0;
	for($i=0;$i<=$dayofmonth;$i++)
	{
		$envent_days[$i]=0;
	}
	
	$month_next=$month+1;
	$year_next=$year;
	if($month_next>12){$year_next++;$month_next=1;}
	$current_date="'$year-".str_pad($month, 2, "0", STR_PAD_LEFT)."-01'";
	$next_date="'$year_next-".str_pad($month_next, 2, "0", STR_PAD_LEFT)."-01'";
	
	$where_realty='';
	if(isset($_GET['realty_ids']) && $_GET['realty_ids']!=''){
		$realty_ids="'".str_replace(',',"','",$_GET['realty_ids'])."'";
		$where_realty="realty_id IN ({$realty_ids}) AND";
	}
	$where_users='';
	global $current_user;
	if(!is_admin($current_user))
		$where_users="assigned_user_id='{$current_user->id}' AND";
	require_once('include/utils/db_utils.php');
	$db = DBManagerFactory::getInstance();

	$query = "SELECT date_start, date_end
			FROM meetings
			WHERE deleted <> 1 AND
				$where_realty
				$where_users
				meeting_type <> 'meeting' AND
				(
					(date_start >= $current_date && date_start < $next_date) OR
					(date_end >= $current_date && date_end < $next_date)
				)
				";
	//echo $query;
	$result = $db->query($query);
	while($row = $db->fetchByAssoc($result)) {
		$start=(int)substr($row['date_start'],8,2);
		$end=(int)substr($row['date_end'],8,2);
		for($i=$start;$i<=$end;$i++)
		{
			$envent_days[$i]++;
		}
		$month_events++;
	}
	/*$conn = new COM('ADODB.Connection') or die('Could not make conn'); 
	$rs = new COM('ADODB.Recordset') or die('Coult not make rs'); 

	$connstring = "Provider=Microsoft.Jet.OLEDB.4.0; Data Source=C:\Inetpub\wwwroot\calendar\db.mdb"; 

	$conn->Open($connstring); 

	$sql = "SELECT DAY from CALENDAR where USER_ID=$mId and MONTH=$month and YEAR=$year"; 

	$rs->Open($sql, $conn, 1, 3); 

	

	$rs->Close(); 
	$conn->Close(); 
	$rs=null; $conn=null;*/
//

	// Счётчик для дней месяца
	$day_count = 1;

	// 1. Первая неделя
	$num = 0;
	for($i = 0; $i < 7; $i++)
	{
		// Вычисляем номер дня недели для числа
		$dayofweek = date('w', 	mktime(0, 0, 0, $month, $day_count, $year));
		// Приводим к числа к формату 1 - понедельник, ..., 6 - суббота
		$dayofweek = $dayofweek - 1;
		if($dayofweek == -1)
			$dayofweek = 6;

		if($dayofweek == $i)
		{
			// Если дни недели совпадают,
			// заполняем массив $week
			// числами месяца
			$week[$num][$i] = $day_count;
			$day_count++;
		}
		else
		{
			$week[$num][$i] = "";
		}
	}

	// 2. Последующие недели месяца
	while(true)
	{
		$num++;
		for($i = 0; $i < 7; $i++)
		{
			$week[$num][$i] = $day_count;
			$day_count++;
			// Если достигли конца месяца - выходим
			// из цикла
			if($day_count > $dayofmonth)
				break;
		}
		// Если достигли конца месяца - выходим
		// из цикла
		if($day_count > $dayofmonth)
			break;
	}

	// 3. Выводим содержимое массива $week
	// в виде календаря
	// Выводим таблицу
	/*<tr class='title'>";
	echo "<td>< <a href='javascript:void(0)' onclick='load_calendar(\"month=$p_month&year=$year\");' title='предыдущий месяц'>предыдущий месяц</a></td>";
	echo"<td colspan=5>";
	echo $data[$month].", ".$year." [<a href='javascript:void(0)' onclick='load_calendar();'>Сегодня</a>]</td>";
	echo "<td><a href='javascript:void(0)' onclick='load_calendar(\"month=$n_month&year=$year\");' title='следующий месяц' >следующий месяц</a> ></td>";
	echo "</tr>";*/
	echo "Всего показов в этом месяце: $month_events<br/>";
	echo"<div class='monthHeader'>
		<div style='float: left; width: 20%;'><a href='javascript:void(0)' onclick='load_calendar(\"month=$p_month&year=$year\");' title='предыдущий месяц'><img src='themes/default/images/calendar_previous.gif?v=eL6r1A6qE8QZd1dJyQo3tQ' align='absmiddle' border='0'>  Предыдущий месяц</a></div>
		<div style='float: left; width: 60%; text-align: center;'><h3>{$data[$month]}, $year [<a href='javascript:void(0)' onclick='load_calendar();'>Текущий месяц</a>]</h3></div>
		<div style='float: right;'><a href='javascript:void(0)' onclick='load_calendar(\"month=$n_month&year=$year\");' title='следующий месяц' >Следующий месяц  <img src='themes/default/images/calendar_next.gif?v=eL6r1A6qE8QZd1dJyQo3tQ' align='absmiddle' border='0'></a></div>
		<br style='clear:both;'>
		<br style='clear:both;'>
	</div>";
	echo "<center><table class='calendar' border=0>";

	for($i = 0; $i < count($week); $i++)
	{
		echo "<tr>";
		for($j = 0; $j < 7; $j++)
		{
			$day=@$week[$i][$j];
			if(!empty($day))
			{
				// Если имеем дело с субботой и воскресенья
				// подсвечиваем их
				
				if($day==date('j') && $month==date('n') && $year==date('Y'))
					echo "<td class='today' ";
				else
				{
					if($j == 5 || $j == 6) 
						echo "<td class='holyday' ";
					else
						echo "<td class='another' ";
				}
				echo" onclick='view_date(\"$year-$month-$day\");' ";
				echo "style='cursor:pointer' height='100px' width='150px'><div class='day_title'>{$week_day[$j]} $day</div><br/><br/><span class='events'>";
				if($envent_days[$day]>0)
					echo "<b>Показов:".$envent_days[$day]."</b>";
				else
					echo"<span style='color:#555;'>Показов:0</span>";
				echo"</span></td>";
			}
			else
				echo "<td class='empty'>&nbsp;</td>";
		}
		echo "</tr>";
	} 
	echo "</table></center>";

?>
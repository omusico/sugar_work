<?php
/**
 * Created by Kolerts
 * Protected by SugarTalk.ru
 */

if(isset($_GET['record']))
{
	require_once('include/utils/db_utils.php');
	
	$record=$_GET['record'];
	$bean = new Realty();
	$bean->retrieve($record);
	echo "<h1>Подобные объекту '{$bean->name}':</h1>";
	echo "<form action='index.php' method='GET'>";
	echo "<input type='hidden' name='module' value='Realty'>";
	echo "<input type='hidden' name='action' value='similar'>";
	echo "<input type='hidden' name='record' value='{$_GET['record']}'>";
	echo "Мин. этаж:<input type='text' name='min_floor' value='{$_GET['min_floor']}'>&nbsp;";
	echo "Макс. этаж:<input type='text' name='max_floor' value='{$_GET['max_floor']}'>&nbsp;&nbsp;&nbsp;";
	echo "Мин. цена:<input type='text' name='min_cost' value='{$_GET['min_cost']}'>&nbsp;";
	echo "Макс. цена:<input type='text' name='max_cost' value='{$_GET['max_cost']}'>&nbsp;";
	echo "<input type='submit' value='Подобрать'>";
	
	echo'<table cellpadding="0" cellspacing="0" width="100%" border="0" class="list view">
		<tbody>
		<th scope="col"><span sugar="slot0" style="white-space:normal;">Название</span></th>
		<th scope="col"><span sugar="slot0" style="white-space:normal;">Количество комнат</span></th>
		<th scope="col"><span sugar="slot0" style="white-space:normal;">Этаж</span></th>
		<th scope="col"><span sugar="slot0" style="white-space:normal;">Этажность</span></th>
		<th scope="col"><span sugar="slot0" style="white-space:normal;">Улица</span></th>
		<th scope="col"><span sugar="slot0" style="white-space:normal;">Площадь квартиры</span></th>
		<th scope="col"><span sugar="slot0" style="white-space:normal;">Цена</span></th>';
		
	$db = DBManagerFactory::getInstance();
	$query = "	SELECT id, name, rooms_quantity, floor, number_of_floors,
					address_street, square, totalcost
				FROM realty
				WHERE rooms_quantity='{$bean->rooms_quantity}'";
	
	if(isset($_GET['min_floor']) && $_GET['min_floor']!='')
		$query .= " AND floor >= {$_GET['min_floor']} ";
	if(isset($_GET['max_floor']) && $_GET['max_floor']!='')
		$query .= " AND floor <= {$_GET['max_floor']} ";
	if(isset($_GET['min_cost']) && $_GET['min_cost']!='')
		$query .= " AND totalcost >= {$_GET['min_cost']} ";
	if(isset($_GET['max_cost']) && $_GET['max_cost']!='')
		$query .= " AND totalcost <= {$_GET['max_cost']} ";

	$query .= "ORDER BY totalcost ASC";
	$result = $db->query($query);
	while($row = $db->fetchByAssoc($result))
	{
		$style="style='border-right:1px solid #ccf'";
		if($row['id']==$record)
			$style="style='background-color:#bfb;border-right:1px solid #ccf'";
		echo "<tr class='oddListRowS1' $style>
		<td $style><a href='index.php?module=Realty&action=DetailView&record={$row['id']}'>{$row['name']}</a></td>
		<td $style>{$row['rooms_quantity']}</td>
		<td $style>{$row['floor']}</td>
		<td $style>{$row['number_of_floors']}</td>
		<td $style>{$row['address_street']}</td>
		<td $style>{$row['square']}</td>
		<td $style>{$row['totalcost']}</td>
		</tr>";
	}
	echo "</tbody></table>";
}
else
	echo "<b style='color:#b00;'>Ошибка получения данных объекта</b>";
?>

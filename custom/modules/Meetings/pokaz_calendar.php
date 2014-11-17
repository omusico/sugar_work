<style>
	table .calendar{
		text-valign:top;
		border:1px solid #666;
	}
	.calendar td {
		border:1px solid #666;
	}
	.day_title{
		margin-top:-35px;
		padding:4px;
		border-bottom:1px solid #666;
		font-weight:bold;
		background-color:#eee;
		text-align:right;
	}
	
	.add {
		font-size:150%;
		text-align:center;
		color:#bbb;
	}
	
	.events {
		//background:#b00;
		font-size:11pt;
		color:#000;
		text-align:center;
	}
	
	.title {
		text-align:center;
		font-weight:bold;
	}
	
	.holyday {
		color:#b00;
		text-align:center;
	}
	.today {
		background:#ffb;
		text-align:center;
		/*color:#fff;*/
	}
	.another {
		background:#fff;
		text-align:center;
		/*color:#000;*/
	}
	
	.holyday:hover {
		background:#ddf;
	}
	.today:hover {
		background:#ddf;
		/*color:#fff;*/
	}
	.another:hover {
		background:#ddf;
		/*color:#000;*/
	}
	
	.empty {
		background:#bbb;
		/*color:#fff;*/
	}
	.window_pokaz{
		display:none;
		position:fixed;/*absolute*/
		top:10px;left:10%;
		width:80%;/*height:50%;*/
		background-color:#fbfbff;
		padding:10px;
		border:2px solid #8ad;
		
		-moz-box-shadow: 5px 5px 5px rgba(0,0,0,0.5); /* Для Firefox */
		-webkit-box-shadow: 5px 5px 5px rgba(0,0,0,0.5); /* Для Safari и Chrome */
		box-shadow: 5px 5px 5px rgba(0,0,0,0.5); /* Параметры тени */
		filter: progid:DXImageTransform.Microsoft.shadow(direction=120, color=#000000, strength=5);/*IE*/
	}
</style>

<script>
/**
 * Created by Kolerts
 * Protected by SugarTalk.ru
 */
var calendar, window_pokaz, window_html, pokaz_html;
function loadHTML(sURL)
{
	var request=null;
	// пытаемся создать объект для MSXML 2 и старше
	if(!request) try
	{
		request=new ActiveXObject('Msxml2.XMLHTTP');
	} catch (e){}

	// не вышло... попробуем для MSXML 1
	if(!request) try
	{
		request=new ActiveXObject('Microsoft.XMLHTTP');
	} catch (e){}

	// не вышло... попробуем для Mozilla
	if(!request) try
	{
		request=new XMLHttpRequest();
	} catch (e){}

	if(!request)
		// ничего не получилось...
		return '';

	// делаем запрос
	request.open('GET', sURL, false);
	request.send(null);

	// возвращаем текст
	return request.responseText;
}
function set_pokaz_status()
{
	$("#why_not_held").parent().parent().hide();
	$("#disable_next").parent().parent().hide();
	$("#result").parent().parent().hide();
	
	switch($('#status').val())
	{
		case 'Held':// состоялся
			$("#result").parent().parent().show();
		break;
		case 'Not Held':// не состоялся
			$("#why_not_held").parent().parent().show();
			$("#disable_next").parent().parent().show();
		break;
	}
}
function save_pokaz($id)
{
	//pokaz_html.innerHTML="<center>Сохранение данных <br/>пожалуйста подождите..</center>";
	var res=loadHTML('index.php?entryPoint=pokaz_list&id_c='+$id+'&status='+$('#status').val()+'&res='+$('#result').val()+'&why='+$('#why_not_held').val()+'&d_next='+$('#disable_next').is(':checked'));
	res=res.replace("\ufeff", "");//utf bom fix
	if(res!='ok')
	{
		win1 = window.open(res, "Показ на следующий день", "resizable=yes,scrollbars=yes,width=800,height=600"); 
		//win1.document.writeln(res); 
		//win1.focus();
	}
	view_pokaz($id);
}
function hide_window()
{
	window_pokaz.style.display='none';
	pokaz_html.style.display='none';
	return false;
}
function view_pokaz($id)
{
	pokaz_html.innerHTML="<center>Загрузка данных <br/>пожалуйста подождите..</center>";
	pokaz_html.style.display='block';
	pokaz_html.innerHTML=loadHTML('index.php?entryPoint=pokaz_list&id='+$id);
	set_pokaz_status();
}
function view_date($date)
{
	//pokaz_html.style.display='none';
	pokaz_html.innerHTML="<center>Выберите показ из списка для отображения его параметров</center>";
	window_html.innerHTML="<center>Загрузка данных <br/>пожалуйста подождите..</center>";
	window_pokaz.style.display='block';
	pokaz_html.style.display='block';
	window_html.innerHTML=loadHTML('index.php?entryPoint=pokaz_list&date='+$date);
}
function load_calendar($params)
{
	//alert('index.php?entryPoint=pokaz_calendar&'+$params+'<?php echo $_GET['realty_ids'];?>');
	calendar.innerHTML=loadHTML('index.php?entryPoint=pokaz_calendar&'+$params+'&realty_ids=<?php echo $_GET['realty_ids'];?>');
}
$(document).ready(function() {
	calendar=document.getElementById('calendar');
	window_pokaz=document.getElementById('window_pokaz');
	window_html=document.getElementById('window_html');
	pokaz_html=document.getElementById('pokaz_html');
	load_calendar();
});
</script>
<?php
	echo"<div id='window_pokaz' class='window_pokaz'>
	<p align='right'><button onclick='return hide_window();'>Закрыть окно</button></p>
	<table width=100%><tr>
	<td id='window_html' style='width:50%;vertical-align:top;' ></td>
	<td id='pokaz_html' style='border:3px double #8ad;padding:5px;'></td>
	</tr></table></div>";
	echo"<h1>{$mod_strings['LNK_POKAZ_CALENDAR']}</h1><br/>
	<div id='calendar' name='calendar'></div>";
?>
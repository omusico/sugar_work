/**
 * Created by Kolerts
 * Protected by SugarTalk.ru
 */
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
	$("#result").parent().hide();
	$("#result").parent().prev().hide();
	
	if ($('#meeting_type').val()!='meeting'){// не встреча -> показ
		switch($('#status').val())
		{
			case 'Held':// состоялся
				$("#result").parent().show();
				$("#result").parent().prev().show();
			break;
			case 'Not Held':// не состоялся
				$("#why_not_held").parent().parent().show();
			break;
		}
	}
}

$(document).ready(function() {
    set_pokaz_status();
	
	$('#meeting_type').change(function(){set_pokaz_status();});
	$('#status').change(function(){set_pokaz_status();});
	document.EditView.onsubmit = check_save;
});

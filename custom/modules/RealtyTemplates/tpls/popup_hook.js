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

function check_realty(id)
{
	var alredy_in_op=loadHTML('index.php?entryPoint=popup_check&action_=alredy_in_op&id='+id);
	var alredy_status=loadHTML('index.php?entryPoint=popup_check&action_=alredy_status&id='+id);
	var confirm_=true;
	if(alredy_in_op!='false')
	{
		if(confirm("Данный объект находится в сделке '"+alredy_in_op+"'. Желаете продолжить?"))
			send_back('RealtyTemplates',id);
		confirm_=false;
	}
	if(alredy_status!='false')
	{
		if(confirm("Данный объект уже "+alredy_status+". Желаете продолжить?"))
			send_back('RealtyTemplates',id);
		confirm_=false;
	}
	
	/*$.ajax({
		type: 'GET',
		url:'index.php',
		data: 
		{
			entryPoint:'popup_check',
			id:id,
			action_:'alredy_in_op',
		},
		success: function(data){
			if(data!='false')
			{
				if(confirm("Данный объект находится в сделке '"+data+"'. Желаете продолжить?"))
					send_back('RealtyTemplates',id);
				
			}
			confirm_=false;
		}
	});
	$.ajax({
		type: 'GET',
		url:'index.php',
		data: 
		{
			entryPoint:'popup_check',
			id:id,
			action_:'alredy_status',
		},
		success: function(data){
			if(data!='false')
			{
				if(confirm("Данный объект уже "+data+". Желаете продолжить?"))
					send_back('RealtyTemplates',id);
				confirm_=false;
			}
		}
	});*/
	if(confirm_)
		send_back('RealtyTemplates',id);
};

/*
*	Created by Kolerts
*/

function loadPOST(sURL, sDATA)
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
	request.open('POST', sURL, false);
	request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	request.send(sDATA);

	// возвращаем текст
	return request.responseText;
}
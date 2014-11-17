/*
*	Created by Kolerts
*/

function loadPOST(sURL, sDATA)
{
	var request=null;
	// �������� ������� ������ ��� MSXML 2 � ������
	if(!request) try
	{
		request=new ActiveXObject('Msxml2.XMLHTTP');
	} catch (e){}

	// �� �����... ��������� ��� MSXML 1
	if(!request) try
	{
		request=new ActiveXObject('Microsoft.XMLHTTP');
	} catch (e){}

	// �� �����... ��������� ��� Mozilla
	if(!request) try
	{
		request=new XMLHttpRequest();
	} catch (e){}

	if(!request)
		// ������ �� ����������...
		return '';

	// ������ ������
	request.open('POST', sURL, false);
	request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	request.send(sDATA);

	// ���������� �����
	return request.responseText;
}
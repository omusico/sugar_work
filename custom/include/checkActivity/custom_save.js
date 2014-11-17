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
function custom_save($id)
{
	ajaxStatus.showStatus("Проверка существующих объектов на выбранное время..");
	var qc='false';
	if($id=='calls' || $id=='meetings' || $id=='tasks'){
		qc=$id;
		$id='';
	}
	var link='index.php?entryPoint=check_activity&check_id='+$id;
	if(qc!='false')
		link+='&module='+qc;
	if(qc=='calls'){
		link+='&d_s='+document.form_SubpanelQuickCreate_Calls.date_start.value;
		link+='&assigned_user_id='+document.form_SubpanelQuickCreate_Calls.assigned_user_id.value;
	}else if(qc=='meetings'){
		link+='&d_s='+document.form_SubpanelQuickCreate_Meetings.date_start.value;
		link+='&assigned_user_id='+document.form_SubpanelQuickCreate_Meetings.assigned_user_id.value;
	}else if(qc=='tasks'){
		link+='&d_s='+document.form_SubpanelQuickCreate_Tasks.date_start.value;
		link+='&assigned_user_id='+document.form_SubpanelQuickCreate_Tasks.assigned_user_id.value;
	}else{
		link+='&module='+module_sugar_grp1.toLowerCase();
		link+='&d_s='+$('#date_start').val();
		link+='&id='+document.getElementsByName('record')[0].value;
		link+='&assigned_user_id='+document.getElementById('assigned_user_id').value;
	}
	// alert(link);
	var res=loadHTML(link);
	res=res.replace("\ufeff", "");//utf bom fix
	// alert(res);
	ajaxStatus.hideStatus();
	res = JSON.parse(res);
	if(res['result']=='true')
		if($("#Calls_subpanel_save_button").attr('title')=="Сохранить")
			return true;
		else
			return check_form('EditView');
	else
		alert('На это время уже назначено мероприятие');
		return false;
}
/*
if($("#Calls_subpanel_save_button").attr('title')=="Сохранить")
	$("#Calls_subpanel_save_button").attr("onclick",
		"var _form = document.getElementById('form_SubpanelQuickCreate_Calls');"+
		"disableOnUnloadEditView();"+
		"_form.action.value='Save';"+
		"if(check_form('form_SubpanelQuickCreate_Calls') && custom_save(''))"+
		"	return SUGAR.subpanelUtils.inlineSave(_form.id, 'Calls_subpanel_save_button');"+
		"return false;");
if($("#Meetings_subpanel_save_button").attr('title')=="Сохранить")
	$("#Meetings_subpanel_save_button").attr("onclick",
		"var _form = document.getElementById('form_SubpanelQuickCreate_Meetings');"+
		"disableOnUnloadEditView();"+
		"_form.action.value='Save';"+
		"if(check_form('form_SubpanelQuickCreate_Meetings') && custom_save(''))"+
		"	return SUGAR.subpanelUtils.inlineSave(_form.id, 'Meetings_subpanel_save_button');"+
		"return false;");
if($("#Tasks_subpanel_save_button").attr('title')=="Сохранить")
	$("#Tasks_subpanel_save_button").attr("onclick",
		"var _form = document.getElementById('form_SubpanelQuickCreate_Tasks');"+
		"disableOnUnloadEditView();"+
		"_form.action.value='Save';"+
		"if(check_form('form_SubpanelQuickCreate_Tasks') && custom_save(''))"+
		"	return SUGAR.subpanelUtils.inlineSave(_form.id, 'Tasks_subpanel_save_button');"+
		"return false;");
*/
/*
*	Created by Kolerts
*/

if (!$("#actionLinkTop > .sugar_action_button > .subnav > li").hasClass('xml_li'))
    $('#actionLinkTop > .sugar_action_button > .subnav').append(
		'<li class="xml_li"><a href="#" name="kxml" id="kxml" class="xls" onclick="open_xmlMenu(); return false;">Создать объявления</a></li>');
if (!$("#actionLinkBottom > .sugar_action_button > .subnav > li").hasClass('xml_li'))
    $('#actionLinkBottom > .sugar_action_button > .subnav').append(
		'<li class="xml_li"><a href="#" name="kxml" id="kxml" class="xls" onclick="open_xmlMenu(); return false;">Создать объявления</a></li>');

function generate_xml($button, $module, $name, $custom_generate)
{
	var but_inner=$button.src;
	//$button.disabled=true;
	$button.src='themes/default/images/img_loading.gif';
	$('#buton_sa').hide();
	$('#buton_img_sa').hide();
	$('#img_2_sa').css('display', 'block');
	$('#img_sa').css('display', 'block');
	/*var arr = new Array();
    var i = 0;

    $('#right_multiselect option').each(function(){
        arr[i] = [ this.text, this.value ];
        i++;
    });*/
	sugarListView.get_checks();
	var data_args="module="+$module;
	data_args+="&name="+$name;
	data_args+='&select_entire_list='+document.MassUpdate.select_entire_list.value;
	data_args+='&records='+document.MassUpdate.uid.value;
	data_args+='&custom_generate='+$custom_generate;
	var res=loadPOST('index.php?entryPoint=generate_xml', data_args);
	if(res=='')
		res='При создании объеков возникла ошибка';
	
	
	//$button.disabled=false;
	$button.src=but_inner;
	$('#img_sa').css('display', 'none');
	$('#img_2_sa').css('display', 'none');
	$('#buton_sa').show();
	$('#buton_img_sa').show();
	$("#buton_sa").text("Готово");
	alert(res);
}
function detail_xml($path, $name, $custom_generate)
{
	$('#detail_'+$name).html('<img src="themes/Sugar5/images/img_loading.gif" width="10" height="10"/> загрузка информации..');
	$('#detail_'+$name).show();
	var data_args='func=detail_xml';
		data_args+='&path='+$path;
		data_args+='&record='+$name;
		data_args+='&custom_generate='+$custom_generate;
	var res=loadPOST('index.php?module=kXML&action=ajax&to_pdf=1', data_args);
	$('#detail_'+$name).html(res);
}
function delete_xml($path, $name)
{
	if(confirm('Вы уверены что хотите удалить файл?')){
		var data_args='&func=delete_xml';
			data_args+='&path='+$path;
			data_args+='&record='+$name;
		var res=loadPOST('index.php?module=kXML&action=ajax&to_pdf=1', data_args);
		alert(res);
	}
}
function edit_tpl($module, $name)
{
	var strUrl=	'index.php?module=kXML&action=index'+
				'&return_module='+$module+
				'&record='+$name;
	window.open(strUrl, 'Редактировать шаблон '+$name);
}
function edit_xml($module, $name)
{
	var strUrl=	'index.php?module=kXML&action=read_xml'+
				'&return_module='+$module+
				'&record='+$name;
	window.open(strUrl, 'Редактировать XML '+$name);
}
function view_log($module, $name)
{
	var strUrl=	'index.php?module=kXML&action=view_log'+
				'&return_module='+$module+
				'&record='+$name;
	window.open(strUrl, 'Лог по шаблону '+$name, 'menubar=no,location=no,status=no,width=800,height=600,resizable=yes,scrollbars=yes');
}
function delete_tpl($path, $name)
{
	if(confirm('Вы уверены что хотите удалить данный шаблон и потерять интеграцию с доской объявлений?')){
		var data_args='&func=delete_tpl';
			data_args+='&path='+$path;
			data_args+='&record='+$name;
		var res=loadPOST('index.php?module=kXML&action=ajax&to_pdf=1', data_args);
		alert(res);
	}
}

function open_xmlMenu()
{
	$('#xmlMenu').show();
	$('#buton_sa').attr('disabled', false);
	$("#buton_sa").text("Создать");
}

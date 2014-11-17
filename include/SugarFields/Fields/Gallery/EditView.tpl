{php}
global $current_language;
$app_list_strings = return_app_list_strings_language($current_language);
{/php}

{   assign var = images        value = "^|^"|explode:{{sugarvar key = 'value' string = true}} }
{   assign var = imageCounter  value = 0    }
{   assign var = cur_count     value = $images|@count   }

{if $bean->new_with_id and !empty($new_with_id)}
    {   assign var = id     value = $new_with_id   }
    <input type="hidden" name="new_with_id" id="new_with_id" value="{$id}" />
{/if}

{assign var = upload_path     value = "upload/gallery_images/`$id`/"}

{* исключаем конфликт с другим либами
<script src="custom/include/GalleryField/Jcrop/js/jquery.min.js" type="text/javascript"></script>
*}
<script src="custom/include/GalleryField/Jcrop/js/jquery-ui.min.js" type="text/javascript"></script>
<script src="custom/include/GalleryField/Jcrop/js/jquery.color.js" type="text/javascript"></script>
<script src="custom/include/GalleryField/Jcrop/js/jquery.Jcrop.js" type="text/javascript"></script>
<link rel="stylesheet" href="custom/include/GalleryField/Jcrop/css/jquery-ui.css" type="text/css" />
<link rel="stylesheet" href="custom/include/GalleryField/Jcrop/css/jquery.Jcrop.css" type="text/css" />
{*
    //bagfix
    убираем багофайл из-за которого смещается поиск и расползается панель, что именно в нём не так - пока не понял...
    <link rel="stylesheet" href="custom/include/GalleryField/Jcrop/css/demos.css" type="text/css" />

 *}


<script type="text/javascript" language="javascript">

    var cur_count = {$cur_count};

    var table = document.getElementById('EditView');

    table.enctype = 'multipart/form-data';



    function addImageRow()
    {ldelim}
        cur_count += 1;
        var table = document.getElementById("{$module}images");
        var rowCount = table.rows.length;
        var newRow = table.insertRow(rowCount);
        newRow.id = "{$module}imageRow" + cur_count;

        // it's quite ugly code but cross-browser
        var newTD1 = document.createElement('td');
        newTD1.innerHTML = '<div style="padding-top:10px;"><span style="padding-right:8px;margin-bottom:4px;"><input type="radio" name="RADIO_MAIN" id="'+cur_count+'" value="" onclick="pos_main(this)">главная</span>' +
				'<span style="padding-right:8px;"><input type="checkbox"  name="{$module}imageFlag7_'+cur_count+'" id="{{sugarvar key='name'}}_'+cur_count+'_onsite" class="pres_chb" onchange="checkPresChbox(this);">презентация</span>'+
				'<span style="padding-right:8px;"><input type="checkbox" name="{$module}imageFlag8_'+cur_count+'" id="{{sugarvar key='name'}}_'+cur_count+'_advert">выгрузка на сайт</span>'+
				'<span style="padding-right:8px;"><input type="checkbox" name="{$module}imageFlag9_'+cur_count+'" id="{{sugarvar key='name'}}_'+cur_count+'_plan">планировка</span>'+
				'</div>'+
                '<input type="text" name="KEY_'+cur_count+'" id="KEY_'+cur_count+'" size="5" value="">&nbsp;' +
                '<input type="text" name="{$module}imageFlag0_'+cur_count+'" id="{$module}imageFlag0_'+cur_count+'" size="30" value="">' +
                '&nbsp;&nbsp; <td><input type="file"  name="{$module}imageFlag2_'+cur_count+'" maxlength="200" ACCEPT="image/*" size="1"  id="{{sugarvar key='name'}}_'+cur_count+'"  {{$displayParams.field}} onchange="multi_=false;uploadFile(this);" />'+
				'<br/> <input style="margin-top:5px;"value="Редактировать изображение" type="button" title="{$module}imageRow'+cur_count+'" name="{$module}imageFlag2_' + cur_count +'_crop" id="{{sugarvar key='name'}}_'+cur_count+'_crop" style="display: none" onclick="cropImage(this)"/>';
        newRow.appendChild (newTD1);

        var newTD3 = document.createElement('td');
        newTD3.innerHTML =
                '<input type="hidden" id="{{sugarvar key='name'}}_'+cur_count+'_crop_image_origin" {if is_file($origin_image)} value="origin_{$item.1}"{/if}/>' +

                        '<input type="hidden"   name="{$module}imageFlag2_'+cur_count+'" id="{{sugarvar key='name'}}_'+cur_count+'_crop_image"/>' +

                        '<input type="hidden"   name="{$module}imageFlag1_'+cur_count+'" id="{$module}imageFlag1_'+cur_count+'"  value="{$item.1}" />' +

                        '<input type="hidden"   name="{$module}imageFlag3_'+cur_count+'" id="{{sugarvar key='name'}}_'+cur_count+'_crop_image_x"/>' +

                        '<input type="hidden"   name="{$module}imageFlag4_'+cur_count+'" id="{{sugarvar key='name'}}_'+cur_count+'_crop_image_y"/>' +

                        '<input type="hidden"   name="{$module}imageFlag5_'+cur_count+'" id="{{sugarvar key='name'}}_'+cur_count+'_crop_image_w"/>' +

                        '<input type="hidden"   name="{$module}imageFlag6_'+cur_count+'" id="{{sugarvar key='name'}}_'+cur_count+'_crop_image_h"/>';

        newRow.appendChild (newTD3);


        var newTD5 = document.createElement('td');
        newTD5.innerHTML = '';
        newRow.appendChild (newTD5);


        var newTD6 = document.createElement('td');
        newTD6.innerHTML = '&nbsp;&nbsp; <img onclick="delImageRow(\'{$module}imageRow'+cur_count+'\')" id="{$module}removeButton0" class="id-ff-remove" name="0" src="{sugar_getimagepath file="id-ff-remove-new.png"}">';
        newRow.appendChild (newTD6);
		return cur_count;
    {rdelim}





    function delImageRow(row_id)
    {ldelim}

        var parent = document.getElementById(row_id).parentNode;
        parent.removeChild(document.getElementById(row_id));

    {rdelim}

    function pos_main(e)
    {ldelim}
			document.getElementById('main_pos').value = e.id;
    {rdelim}




</script>



{if !empty($id)}
<span id="extimage"><input type="hidden" id="gallery_name" value="{{sugarvar key='name'}}">
<table style="border-spacing: 1pt;border:1px solid #bbf">
    <tr>
        <td valign="top" nowrap="">
            <table class="emailaddresses" id="{$module}images">
                <tr>
                    <td nowrap="" scope="row">
                        <span class="id-ff multiple ownline">
                            <button value="Добавить" onclick="addImageRow()" type="button" class="button">
                                <img src="{sugar_getimagepath file = "id-ff-add-new.png"}">
                            </button>
                        </span>
						<input type="file"  name="gallery_upload_multy[]" maxlength="200" ACCEPT="image/*" size="0"   id="gallery_upload_multy"  {{$displayParams.field}} onchange="uploadFiles()" multiple="" />
                    </td>

                    <td nowrap="" scope="row">
                        &nbsp;
                    </td>

                    <td scope="row" NOWRAP>
                        &nbsp;
                    </td>

                    <td nowrap="" scope="row">
                        {$APP.LBL_image_MAIN}
                    </td>

                    <td nowrap="" scope="row">
                        {$APP.LBL_image_DONT_CALL}
                    </td>
                </tr>
				{assign var = my_per      value=0}
                {foreach name = outer   item = image    from = $images}
					{if $item.2 == 'main'}
						{assign var=my_per value=$imageCounter-1}
					{/if}
					{assign var = item      value = "^,^"|explode:$image}
					{if $item.1 != ''}
						{assign var = item_1 value = $item.1}

						{assign var = origin_image      value = "`$upload_path`origin_`$item_1`"}

						<tr id="{$module}imageRow{$imageCounter}">

							<td nowrap="nowrap">
								<div style="padding-top:10px;">
									<span style="padding-right:8px;"><input type="radio" name="RADIO_MAIN" id="{$imageCounter}" value="" onclick="pos_main(this)" {if $item.2 == 'main'}checked="checked"{/if}>главная</span>
									<span style="padding-right:8px;"><input type="checkbox" name="{$module}imageFlag7_{$imageCounter}" id="{{sugarvar key='name'}}_{$imageCounter}_onsite" {if $item.7 == 'on'}checked="checked"{/if} class="pres_chb" onchange="checkPresChbox(this);">презентация</span>
									<span style="padding-right:8px;"><input type="checkbox" name="{$module}imageFlag8_{$imageCounter}" id="{{sugarvar key='name'}}_{$imageCounter}_advert" {if $item.8 == 'on'}checked="checked"{/if}>выгрузка на сайт</span>
									<span style="padding-right:8px;"><input type="checkbox" name="{$module}imageFlag9_{$imageCounter}" id="{{sugarvar key='name'}}_{$imageCounter}_plan" {if $item.9 == 'on'}checked="checked"{/if}>планировка</span>
								</div>
								<input type="text" name="KEY_{$imageCounter}" id="KEY_{$imageCounter}" size="5" value="{$imageCounter+1}">&nbsp;
								<input type="text" name="{$module}imageFlag0_{$imageCounter}" id="{$module}imageFlag0_{$imageCounter}" size="30" value="{$item.0}">

								&nbsp;&nbsp;<input type="file"  name="{$module}imageFlag2_{$imageCounter}" maxlength="200" ACCEPT="image/*" size="1"   id="{{sugarvar key='name'}}_{$imageCounter}"  {{$displayParams.field}} onchange="multi_=false;uploadFile(this);"/>
								<br/><input style="margin-top:5px;" value="Редактировать изображение" type="button" title="{$module}imageRow{$imageCounter}" name="{$module}imageFlag2_{$imageCounter}_crop" id="{{sugarvar key='name'}}_{$imageCounter}_crop" {if $item.1 == ''}style="display: none"{/if} onclick="cropImage(this)"/>
							</td>

							<td>
								<input type="hidden" id="{{sugarvar key='name'}}_{$imageCounter}_crop_image_origin" {if is_file($origin_image)} value="origin_{$item.1}"{/if}/>

								<input type="hidden"   name="{$module}imageFlag2_{$imageCounter}" id="{{sugarvar key='name'}}_{$imageCounter}_crop_image" value="{$item.1}"/>

								<input type="hidden"   name="{$module}imageFlag1_{$imageCounter}" id="{$module}imageFlag1_{$imageCounter}"  value="{$item.1}" />

								<input type="hidden"   name="{$module}imageFlag3_{$imageCounter}" id="{{sugarvar key='name'}}_{$imageCounter}_crop_image_x" value="{$item.3}"/>

								<input type="hidden"   name="{$module}imageFlag4_{$imageCounter}" id="{{sugarvar key='name'}}_{$imageCounter}_crop_image_y" value="{$item.4}"/>

								<input type="hidden"   name="{$module}imageFlag5_{$imageCounter}" id="{{sugarvar key='name'}}_{$imageCounter}_crop_image_w" value="{$item.5}"/>

								<input type="hidden"   name="{$module}imageFlag6_{$imageCounter}" id="{{sugarvar key='name'}}_{$imageCounter}_crop_image_h" value="{$item.6}"/>

								 {if $item.1 != ''}
									{assign var = x     value = 1|rand:9999}
									&nbsp;&nbsp; <img src="{$upload_path}{$item.1}?qwer={$x}" style="height:80px;">
								{/if}
							</td>

							<td>
								&nbsp;&nbsp;<img onclick="delImageRow('{$module}imageRow{$imageCounter}')" id="{$module}removeButton0" class="id-ff-remove" name="0" src="{sugar_getimagepath file="id-ff-remove-new.png"}">
							</td>

						</tr>

						{assign var = imageCounter    value = $imageCounter+1}
					{/if}
                {/foreach}
                <input type="hidden" name="main_pos" id="main_pos" value="{$my_per}">
            </table>
        </td>
    </tr>
</table>
</span>
{/if}
{if empty($id)}
<b> Фотографии можно прикреплять только к созданной записи! </b>
{/if}







{literal}

<script type="text/javascript">


var iframe;
var tmpForm;
var crop_button;
var multi_=false;

function checkPresChbox($obj){
	/*var cheked=0;
	$('.pres_chb').each(function(){
		if($(this).is(":checked"))
			cheked++;
	});
	if(cheked>3)
		$obj.checked=false;*/
}

function uploadFile(element)
{
    var mainBody = $('body')[0];
    //Создаем невидимый фрейм со случайным именем
    iframe = document.createElement('iframe');
    iframe.name = 'ajax-frame-' + Math.random();
    iframe.className = 'x-hidden';
    //Размещаем фрейм в документе
    mainBody.appendChild(iframe);

    tmpForm = document.createElement('form');
    // Указываем в качестве цели созданый фрейм
    tmpForm.target = iframe.name;
    // Настраивайм форму-копию для передачи файла
    tmpForm.enctype = "multipart/form-data";
    tmpForm.method = "post";
    tmpForm.action = 'index.php?entryPoint=upload_photo';
    tmpForm.className = 'x-hidden';


{/literal}
    var module_name = document.createElement('input');
    module_name.type = 'hidden';
    module_name.name = 'module_name';
    module_name.value = '{$module}';

    var record_id = document.createElement('input');
    record_id.type = 'hidden';
    record_id.name = 'record_id';
    record_id.value = '{$id}';
{literal}
	if(!multi_)
		crop_button = document.getElementById(element.id + '_crop');

    var old_image = document.createElement('input');
    old_image.type = 'hidden';
    old_image.name = 'old_image';
	if(!multi_)
		old_image.value = document.getElementById(element.id + '_crop_image').value;

	var element_upload=element;// $('#'+element.id).clone()[0]; // just for FireFox
	tmpForm.appendChild(element_upload);
    tmpForm.appendChild(module_name);
    tmpForm.appendChild(record_id);
    tmpForm.appendChild(old_image);

    mainBody.appendChild(tmpForm);
    //Указываем функцию обработки отправки запроса
    iframe.onload = getResponse;
    //Отправляем запрос
    tmpForm.submit();
    //Удаляем форму-дубликат
    mainBody.removeChild(tmpForm);
    //tmpForm.removeNode(true);
} // uploadFile
/*
function clone(obj){
    if(obj == null || typeof(obj) != 'object')
        return obj;
    if(obj.constructor == Array)
        return [].concat(obj);
    var temp = {};
    for(var key in obj)
        temp[key] = clone(obj[key]);
    return temp;
}*/

function uploadFiles(){ // Kolerts
	var input = document.getElementById('gallery_upload_multy');
	//for every file...
	multi_= new Array();
	for (var i = 0; i < input.files.length; i++) {
		multi_.push(addImageRow());
		/*var upload_input=document.getElementById('galleria_c_'+$id);
		//upload_input.files = new array();
		var path=input.files[i].getAsDataURL();*/
	}
	uploadFile(input);
	input.files='';
}



function getResponse()
{
	//multi = multi || false;
    //Получение содержимого тела фрейма (ответ сервера)
    var body = iframe.contentDocument.getElementsByTagName('body')[0];
    var html = body.innerHTML;
    if (html) {
        //Эмулируем объект XMLHttpRequest
        var responseText = html;
        var response = {
            'responseText' : responseText
        };
        //Передаем полученый ответ на обработку
        processRequest(response);
    }
    // Удаляем созданый фрейм
    var mainBody = document.getElementsByTagName('body')[0];
    mainBody.removeChild(iframe);
    //iframe.removeNode(true);
} // getResponse







function processRequest (response)
{
	//multi = multi || false;
    console.log(response.responseText);
    eval("var result = " + response.responseText); // Расшифровка ответа
	var gallery_name=$('#gallery_name').val();

    if(!multi_)
		updateGalFields(result, 0);
	else{
		for(var i=0;i<multi_.length;i++){
			crop_button = document.getElementById(gallery_name+"_"+multi_[i] + '_crop');
			updateGalFields(result, i);
		}
	}
} // processRequest


function updateGalFields(result, idx){
	var td = document.getElementById(crop_button.id).parentNode.nextElementSibling;

    if (result[idx].status == 'ok') {
		$('#' + crop_button.id).css('display', '');

		document.getElementById(crop_button.id + '_image_x').value = '';
		document.getElementById(crop_button.id + '_image_y').value = '';
		document.getElementById(crop_button.id + '_image_w').value = '';
		document.getElementById(crop_button.id + '_image_h').value = '';

		var image_name = document.getElementById(crop_button.id + '_image');
		image_name.value = result[idx].file_name;

		var image_name_origin = image_name.previousElementSibling;
		image_name_origin.value = '';

		if(td.getElementsByTagName('img').length > 0)
		{
			td.removeChild(td.getElementsByTagName('img')[0]);
		}

		var img = document.createElement('img');

	{/literal} img.src = '{$upload_path}' + result[idx].file_name  + '?qwer=' + Math.random(); {literal}

		img.style.height = '80px';
		td.appendChild(img);

	}
	else { //ошибка
		delImageRow(crop_button.title);
		alert('Неподходящий файл!');
	}
}


jQuery(document).ready(function($) {
    var head = document.getElementsByTagName('head');
    head.innerHTML += '<style>.x-hidden {display:none;}</style>';
});











function cropImage (button)
{
        jQuery(function($){

    $('button.ui-button').button();
    var jcrop_api;

    var image_name = document.getElementById(button.id + '_image_origin');

    if (image_name == null || image_name.value == '') {
        image_name = document.getElementById(button.id + '_image');
    }
    if (image_name == null || image_name.value == '') {
        image_name = image_name.nextElementSibling;
    }

    image_name = image_name.value;


    var current_image = button.id + '_image_';

    var x = parseInt($('#' + current_image + 'x').val());
    var y = parseInt($('#' + current_image + 'y').val());
    var w = parseInt($('#' + current_image + 'w').val());
    var h = parseInt($('#' + current_image + 'h').val());


{/literal} var $dialog = $('<div><div class="jc-dialog" id="jc-dialog"><img src="{$upload_path}' + image_name + '?qwer=' + Math.random() +'"/></div></div>'); {literal}
    $dialog.find('img').Jcrop({},function(){
        jcrop_api = this;

        $dialog.dialog({
            modal: true,
            title: image_name,
            close: function(){ $dialog.remove(); },
            width: jcrop_api.getBounds()[0]+34,
            resizable: false
        })

        jcrop_api.ui.holder.addClass('jcrop-dark');
        jcrop_api.setOptions({
            bgColor: 'black',
            bgOpacity: 0.4,
            onSelect: updateCoords,
            onChange:   updateCoords,
            onRelease:  releaseCoords
        });

        if (w) {
            jcrop_api.setSelect([x, y, x + w, y + h]);
        }


    });


    var image_name = document.getElementById(button.id + '_image');

    if (image_name.value == '') {
        image_name = image_name.nextElementSibling.value;
    }
    else {
        image_name = document.getElementById(button.id + '_image').value;
    }



        $dialog.append('<div id="help_image_resize" style="display: none">Внимание! Любые изменения оригинала являются необратимыми операциями! <br/> Для восстановления загрузите исходный файл на сервер заново.<br/> Размер изображения может быть выставлен как в пикселях, так и в процентах, <br/> при этом возможно как уменьшение, так и увеличение изображения.</div>' +
        '<a id="help_image_resize_on" onclick="document.getElementById(\'help_image_resize\').style.display = \'\'; document.getElementById(\'help_image_resize_on\').style.display = \'none\';">Показать подсказку</a>' +
        '<table>'+
        '<input type="hidden" id="x" name="x" value="'+x+'"/>' +
        '<input type="hidden" id="y" name="y" value="'+y+'"/>' +
        '<input type="hidden" id="w" name="w" value="'+w+'"/>' +
        '<input type="hidden" id="h" name="h" value="'+h+'"/>' +

        '<input type="hidden" id="current_image" name="h" value="'+button.id+'"/>' +
        '<tr><td><input type="button" class="ui-button" value="Применить настройки" onclick="saveCrop(\''+button.id+'\')" /></td></tr>' +

        '<td>Заменить оригинал кропом? <input type="checkbox" id="replace_origin" name="replace_origin"/></td></tr>' +
        '<tr><td>Уменьшить оригинал до ширины(px,%): <input type="text" id="width_resize" name="width_resize" size="10" value=""/></td>' +
        '<td>Качество оригинала (0-100): <input type="text" id="quality" name="quality" size="10" value=""/></td></tr>' +

        '<input type="hidden" id="image_name" name="image_name" value="'+image_name+'"/>' +

{/literal}'<input type="hidden" id="upload_path" name="upload_path" value="{$upload_path}"/>'{literal} +

        '</table>');
});
}




function saveCrop(button_id)
{
    var x = $('#x').clone(true);
    var y = $('#y').clone(true);
    var w = $('#w').clone(true);
    var h = $('#h').clone(true);

    var replace_origin = $('#replace_origin').clone(true);
    var width_resize = $('#width_resize').clone(true);
    var quality = $('#quality').clone(true);
    var image_name = $('#image_name').clone(true);
    var upload_path = $('#upload_path').clone(true);

    var current_image = $('#current_image').val() + '_image_';
    $('#' + current_image + 'x').val(x.val());
    $('#' + current_image + 'y').val(y.val());
    $('#' + current_image + 'w').val(w.val());
    $('#' + current_image + 'h').val(h.val());

    var isValidResizeValues = false;
    var isValidQuality = false;
    var isValidWidthResize = false;
    var isWidthResizeInPercent = false;

    var width_resize_val = parseInt($('#width_resize').val());
    var str = $('#width_resize').val().toString();
    if(str.indexOf('%') + 1) {
        isWidthResizeInPercent = true;
    }

    var quality_val = parseInt($('#quality').val());

    $('#width_resize').val('');
    $('#quality').val('');



    if (!isNaN(width_resize_val) || !isNaN(quality_val)) {
        if ((quality_val >= 0 && quality_val <= 100) || isNaN(quality_val)) {
            isValidQuality = true;
        }
        if ((!isWidthResizeInPercent && width_resize_val >= 200 && width_resize_val <= 2000) || isNaN(width_resize_val)) {
            isValidWidthResize = true;
        }
        if ((isWidthResizeInPercent && width_resize_val >= 5 && width_resize_val <= 300) || isNaN(width_resize_val)) {
            isValidWidthResize = true;
        }
    }
    else {
        isValidQuality = true;
        isValidWidthResize = true;
    }

    if (isValidQuality && isValidWidthResize) {
        isValidResizeValues = true;
    }


    if (!isValidResizeValues) {
        alert('Некорректные параметры качества (0-100) или ширины (200-2000px, 5-300%)! Изменение оригинала не будет совершено!');
    }

    cropFile(x[0], y[0], w[0], h[0], width_resize[0], quality[0], image_name[0], upload_path[0], replace_origin[0], button_id, isValidResizeValues);
}



function updateCoords(c)
{
    $('#x').val(c.x);
    $('#y').val(c.y);
    $('#w').val(c.w);
    $('#h').val(c.h);
}


function releaseCoords ()
{
    $('#x').val('');
    $('#y').val('');
    $('#w').val('');
    $('#h').val('');
}








function cropFile(x, y, w, h, width_resize, quality, image_name, upload_path, replace_origin, button_id, isValidResizeValues)
{
    var mainBody = document.getElementsByTagName('body')[0];
    //Создаем невидимый фрейм со случайным именем
    iframe = document.createElement('iframe');
    iframe.name = 'ajax-frame-' + Math.random(1000000);
    iframe.className = 'x-hidden';
    //Размещаем фрейм в документе
    mainBody.appendChild(iframe);

    tmpForm = document.createElement('form');
    // Указываем в качестве цели созданый фрейм
    tmpForm.target = iframe.name;
    // Настраивайм форму-копию для передачи файла
    tmpForm.enctype = "multipart/form-data";
    tmpForm.method = "post";
    tmpForm.action = 'index.php?entryPoint=crop_photo';
    tmpForm.className = 'x-hidden';

    crop_button = document.getElementById(button_id);

    var isVal = document.createElement('input');
    isVal.type = 'hidden';
    isVal.name = 'isValidResizeValues';
    isVal.value = isValidResizeValues;

    tmpForm.appendChild(x);
    tmpForm.appendChild(y);
    tmpForm.appendChild(w);
    tmpForm.appendChild(h);
    tmpForm.appendChild(width_resize);
    tmpForm.appendChild(quality);
    tmpForm.appendChild(image_name);
    tmpForm.appendChild(upload_path);
    tmpForm.appendChild(replace_origin);
    tmpForm.appendChild(isVal);


    mainBody.appendChild(tmpForm);
    //Указываем функцию обработки отправки запроса
    iframe.onload = getCropResponse;
    //Отправляем запрос
    tmpForm.submit();
    //Удаляем форму-дубликат
    mainBody.removeChild(tmpForm);
}







function getCropResponse()
{
    var body = iframe.contentDocument.getElementsByTagName('body')[0];
    var html = body.innerHTML;
    if (html) {
        var responseText = html;
        var response = {
            'responseText' : responseText
        };
        processCropRequest(response);
    }
    var mainBody = document.getElementsByTagName('body')[0];
    mainBody.removeChild(iframe);
}








function processCropRequest (response)
{
    eval("var result = " + response.responseText); // Расшифровка ответа

        if (result.status == 'ok') {

    if (result.origin_chanched == 'true') {
        alert('Для просмотра изменений размера и качества оригинала откройте картинку для редактирования заново');
        $('#' + crop_button.id + '_image_x').val('');
        $('#' + crop_button.id + '_image_y').val('');
        $('#' + crop_button.id + '_image_w').val('');
        $('#' + crop_button.id + '_image_h').val('');
    }

    var image_origin = document.getElementById(crop_button.id + '_image_origin');

    if (result.origin_name_chanched == 'true') {
        image_origin.value = 'origin_' + result.file_name;
    }
    else {
        image_origin.value = result.file_name;
    }

    var td = document.getElementById(crop_button.id).parentNode.nextElementSibling;

    if(td.getElementsByTagName('img').length > 0)
    {
        td.removeChild(td.getElementsByTagName('img')[0]);
    }

    var img = document.createElement('img');

{/literal} img.src = '{$upload_path}' + result.file_name  + '?qwer=' + Math.random(); {literal}

    img.style.height = '80px';
    td.appendChild(img);

}
else {
    alert('fail');
}
}


</script>

{/literal}
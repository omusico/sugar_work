/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 * Upgraded By Kolerts
 */
var xls_limit = 20;
var xls_selected_ids;
var xls_ids_c, entryes_done, xls_steps, step_done;
var xls_relate_modules_f, xls_linked_modules_f;
var left_multiselect, right_multiselect;
var xls_post_arr, xls_arr_i;
function xls_update_related(){
	id_postfix = '';
	if(xls_relate_modules_f.val()!=''){
		if(xls_linked_modules_f.val()!='')
			xls_linked_modules_f.val('');
		id_postfix = xls_add_selects(xls_relate_modules_f, 'rel');
	}
	xls_rewrite_selects(id_postfix);
}
function xls_update_linked(){
	id_postfix = '';
	if(xls_linked_modules_f.val()!=''){
		if(xls_relate_modules_f.val()!='' )
			xls_relate_modules_f.val('');
		id_postfix = xls_add_selects(xls_linked_modules_f, 'ln');
	}
	xls_rewrite_selects(id_postfix);
}
function xls_add_selects($field, $type){
	module_val = $field.val();
	module_lbl = $field.find('option:selected').text();
	select_options = {};
	select_args='';
	xls_block_select = '_'+$type+'_'+module_val;
	xls_left_block_select_f = $('#left_multiselect'+xls_block_select);
	if(xls_left_block_select_f.length==0){
		xls_sel_option = $field.find('option:selected');
		xls_sel_option.show();
		xls_sel_option.removeAttr('disabled');
		if($type == 'rel'){
			$field.find('option:not(:selected)').each(function(){
				if($(this).val()!=''){
					$(this).hide();
					$(this).attr('disabled','disabled');
				}
			});
			select_args = 'data-type="rel"';
			select_args+= 'data-ext_where="'+xls_sel_option.data('ext_where')+'"';
			select_args+= 'data-key="'+xls_sel_option.data('key')+'"';
			select_args+= 'data-table="'+xls_sel_option.data('table')+'"';
			select_args+= 'data-module="'+module_val+'"';
			select_args+= 'data-module_lbl="'+module_lbl+'"';
		}
		else if($type == 'ln'){
			select_args = 'data-type="ln"';
			select_args+= 'data-rtype="'+xls_sel_option.data('type')+'"';
			select_args+= 'data-rel="'+xls_sel_option.data('rel')+'"';
			select_args+= 'data-module="'+module_val+'"';
			select_args+= 'data-module_lbl="'+module_lbl+'"';
		}
		response = $.ajax({
		  url: "index.php?module=Administration&action=xls_export&to_pdf=true&func=get_fields&module_name="+$field.val(),
		  async: false
		 }).responseText;
		select_options = JSON.parse(response);
		xls_lblock_append = xls_select_text('left', '_multiselect'+xls_block_select, select_args, 'Доступные поля('+module_lbl+')', select_options);
		$('#__xls_left_block').append(xls_lblock_append);
		xls_lblock_append = xls_select_text('right','_multiselect'+xls_block_select, select_args, 'Поля на экспорт('+module_lbl+')', {});
		$('#__xls_right_block').append(xls_lblock_append);
	}
	return xls_block_select;
}
function xls_select_text($type, $id, $args, $title, $options){
	select_text='<div class="header_select">'+$title+'</div>';
	select_text+='<select id="'+$type+$id+'" '+$args+' multiple class="__xls_'+$type+'_multiselect">';
	for(option in $options)
		select_text+='<option value="'+$options[option].val+'">'+$options[option].lbl+'</option>';
	select_text+='</select>';
	return select_text;
}
function xls_rewrite_selects($id_postfix){
	xls_rewrite_select($id_postfix, 'left');
	xls_rewrite_select($id_postfix, 'right');
	xls_left_multiselect = 'left_multiselect'+$id_postfix;
	xls_right_multiselect = 'right_multiselect'+$id_postfix;
	$("#success_end").hide(200);
}
function xls_rewrite_select($id_postfix, $type){
	xls_block_select_f = $('#'+$type+'_multiselect'+$id_postfix);
	$('.__xls_'+$type+'_multiselect').each(function(){
		$(this).hide();
		$(this).prev().hide();
	});
	xls_block_select_f.show();
	xls_block_select_f.prev().show();
}

function open_pop_up(box) {
    sugarListView.get_checks(); // Получаем отмеченные записи
        var dis = document.getElementById('massall_top').getAttribute('disabled');
    var check = document.getElementById('massall_top').getAttribute('checked');
    if(check === "checked" && dis === "disabled"){
        $('#selected_ids').val("all_items");
    }
    else
		$('#selected_ids').val(document.MassUpdate.uid.value); // Заносим в скрытый инпут ID всех записей через запятую
    $("#overlay").show();
    $(box).center_pop_up();
    $(box).show(500);
}

function close_pop_up(box) {
    $(box).hide(500);
    $("#overlay").delay(100).hide(1);
}

function getFieldsToExport()
{
    var arr = new Array();
    var i = 0;
	
	//Если после закрытия окна с ссылкой на файл, пользователь решил еще раз запустить экспорт, восстанавливаем прежнее окно генерации файла
    $("#success_end > #success_end_message").text("");
    $("#fountainG").show();
    $(".close_success_box_button").hide();
    $("#loading_message").text("Генерация документа...");
	$("#loading_message").css("color", "black");

	$('.__xls_right_multiselect').each(function(){
		$right_multiselect = $(this).attr('id');
		cur_multiselect=$('#'+$right_multiselect);
		$('#'+$right_multiselect+' option').each(function(){
			if(cur_multiselect.data('type')=='rel'){
				arr[i] = [
					this.text,
					this.value,
					'rel',
					cur_multiselect.data('module'),
					cur_multiselect.data('module_lbl'),
					cur_multiselect.data('table'),
					cur_multiselect.data('key'),
					cur_multiselect.data('ext_where')
				];
			}
			else if(cur_multiselect.data('type')=='ln'){
				arr[i] = [
					this.text,
					this.value,
					'ln',
					cur_multiselect.data('module'),
					cur_multiselect.data('module_lbl'),
					cur_multiselect.data('rel'),
					cur_multiselect.data('rtype')
				];
			}
			else{
				arr[i] = [ this.text, this.value];
			}
			i++;
		});
	});
   
	xls_module = $('#module_name').val();
	xls_selected_ids = $('#selected_ids').val();
	xls_listview_filter = $('textarea[name=listview_filter]').val();
	xls_all_list=$("#MassUpdate input[name=select_entire_list]").val();
	
	prepare_res = $.ajax({
	  url: 'index.php?module=Administration&action=xls_export&to_pdf=true&func=prepare&m_name='+xls_module,
	  async: false
	}).responseText;
	
    arr[i] = ["module", xls_module];
    arr[i+1] = ["records", xls_selected_ids, xls_listview_filter];
	
	if(xls_all_list=='1'){
		xls_selected_ids = $.ajax({
		  url: 'index.php?module=Administration&action=xls_export&to_pdf=true&func=get_ids&m_name='+xls_module+'&filter='+xls_listview_filter,
		  async: false
		}).responseText;
	}

//    $.getJSON('index.php?module=Administration&action=xls_export&to_pdf=true&all_list='+$("#MassUpdate input[name=select_entire_list]").val(), {
//        data: {
//            param: JSON.stringify(arr)
//        }
//       },
//        function(data){
//            $("#fountainG").hide();
//            $("#success_end > #success_end_message").append("Ссылка на скачивание файла <a href='" + data.result + "'>" + $("#module_name").val() + ".xls</a>");
//            $("#loading_message").text("Сгенерирован успешно!").css("color", "green");
//            $(".close_success_box_button").css("display", "inline-block");
//        }
//    );
	
	xls_ids_arr = xls_selected_ids.split(',');
	//xls_limit
	xls_ids_c=xls_ids_arr.length;
	if(xls_all_list==1)
		xls_ids_c++;
    $("#loading_message").text("Генерация документа...\nОбработано записей 0/"+xls_ids_c);
	
	xls_steps = Math.ceil(xls_ids_c/xls_limit);
	step = 0;
	entryes_done=0;
	step_done=0;
	request_delay=100;
	xls_post_arr = [];
	while(step<xls_steps){
		sql_ids_arr = [];
		for(var ii = step*xls_limit; ii < (step+1)*xls_limit; ii++){
			if(ii<xls_ids_c){
				sql_ids_arr.push(xls_ids_arr[ii]);
			}
		}
		sql_ids = sql_ids_arr.join(',');
		arr[i+1] = ["records", sql_ids, xls_listview_filter];
		step++;
		xls_post_arr.push(JSON.stringify(arr));
	}
	xls_arr_i=0;
	for(arr_i in xls_post_arr){
		xls_arr_i = arr_i;
		setTimeout(function(){
			$.post( 'index.php?module=Administration&action=xls_export&to_pdf=true&all_list=0',
				{'param':xls_post_arr[xls_arr_i]}
			).done(function( response ) {
				if(isJSON(response)){
					data = JSON.parse(response);
					entryes_done+=data.num;
				}
				step_done++;
				$("#loading_message").text("Генерация документа...\nОбработано записей "+entryes_done+'/'+xls_ids_c);
				if(step_done==xls_steps){
					save_res = $.ajax({
					  url: 'index.php?module=Administration&action=xls_export&to_pdf=true&func=save_file&m_name='+xls_module,
					  async: false
					}).responseText;
					sdata = JSON.parse(save_res);
					$color = (entryes_done<xls_ids_c)?'#b00':'#0b0';
					$result = (entryes_done<xls_ids_c)?'c ошибками':'успешно!';
					$res_rext = "Обработано записей <font color='"+$color+"'>"+entryes_done+'/'+xls_ids_c+'</font><br/>';
					$res_rext+= "Добавлено строк за счет субпанелей: "+(sdata.num-entryes_done)+'<br/>';
					$res_rext+= "Ссылка на скачивание файла <a href=" + sdata.link + ">" + $("#module_name").val() + ".xls</a>";
					$("#fountainG").hide();
					$("#success_end > #success_end_message").html($res_rext);
					$("#loading_message").text("Сгенерирован "+$result).css("color", $color);
					$(".close_success_box_button").css("display", "inline-block");
				}
			});
			xls_arr_i++;
		}
		,request_delay);
		request_delay+=1000;
		xls_arr_i=0;
	}
	/**
		while(step<steps){
			sql_ids_arr = [];
			for(var ii = step*xls_limit; ii < (step+1)*xls_limit; ii++) {
				if(ii<xls_ids_c){
					sql_ids_arr.push(xls_ids_arr[ii]);
					entryes_done++;
				}
			}
			sql_ids = sql_ids_arr.join(',');
			arr[i+1] = ["records", sql_ids, xls_listview_filter];
			step++;
			data = $.ajax({
				type: 'POST',
				url:'index.php?module=Administration&action=xls_export&to_pdf=true&all_list='+xls_all_list,
				data:{'param':JSON.stringify(arr)},
				async:false
			}).responseText;
			$("#loading_message").text("Генерация документа...\nОбработано записей "+entryes_done+'/'+xls_ids_c);
		}
		$("#fountainG").hide();
		$("#success_end > #success_end_message").append("Ссылка на скачивание файла <a href=" + data + ">" + $("#module_name").val() + ".xls</a>");
		$("#loading_message").text("Сгенерирован успешно!").css("color", "green");
		$(".close_success_box_button").css("display", "inline-block");
	*/
}
function isJSON(str) {
    try {JSON.parse(str);
    } catch (e) {return false;
    } return true;
}

jQuery.fn.center_pop_up = function(){
    this.css('position','absolute');
    this.css('top', ($(window).height() - this.height()) / 2+$(window).scrollTop() + 'px');
    this.css('left', ($(window).width() - this.width()) / 2+$(window).scrollLeft() + 'px');
}

// Предотвращаем лишние добавления элементов списка при нажатии на кнопку базовый поиск и расширенный поиск

if (!$("#actionLinkTop > .sugar_action_button > .subnav > li").hasClass('xls_li')){
    $('#actionLinkTop > .sugar_action_button > .subnav').append('<li class="xls_li"><a href="#" name="xls_export" id="xls_export" class="xls" onclick="open_pop_up(\'#pop-up\'); return false;">Экспортировать в Excel</a></li>');
}

if (!$("#actionLinkBottom > .sugar_action_button > .subnav > li").hasClass('xls_li')){
    $('#actionLinkBottom > .sugar_action_button > .subnav').append('<li class="xls_li"><a href="#" name="xls_export" id="xls_export" class="xls" onclick="open_pop_up(\'#pop-up\'); return false;">Экспортировать в Excel</a></li>');
}

function xls_update_fields($func){
	$("#success_end > #success_end_message").text("");
    $("#loading_message").text("Обновление полей..");
	$("#loading_message").css("color", "black");
	$("#success_end").fadeIn(200);
	$("#success_end").center_pop_up();
	setTimeout($func,200);
}
function get_data_config(config_id){
	/* var options_right = $('#right_multiselect option');
	$('#right_multiselect').each(function(){
	   $('#left_multiselect').append(options_right);
	}); */
	$('.__xls_right_multiselect').each(function(){
		$right_multiselect = $(this).attr('id');
		$msel_arr=$right_multiselect.split('_');
		$msel_id = '';
		if($msel_arr[2]!=undefined){
			$msel_id = '_'+$msel_arr[2]+'_'+$msel_arr[3];
		}
		var options_right = $('#right_multiselect'+$msel_id+' option');
		$('#right_multiselect'+$msel_id).each(function(){
			$('#left_multiselect'+$msel_id).append(options_right);
		});
	});

   $.ajax({
		type: 'POST',
		url:'index.php?module=Administration&action=xls_export&to_pdf=true',
		data:{
			func:'get_config_data',
			config_id: config_id
		},
		success: function(data){
//                left_multiselect = $('#left_multiselect');
//                $('#right_multiselect').append(left_multiselect_select);
			if(data){
				data1 = JSON.parse(data);
				for(var key in data1){
					sub_msel_data = key.split('_');
					$sub_msel_id='';
					if(sub_msel_data[0]!='undefined'){
						if(sub_msel_data[0]=='rel'){
							xls_relate_modules_f.val(sub_msel_data[1]);
							xls_update_related();
						}
						else{
							xls_linked_modules_f.val(sub_msel_data[1]);
							xls_update_linked();
						}
						$sub_msel_id='_'+key;
					}
					for(var sub_val in data1[key]){
						// $("#left_multiselect option[value='" + sub_val + "']").attr("selected", 1);
						// var selected = $('#left_multiselect option:selected');
						$('#right_multiselect'+$sub_msel_id).append($("#left_multiselect"+$sub_msel_id+" option[value='" + sub_val + "']"));
						// selected.attr('selected', false);
					}
				}
				
			}
			else if(data==""){
				var selected = $('#right_multiselect option:selected');
				$('left_multiselect').append(selected);
				selected.attr('selected', false);
			}
			else{
				alert("Ошибка!");
			}
		}
	});
}

$(document).ready(function(){
	xls_left_multiselect = 'left_multiselect';
	xls_right_multiselect = 'right_multiselect';
	xls_relate_modules_f=$('#__xls_relate_modules');
	xls_linked_modules_f=$('#__xls_linked_modules');
	xls_relate_modules_f.change(function(){xls_update_fields(xls_update_related)});
	xls_linked_modules_f.change(function(){xls_update_fields(xls_update_linked)});
	/* $('.__xls_left_multiselect').live('focus', function(){
		xls_left_multiselect = $(this).attr('id');
	});
	$('.__xls_right_multiselect').live('focus', function(){
		xls_right_multiselect = $(this).attr('id');
	}); */
	
    $('#to_right').click( function()
    {
        var selected = $('#'+xls_left_multiselect+' option:selected');
        $('#'+xls_right_multiselect).append(selected);
        selected.attr('selected', false);
    });

    $('#to_left').click( function()
    {
        var selected = $('#'+xls_right_multiselect+' option:selected');
        $('#'+xls_left_multiselect).append(selected);
        selected.attr('selected', false);
    });

    $('#up').click( function(){
        $('#'+xls_right_multiselect+' option:selected').each( function() {
            var newPos = $('#'+xls_right_multiselect+' option').index(this) - 1;
            if (newPos > -1) {
                $('#'+xls_right_multiselect+' option').eq(newPos).before("<option value='"+$(this).val()+"' selected='selected'>"+$(this).text()+"</option>");
                $(this).remove();
            }
        });
    });
    $('#down').click(function() {
        var countOptions = $('#'+xls_right_multiselect+' option').size();
        $('#'+xls_right_multiselect+' option:selected').each( function() {
            var newPos = $('#'+xls_right_multiselect+' option').index(this) + 1;
            if (newPos < countOptions) {
                $('#'+xls_right_multiselect+' option').eq(newPos).after("<option value='"+$(this).val()+"' selected='selected'>"+$(this).text()+"</option>");
                $(this).remove();
            }
        });
    });

    $('#submit_button').click(function(){

        if($("#right_multiselect option").size() > 0)
        {
            $("#pop-up").fadeOut(500);
            $("#success_end").fadeIn(600);
            $("#success_end").center_pop_up();
            getFieldsToExport();
        }
		else {
            alert("Вы не выбрали поля для экспорта!");
        }

    });

    $('.close_success_box_button').click(function(){
        close_pop_up("#success_end");
    });
    $('#cancel_button_').click(function(){
        close_pop_up("#pop-up");
		$("#config").fadeOut(1);
        $("#config_name").val("");
        $("#all_visible").removeAttr("checked");
    });
	
	
	$("#user_config_select").change(function(){
        $("#to_left").trigger("click");
        get_data_config($(this).val());
    });
    $('#save_config_button').click(function(){
        selectInputs = document.getElementById('right_multiselect');
        countOpt = selectInputs.length;
        //console.log();
        if ( countOpt != null && countOpt != 'undefined' && countOpt != '') {
            $("#config").fadeIn(500);
            //return false;
        }
        else
			alert("Вначале выберите поля!");
    });
    $('#save_config').click(function(){
		var  jsonArray = new Object();
		$('.__xls_right_multiselect').each(function(){
			tmpArray = new Object();
			$right_multiselect = $(this).attr('id');
			cur_multiselect=$('#'+$right_multiselect);
			cur_multiselect.find('option').each(function(){
				tmpArray[$(this).val()] = $(this).text();
			});
			jsonArray[cur_multiselect.data('type')+'_'+cur_multiselect.data('module')]=tmpArray;
		});
		/* right_multiselect = document.getElementById('right_multiselect');
		$.each(right_multiselect, function(index, element){
		   jsonArray[element.value] = element.text;
		}); */

		// user_id = $('input[name=id_current_user]').val();
		current_module = $('#module_name').val();//$('input[name=current_module_config]').val();
		config_name = document.getElementById('config_name').value;
		all_visible = $('#all_visible').prop("checked");

		if(all_visible) all_visible = 1;
		else if(!all_visible) all_visible = 0;

        $.ajax({
            type: 'POST',
            url:'index.php?module=Administration&action=xls_export&to_pdf=true',
            data:{
                func:'save_config',
                config_name: config_name,
                current_module:current_module,
                all_visible: all_visible,
                // user_id:user_id,
                fields_list: $.toJSON(jsonArray)
            },
            success: function(data){
                if(data == '1'){
                    alert("Конфигурация успешно сохранена");
                    $("#config").fadeOut("fast");
                }
                else if(data == "name_error") alert("Такое имя конфигурации уже существует, задайте другое имя");
                else alert("Что-то пошло не так, обратитесь к администратору");
            }
        });
    });
    $('#cancel_config').click(function(){
        $("#config").fadeOut(500);
    });
   $('#select_button').click(function(){
		current_module = $('#module_name').val();//$('input[name=current_module_config]').val();
		data = $.ajax({
			url:'index.php?module=Administration&action=xls_export&to_pdf=true&func=open_config_select&m_name='+current_module,
			async:false
		}).responseText;
		if(data != ""){
			$("#user_config_select").html(data);
			$("#user_config").fadeIn(500);
		}
		else if(data == "") alert("Ниодной конфигурации не сохранено!");
    });
    $('#ok_user_config').click(function(){
        $("#user_config").hide(500);
    });
});
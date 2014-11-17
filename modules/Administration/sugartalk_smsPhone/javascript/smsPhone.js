/* javascript */
/*
 * This script is being used by 
 * ./modules/Administration/sugartalk_smsPhone/smsPhone.js.php
 * ./modules/Administration/sugartalk_smsPhone/sms_processor.php
 * ./modules/Administration/smsPhone.php
 * ./modules/Administration/smsProvider.php
 * 
 * */

$(document).ready(function() { 
		
	/* for some reason, the jQ click() shorthand suddenly didn't work so i had to convert this into a crappy function instead.. duh!  */
	move_to = function (direction) {

		$("input[type=button]#save").attr("disabled", false);
		if (direction == 'right') {
		var items = ''; 
			$.each($("div#original div.item_sel"), function() {
				items += "<div class='item' id='" + $(this).attr('id') + "' onclick='select(this);' title='Нажмите, чтобы выбрать или отменить'>" + $(this).text() + "</div>";
			});
			$("div#selection").html( $("div#selection").html() + items );
			$("div#original div.item_sel").remove();
		} else {
			var items = ''; 
			$.each($("div#selection div.item_sel"), function() {
				items += "<div class='item' id='" + $(this).attr('id') + "' onclick='select(this);' title='Нажмите, чтобы выбрать или отменить'>" + $(this).text() + "</div>";
			});
			$("div#original").html( $("div#original").html() + items );
			$("div#selection div.item_sel").remove();
		}
	}
 
	save_customization = function() {
		
		if ($("div#selection div").length==0) {
			if (!confirm("Нажмите кнопку ОК, чтобы очистить поле настройки телефона " + $("select#module").val())) {
				return false;
			}
		}
	
		var fields = Array(); 
		$("input[type=button]#save").attr("disabled", true);
		$.each($("div#selection div"), function() {
			fields.push($(this).attr('id')); 
		}); 
		$("#field_panels").html("Обработка ... Пожалуйста, подождите!");
		$.get("./index.php?module=Administration&action=smsPhone&sugar_body_only=1", { m:$("select#module").val(), option:2, 'fields[]':fields  }, function(data) {	
			$("#field_panels").html(data);
		});
	} 
	 
	check_macro_requirements = function () {
		var str = jQuery.trim(document.getElementById('macro_string').value);
		if (document.getElementById('macro_field')==null || str=='') {
			alert("Вы должны выбрать поле и введисти макро строку SMS."); return false;
		}
		
		if (str.split(" ").length > 1) {
			alert("Ваша макро строка SMS не должна содержать пробелов."); return false;
		}
		
		return true;
	}
	
	rem_sms_macro = function (m) {
		if (confirm("Нажмите кнопку ОК, чтобы удалить SMS макрос для " + m +".")) {
			$("input[type=hidden]#macro_to_remove").val(m);
			document.macro_remove.submit();
			return true;
		} else return false;
	}
	
	load_fields = function(x) {
		if(x=='panel') {  
			$("div#field_panels").html("");
			if ($("select#module").val() != '') { 
				$("div#field_panels").html("Обработка ... Пожалуйста, подождите!");
				$.get("./index.php?module=Administration&action=smsPhone&sugar_body_only=1", { m:$("select#module").val(), option:1  }, function(data) {
					$("div#field_panels").html(data);
				});
				$("input[type=button]#save").attr("disabled", false);
			} else {
				$("input[type=button]#save").attr("disabled", true);
			}
		} else { 
			if ($("select#module").val() != '') {
				$("td#field_cell").html("Загрузка ...");
				$.get("./index.php?module=Administration&action=smsProvider&sugar_body_only=1", { m:$("select#mod").val(), option:'load_mod_fields' }, function(data) {
					$("td#field_cell").html(data);
				});
			}
		} 
	};
	
	select = function(obj) { 
		var c;
		if ($("#"+obj.id).attr("class") == "item") {
			c = "item_sel";
		} else { 
			c = "item";
		}
		$("#"+obj.id).removeClass();
		$("#"+obj.id).addClass(c);
	}; 
	
	check_sms_len = function () {
		$("input[type=button]#send").attr('disabled', false);
		$("span#sms_len_notifier").html($("textarea#sms_msg").val().length + "/140 characters.");
		if ($("textarea#sms_msg").val().length > 140 || $("textarea#sms_msg").val().length==0) {
			$("input[type=button]#send").attr('disabled', true);
		}
	};
	
	show_tip = function() { 
        var tip = "<p>Пожалуйста, введите полный номер без разделителя в следующем формате" +
		        "<div align='center'>&lt; КОД СТРАНЫ &gt;&lt; НОМЕР ТЕЛЕФОНА &gt;</div></p>" +
		        "<p>Пример:</p><table><tr><td>Украина (+38) </td><td>&nbsp;&nbsp;<strong>0502994488</strong></td></tr>" +
		        "<tr><td>Россия (+7) </td><td>&nbsp;&nbsp;<strong>9500123456</strong></td></tr>" +
		        "<tr><td>Албания (+355) </td><td>&nbsp;&nbsp;<strong>3554234567</strong></td></tr></table>";

		$('div#smstip').html(tip).fadeIn("fast");
	};
	
	hide_tip = function () {
		$('div#smstip').html('').fadeOut("fast");
	}; 

	save_settings = function () {
		var url = "./index.php?module=Administration&action=smsProvider&sugar_body_only=1&option=save&g=" + $("select#sms_gateway").val();
		$("div#response_text").html("Сохранение ... Пожалуйста, подождите!");
		$.post(url, $("form#frm_settings").serialize(), function(data) {
			$("div#response_text").html(data);
		});  
	};
	
	test_connection = function () { 
		var url = "./index.php?module=Administration&action=smsProvider&sugar_body_only=1&option=test_conn";
		$("div#response_text").html("Установление соединения с сервером ... Пожалуйста, подождите!");
		$.post(url, $("form#frm_settings").serialize(), function(data) { 
			$("div#response_text").html(data); 
		}); 
		
		
	};
	
	send_sms = function () { 
			
		var send_to_multi = $("input[type=hidden]#send_to_multi").val(); 
		var ptype = $("input[type=hidden]#ptype").val();
		var url = "./index.php?module=Administration&action=smsProvider&sugar_body_only=1&option=send"; 
		var msg = $("textarea#sms_msg").val();
		var num = $("input[type=text]#number").val();
		var pname = $("input[type=hidden]#pname").val();
	
		if(send_to_multi == 1) {
			// retrieve parent ids
			var x = document.getElementsByName('pids');
			var arr = new Array();
			for(var i=0; i<document.getElementsByName('pids').length;  i++) {
				arr.push(x[i].value);
			} 
			var pid = arr.toString();
			if ($("div.recipient").length == 0) { 
				alert("Вы должны ввести по крайней мере 1 получателя.");
				return false;
			}
		} else {
			var pid = $("input[type=hidden]#pid").val(); 
		}
		
		$("div#editor_style").html("Отправка ... Пожалуйста, подождите!").css("padding", "30px").css("font-weight","bold");
		 
		$.post(url, { num:num, sms_msg:msg, send_to_multi:send_to_multi, pid:pid, ptype:ptype, pname:pname}, function(data) { 
			if ((jQuery.trim(data)=="SENT") && send_to_multi==0) { 
				var res = "Сообщение отправлено. Нажмите кнопку F5, чтобы обновить ваше окно.<br>";
				res += "<input type='button' class='button' value='RELOAD' onclick='window.location.reload();'>";
				$("div#editor_style").html(res).css("padding", "30px").css("font-weight","bold"); 
			} else {
				$("div#editor_style").html(data).css("padding", "30px").css("font-weight","bold");
			} 
			
		}); 
		
	};

        balance = function () {
            var url = "./index.php?module=Administration&action=smsProvider&sugar_body_only=1&option=balance";
		$.post(url, function(data) {
			alert(data);

		});

	};
	
	resend_sms = function() {
		var msg = $("textarea#sms_msg").val(); 
		var num = $("input[type=text]#number").val(); 
		var url = "./index.php?module=Administration&action=smsProvider&sugar_body_only=1&option=resend";
		var rec = $("input[type=hidden]#pid").val();
		
		$("div#editor_style").html("Отправка ... Пожалуйста, подождите!").css("padding", "30px").css("font-weight","bold");
		
		$.post(url, { num:num, sms_msg:msg, rec:rec }, function(data) {
			if ((jQuery.trim(data)=="SENT")) { 
				var res = "Сообщение отправлено. Нажмите кнопку F5, чтобы обновить ваше окно.<br>";
				res += "<input type='button' class='button' value='RELOAD' onclick='window.location.reload();'>";
				$("div#editor_style").html(res).css("padding", "30px").css("font-weight","bold"); 
			} else {
				$("div#editor_style").html(data).css("padding", "30px").css("font-weight","bold");
			} 
		});	
	}; 
	
	load_sms_for_resending = function () {
		var url = "./index.php?module=Administration&action=smsProvider&sugar_body_only=1&option=editor&rec=" + $("input[type=hidden][name=record]").val(); 
		$.openPopupLayer({
			name: "div_sms_sender",
			width: 400,
			url: url
		}); 
	}
	
	open_url = function (url) {
		if (url.substr(0,4) != "http") 
			url = "http://" + url;
		var w = window.open(url,"win","heigh=400,width=700,top=0,left=0,scrollbars=yes,resizable=yes");
		w.focus();
		return true;
	};
	$('input#sender').blur(function () {	
		validate_sender_name();
	});

	validate_sender_name = function () {
		var patt = /[^0-9a-zA-Z]/g;
		var name = $('input#sender').val();
		if(name.match(patt) != null) {
			alert('Имя отправителя должно содержать только буквенно-цифровые символы.\nПожалуйста, внести необходимые коррективы.');
			return false;
		}
		return true;
	}
	
	function inform_closing() {
		$('div#editor_style').html('Вы удалили всех получателей. <br>Нажмите кнопку "Закрыть", чтобы закрыть это сообщение.').css('padding', '30px').css('font-weight','bold');
	}
	 

});


// the scripts below are being used on the Detail view for sending sms messages

$.setupJMPopups({
	screenLockerBackground: "#050505",
	screenLockerOpacity: "0.6"
}); 
  
 

function openAjaxPopup(num,ptype,pid,pname) { 
	var url = "./index.php?module=Administration&action=smsProvider&sugar_body_only=1&option=editor&num=" + num + "&ptype=" + ptype + "&pid=" + pid + "&pname=" + pname; 
	$.openPopupLayer({
		name: "div_sms_sender",
		width: 400,
		url: url
	});
}


function closePopUp() {
    $('#editor_boundary').css('display','none');
    $('#popupLayer_div_sms_sender').css('display','none');
    $('#popupLayerScreenLocker').css('display','none');
}

function openAjaxPopupForMulti(arr,ptype,pid) { 
	var obj = document.getElementsByName(arr);
	var temp = new Array();
	var i;
	for (i=0;i<obj.length;i++) {
			if (obj.item(i).checked)
					temp.push(obj.item(i).value);
	}

	var url = "./index.php?module=Administration&action=smsProvider&sugar_body_only=1&option=editor&num=multi&ptype=" + ptype + "&pid=" + temp.toString();

	$.openPopupLayer({
			name: "div_sms_sender",
			width: 500,
			url: url
	});

}
 
function load_message(id) {
	var url = "./index.php?module=Administration&action=smsProvider&sugar_body_only=1&option=template"; 
	$.get(url, { id: id }, function(data) {
		$("textarea#sms_msg").val(data);
		check_sms_len(data.length);
	});
	 
	
}

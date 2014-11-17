<?php
# This module show an sms icon to phone numbers where a user can send sms
# Applicable to Detail View
# c/o tracy

function sms_phone($focus, $field, $value, $view) {
  	global $beanList;
	$temp_field = $field;
	$phone_num = trim($focus->$temp_field);
	if($view == 'EditView' || $view == 'MassUpdate' || $view == 'QuickCreate') { //If this is EditView Or MassUpdate Include a field box 
	
		$phone_num = edit_field($field, $phone_num);//"<input type='text' name='{$field}' id='{$field}' value='{$phone_num}'>";
	
	} else {
	
		if($focus->object_name == 'Case'){
				$ptype = 'Cases';
	        }else{
				$ptype = array_search($focus->object_name, $beanList);
	        }
		$pname = $focus->name;
		require_once("./modules/Administration/sugartalk_smsPhone/smsPhone.js.php");
		if (strlen(trim($phone_num))){
			$phone_num = get_visible_field($phone_num);
 			$phone_num .= "&nbsp; <img style='border:none;cursor:pointer;' 
					title='Нажмите, чтобы отправить SMS. Открытие редактора может занять некоторое время.'
					src='./modules/Administration/sugartalk_smsPhone/image/cellphone.gif'
					onclick=\"openAjaxPopup('" . urlencode($phone_num). "','{$ptype}','{$focus->id}','{$pname}');\">";
		}
	}
	return $phone_num;
}
function get_visible_field($phone_num){
	$phone_num=explode('^|^',$phone_num);
	return $phone_num[0];
}
function edit_field($field_name, $phone_num){
	$phone_num_v=get_visible_field($phone_num);
	$html = "<input type='text' name='{$field_name}_vis' id='{$field_name}_vis' size='30' value='{$phone_num_v}' class='phone' placeholder='8 495 1234567'
				onkeyup=\"toValidPhoneElement(this, '{$field_name}');\"
				onkeypress=\"toValidPhoneElement(this, '{$field_name}');\"
				onpaste=\"toValidPhoneElement(this, '{$field_name}');\"
				onchange=\"checkDublicatePhoneNew(this, '{$field_name}');\">";
	$html .="<input type='hidden' name='{$field_name}' id='{$field_name}' value='{$phone_num}'>";
	$html .="<div id='{$field_name}_vis_mes' style='color:#f00;font-weight:bold;'></div>";
	$html .=echo_edit_js();
	return $html;
}
function echo_edit_js(){
	$html = "<script type='text/javascript'>
	
		function toValidPhoneElement(element, field){
			element.style.backgroundColor = '#FFF';
			element.style.border='1px solid #94C1E8';
			document.getElementById(element.id+'_mes').innerHTML='';

			var tmp_val=element.value;
			while(tmp_val.match(/[^0-9]/)){
				tmp_val = tmp_val.replace(/[^0-9]/, '');
			}
			tmp_val=tmp_val.substring(tmp_val.length, tmp_val.length-10);
			document.getElementById(field).value=element.value+'^|^'+tmp_val;

			return true;
		}

		function checkDublicatePhoneNew(element, field_name){
			document.getElementById(element.id+'_mes').innerHTML='<img src=themes/Sugar5/images/img_loading.gif>';
			
			var phone_num=element.value;
			while(phone_num.match(/[^0-9]/)){
				phone_num = phone_num.replace(/[^0-9]/, '');
			}
			phone_num=phone_num.substring(phone_num.length, phone_num.length-10);
			
			var link = 'index.php?entryPoint=check_phone';
			link+='&module='+module_sugar_grp1.toLowerCase();
			link+='&fname='+field_name;
			link+='&pnum='+phone_num;
			link+='&id='+document.getElementsByName('record')[0].value;
			var res = loadHTML(link);
			//alert(res);
			if(res=='true'){
				element.style.backgroundColor = '#fee';
				element.style.border='2px solid #f00';
				document.getElementById(element.id+'_mes').innerHTML='по данному номеру найден дубликат';
			}else
				document.getElementById(element.id+'_mes').innerHTML='';
		}
		
		function loadHTML(sURL)
		{
			var request=null;
			if(!request) try{request=new ActiveXObject('Msxml2.XMLHTTP');} catch (e){}
			if(!request) try{request=new ActiveXObject('Microsoft.XMLHTTP');} catch (e){}
			if(!request) try{request=new XMLHttpRequest();} catch (e){}
			if(!request) return '';
			request.open('GET', sURL, false);
			request.send(null);
			return request.responseText;
		}
		</script>
	";
	return $html;
}

?>

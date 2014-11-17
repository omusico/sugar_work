{{capture name=idname assign=idname}}{{sugarvar key='name'}}{{/capture}}
{{if !empty($displayParams.idName)}}
{{assign var=idname value=$displayParams.idName}}
{{/if}}

{if strlen({{sugarvar key='value' string=true}}) <= 0}
    {assign var="value" value={{sugarvar key='default_value' string=true}} }
{else}
	{assign var="value" value={{sugarvar key='value' string=true}} }
{/if}
{assign var=val_vis value="^|^"|explode:{{sugarvar key='value' string=true}}}

{assign var="required" value={{sugarvar key='required' string=true}} }

<input type='text' name='{{$idname}}_vis' id='{{$idname}}_vis' size='{{$displayParams.size|default:30}}' value='{$val_vis[0]}' class='phone' placeholder='8 495 1234567'
				onkeyup="toValidPhoneElement(this, '{{$idname}}');"
				onkeypress="toValidPhoneElement(this, '{{$idname}}');"
				onpaste="toValidPhoneElement(this, '{{$idname}}');"
				onchange="checkDublicatePhoneNew(this, '{{$idname}}');">
<input type='hidden' name='{{$idname}}' id='{{$idname}}' value='{$value}'>
<div id='{{$idname}}_vis_mes' style='color:#f00;font-weight:bold;'></div>


<script type="text/javascript">
{literal}

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


{/literal}
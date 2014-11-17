/*
*	Created by Kolerts
*/

var index=0;
//var container;

function add_e($element){
	if		($element.value=='1')
		add_element($element);
	else if	($element.value=='2')
		add_node($element);
	else if	($element.value=='3')
		add_prop($element);
	else if	($element.value=='4')
		add_cdata($element);
	
	$element.value='0';
}
function add_element($element, $text, $type, $input_style){
	add_item($element, null, 'item', 'border:1px solid #00b;');
}function add_node($element, $text, $type, $input_style){
	add_item($element, null, 'node', 'border:1px solid #000;');
}function add_prop($element, $text, $type, $input_style){
	add_item($element, "parametr=value", 'prop', 'border:1px solid #b00;');
}function add_cdata($element, $text, $type, $input_style){
	add_item($element, null, 'cdata', 'border:1px solid #b80;');
}
function add_item($element, $text, $type, $input_style, $index, $static){
	if($index==undefined)
		index++;
	else
		index=$index;
// alert('s:'+$static);
	var index_id='';
	var $item_text='';
	var $head='';
	if($type=='item')
		index_id=index;
	else
		index_id=$type+index;

	if($text==null)
		$text=$element.previousElementSibling.previousElementSibling.value;
	if($static!=undefined){
		if($static==1)
			$head="checked="+$static;
	}else	if($element.previousElementSibling && $element.previousElementSibling.checked)
		$head="checked="+$element.previousElementSibling.checked;
		

	$item_text+="<div id='"+index_id+"' name='element_div' class='element_div' value=''>"+$type+
			" <input type='text' id='element_"+index+"' style='"+$input_style+"' name='elements' value='"+$text+"' onchange='save_change(this);' "+$head+" />"+
			" <input type='checkbox' id='head_"+index+"' name='elements_head' "+$head+" onchange='save_change_chk(this);'> ";
	if($type=='item')
		$item_text+="<select id='add_"+index+"' onchange='add_e(this);'>"+
			"<option value='0' selected='true'>добавить</option>"+
			"<option value='1'>элемент</option>"+
			"<option value='2'>текст</option>"+
			"<option value='3'>параметр</option>"+
			"<option value='4'>cdata</option>"+
			"</select>";
	$item_text+="<button id='del_"+index+"' onclick='remove_element(this);'>del</button>"+
			"</div>\n";
	$element.parentNode.innerHTML+=$item_text;
	return index;
}

function save_change($element){
	//if(confirm('Применить изменения?'))
		$element.setAttribute('value',$element.value);//fix innerHTML onchange input value
	/*else
		$element.parentNode.innerHTML+='';//update innerHTML*/
}
function save_change_chk($element){
	if($element.checked){
		$element.setAttribute('checked',$element.checked);//fix innerHTML onchange input value
		$element.previousElementSibling.setAttribute('checked',$element.checked);
	}else{
		$element.removeAttribute('checked');//fix innerHTML onchange input value
		$element.previousElementSibling.removeAttribute('checked');
	}
}

function remove_element($element){
    var parent=$element.parentNode;
	return parent.parentNode.removeChild($element.parentNode);
}

function getChildren($list, $div, $t)
{
	var children = $div.childNodes;
	var count=children.length;
	
	for(var $i=0;$i<count;$i++) {
		var child=children[$i];
		if(child.nodeType==1 && child.tagName=='INPUT' && child.getAttribute('name')=='elements'){
			var $checked=0;
			if(child.getAttribute('checked'))
				$checked=1;
			element=[$t,$div.id,child.value, $checked];
			$list.push(element);
		}
	}
	$t+=$div.id+'_';
	for(var $i=0;$i<count;$i++) {
		var child=children[$i];
		if(child.nodeType==1 && child.tagName=='DIV' )
			$list=getChildren($list, child,$t);
			//$list=getChildren($list, child,$t);
		/*	else if(children[$i].tagName=='INPUT')
				list+='-'+children[$i].id+' '+children[$i].value+"\n";*/
	}
	
	return $list;
}

function save_template()
{
	var list = [];
	var div = document.getElementById('root');
		list=getChildren(list, div, '');
	elements=JSON.stringify(list);
	var data_args="module="+document.getElementById('tpl_module').value;
	data_args+="&name="+document.getElementById('tpl_name').value;
	data_args+="&s_name="+document.getElementById('tpl_s_name').value;
	data_args+="&s_text="+document.getElementById('tpl_s_text').value;
	data_args+="&s_custom="+document.getElementById('tpl_s_custom').checked;
	data_args+="&encoding="+document.getElementById('tpl_encoding').value;
	data_args+='&elements='+elements;
	alert(loadPOST('modules/kXML/save_template.php', data_args));
	/*var test='';
	count = list.length;
	alert(count);
	for(var $i=0;$i<count;$i++) {
		test+='p:'+list[$i][0]+' i:'+list[$i][1]+' v:'+list[$i][2]+';\n';
	}
	alert(test);*/
}
/*function generate_xml()
{
	var data_args="module="+document.getElementById('tpl_module').value;
	data_args+="&name="+document.getElementById('tpl_name').value;
	data_args+='&records=1';
	var res=loadPOST('index.php?entryPoint=generate_xml', data_args);
	if(res=='')
		res='В шаблоне были указаны недопустимые символы';
	alert(res);
}*/

$(document).ready(function(){
	var $tpl_s_name_val = document.getElementById('s_name').value;
	var $tpl_s_text_val = document.getElementById('s_text').value;
	if($tpl_s_name_val!='')
		document.getElementById('tpl_s_name').value=$tpl_s_name_val;
	if($tpl_s_text_val!='')
		document.getElementById('tpl_s_text').value=$tpl_s_text_val;
	//loadPOST('modules/kXML/save_template.php', 'hernya=ABRA-KADABRA');
	//container = document.getElementById('container');
});
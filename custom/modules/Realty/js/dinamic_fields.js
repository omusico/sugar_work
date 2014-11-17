/**
 * Created by Kolerts
 * Protected by SugarTalk.ru
 */
 
 //SUGAR.language.get('app_strings', 'LBL_LOADING');
 //SUGAR.language.get('Contacts', 'LBL_LIST_LAST_NAME');

function set_detailpanel_5()
{
	if ($('#type_of_realty').val()=='living' || $('#type_of_realty').val()=='parcel' ){
		$('#detailpanel_5').show();
		
		if((($('#kind_of_realty').val()=='flat' || $('#kind_of_realty').val()=='house')) && $('#operation').val()=='rent' && $('#period').val()=='year')
			$('#for_office').parent().parent().show();
		else
			$('#for_office').parent().parent().hide();
			
		if($('#kind_of_realty').val()=='house' || $('#kind_of_realty').val()=='parcel'){
			$('#gaz').parent().parent().show();
			$('#gaz_add').parent().parent().show();
		}else{
			$('#gaz').parent().parent().hide();
			$('#gaz_add').parent().parent().hide();
		}
		
		if($('#type_of_realty').val()=='living' && $('#operation').val()=='rent'){
			$('#balcon').parent().parent().show();
			$('#boiler').parent().parent().show();
			$('#fridge').parent().parent().show();
			$('#conditioning').parent().parent().show();
			$('#parking').parent().parent().show();
		}else{
			$('#balcon').parent().parent().hide();
			$('#boiler').parent().parent().hide();
			$('#fridge').parent().parent().hide();
			$('#conditioning').parent().parent().hide();
			$('#parking').parent().parent().hide();
		}
	}else{
		$('#detailpanel_5').hide();
	}
}
function set_gaz()
{
	if ($('#gaz').val()=='2'){
		$('#gaz_add').hide();
		$('#gaz_add').parent().prev().html('');
	}else{
		$('#gaz_add').show();
		$('#gaz_add').parent().prev().html(SUGAR.language.get('Realty', 'LBL_GAZ_P')+":");
	}
}
function set_h2o()
{
	if ($('#h2o').val()=='2'){
		$('#h2o_add').hide();
		$('#h2o_add').parent().prev().html('');
	}else{
		$('#h2o_add').show();
		$('#h2o_add').parent().prev().html(SUGAR.language.get('Realty', 'LBL_H2O_P')+":");
	}
}

function copy_comment(){
	$('#d_text').val($('#description').val());
	return false;
}

function validate_float($element){
	while($element.value.match(/[^0-9.]/)){
        $element.value=$element.value.replace(/[^0-9.]/, '');
    }
    var main_s = parseFloat($('#square').val());
    var liv_s = parseFloat($('#living_square').val());
    var kit_s = parseFloat($('#kitchen_square').val());
	if(main_s<(liv_s+kit_s))
		alert('Жилая площадь + площадь кухни меньше общей площади \n'+liv_s+" + "+kit_s+' > '+main_s);
}

$(document).ready(function() {
	set_gaz();
	set_h2o();
	set_detailpanel_5();
    $('#gaz').change(function(){set_gaz();});
    $('#h2o').change(function(){set_h2o();});
	
    $('#type_of_realty').change(function(){set_detailpanel_5();});
    $('#kind_of_realty').change(function(){set_detailpanel_5();});
    $('#operation').change(function(){set_detailpanel_5();});
    $('#period').change(function(){set_detailpanel_5();});
	
    $('#square').change(function(){validate_float($('#square')[0]);});
    $('#living_square').change(function(){validate_float($('#living_square')[0]);});
    $('#kitchen_square').change(function(){validate_float($('#kitchen_square')[0]);});
	
	if(action_sugar_grp1 == 'EditView'){
		$('#d_text').parent().append("<button onclick='return copy_comment();'>Скопировать из комментариев</button>");
	}
});

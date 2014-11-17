/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 */
function set_dov_lico()
{
    if (!$('#dov_lico').is(':checked')){
		$("#dov_fio").parent().hide();
		$("#dov_fio").parent().prev().hide();
		$("#dov_realship").parent().parent().hide();
		$("#dov_phone").parent().parent().hide();
		$("#dov_passport").parent().parent().hide();
		$("#dov_description").parent().parent().hide();
		/*if(action_sugar_grp1 != 'EditView'){
			var phone=document.getElementsByClassName("phone");
			phone[2].parentNode.style.display="none";
		}*/
	}
	else{
		$("#dov_fio").parent().show();
		$("#dov_fio").parent().prev().show();
		$("#dov_realship").parent().parent().show();
		$("#dov_phone").parent().parent().show();
		$("#dov_passport").parent().parent().show();
		$("#dov_description").parent().parent().show();
		/*if(action_sugar_grp1 != 'EditView'){
			var phone=document.getElementsByClassName("phone");
			phone[2].parentNode.style.display="";
		}*/
    }
}

$(document).ready(function() {

	set_dov_lico();
    $('#dov_lico').change(function(){set_dov_lico();});
	
    if ($('#type_of_realty').val() == 'living'){
        $("#kind_of_realty option[value='flat']").css("display","");
        $("#kind_of_realty option[value='room']").css("display","");
        $("#kind_of_realty option[value='house']").css("display","");
        $("#kind_of_realty option[value='stock']").css("display","none");
        $("#kind_of_realty option[value='office']").css("display","none");
        $("#kind_of_realty option[value='parcel']").css("display","none");
    }

    if ($('#type_of_realty').val() == 'not_living'){
        $("#kind_of_realty option[value='flat']").css("display","none");
        $("#kind_of_realty option[value='room']").css("display","none");
        $("#kind_of_realty option[value='house']").css("display","none");
        $("#kind_of_realty option[value='stock']").css("display","");
        $("#kind_of_realty option[value='office']").css("display","");
        $("#kind_of_realty option[value='parcel']").css("display","none");
    }

    if ($('#type_of_realty').val() == 'parcel'){
        $("#kind_of_realty option[value='flat']").css("display","none");
        $("#kind_of_realty option[value='room']").css("display","none");
        $("#kind_of_realty option[value='house']").css("display","none");
        $("#kind_of_realty option[value='stock']").css("display","none");
        $("#kind_of_realty option[value='office']").css("display","none");
        $("#kind_of_realty option[value='parcel']").css("display","");
    }


    $('#type_of_realty').change(function(){
        if ($('#type_of_realty').val() == 'living'){
            $("#kind_of_realty option[value='flat']").attr("selected","selected");
            $("#kind_of_realty option[value='flat']").css("display","");
            $("#kind_of_realty option[value='room']").css("display","");
            $("#kind_of_realty option[value='house']").css("display","");
            $("#kind_of_realty option[value='stock']").css("display","none");
            $("#kind_of_realty option[value='office']").css("display","none");
            $("#kind_of_realty option[value='parcel']").css("display","none");
        }

        if ($('#type_of_realty').val() == 'not_living'){
            $("#kind_of_realty option[value='stock']").attr("selected","selected");
            $("#kind_of_realty option[value='flat']").css("display","none");
            $("#kind_of_realty option[value='room']").css("display","none");
            $("#kind_of_realty option[value='house']").css("display","none");
            $("#kind_of_realty option[value='stock']").css("display","");
            $("#kind_of_realty option[value='office']").css("display","");
            $("#kind_of_realty option[value='parcel']").css("display","none");
        }

        if ($('#type_of_realty').val() == 'parcel'){
            $("#kind_of_realty option[value='parcel']").attr("selected","selected");
            $("#kind_of_realty option[value='flat']").css("display","none");
            $("#kind_of_realty option[value='room']").css("display","none");
            $("#kind_of_realty option[value='house']").css("display","none");
            $("#kind_of_realty option[value='stock']").css("display","none");
            $("#kind_of_realty option[value='office']").css("display","none");
            $("#kind_of_realty option[value='parcel']").css("display","");
        }
    });
});
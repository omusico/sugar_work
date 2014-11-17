/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 */
$(document).ready(function(){

    if($('#type_of_realty').val() == 'realty')
    {
        $('#amount').css("display","none");
        $('#cost_for_period').css("display","none");
    }

    if($('#type_of_opportunity').val() == 'buying')
    {
        $('#cost_for_period').parent().parent().css("display","none");
    }

    $('#type_of_realty').change(function(){

        if($('#type_of_realty').val() == "realty")
        {
            $('#amount').css("display","none");
			$('#amount').prev().css("display","none");
            $('#cost_for_period').css("display","none");
			$('#cost_for_period').prev().css("display","none");
        }

        if($('#type_of_realty').val() == "client")
        {
            $('#amount').css("display","");
            $('#cost_for_period').css("display","");
        }
    });



      $('#type_of_opportunity').change(function(){

        if($('#type_of_opportunity').val() == "rent")
        {
            $('#cost_for_period').parent().parent().css("display","");
        }

        if($('#type_of_opportunity').val() == "buying")
        {
            $('#cost_for_period').parent().parent().css("display","none");
        }
    });

});

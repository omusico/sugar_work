/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 */
$(document).ready(function() {

    if ($('#type_of_realty').val() == 'living')
    {
        $("#kind_of_realty option[value='flat']").css("display","");
        $("#kind_of_realty option[value='room']").css("display","");
        $("#kind_of_realty option[value='house']").css("display","");
        $("#kind_of_realty option[value='stock']").css("display","none");
        $("#kind_of_realty option[value='office']").css("display","none");
        $("#kind_of_realty option[value='parcel']").css("display","none");
    }

    if ($('#type_of_realty').val() == 'not_living')
    {
        $("#kind_of_realty option[value='flat']").css("display","none");
        $("#kind_of_realty option[value='room']").css("display","none");
        $("#kind_of_realty option[value='house']").css("display","none");
        $("#kind_of_realty option[value='stock']").css("display","");
        $("#kind_of_realty option[value='office']").css("display","");
        $("#kind_of_realty option[value='parcel']").css("display","none");
    }

    if ($('#type_of_realty').val() == 'parcel')
    {
        $("#kind_of_realty option[value='flat']").css("display","none");
        $("#kind_of_realty option[value='room']").css("display","none");
        $("#kind_of_realty option[value='house']").css("display","none");
        $("#kind_of_realty option[value='stock']").css("display","none");
        $("#kind_of_realty option[value='office']").css("display","none");
        $("#kind_of_realty option[value='parcel']").css("display","");
    }


    $('#type_of_realty').change(function(){

        if ($('#type_of_realty').val() == 'living')
        {
            $("#kind_of_realty option[value='flat']").attr("selected","selected");
            $("#kind_of_realty option[value='flat']").css("display","");
            $("#kind_of_realty option[value='room']").css("display","");
            $("#kind_of_realty option[value='house']").css("display","");
            $("#kind_of_realty option[value='stock']").css("display","none");
            $("#kind_of_realty option[value='office']").css("display","none");
            $("#kind_of_realty option[value='parcel']").css("display","none");
        }

        if ($('#type_of_realty').val() == 'not_living')
        {
            $("#kind_of_realty option[value='stock']").attr("selected","selected");
            $("#kind_of_realty option[value='flat']").css("display","none");
            $("#kind_of_realty option[value='room']").css("display","none");
            $("#kind_of_realty option[value='house']").css("display","none");
            $("#kind_of_realty option[value='stock']").css("display","");
            $("#kind_of_realty option[value='office']").css("display","");
            $("#kind_of_realty option[value='parcel']").css("display","none");
        }

        if ($('#type_of_realty').val() == 'parcel')
        {
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
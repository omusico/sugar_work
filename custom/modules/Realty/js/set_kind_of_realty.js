/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 */
$(document).ready(function() {

    var currency = $('#currency').val();
    var period = $('#period').val();

    var period_icon = "месяц";
	/*if(period=='day')
		period_icon='сутки';*/

    // This for type onload
    if ($('#type_of_realty').val() == 'living')
    {
        $("#kind_of_realty option[value='flat']").css("display","");
        $("#kind_of_realty option[value='room']").css("display","");
        $("#kind_of_realty option[value='house']").css("display","");
        $("#kind_of_realty option[value='stock']").css("display","none");
        $("#kind_of_realty option[value='office']").css("display","none");
        $("#kind_of_realty option[value='parcel']").css("display","none");
        $("#kind_of_realty option[value='gost']").css("display","none");
        $("#kind_of_realty option[value='poly']").css("display","none");
        $("#kind_of_realty option[value='torg']").css("display","none");
        $("#kind_of_realty option[value='sto']").css("display","none");
    }

    if ($('#type_of_realty').val() == 'not_living')
    {
        $("#kind_of_realty option[value='flat']").css("display","none");
        $("#kind_of_realty option[value='room']").css("display","none");
        $("#kind_of_realty option[value='house']").css("display","none");
        $("#kind_of_realty option[value='stock']").css("display","");
        $("#kind_of_realty option[value='office']").css("display","");
        $("#kind_of_realty option[value='parcel']").css("display","none");
        $("#kind_of_realty option[value='gost']").css("display","");
        $("#kind_of_realty option[value='poly']").css("display","");
        $("#kind_of_realty option[value='torg']").css("display","");
        $("#kind_of_realty option[value='sto']").css("display","");
    }

    if ($('#type_of_realty').val() == 'parcel')
    {
        $("#kind_of_realty option[value='flat']").css("display","none");
        $("#kind_of_realty option[value='room']").css("display","none");
        $("#kind_of_realty option[value='house']").css("display","none");
        $("#kind_of_realty option[value='stock']").css("display","none");
        $("#kind_of_realty option[value='office']").css("display","none");
        $("#kind_of_realty option[value='parcel']").css("display","");
        $("#kind_of_realty option[value='gost']").css("display","none");
        $("#kind_of_realty option[value='poly']").css("display","none");
        $("#kind_of_realty option[value='torg']").css("display","none");
        $("#kind_of_realty option[value='sto']").css("display","none");
    }


    // This for operation onload
    if ($('#operation').val() == 'rent')
    {
        if($('#type_of_realty').val() == 'living')
        {
            $("#square_unit").css("display","none");
            $("#square_unit_label").text("");
	    $("#cost").parent().prev().text("Стоимость("+currency+"/м2/"+period_icon+")");
        }

        $("#operation_status option[value='in_rent']").css("display","");
        $("#operation_status option[value='out_rent']").css("display","");
        $("#operation_status option[value='bought']").css("display","none");
        $("#operation_status option[value='not_bought']").css("display","none");

        $("#cost").parent().prev().text("Стоимость("+currency+"/"+period_icon+")");
    }

    if ($('#operation').val() == 'buying')
    {
        $("#period").css("display","none");
        $("#period_label").text("");

        $("#cost").parent().prev().text("Стоимость("+currency+")");

        $("#operation_status option[value='in_rent']").css("display","none");
        $("#operation_status option[value='out_rent']").css("display","none");
        $("#operation_status option[value='bought']").css("display","");
        $("#operation_status option[value='not_bought']").css("display","");
    }


    if($('#sections_exist').val() == 'no')
    {
        $('#section_name').parent().css("display", "none");
        $('#section_name_label').css("display", "none");
        $('#building_name').css("display", "");
        $('#building_name_label').css("display", "");
    }

    if($('#sections_exist').val() == 'yes')
    {
        $('#section_name').parent().css("display", "");
        $('#section_name_label').css("display", "");
    }


    $('#type_of_realty').change(function(){

        // This for type change

        if ($('#type_of_realty').val() == 'living')
        {
            $("#kind_of_realty option[value='flat']").attr("selected","selected");
            $("#kind_of_realty option[value='flat']").css("display","");
            $("#kind_of_realty option[value='room']").css("display","");
            $("#kind_of_realty option[value='house']").css("display","");
            $("#kind_of_realty option[value='stock']").css("display","none");
            $("#kind_of_realty option[value='office']").css("display","none");
            $("#kind_of_realty option[value='parcel']").css("display","none");
			$("#kind_of_realty option[value='gost']").css("display","none");
			$("#kind_of_realty option[value='poly']").css("display","none");
			$("#kind_of_realty option[value='torg']").css("display","none");
			$("#kind_of_realty option[value='sto']").css("display","none");

	    
	    $("#cost").parent().prev().text("Стоимость("+currency+"/"+period_icon+")");

            $("#square_unit").css("display","none");
            $("#square_unit_label").text("");
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
			$("#kind_of_realty option[value='gost']").css("display","");
			$("#kind_of_realty option[value='poly']").css("display","");
			$("#kind_of_realty option[value='torg']").css("display","");
			$("#kind_of_realty option[value='sto']").css("display","");

	    $("#cost").parent().prev().text("Стоимость("+currency+"/м2/"+period_icon+")");

            $("#square_unit").css("display","");
            $("#square_unit_label").text("Единица измерения площади");
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
			$("#kind_of_realty option[value='gost']").css("display","none");
			$("#kind_of_realty option[value='poly']").css("display","none");
			$("#kind_of_realty option[value='torg']").css("display","none");
			$("#kind_of_realty option[value='sto']").css("display","none");


            $("#square_unit").css("display","");
            $("#square_unit_label").text("Единица измерения площади");
        }
    });

    $('#operation').change(function(){

        // This for operation change

        if ($('#operation').val() == 'rent')
        {
            $("#period").css("display","");
            $("#period_label").text("Период");

            $("#cost").parent().prev().text("Стоимость("+currency+"/м2/"+period_icon+")");

            $("#operation_status option[value='in_rent']").attr("selected","selected");
            $("#operation_status option[value='in_rent']").css("display","");
            $("#operation_status option[value='out_rent']").css("display","");
            $("#operation_status option[value='bought']").css("display","none");
            $("#operation_status option[value='not_bought']").css("display","none");

	    if($('#type_of_realty').val() == 'living')
        {
	    $("#cost").parent().prev().text("Стоимость("+currency+"/"+period_icon+")");
        }

	if($('#type_of_realty').val() == 'not_living')
        {
	    $("#cost").parent().prev().text("Стоимость("+currency+"/m2/"+period_icon+")");
        }
        }

        if ($('#operation').val() == 'buying')
        {
            $("#period").css("display","none");
            $("#period_label").text("");

            $("#cost").parent().prev().text("Стоимость("+currency+")");

            $("#operation_status option[value='bought']").attr("selected","selected");
            $("#operation_status option[value='in_rent']").css("display","none");
            $("#operation_status option[value='out_rent']").css("display","none");
            $("#operation_status option[value='bought']").css("display","");
            $("#operation_status option[value='not_bought']").css("display","");
        }
    });


    $('#sections_exist').change(function(){


        if ($('#sections_exist').val() == 'yes')
        {
            $('#section_name').parent().css("display", "");
            $('#section_name_label').css("display", "");
        }

        if ($('#sections_exist').val() == 'no')
        {
            $('#section_name').parent().css("display", "none");
            $('#section_name_label').css("display", "none");
        }
    });

    $('#btn_section_name').mousedown(function(){

        if($('#building_name').val() == "")
        {
            alert("Сначала выберите здание!");
            return false;
        }

    });

});

/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 */
$(document).ready(function(){

    var currency = $('#currency').val();
    var period = $('#period').val();

    var period_icon;

    if(period == "month")
    {
        period_icon = "месяц"
    }

    if(period == "year")
    {
        period_icon = "месяц"
    }

    if(period == "day")
    {
        period_icon = "день"
    }

    if ($('#operation').val() == 'buying')
    {
        $("#whole_subpanel_realty_contacts_rent").css("display","none");
        $("#whole_subpanel_realty_contacts_buying").css("display","");

        $("#whole_subpanel_realty_accounts_rent").css("display","none");
        $("#whole_subpanel_realty_accounts_buying").css("display","");

        $("#period").parent().prev().text("");
        $("#period").parent().text("");

        $("#cost").parent().prev().text("Стоимость("+currency+")");


        $("#square_unit").parent().prev().text("");
        $("#square_unit").parent().text("");
    }

    if ($('#operation').val() == 'rent')
    {
        $("#cost").parent().prev().text("");

        $("#whole_subpanel_realty_contacts_rent").css("display","");
        $("#whole_subpanel_realty_contacts_buying").css("display","none");

        $("#whole_subpanel_realty_accounts_rent").css("display","");
        $("#whole_subpanel_realty_accounts_buying").css("display","none");

        $("#cost").parent().prev().text("Стоимость("+currency+"/м2/"+period_icon+")");


	if($('#type_of_realty').val() == 'living')
        {
	    $("#cost").parent().prev().text("Стоимость("+currency+"/"+period_icon+")");
        }

    }

    if($('#sections_exist').val() == 'no')
    {
        $("#section_id").parent().prev().text("");
        $("#section_id").parent().text("");
    }
});

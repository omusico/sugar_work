$(document).ready(function() {
	set_type_of_realty();
	$('#type_of_realty').change(set_type_of_realty);
});

function set_type_of_realty(){
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
    }else if ($('#type_of_realty').val() == 'not_living')
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
    }else if ($('#type_of_realty').val() == 'parcel')
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
}


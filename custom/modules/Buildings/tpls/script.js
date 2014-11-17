$(document).ready(function(){

	$('#_get_address').click(function(){$('#address').val(_get_address());return false;});
	
    // $("#address_street").hide();
    //Autocomplete COUNTRY
    $(function(){

        $('#address_country').autocomplete({source:'index.php?entryPoint=adress_data&field_name=country',
            width: 200,
            max: 5
        });
    });

    //Autocomplete REGION
    $('#address_region').focus(function(){
        var country_val = $("#address_country").val();

        $('#address_region').autocomplete({source:'index.php?entryPoint=adress_data&field_name=region&country="' +  country_val+ '"',
            width: 200,
            max: 8
        });
});

    //Autocomplete CITY
    $('#address_city').focus(function(){
        $('#address_city').autocomplete({source:'index.php?entryPoint=adress_data&field_name=city&region="'+$("#address_region").val()+'"&country="'+$("#address_country").val()+'"',
            width: 200,
            max: 8
        });
    });

    //Autocomplete STREET
    /*    var street = $("#address_street");

        if(street.val() != "")
        {
            $("#address").val(street.val());
        }*/

    $("#address").live('focus', function(){

        var street = $("#address");
		set_street_val(street);

        street.geocomplete({
            map: "#map_canvas",
            details: "form",
            detailsAttribute: "data-geo",
			markerOptions: {draggable: true},
        }).live("geocode:result", function(event, result){
                /*$("#address_street").val(result.name);
                $("#address").hide();
                $("#address_street").show();*/
				$("#address_street").val($("#route").val());
				$("#address_house").val($("#street_number").val());
            }).bind("geocode:dragged", function(event, result){
			$('#latitude').val(result.lb);
            $('#longitude').val(result.mb);
		});
    });
});

function set_street_val(address){
	street_=_get_address();
	if(address.val()==''){
		address.val(street_);
	}else{
		var adr_=address.val().split(',');
		var country_val=$("#address_country").val();
		if(adr_[0]!=country_val && adr_[0]!=' '+country_val){
			address.val('');
			for(var i=(adr_.length-1);i>=0;i--)
				address.val(address.val()+adr_[i]+',');
		}
	}
}
function _get_address(){
	var country = $("#address_country").val();
	var city = $("#address_city").val();
	var state = $("#address_region").val();
	var street = $("#address_street").val();
	var house = $("#address_house").val();

	if(country == "")
	{
		country = "";
	}
	else { country = country + ","; }

	if(city == "")
	{
		city = "";
	}
	else { city = city + ","; }

	if(state == "")
	{
		state = "";
	}
	else { state = state + ","; }
	
	if(street == "")
	{
		street = "";
	}
	else { street = street + ","; }

	var admin_centr = document.getElementById("admin_centr");
	var street_=country + city + street + house;
	return street_;
}
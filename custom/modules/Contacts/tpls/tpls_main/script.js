$(document).ready(function(){

    // $("#main_address_street").hide();
    //Autocomplete COUNTRY
    $(function(){

        $('#main_address_country').autocomplete({source:'custom/modules/Realty/tpls/data.php?field_name=country',
            width: 200,
            max: 5
        });
    });

    //Autocomplete REGION
    $('#main_address_region').focus(function(){

        var country_val = $("#main_address_country").val();
        $('#main_address_region').autocomplete({source:'custom/modules/Realty/tpls/data.php?field_name=region&country="' +  country_val+ '"',
            width: 200,
            max: 8
        });
    });

    //Autocomplete CITY
    $('#main_address_city').focus(function(){
        $('#main_address_city').autocomplete({source:'custom/modules/Realty/tpls/data.php?field_name=city&region="'+$("#main_address_region").val()+'"&country="'+$("#main_address_country").val()+'"',
            width: 200,
            max: 8
        });
    });

    //Autocomplete STREET
        var street = $("#main_address_street");

        if(street.val() != "")
        {
            $("#main_address").val(street.val());
        }

    $("#main_address").live('focus', function(){

         var street = $("#main_address");
		set_street_val(street);

        street.geocomplete({
            map: "#map_canvas",
            details: "form",
            detailsAttribute: "data-geo"
        }).live("geocode:result", function(event, result){

                $("#main_address_street").val(result.name);
                // $("#main_address").hide();
                // $("#main_address_street").show();
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
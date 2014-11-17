$(document).ready(function(){

    $("#main_address_street").hide();
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

        var country = $("#main_address_country").val();
        var city = $("#main_address_city").val();
        var state = $("#main_address_region").val();

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

        var street = $("#main_address");

        if(street.val() == "")
        {
            street.val(country + city);
        }
        else {
            var curr_val = street.val();
            street.val(country + city + curr_val);
        }

        console.log(street);

        street.geocomplete({
            map: "#map_canvas",
            details: "form",
            detailsAttribute: "data-geo"
        }).live("geocode:result", function(event, result){

                $("#main_address_street").val(result.name);
                $("#main_address").hide();
                $("#main_address_street").show();
            });
    });
});

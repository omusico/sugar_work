$(document).ready(function(){

    // $("#address_street").hide();
    //Autocomplete COUNTRY
    $(function(){

        $('#address_country').autocomplete({source:'custom/modules/Realty/tpls/data.php?field_name=country',
            width: 200,
            max: 5
        });
    });

    //Autocomplete REGION
    $('#address_region').focus(function(){

        var country_val = $("#address_country").val();
        $('#address_region').autocomplete({source:'custom/modules/Realty/tpls/data.php?field_name=region&country="' +  country_val+ '"',
            width: 200,
            max: 8
        });
    });

    //Autocomplete CITY
    $('#address_city').focus(function(){
        $('#address_city').autocomplete({source:'custom/modules/Realty/tpls/data.php?field_name=city&region="'+$("#address_region").val()+'"&country="'+$("#address_country").val()+'"',
            width: 200,
            max: 8
        });
    });

    //Autocomplete STREET
        var street = $("#address_street");

        if(street.val() != "")
        {
            $("#address").val(street.val());
        }

    $("#address").live('focus', function(){

        var country = $("#address_country").val();
        var city = $("#address_city").val();
        var state = $("#address_region").val();

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

        var street = $("#address");

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

                $("#address_street").val(result.name);
                // $("#address").hide();
                // $("#address_street").show();
            });
    });
});

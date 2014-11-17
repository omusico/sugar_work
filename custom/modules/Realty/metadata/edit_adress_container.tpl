{literal}
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=places"></script>
<script src="custom/modules/Realty/tpls/jquery.geocomplete.min.js"></script>

<script type="text/javascript">

    //Autocomplete COUNTRY
    $(function(){

        $('#address_country').autocomplete({source:'custom/modules/Realty/tpls/data.php',
            width: 200,
            max: 5
        });
    });





    //Autocomplete CITY
    (function($, undefined){

        $(document).ready(function(){
            $('#city_temp').hide();
        });

        $("form input[name=address_city]").live('focus',function(){

            $("form input[name=city_temp]").show();

            $("form input[name=address_city]").hide();

        });

        $("#city_temp").live('focus', function(){

            var city = $("#city_temp");

            var country = $("#address_country").val();

            $.ajax({
                type: "GET",
                url: "http://maps.googleapis.com/maps/api/geocode/json",
                data: 'address='+country+'&sensor=false',
                dataType: "json",

                success: function(data) {

                    var geo = data.results[0].geometry.bounds;

                    var serachBound = new google.maps.LatLngBounds(
                            new google.maps.LatLng(geo.southwest.lat, geo.southwest.lng),
                            new google.maps.LatLng(geo.northeast.lat, geo.northeast.lng)
                    );

                    city.geocomplete({
                        details: "#detailpanel_2",
                        bounds: serachBound,
                        types: ["geocode"]
                    })
                            .live("geocode:result", function(event, result){

                                $("#address_city").val(result.name);

                                $("#city_temp").hide();

                                $("#address_city").show();

                            });

                }

            });

        });

    })(jQuery);




    //Autocomplete STREET
    (function($, undefined){

        $(document).ready(function(){
            $('#street_temp').hide();
        });

        $("form input[name=address_street]").live('focus',function(){

            $("form input[name=street_temp]").show();

            $("form input[name=address_street]").hide();

        });

        $("#street_temp").live('focus', function(){

            var street = $("#street_temp");

            var city = $("#address_city").val();

            var country = $("#address_country").val();
            console.log(city);
            console.log(country);
            console.log(street);

            $.ajax({
                type: "GET",
                url: "http://maps.googleapis.com/maps/api/geocode/json",
                data: 'address='+country+'+'+city+'&sensor=false',
                dataType: "json",

                success: function(data) {

                    var geo = data.results[0].geometry.bounds;

                    var serachBound = new google.maps.LatLngBounds(
                            new google.maps.LatLng(geo.southwest.lat, geo.southwest.lng),
                            new google.maps.LatLng(geo.northeast.lat, geo.northeast.lng)
                    );

                    street.geocomplete({
                        details: "#detailpanel_2",
                        bounds: serachBound,
                        types: ["geocode"]
                    })
                            .live("geocode:result", function(event, result){

                                $("#address_street").val(result.name);

                                $("#street_temp").hide();

                                $("#address_street").show();

                            });

                }

            });

        });

    })(jQuery);

</script>

{/literal}
<table border="1" cellspacing="1" cellpadding="0" class="edit" width="100%">

	<tr>
        <td id="address_country_label" width="%" scope="row" >
            <label for="address_country">{sugar_translate label="LBL_ADDRESS_COUNTRY" module=""}:
            {if $fields.address_country.required || false}
                <span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span>
            {/if}
        </td>
        <td>
            <input type="text" name="address_country" id="address_country" size="60" maxlength="150" value="{$fields.address_country.value}" tabindex="0" class="ac_input">
        </td>
    </tr>

    <tr>
        <td id="address_city_label" width="%" scope="row" >
            <label for="address_city">{sugar_translate label="LBL_ADDRESS_CITY" module=""}:
            {if $fields.address_city.required || false}
                <span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span>
            {/if}
        </td>
        <td>
            <input type="text" name="address_city" id="address_city" size="60" maxlength="150" value="{$fields.address_city.value}" tabindex="0">
            <input type="text" name="city_temp" id="city_temp" size="60" maxlength="150" value="{$fields.address_city.value}" tabindex="0">
        </td>
    </tr>



    <tr>
        <td valign="top" id="address_street_label_textarea" width="25%" scope="row" >
            <label for="address_street">{sugar_translate label="LBL_ADDRESS_STREET" module=""}:</label>
        {if $fields.address_street.required || false}
            <span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span>
        {/if}
        </td>
        <td>
            <input type="text" name="address_street" id="address_street" size="60" maxlength="150" value="{$fields.address_street.value}" tabindex="0">
            <input type="text" name="street_temp" id="street_temp" size="60" maxlength="150" value="{$fields.address_street.value}" tabindex="0">
        </td>
    </tr>



    {*<tr>*}
        {*<td id="address_house_label" width="%" scope="row" >*}
            {*<label for="address_house">{sugar_translate label="LBL_ADDRESS_HOUSE" module=""}:</label>*}
        {*{if $fields.address_house.required || false}*}
            {*<span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span>*}
        {*{/if}*}
        {*</td>*}
        {*<td>*}
            {*<input type="text" name="address_house" id="address_house" size="30" maxlength="150" value="{$fields.address_house.value}" tabindex="0">*}
        {*</td>*}
    {*</tr>*}

        <tr>
            <td colspan="2"" NOWRAP>&nbsp;</td>
        </tr>
</table>

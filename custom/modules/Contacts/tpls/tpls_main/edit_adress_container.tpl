{*literal}


<script src="custom/modules/Accounts/tpls/tpls_main/script.js"></script>


{/literal*}
<table border="1" cellspacing="1" cellpadding="0" class="edit" width="100%">
<div id="map_canvas" style="display:none;"></div>
	<tr>
        <td id="main_address_country_label" width="%" scope="row" >
            <label for="main_address_country">{sugar_translate label="LBL_ADDRESS_COUNTRY" module=""}:
            {if $fields.main_address_country.required || false}
                <span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span>
            {/if}
        </td>
        <td>
            <input type="text" name="main_address_country" id="main_address_country" size="60" maxlength="150" value="{$fields.main_address_country.value}" tabindex="0" class="ac_input">
        </td>
    </tr>

    <tr>
        <td id="main_address_region_label" width="%" scope="row" >
            <label for="main_address_region">{sugar_translate label="LBL_ADDRESS_REGION" module=""}:
            {if $fields.main_address_region.required || false}
                <span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span>
            {/if}
        </td>
        <td>
            <input type="text" name="main_address_region" id="main_address_region" size="60" maxlength="150" value="{$fields.main_address_region.value}" tabindex="0" class="ac_input">
        </td>
    </tr>

    <tr>
        <td id="main_address_city_label" width="%" scope="row" >
            <label for="main_address_city">{sugar_translate label="LBL_ADDRESS_CITY" module=""}:
            {if $fields.main_address_city.required || false}
                <span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span>
            {/if}
        </td>
        <td>
            <input type="text" name="main_address_city" id="main_address_city" size="60" maxlength="150" value="{$fields.main_address_city.value}" tabindex="0">
        </td>
    </tr>

    <tr>
        <td valign="top" id="main_address_street_label_textarea" width="25%" scope="row" >
            <label for="main_address_street">{sugar_translate label="LBL_ADDRESS_STREET" module=""}:</label>
        {if $fields.main_address_street.required || false}
            <span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span>
        {/if}
        </td>
        <td>
            <input type="text" name="main_address_street" id="main_address_street" size="60" maxlength="150" value="{$fields.main_address_street.value}" tabindex="0">
        </td>
    </tr>
{*
    <tr>
        <td valign="top" id="main_address_label" width="25%" scope="row" >
            <label for="main_address">{sugar_translate label="LBL_ADDRESS" module="Request"}:</label>
        </td>
        <td>
            <input type="text" name="main_address" id="main_address" size="60" maxlength="150" value="" tabindex="0">
            <input type="hidden" data-geo="route" name="route"> &nbsp; <input type="hidden" data-geo="street_number" name="street_number">
        </td>
    </tr>
*}


    <tr>
        <td id="address_house_label" width="%" scope="row" >
            <label for="address_house">{sugar_translate label="LBL_ADDRESS_HOUSE" module=""}:</label>
        {if $fields.address_house.required || false}
            <span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span>
        {/if}
        </td>
        <td>
            <input type="text" name="address_house" id="address_house" size="30" maxlength="150" value="{$fields.address_house.value}" tabindex="0">
        </td>
    </tr>
	<tr>
        <td id="address_appartment_label" width="%" scope="row" >
            <label for="address_appartment">{sugar_translate label="LBL_ADDRESS_APPARTMENT" module=""}:</label>
        {if $fields.address_appartment.required || false}
            <span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span>
        {/if}
        </td>
        <td>
            <input type="text" name="address_appartment" id="address_appartment" size="30" maxlength="150" value="{$fields.address_appartment.value}" tabindex="0">
        </td>
    </tr>

        <tr>
            <td colspan="2"" NOWRAP>&nbsp;</td>
        </tr>
</table>

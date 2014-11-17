{literal}


<script src="custom/modules/Realty/tpls/script.js"></script>


{/literal}
<table border="1" cellspacing="1" cellpadding="5" class="edit" width="100%" >
<tr><td colspan="4" NOWRAP>&nbsp;</td></tr>
	<tr>
        <td id="address_country_label" width="%" scope="row" >
            <label for="address_country">{sugar_translate label="LBL_ADDRESS_COUNTRY" module=""}:
            {if $fields.address_country.required || false}
                <span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span>
            {/if}
        </td>
        <td>
            <input type="text" name="address_country" id="address_country" size="30" maxlength="150" value="{$fields.address_country.value}" tabindex="0" class="ac_input">
        </td>          
        <td id="address_region_label" width="%" scope="row" >
            <label for="address_region">{sugar_translate label="LBL_ADDRESS_REGION" module=""}:
            {if $fields.address_region.required || false}
                <span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span>
            {/if}
        </td>
        <td>
            <input type="text" name="address_region" id="address_region" size="30" maxlength="150" value="{$fields.address_region.value}" tabindex="0" class="ac_input">
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
            <input type="text" name="address_city" id="address_city" size="30" maxlength="150" value="{$fields.address_city.value}" tabindex="0">
        </td>    
        <td valign="top" id="address_street_label_textarea" width="25%" scope="row" >
            <label for="address_street">{sugar_translate label="LBL_ADDRESS_STREET" module=""}:</label>
        {if $fields.address_street.required || false}
            <span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span>
        {/if}
        </td>
        <td>
            <input type="text" name="address_street" id="address_street" size="30" maxlength="150" value="{$fields.address_street.value}" tabindex="0">
        </td>
	</tr>
	<tr>
		<td valign="top" id="address_house_label" width="25%" scope="row" >
            <label for="address_house">{sugar_translate label="LBL_ADDRESS_HOUSE" module=""}:</label>
        {if $fields.address_house.required || false}
            <span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span>
        {/if}
        </td>
        <td>
            <input type="text" name="address_house" id="address_house" size="30" maxlength="150" value="{$fields.address_house.value}" tabindex="0">
        </td>
		<td valign="top" id="address_apartment_label" width="25%" scope="row" >
            <label for="address_apartment">{sugar_translate label="LBL_ADDRESS_APARTMENT" module=""}:</label>
        {if $fields.address_apartment.required || false}
            <span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span>
        {/if}
        </td>
        <td>
            <input type="text" name="address_apartment" id="address_apartment" size="30" maxlength="150" value="{$fields.address_apartment.value}" tabindex="0">
        </td>
	</tr>
	<tr>
		<td valign="top" id="address_street_label_textarea" width="25%" scope="row" >
            <label for="address">{sugar_translate label="LBL_ADDRESS_GOOGLE" module=""}:</label>
			{if $fields.address_street.required || false}
				<span class="required">{$APP.LBL_REQUIRED_SYMBOL}</span>
			{/if}
        </td>
        <td colspan="3">
			<button id="_get_address">Cобрать адрес для карты</button> <span style="color:#b00;">нажмите на поле адрес для построения на карте</span>
			<br/><br/>
			<input type="text" name="address" id="address" size="70" maxlength="200" value="" tabindex="0">
			<input type="hidden" data-geo="route" name="route" id="route"> &nbsp; <input type="hidden" id="street_number" data-geo="street_number" name="street_number">
        </td>
    </tr>
</table>

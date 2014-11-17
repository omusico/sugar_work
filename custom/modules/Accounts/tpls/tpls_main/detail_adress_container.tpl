
{if !$fields.main_address_street.hidden}
    {counter name="panelFieldCount"}

    <table border='0' cellpadding='0' cellspacing='0' width='100%'>
        <tr>
            <td width='99%'>
				<input type="hidden" class="sugar_field" id="main_address_country" value="{$fields.main_address_region.value|escape:'htmlentitydecode'|escape:'html'|url2html|nl2br}">
				<input type="hidden" class="sugar_field" id="main_address_country" value="{$fields.main_address_country.value|escape:'htmlentitydecode'|escape:'html'|url2html|nl2br}">
                <input type="hidden" class="sugar_field" id="main_address_street" value="{$fields.main_address_street.value|escape:'htmlentitydecode'|escape:'html'|url2html|nl2br}">
                <input type="hidden" class="sugar_field" id="main_address_city" value="{$fields.main_address_city.value|escape:'htmlentitydecode'|escape:'html'|url2html|nl2br}">
                <input type="hidden" class="sugar_field" id="main_address_house" value="{$fields.main_address_house.value|escape:'htmlentitydecode'|escape:'html'|url2html|nl2br}">

				{$fields.main_address_country.value|escape:'htmlentitydecode'|strip_tags|url2html|nl2br}

				{$fields.main_address_region.value|escape:'htmlentitydecode'|strip_tags|url2html|nl2br}

                {$fields.main_address_city.value|escape:'htmlentitydecode'|escape:'html'|url2html|nl2br}<br>

                {$fields.main_address_street.value|escape:'htmlentitydecode'|escape:'html'|url2html|nl2br}<br>

                {*{$fields.address_house.value|escape:'htmlentitydecode'|strip_tags|url2html|nl2br}*}

            </td>
            <td class='dataField' width='1%'>
                {$custom_code_primary}
            </td>
        </tr>
    </table>
{/if}

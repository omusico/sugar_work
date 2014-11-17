
{include file="modules/DynamicFields/templates/Fields/Forms/coreTop.tpl"}

<tr>
    <td class='mbLBL'>{sugar_translate module="DynamicFields" label="GALLERY_TITLE_LABEL_WIDTH"}:</td>
    <td>
        <input id ="rows" type="text" name="width" value="{$vardef.width|default:500}" />
    </td>
</tr>
<tr>
    <td class='mbLBL'>{sugar_translate module="DynamicFields" label="GALLERY_TITLE_LABEL_HEIGHT"}:</td>
    <td>
        <input id ="cols" type="text" name="height" value="{$vardef.height|default:350}" />
    </td>
</tr>

<tr >
    <td class='mbLBL'>{sugar_translate module="DynamicFields" label="GALLERY_TITLE_OPTION_TURN_ON"}:</td>
    <td>
        <input type="checkbox" name="turn_on" value="1"  {if !empty($vardef.turn_on)} checked {/if}/>
    </td>
</tr>





<tr >
    <td class='mbLBL'>{sugar_translate module="DynamicFields" label="COLUMN_TITLE_REQUIRED_OPTION"}:</td>
    <td>
        <input type="checkbox" name="required" value="0" disabled/>
    </td>
</tr>

<tr>
    <td class='mbLBL'>{sugar_translate module="DynamicFields" label="COLUMN_TITLE_DEFAULT_VALUE"}:</td><td>
{sugar_translate module="DynamicFields" label="GALLERY_IS_BY_DEFAULT"}
</td>
</tr>

{if !$hideReportable}
<tr>
    <td class='mbLBL'>{sugar_translate module="DynamicFields" label="COLUMN_TITLE_REPORTABLE"}:</td>
    <td>
        {sugar_translate module="DynamicFields" label="GALLERY_IS_NOT_REPORTABLE"}
        <input type="hidden" name="reportable" value="0">
    </td>
</tr>
{/if}

<tr>
    <td class='mbLBL'>{sugar_translate module="DynamicFields" label="COLUMN_TITLE_AUDIT"}:</td>
    <td>
        <input type="checkbox" name="audited" value="1" {if !empty($vardef.audited) }CHECKED{/if} {if $hideLevel > 5}disabled{/if}/>{if $hideLevel > 5}<input type="hidden" name="audited" value="{$vardef.audited}">{/if}
    </td>
</tr>

<tr>
    <td class='mbLBL'>{sugar_translate module="DynamicFields" label="COLUMN_TITLE_IMPORTABLE"}:</td>
    <td>
    {sugar_translate module="DynamicFields" label="GALLERY_IS_NOT_IMPORTABLE"}
    </td>
</tr>

<tr>
    <td class='mbLBL'>{sugar_translate module="DynamicFields" label="COLUMN_TITLE_DUPLICATE_MERGE"}:</td>
    <td>
    {sugar_translate module="DynamicFields" label="GALLERY_IS_NOT_MERGEABLE"}
    </td>
</tr>
</table>
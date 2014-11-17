<script type="text/javascript" src="{sugar_getjspath file='include/javascript/sugar_grp_overlib.js'}"></script>
<script type="text/javascript" src="{sugar_getjspath file='include/javascript/sugar_grp_yui_widgets.js'}"></script>

<script src="modules/OfficeReportsMerge/javascript/officeform.js"></script>
<script src="modules/OfficeReportsMerge/javascript/dispatcher.js"></script>

<script type="text/javascript">
var ERR_NO_SINGLE_QUOTE = '{$APP.ERR_NO_SINGLE_QUOTE}';
{literal}
function verify_data(formName)
{
	var f = document.getElementById(formName);

	for(i=0; i<f.elements.length; i++) {
		if(f.elements[i].value == "'") {
			alert(ERR_NO_SINGLE_QUOTE + " " + f.elements[i].name);
			return false;
		}
	}

	var disabledTable = SUGAR.subDisabledTable;
	var panels = "";
	for(var i=0; i < disabledTable.getRecordSet().getLength(); i++){
		var data = disabledTable.getRecord(i).getData();
		if (data.module && data.module != '') panels += ":" + data.module;
	}
	panels = panels == "" ? panels : panels.substr(1);

	document.getElementById("officeDocxExcludeModules").value = panels;

	return true;
}
</script>
{/literal}


<form id="ConfigureOfficeSettings" name="ConfigureOfficeSettings" enctype='multipart/form-data' method="POST" action="index.php?module={$MODULE_NAME}&action={$ACTION_NAME}&process=true">

<table width="100%" cellpadding="0" cellspacing="0" border="0" class="actionsContainer">
<tr>
	<td>
		<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}"
			class="button primary" type="submit" name="save" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  "
			onclick="return verify_data('ConfigureOfficeSettings');">
		&nbsp;<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}"  onclick="document.location.href='index.php?module=Administration&action=index'" class="button"  type="button" name="cancel" value="  {$APP.LBL_CANCEL_BUTTON_LABEL}  " >
	</tr>
</table>
<br>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="edit view">
<tr>
	<th align="left" scope="row" colspan="4"><h4>{$MOD.SET_MAIN_CONFIG}</h4></th>
</tr>
<tr>
	<td scope="row" width="400">{$MOD.SET_HISTORY}: </td>
	<td>
        <input type="hidden" value="false" name="officeDocxHistorySave">
		<input type="checkbox" onclick="setHistory();" name="officeDocxHistorySave" id="officeDocxHistorySave" value="true" {if !empty($config.officeDocxHistorySave)}checked{/if}>
	</td>
	<td scope="row" width="400">{$MOD.SET_TEMPLATE_SAVE_HISTORY}: </td>
	<td>
        <input type="hidden" value="false" name="officeDocxHistorySaveReport">
		<input type="checkbox" name="officeDocxHistorySaveReport" id="officeDocxHistorySaveReport" value="true" {if !empty($config.officeDocxHistorySaveReport)}checked{/if}>
	</td>
</tr>
<tr>
	<td scope="row" width="400">{$MOD.SET_EMAIL_HISTORY}: </td>
	<td>
        <input type="hidden" value="false" name="officeDocxSaveEmail">
		<input type="checkbox" name="officeDocxSaveEmail" value="true" {if !empty($config.officeDocxSaveEmail)}checked{/if}>
	</td>
	<td scope="row" width="400">
	<td>
		&nbsp;
	</td>
</tr>
    <tr>
    	<td scope="row" width="400">{$MOD.SET_DOCX_DEBUG_MODE}:&nbsp;{sugar_help text=$MOD.SET_DOCX_DEBUG_MODE_HELP}</td>
    	<td>
            <input type="hidden" value="false" name="officeDocxDebugMode">
    		<input type="checkbox" name="officeDocxDebugMode" value="true" {if !empty($config.officeDocxDebugMode)}checked{/if}>
    	</td>
    	<td scope="row" width="400">
    	<td>
    		&nbsp;
    	</td>
    </tr>
</table>


<h4>{$MOD.SET_SETTINGS_ENABLED}</h4>
<div class='add_table' style='margin-bottom:5px'>
	<table id="ConfigureExcludeModules" class="themeSettings edit view" style='margin-bottom:0px;' border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width='1%'>
				<div id="enabled_div"></div>
			</td>
			<td>
				<div id="disabled_div"></div>
			</td>
		</tr>
	</table>
</div>
<input type="hidden" name="officeDocxExcludeModules" id="officeDocxExcludeModules">

<table width="100%" cellpadding="0" cellspacing="0" border="0" class="actionsContainer">
<tr>
	<td>
		<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}"
			class="button primary" type="submit" name="save" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  "
			onclick="return verify_data('ConfigureOfficeSettings');">
		&nbsp;<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}"  onclick="document.location.href='index.php?module=Administration&action=index'" class="button"  type="button" name="cancel" value="  {$APP.LBL_CANCEL_BUTTON_LABEL}  " >
	</tr>
</table>

</form>

<script>
{literal}
function setHistory()
{
	if (document.getElementById('officeDocxHistorySave').checked)
	{
		document.getElementById('officeDocxHistorySaveReport').disabled = false;
	}
	else
	{
		document.getElementById('officeDocxHistorySaveReport').disabled = true;
	}
}
{/literal}

(function(){ldelim}
setHistory();

var enabled_modules = {$enabled_modules};
var disabled_modules = {$disabled_modules};
var lblEnabled = '{sugar_translate label="SET_ENABLED_MODULES"}';
var lblDisabled = '{sugar_translate label="SET_DISABLED_MODULES"}';
{literal}
SUGAR.subEnabledTable = new YAHOO.SUGAR.DragDropTable(
	"enabled_div",
	[{key:"label",  label: lblEnabled, width: 200, sortable: false},
	 {key:"module", label: lblEnabled, hidden:true}],
	new YAHOO.util.LocalDataSource(enabled_modules, {
		responseSchema: {
		   fields : [{key : "module"}, {key : "label"}]
		}
	}),
	{height: "200px"}
);
SUGAR.subDisabledTable = new YAHOO.SUGAR.DragDropTable(
	"disabled_div",
	[{key:"label",  label: lblDisabled, width: 200, sortable: false},
	 {key:"module", label: lblDisabled, hidden:true}],
	new YAHOO.util.LocalDataSource(disabled_modules, {
		responseSchema: {
		   fields : [{key : "module"}, {key : "label"}]
		}
	}),
	{height: "200px"}
);
SUGAR.subEnabledTable.disableEmptyRows = true;
SUGAR.subDisabledTable.disableEmptyRows = true;
SUGAR.subEnabledTable.addRow({module: "", label: ""});
SUGAR.subDisabledTable.addRow({module: "", label: ""});
SUGAR.subEnabledTable.render();
SUGAR.subDisabledTable.render();
{/literal}
{rdelim})();
</script>
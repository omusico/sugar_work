<div class="detail view" id="officeFormReport">

<form method="POST" action="index.php?action=processOfficeReport&module=OfficeReportsMerge" id="officeTemplateForm">
<table cellspacing="0" id="tableOfficeFormReport">
<tbody>
<tr>
	<td width="12%" scope="row">
	{$MOD.LBL_NAME}:
	</td>
	<td width="38%">
	<select name="record" id="officeTemplateRecord" onchange="changeOfficeReportSelect();">{$AVAILABLE_TEMPLATES}</select>
	</td>

	<td width="12%" scope="row">
	{$MOD.LBL_FORMAT}:
	</td>
	<td width="38%">
	<span name="officeTemplateFormat" id="officeTemplateFormat">{$CURRENT_FORMAT}</span>
	</td>
</tr>
<tr>
	<td width="12%" scope="row">
	{$MOD.BOX_DOWNLOAD_ON_LOCAL_PC}:
	</td>
	<td width="38%">
	<input type="checkbox" name="officeTemplateLink" onclick="officeTemplateCheckBoxChange();" id="officeTemplateLink">
	</td>

	<td width="12%" scope="row">
	{$MOD.BOX_ATTACH_TO_HISTORY}:
	</td>
	<td width="38%">
	<input type="checkbox" name="officeTemplateHistory" onclick="officeTemplateCheckBoxChange();" id="officeTemplateHistory">
	</td>
</tr>
<tr>
	<td width="12%" scope="row">
	{$MOD.BOX_SEND_ON_EMAIL}:<br><br>
	{$MOD.BOX_TEMPLATE_EMAILS}:
	</td>
	<td width="38%">
	<input type="checkbox" name="officeTemplateEmail" onclick="officeTemplateCheckBoxChange();" id="officeTemplateEmail"><br><br>
	<select name="officeTemplateEmailTemplate" id="officeTemplateEmailTemplate">{$EMAIL_TEMPLATES}</select>
	</td>

	<td width="12%" scope="row">
	{$MOD.BOX_EMAILS}:
	</td>
	<td width="38%">
	<textarea rows="2" name="officeTemplateEmailAddr" id="officeTemplateEmailAddr" disabled>{if isset($fields.email1) AND !empty($fields.email1)}{$fields.email1}{/if}</textarea>
	</td>
</tr>
<tr>
	<td width="12%" scope="row">
	{$MOD.LBL_DESCRIPTION}:
	</td>
	<td width="88%" colspan=3>
	<span id="officeDescription"></span>
	</td>
</tr>
<tr>
	<td width="12%" scope="row">
	{$MOD.LBL_DATE_ENTERED}:
	</td>
	<td width="88%" colspan=3>
	<span id="officeDateEntered"></span>
	</td>
</tr>
<tr>
	<td width="100%" colspan=4>
	<input type="hidden" name="to_pdf" value="true">
	<input type="submit" onclick="officeTemplategenerate();return false;" id="officeTemplateButton" value="{$MOD.LBL_GENERATE_BUTTON}" disabled="true">
	<input type="button" onclick="YAHOO.container.modal_box.hide();" value="{$MOD.BOX_CLOSE}">
	</td>
</tr>

</tbody>
</table>
</form>

</div>


<script type="text/javascript">
var OfficeTemplateObject = YAHOO.lang.JSON.parse('{$JSON_TEMPLATES}');
{literal}
function changeOfficeReportSelect()
{
	var selectOfficeTemplate = document.getElementById('officeTemplateRecord');
	var recordId = selectOfficeTemplate.options[selectOfficeTemplate.selectedIndex].value;

    document.getElementById('officeTemplateFormat').innerHTML = OfficeTemplateObject[recordId].extension_template.toUpperCase();
	document.getElementById('officeDescription').innerHTML = OfficeTemplateObject[recordId].description;
	document.getElementById('officeDateEntered').innerHTML = OfficeTemplateObject[recordId].date_entered;
}

function officeTemplateCheckBoxChange()
{
	if (document.getElementById('officeTemplateLink').checked || document.getElementById('officeTemplateHistory').checked || document.getElementById('officeTemplateEmail').checked){
		document.getElementById('officeTemplateButton').disabled = false;
	}else{
		document.getElementById('officeTemplateButton').disabled = true;
	}
	if (document.getElementById('officeTemplateEmail').checked){
		document.getElementById('officeTemplateEmailAddr').disabled = false;
		document.getElementById('officeTemplateEmailTemplate').disabled = false;
	}
	else{
		document.getElementById('officeTemplateEmailAddr').disabled = true;
		document.getElementById('officeTemplateEmailTemplate').disabled = true;
	}

}

function officeTemplategenerate()
{
  var formObject = document.getElementById('officeTemplateForm');
  YAHOO.util.Connect.setForm(formObject);
  // This facilitates a POST transaction.  The POST data(HTML form)
  var cObj = YAHOO.util.Connect.asyncRequest('POST', 'index.php?module=OfficeReportsMerge&action=processOfficeReport&officeTemplateRecord=' + OfficeParams.record, {success: officeTemplateAnswer, failure: officeTemplateAnswer});
  YAHOO.container.modal_box.hide();
  var body = '<span>' + SUGAR.language.get('app_strings', 'BOX_PLEASE_WAIT') + '</span><span style="float:right;">' + office_preloader_img + '</span>';
  officeTemplateAlertAnswer(body);
}

function officeTemplateAnswer(data)
{
  try {
	var response = YAHOO.lang.JSON.parse(data.responseText);
	if (response.result != 'ok' || response.answer == null || response.answer == undefined){
	  officeTemplateAlertAnswer(SUGAR.language.get('app_strings', 'BOX_ERROR'));
	}else{
	  officeTemplateAlertAnswer(response.answer);
	}
  }
  catch(err){
	officeTemplateAlertAnswer(SUGAR.language.get('app_strings', 'BOX_ERROR'));
  }
  return false;
}

function officeTemplateAlertAnswer(text)
{
  officeAlertWindow.setBody(text);
  officeAlertWindow.show();
}

{/literal}
changeOfficeReportSelect();
officeTemplateCheckBoxChange();
</script>
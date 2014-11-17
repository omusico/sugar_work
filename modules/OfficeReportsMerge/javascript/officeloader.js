function officeGenerateForm(e)
{
	var report_module_name = 'OfficeReportsMerge';
	if (OfficeLazyLoad)
	{
		//create form for generate
		var loader = new YAHOO.util.YUILoader();
		loader.addModule({
			name: "OfficeForm",
			type: "js", //can be "js" or "css"
			fullpath: "modules/" + report_module_name + "/javascript/officeform.js",
			varName: "OfficeForm"
		});
		loader.addModule({
			name: "Dispatcher",
			type: "js", //can be "js" or "css"
			fullpath: "modules/" + report_module_name + "/javascript/dispatcher.js",
			varName: "Dispatcher"
		});
		loader.require("OfficeForm");
		loader.require("Dispatcher");
		loader.onSuccess = officeLoadForm;
		loader.insert();
		OfficeLazyLoad = false;
	}
	else
	{
		officeLoadForm();
	}

	return false;
}

function officeLoadForm()
{
	officeShowBox('BOX_HEADER_OFFICEFORM', 'officeform_box');
	officeCreateForm();
}

function officeCreateReportButton()
{
	var report_module_name = 'OfficeReportsMerge';
	var buttons = YAHOO.util.Selector.query('table.actionsContainer .buttons');
	var num_last = buttons.length-1;

	var new_td = document.createElement("td");
	YAHOO.util.Dom.addClass(new_td, "buttons");
	YAHOO.util.Dom.setAttribute(new_td, "align", "left");

	var office_report_button = document.createElement("input");
	YAHOO.util.Dom.addClass(office_report_button, "button");
	YAHOO.util.Dom.setAttribute(office_report_button, "id", "office_report_button");
	YAHOO.util.Dom.setAttribute(office_report_button, "name", "generate_report");
	YAHOO.util.Dom.setAttribute(office_report_button, "type", "submit");
	YAHOO.util.Dom.setAttribute(office_report_button, "value", SUGAR.language.get('app_strings', 'LBL_GENERATE_BUTTON'));
	YAHOO.util.Dom.setAttribute(office_report_button, "title", SUGAR.language.get('app_strings', 'LBL_GENERATE_BUTTON'));

	new_td.appendChild(office_report_button);

	YAHOO.util.Dom.insertAfter(new_td, buttons[num_last]);

	YAHOO.util.Event.addListener("office_report_button", "click", officeGenerateForm);
}

function officeCreateReportButton65()
{
    var report_module_name = 'OfficeReportsMerge';
    var buttons = document.getElementsByClassName('dropdown-menu')[1];

    var new_li = document.createElement("li");
    var new_a = document.createElement("a");
    YAHOO.util.Dom.setAttribute(new_a, "id", "office_report_button");
    new_a.innerHTML = SUGAR.language.get('app_strings', 'LBL_GENERATE_BUTTON');

    var office_report_button = document.createElement("input");
    
    YAHOO.util.Dom.addClass(new_a, "button");

    YAHOO.util.Dom.addClass(office_report_button, "button");
    YAHOO.util.Dom.setAttribute(office_report_button, "id", "office_report_button");
    YAHOO.util.Dom.setAttribute(office_report_button, "name", "generate_report");
    YAHOO.util.Dom.setAttribute(office_report_button, "type", "submit");
    YAHOO.util.Dom.setAttribute(office_report_button, "value", SUGAR.language.get('app_strings', 'LBL_GENERATE_BUTTON'));
    YAHOO.util.Dom.setAttribute(office_report_button, "title", SUGAR.language.get('app_strings', 'LBL_GENERATE_BUTTON'));
    YAHOO.util.Dom.setAttribute(office_report_button, "style", 'display:none');

    //new_a.appendChild(office_report_button);
    new_li.appendChild(new_a);
    new_li.appendChild(office_report_button);

    YAHOO.util.Dom.insertAfter(new_li, buttons.lastChild);

    YAHOO.util.Event.addListener("office_report_button", "click", officeGenerateForm);
}
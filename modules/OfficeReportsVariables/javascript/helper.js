var report_node = null;
var related_node = null;
var field_node = null;
var code_node = null;

YAHOO.util.Event.onDOMReady(function()
{
    report_node = document.getElementById("select_report_module");
    related_node = document.getElementById("select_related_modules");
    field_node = document.getElementById("select_module_fields");
    code_node = document.getElementById("input_code");
    change_report_module();
});

function change_report_module()
{
    var report_module = report_node.options[report_node.selectedIndex].value;
    var cObj = YAHOO.util.Connect.asyncRequest('POST','index.php?module=OfficeReportsVariables&action=RelatedModules&report_module='+report_module, {success: load_report_module, failure: fail_load});
    change_relate_module(false);
}

function change_relate_module(relate)
{
    var relate_module = '';
    if (relate) {
        relate_module = related_node.options[related_node.selectedIndex].value;
        if (relate_module == '') {
            relate_module = report_node.options[report_node.selectedIndex].value;
        }
    } else {
        relate_module = report_node.options[report_node.selectedIndex].value;
    }
    var cObj2 = YAHOO.util.Connect.asyncRequest('POST','index.php?module=OfficeReportsVariables&action=ModuleFields&relate_module='+relate_module, {success: load_module_fields, failure: fail_load});
}

function load_report_module(data)
{
    try {
        var select = data.responseText;
        related_node.innerHTML = select;
    }
    catch(err){
        fail_load(err);
    }
}

function load_module_fields(data)
{
    try {
        var select = data.responseText;
        field_node.innerHTML = select;
        change_module_fields();
    }
    catch(err){
        fail_load(err);
    }
}

function change_module_fields()
{
    var relate_module = related_node.options[related_node.selectedIndex].value;
    var related_code = '';
    if (relate_module != '')
        related_code = relate_module + '.';

    var field = field_node.options[field_node.selectedIndex].value;

    code_node.value = '[' + related_code + field + ']';
}

function fail_load(err)
{
    YAHOO.SUGAR.MessageBox.show({
        title: 'Error',
        msg: data.responseText,
        width: 400
    });
}
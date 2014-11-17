function addReportField()
{
    var curField = '';

    var select_module_fields = document.getElementById('select_module_fields');
    var nameField = select_module_fields.options[select_module_fields.selectedIndex].value;
    var labelField = select_module_fields.options[select_module_fields.selectedIndex].innerHTML;

    var select_related_modules = document.getElementById('select_related_modules');
    var selModule = select_related_modules.options[select_related_modules.selectedIndex].value;

    curField = nameField;
    if (selModule != "")
    {
        curField = selModule + '.' + curField;
        labelField = selModule + '::' + labelField;
    }

    var reportsFields = document.getElementById('report_vars');

    var elOptNew = document.createElement('option');
    elOptNew.text = labelField;
    elOptNew.value = curField;
    reportsFields.options.add(elOptNew);
    sortlist();
}

function selectAllFields()
{
    var rv = document.getElementById('report_vars');

    for (var i=0; i<rv.options.length; i++) {
        rv.options[i].selected = true;
    }
    return check_form("EditView");
}

function removeReportField()
{
    var rv = document.getElementById('report_vars');
    for (var i=0; i<rv.options.length; i++) {
        if (rv.options[i].selected == true) {
            rv.remove(i);
            i = 0;
        }
    }
}

function sortlist() {
    var rv = document.getElementById('report_vars');
    var arrTexts = new Array();
    var relateArr = new Array();

    for (var i=0; i<rv.length; i++)  {
        arrTexts[i] = rv.options[i].text;
        relateArr[arrTexts[i]] = rv.options[i].value;
    }

    arrTexts.sort();

    for (i=0; i<rv.length; i++)  {
        rv.options[i].text = arrTexts[i];
        rv.options[i].value = relateArr[arrTexts[i]];
    }
}
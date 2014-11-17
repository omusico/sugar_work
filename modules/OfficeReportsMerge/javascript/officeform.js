var id = 'officeform_box';
var office_form_id = '';
var office_preloader_img = "<img src='index.php?entryPoint=getImage&themeName="+SUGAR.themes.theme_name+"&imageName=OfficeReportPreloader.gif'/>";

YAHOO.namespace("container");
office_form_id = id;
width = typeof(width) != 'undefined' ? width : 700;
YAHOO.container.modal_box =
    new YAHOO.widget.Panel("modal_box", {
        width: "720px",
        //fixedcenter: true,
        // close:true,
        autoScroll: "true",
        draggable: true,
        zindex:1000,
        modal: true,
        visible: false,
        underlay: "shadow",
        constraintoviewport:true,
        fixedcenter: true,
        effect:
        {
            effect:YAHOO.widget.ContainerEffect.FADE,
            duration: 0.7
        }
    });

var listeners = new YAHOO.util.KeyListener(document, { keys : 27 }, {fn: function() {YAHOO.container.modal_box.hide();}} );

YAHOO.container.modal_box.cfg.queueProperty("keylisteners", listeners);

var report_module_name = 'OfficeReportsMerge';
YAHOO.container.modal_box.setHeader(SUGAR.language.get('app_strings', 'BOX_HEADER_OFFICEFORM'));
YAHOO.container.modal_box.setBody("<div id='" + id + "'><span>" + SUGAR.language.get('app_strings', 'BOX_GET_FORM_PROCESS') + '</span><span style="float:right;">' + office_preloader_img + '</span></div>');
YAHOO.container.modal_box.render(document.body);
YAHOO.container.modal_box.center();


function officeCreateForm()
{
    var report_module_name = 'OfficeReportsMerge';
    YAHOO.plugin.Dispatcher.fetch ( office_form_id, 'index.php?module=' + report_module_name + '&action=getOfficeForm&report_module=' + OfficeParams.module + '&record=' + OfficeParams.record );
}

function officeShowBox()
{
    YAHOO.container.modal_box.show();
}

// our dialog for info, to show messages to the users
officeAlertWindow = new YAHOO.widget.SimpleDialog("officeAlertWindow",
    {
        width: "270px",
        fixedcenter: true,
        visible: false,
        draggable: true,
        zIndex: 1000,
        close: true,
        modal: true,
        effect:{effect:YAHOO.widget.ContainerEffect.FADE,duration:0.25},
        constraintoviewport: true,
        buttons: [ { text:"close", handler: function(){this.hide();}, isDefault:true }]
    });
officeAlertWindow.setHeader(SUGAR.language.get('app_strings', 'LBL_MODULE_TITLE'));
officeAlertWindow.render(document.body);
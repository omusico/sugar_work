$(document).ready(function() {
    /* var project = $("#project");
    changeProjectsList(project); */

    /* if( getUrlVars()["action"] != 'DetailView'){
      // project.change(function(){changeProjectsList($(this))});
      var type_of_realty = $("#type_of_realty");
      changeKindOfRealty_list();
      type_of_realty.change(function(){changeKindOfRealty_list();});
    } */
	set_type_of_realty();
	$('#type_of_realty').change(set_type_of_realty);
});
function set_type_of_realty(){
	if ($('#type_of_realty').val() == 'living'){
        $("#kind_of_realty option[value='flat']").css("display","");
        $("#kind_of_realty option[value='room']").css("display","");
        $("#kind_of_realty option[value='house']").css("display","");
        $("#kind_of_realty option[value='stock']").css("display","none");
        $("#kind_of_realty option[value='office']").css("display","none");
        $("#kind_of_realty option[value='parcel']").css("display","none");
        $("#kind_of_realty option[value='gost']").css("display","none");
        $("#kind_of_realty option[value='poly']").css("display","none");
        $("#kind_of_realty option[value='torg']").css("display","none");
        $("#kind_of_realty option[value='sto']").css("display","none");
    }
	else if ($('#type_of_realty').val() == 'not_living'){
        $("#kind_of_realty option[value='flat']").css("display","none");
        $("#kind_of_realty option[value='room']").css("display","none");
        $("#kind_of_realty option[value='house']").css("display","none");
        $("#kind_of_realty option[value='stock']").css("display","");
        $("#kind_of_realty option[value='office']").css("display","");
        $("#kind_of_realty option[value='parcel']").css("display","none");
        $("#kind_of_realty option[value='gost']").css("display","");
        $("#kind_of_realty option[value='poly']").css("display","");
        $("#kind_of_realty option[value='torg']").css("display","");
        $("#kind_of_realty option[value='sto']").css("display","");
    }
	else if ($('#type_of_realty').val() == 'parcel'){
        $("#kind_of_realty option[value='flat']").css("display","none");
        $("#kind_of_realty option[value='room']").css("display","none");
        $("#kind_of_realty option[value='house']").css("display","none");
        $("#kind_of_realty option[value='stock']").css("display","none");
        $("#kind_of_realty option[value='office']").css("display","none");
        $("#kind_of_realty option[value='parcel']").css("display","");
        $("#kind_of_realty option[value='gost']").css("display","none");
        $("#kind_of_realty option[value='poly']").css("display","none");
        $("#kind_of_realty option[value='torg']").css("display","none");
        $("#kind_of_realty option[value='sto']").css("display","none");
    }
}

/* 
function changeProjectsList(project) {
    var type_of_realty = $("#type_of_realty");
    var kind_of_realty = $("#kind_of_realty");
    var operation = $("#operation");
    var cost_rent = $("#cost_rent");
    var cost_rent_label = cost_rent.parent().prev();
    var type_of_realty_label = type_of_realty.parent().prev();
    var kind_of_realty_label = kind_of_realty.parent().prev();
   if(project.val() != "realty"){
       if((project.val()=="investment" || project.val()=="business") && operation.val() == "buying"){
           cost_rent.css("display","");
           cost_rent_label.css("visibility","visible");
       } else {
           cost_rent.css("display","none");
           cost_rent_label.css("visibility","hidden");
       }
       type_of_realty.css("display","none");
       type_of_realty_label.css("visibility","hidden");
       kind_of_realty.css("display","none");
       kind_of_realty_label.css("visibility","hidden");
   } else {
       changeKindOfRealty(kind_of_realty);
       type_of_realty.css("display","");
       type_of_realty_label.css("visibility","visible");
       kind_of_realty.css("display","");
       kind_of_realty_label.css("visibility","visible");

       cost_rent.css("display","none");
       cost_rent_label.css("visibility","hidden");
   }
}

function changeKindOfRealty(kind_of_realty)
{
    var realty_class = $("#realty_class");
    var realty_class_label = realty_class.parent().parent().find("td#realty_class_label");

    if(kind_of_realty.val() != "office"){
         realty_class.css("display","none")
         realty_class_label.css("visibility","hidden");
    } else {
         realty_class.css("display","")
         realty_class_label.css("visibility","visible");
    }
}

Array.prototype.in_array = function(p_val) {
  for(var i = 0, l = this.length; i < l; i++)
    if(this[i] == p_val)
      return true;
  return false;
}

function changeKindOfRealty_list()
{
    var type_of_realty = document.getElementById('type_of_realty').value;
    var data = SUGAR.language.get('app_list_strings', "kind_of_realty_list");
    $selected = $('#kind_of_realty').val();
    if (type_of_realty == 'living')
    {
        data = SUGAR.language.get('app_list_strings', "kind_of_realty_list_living");
    }
    if (type_of_realty == 'commercial')
    {
        data = SUGAR.language.get('app_list_strings', "kind_of_realty_list_commercial");
    }

    var select = document.getElementById('kind_of_realty').options;
    select.length = 0;

    for (key in data)
    {
        select[select.length] = new Option (data[key], key);
    }

    if($selected!=null)
        for (var i = 0; i < select.length; i++)
        {
            var val=select[i].value;
            if ($selected.in_array(val))
            {
                    select[i].selected = true;
            }
        }
}

function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
} */
$(document).ready(function() {

function propertyChangeListener(el,property,func,param,forceCheck){
   forceCheck = forceCheck ? forceCheck : property=='value' ? true : false;
   var handler = function(e,o){
      if((o.ie ? e.propertyName.split('.')[0] : e.attrName)==o.prop){
         o.execute(o.param);
      }
   }
   YAHOO.util.Event.onDOMReady(function(){
      var element = YAHOO.lang.isObject(el) ? el : YAHOO.util.Dom.get(el);
      if(YAHOO.env.ua.ie>0 && !forceCheck){
         YAHOO.util.Event.on(element,'propertychange',handler,{ie:true,execute:func,param:param,prop:property});
      }else if(YAHOO.env.ua.webkit || forceCheck){
         var getProp = function(){
            return property=='value' ? element.value : element.getAttribute(property);
         }
         var oldProp = getProp();
         setInterval(function(){
            if(oldProp!=getProp()){
               func(param);
            }
            oldProp = getProp();
         },200);
      }else{
         YAHOO.util.Event.on(element,'DOMAttrModified',handler,{ie:false,execute:func,param:param,prop:property});
      }
   });
}

new propertyChangeListener(document.getElementById('realty_id'), 'value', check_data_cont);


	function check_data_cont()
	{
	 	var realty_id = $('#realty_id').val();

	 	 $.getJSON('index.php?entryPoint=check_cost&realty_id='+realty_id, function(data){	 		
		
			 	$('#amount').val(data);			
		});	
	}
});



$(document).ready(function() {

	var building_value = $('#building_id').attr('value');

	if(building_value.length){

	     $.getJSON('index.php?entryPoint=add_address&building_id='+building_value, function(data){	  	

	         jQuery.each(data, function(key, val){
	         	
	         	$('#address_country').val(val.country);
	            $('#address_region').val(val.region);
	         	$('#address_city').val(val.city);
	         	$('#address_street').val(val.street);
	         	$('#address_house').val(val.house);
	     	});
		 });   
	}
});
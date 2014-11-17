 $(document).ready(function() {

// Функция автообновления координат на яндекс-карте
// function set_point_map(request){

//                 ymaps.geocode( request, {
//                     results: 10
//                 }).then( function (res) {
//                    var result = new Array();
//                    $.each(res,function(index, val){
//                        if(index == "geoObjects")
//                        {
//                             val.each(function (el, i) {
//                                 var temp = el.geometry.getCoordinates();
//                                 result[i] = new Array();
//                                 result[i]["name"] = el.properties.get("name");
//                                 result[i]["text"] = el.properties.get("metaDataProperty.GeocoderMetaData.text");
//                                 result[i]["latitude"] = temp[0];
//                                 result[i]["longitude"] = temp[1];
//                             });
//                        }
//                    });
// 		var label = result[0]["name"];
// 		var value = result[0]["text"];
// 		var latitude = result[0]["latitude"];
// 		var longitude = result[0]["longitude"];

//                 $("#latitude").val(latitude);
//                 $("#longitude").val(longitude);
//                 console.log(marker);
//                 marker.properties.set({
//                     iconContent: label,
//                     balloonContent: value
//                 });
//                 marker.geometry.setCoordinates([latitude, longitude]);
//                 map.setCenter([latitude, longitude], 12);

//               });
// }
$pref = (module_sugar_grp1=='Contacts')?'main_':'';
// автоматическое заполнение адрес-полей 	
if($("#"+$pref+"address_country").val().length == ''){

	$("#"+$pref+"address_country").val('Россия');
}


// Получение улицы из базы КЛАДР
	$("#"+$pref+"address_street").keyup(function(){

		if($("#"+$pref+"address_country").val() == 'Россия'){		  

			$("#"+$pref+"address_house").val(''); 
			$("#"+$pref+"address_street_label_textarea").addClass('not_cladr');

				if($("#"+$pref+"address_region").val().length){

					var address_region = $("#"+$pref+"address_region").val();
				}
				else{

					var address_region = '';
				}
				if($("#"+$pref+"address_city").val().length){

					var address_city = $("#"+$pref+"address_city").val();
				}
				else{

					var address_city = '';
				}

				var address_street = $("#"+$pref+"address_street").val();
				var type_code = 'street';
				var cladr_code = address_region+' '+address_city+' '+address_street;
			   
				$.getJSON('index.php?entryPoint=get_cladr_code&address_code='+cladr_code+'&type_code='+type_code, function(data){

					var arr = [];
					$.each(data, function(i, el){
					  if($.inArray(el, arr) === -1)
						arr.push(el);
					});
					$( "#"+$pref+"address_street" ).autocomplete({
						delay: 1200,
						source: arr,
						select: function(event, ui) {
						
						$("#"+$pref+"address_street_label_textarea").addClass('complete');
						$("div.street_err").remove();

							},
						close: function(event, ui) { 															

							if(!$("#"+$pref+"address_street_label_textarea").hasClass('complete') && $("#"+$pref+"address_street").val().length){									
								//$("#address_street").val('');
								$("#"+$pref+"address_street").parent().append("<div  class='required validation-message street_err' id='street_err'>Предупреждение: улица выбрана не из базы КЛАДР</div>");
							}

						$("#"+$pref+"address_street_label_textarea").removeClass('complete');
						$("#"+$pref+"address_street_label_textarea").removeClass('not_cladr');

						}
					}); 
				});
		   }	      
	});

// Получение города из базы КЛАДР
	$("#"+$pref+"address_city").keyup(function(){

		if($("#"+$pref+"address_country").val() == 'Россия'){

			$("#"+$pref+"address_street").val('');
			$("#"+$pref+"address_house").val('');
			$("#"+$pref+"address_city_label").addClass('not_cladr');

			   
			if($("#"+$pref+"address_region").val().length){

				var address_region = $("#"+$pref+"address_region").val();
			}
			else{

				var address_region = '';
			}

			var address_city = $("#"+$pref+"address_city").val();
			var type_code = 'city';
			var cladr_code = address_region+' '+address_city;
		
		   
			$.getJSON('index.php?entryPoint=get_cladr_code&address_code='+cladr_code+'&type_code='+type_code, function(data){
			
				var arr = [];
				$.each(data, function(i, el){
				  if($.inArray(el, arr) === -1)
					arr.push(el);
				});
				$( "#"+$pref+"address_city" ).autocomplete({
					delay: 1200,
					source: arr,
					select: function(event, ui) { 
				
				$("#"+$pref+"address_city_label").addClass('complete');
				$("div.city_err").remove();
					},
				close: function(event, ui) { 															

					if(!$("#"+$pref+"address_city_label").hasClass('complete') && $("#"+$pref+"address_city").val().length){									
						//$("#"+$pref+"address_city").val('');
						$("#"+$pref+"address_city").parent().append("<div  class='required validation-message city_err' id='city_err'>Предупреждение: город выбран не из базы КЛАДР</div>");
					}

				$("#"+$pref+"address_city_label").removeClass('complete');
				$("#"+$pref+"address_city_label").removeClass('not_cladr');

					}
				});				
			});		   
	   }      
	});

// Получение региона из базы КЛАДР
	$("#"+$pref+"address_region").keyup(function(){

		if($("#"+$pref+"address_country").val() == 'Россия'){

			$("#"+$pref+"address_city").val('');
			$("#"+$pref+"address_street").val( '');
			$("#"+$pref+"address_house").val('');
			$("#"+$pref+"address_region_label").addClass('not_cladr');			       	

			var address_region = $("#"+$pref+"address_region").val();
			var type_code = 'region';
			var cladr_code = address_region;
			   
			$.getJSON('index.php?entryPoint=get_cladr_code&address_code='+cladr_code+'&type_code='+type_code, function(data){
				var arr = [];
				$.each(data, function(i, el){
				  if($.inArray(el, arr) === -1)
					arr.push(el);
				});
				
				$( "#"+$pref+"address_region" ).autocomplete({
					delay: 1200,
					source: arr,
					select: function(event, ui) { 
				
				$("#"+$pref+"address_region_label").addClass('complete');
				$("div.region_err").remove();
					},
				close: function(event, ui) { 

					if(!$("#"+$pref+"address_region_label").hasClass('complete') && $("#"+$pref+"address_region").val().length){									
						//$("#"+$pref+"address_region").val('');
						$("#"+$pref+"address_region").parent().append("<div  class='required validation-message region_err' id='region_err'>Предупреждение: регион выбран не из базы КЛАДР</div>");
					}

				$("#"+$pref+"address_region_label").removeClass('complete');
				$("#"+$pref+"address_region_label").removeClass('not_cladr');

					}
				});
			});
		}	      
	});

// Проверка заполнен ли адрес с базы кладр, если нет, то выводим сообщение. 
	$("#"+$pref+"address_street").change(function () { 

		if($("#"+$pref+"address_country").val() == 'Россия'){

		setTimeout(check_cladr_street, 300);
		}	
	});

	$("#"+$pref+"address_city").change(function () { 

		if($("#"+$pref+"address_country").val() == 'Россия'){

		setTimeout(check_cladr_city, 300);
		}
	});

	$("#"+$pref+"address_region").change(function () { 

		if($("#"+$pref+"address_country").val() == 'Россия'){

		setTimeout(check_cladr_region, 300);
		}
	});

	function check_cladr_street()
	{

		if($("#"+$pref+"address_street_label_textarea").hasClass('not_cladr') && $("#"+$pref+"address_street").val().length){

			$("#"+$pref+"address_street").parent().append("<div  class='required validation-message street_err' id='street_err_2'>Предупреждение: улица выбрана не из базы КЛАДР</div>");			
		}
	}

	function check_cladr_city()
	{
		
		if($("#"+$pref+"address_city_label").hasClass('not_cladr') && $("#"+$pref+"address_city").val().length){

			$("#"+$pref+"address_city").parent().append("<div  class='required validation-message city_err' id='city_err_2'>Предупреждение: город выбран не из базы КЛАДР</div>");			
		}
	}

	function check_cladr_region()
	{
		
		if($("#"+$pref+"address_region_label").hasClass('not_cladr') && $("#"+$pref+"address_region").val().length){

			$("#"+$pref+"address_region").parent().append("<div  class='required validation-message region_err' id='region_err_2'>Предупреждение: регион выбран не из базы КЛАДР</div>");			
		}
	}

// Событие изменение страны
	$("#"+$pref+"address_country").keyup(function () { 

		$("#"+$pref+"address_region").val('');
		$("#"+$pref+"address_city").val('');
		$("#"+$pref+"address_street").val( '');
		$("#"+$pref+"address_house").val('');
	});	

/*
// Заполнение поля, для получение яндекс-адреса
    $("#addrs_city_realty_name").blur(function () {

        if($("#address_country").val().length){

		var address = $("#address_country").val()+', ';
	}
        //if($("#address_region").val().length){

		//address = address + $("#address_region").val()+', ';
		//}
        if($("#addrs_city_realty_name").val().length){

		address = address + $("#addrs_city_realty_name").val()+', '; 
	}
        if($("#addrs_street_realty_name").val().length){

		address = address + $("#addrs_street_realty_name").val()+', ';
	}
        if($("#address_house").val().length){

		address = address + $("#address_house").val();
	}
	
	$("#address").val(address);		
	set_point_map(address); 
	 
    });

    $("#addrs_street_realty_name").blur(function () {

 	if($("#address_country").val().length){

		var address = $("#address_country").val()+', ';
	}
     //if($("#address_region").val().length){

		//address = address + $("#address_region").val()+', ';
	//}
        if($("#addrs_city_realty_name").val().length){

		address = address + $("#addrs_city_realty_name").val()+', ';
	}
        if($("#addrs_street_realty_name").val().length){

		address = address + $("#addrs_street_realty_name").val()+', ';
	}
        if($("#address_house").val().length){

		address = address + $("#address_house").val();
	}
	
	$("#address").val(address);
        set_point_map(address);
	//if($("#addrs_street_realty_name").hasClass('complete')){

		//console.log('no');	
	//}
    });

    $("#address_house").blur(function () {

      if($("#address_country").val().length){

		var address = $("#address_country").val()+', ';
	}
    //if($("#address_region").val().length){

		//address = address + $("#address_region").val()+', ';
	//}
        if($("#addrs_city_realty_name").val().length){

		address = address + $("#addrs_city_realty_name").val()+', ';
	}
        if($("#addrs_street_realty_name").val().length){

		address = address + $("#addrs_street_realty_name").val()+', ';
	}
        if($("#address_house").val().length){

		address = address + $("#address_house").val();
	}
	
	$("#address").val(address);
    	set_point_map(address);
    });*/

});








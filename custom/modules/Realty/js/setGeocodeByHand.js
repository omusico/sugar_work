/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 */

var geocoder;
var map;
var marker;

var curr_lat;
var curr_lng;

function initialize(){
//Определение карты

    var input_lat = document.getElementById("latitude").value;
    var input_lng = document.getElementById("longitude").value;

    curr_lat = 44.60160400000000180398;
    curr_lng = 33.52378000000000213277;

    if (input_lat != null)
    {
        curr_lat = input_lat;
    }

    if (input_lng != null)
    {
        curr_lng = input_lng;
    }

    var latlng = new google.maps.LatLng(curr_lat,curr_lng);
    var options = {
        zoom: 12,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        styles: [
                    {stylers:[{saturation:-100},{gamma:1}]},
                    {elementType:"labels.text.stroke",stylers:[{visibility:"off"}]},
                    {featureType:"poi.business",elementType:"labels.text",stylers:[{visibility:"off"}]},
                    {featureType:"poi.business",elementType:"labels.icon",stylers:[{visibility:"off"}]},
                    {featureType:"poi.place_of_worship",elementType:"labels.text",stylers:[{visibility:"off"}]},
                    {featureType:"poi.place_of_worship",elementType:"labels.icon",stylers:[{visibility:"off"}]},
                    {featureType:"road",stylers:[{hue: "#68b"},{saturation:90}]},
                    {featureType:"road.arterial",stylers: [{hue: "#8ad"}]},
                    {featureType:"water",stylers:[{visibility:"on"},{saturation:50},{gamma:0},{hue:"#50a5d1"}]},
                    {featureType:"administrative.neighborhood",elementType:"labels.text.fill",stylers:[{color:"#333333"}]},
                    {featureType:"road.local",stylers: [{hue: "#8ad"}]},
                    {featureType:"transit.station",elementType:"labels.icon",stylers:[{gamma:1},{saturation:50}]}]
    };

    map = new google.maps.Map(document.getElementById("map_canvas"), options);

    //Определение геокодера
    geocoder = new google.maps.Geocoder();

    var point = new google.maps.LatLng(parseFloat(input_lat),parseFloat(input_lng));

    marker = new google.maps.Marker({
        map: map,
        position: point,
        draggable: true
    });

}
function set_geocode_by_hand($update_adr){
	$(function() {
        $("#address").autocomplete({
            //Определяем значение для адреса при геокодировании
            source: function(request, response) {
                geocoder.geocode( {'address': request.term}, function(results, status) {
                    response($.map(results, function(item) {
                        return {
                            label:  item.formatted_address,
                            value: item.formatted_address,
                            latitude: item.geometry.location.lat(),
                            longitude: item.geometry.location.lng()
                        }
                    }));
                })
            },
            //Выполняется при выборе конкретного адреса
            select: function(event, ui) {
                $("#latitude").val(ui.item.latitude);
                $("#longitude").val(ui.item.longitude);
                var location = new google.maps.LatLng(ui.item.latitude, ui.item.longitude);
                marker.setPosition(location);
                map.setCenter(location);
            }
        });
    });

    //Добавляем слушателя события обратного геокодирования для маркера при его перемещении
    google.maps.event.addListener(marker, 'drag', function() {
        geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
					if($update_adr){
						if(results[0].address_components[0].types[0]=='street_number'){
							$("#address_house").val(results[0].address_components[0].long_name);
							if(results[0].address_components[1].types[0]=='route')
								$("#address_street").val(results[0].address_components[1].long_name);
						}else if(results[0].address_components[0].types[0]=='route'){
							$("#address_street").val(results[0].address_components[0].long_name);
							$("#address_house").val('');
						}
						$('#address').val(results[0].formatted_address);
					}
                    $('#latitude').val(marker.getPosition().lat());
                    $('#longitude').val(marker.getPosition().lng());
                }
            }
        });
    });
}

$(document).ready(function() {
    initialize();
	set_geocode_by_hand(true);
    
});
/*
$(document).ready(function() {

    initialize();

    $(function() {
        $("#address").autocomplete({
            //Определяем значение для адреса при геокодировании
            source: function(request, response) {
                geocoder.geocode( {'address': request.term}, function(results, status) {
                    response($.map(results, function(item) {
                        return {
                            label:  item.formatted_address,
                            value: item.formatted_address,
                            latitude: item.geometry.location.lat(),
                            longitude: item.geometry.location.lng()
                        }
                    }));
                })
            },
            //Выполняется при выборе конкретного адреса
            select: function(event, ui) {
                $("#latitude").val(ui.item.latitude);
                $("#longitude").val(ui.item.longitude);
                var location = new google.maps.LatLng(ui.item.latitude, ui.item.longitude);
                marker.setPosition(location);
                map.setCenter(location);
            }
        });
    });

    //Добавляем слушателя события обратного геокодирования для маркера при его перемещении
    google.maps.event.addListener(marker, 'drag', function() {
        geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    $('#address').val(results[0].formatted_address);
                    $('#latitude').val(marker.getPosition().lat());
                    $('#longitude').val(marker.getPosition().lng());
                }
            }
        });
    });
});*/
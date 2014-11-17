/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 */

var geocoder;
var map;
var marker;
var infowindow;

var curr_lat;
var curr_lng;
var clicked=false;
var this_url;
var rand_num;

function initialize(){
//Определение карты
    var count = 0;
    if($(".realty_map").length) {
        $('.realty_map').each(function()
        {
            var input_lat = $(this).attr('data-lat');
            var input_lng = $(this).attr('data-lon');
            if(count == 0)
            {
                var latlng = new google.maps.LatLng(input_lat,input_lng);
                var options = {
                    zoom: 10,
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

            }

                var point = new google.maps.LatLng(parseFloat(input_lat),parseFloat(input_lng));

                infowindow = new google.maps.InfoWindow();

                rand_num = Math.floor(Math.random()*(5));

                marker = new google.maps.Marker({
                    map: map,
                    position: point,
                    draggable: false,
                    title:$(this).attr('data-name'),
                    icon: 'modules/Realty/images/'+rand_num+'.png'
                });
                this_url = '<a href="index.php?module=Realty&action=DetailView&record='+$(this).attr('data-id')+'" target="_blank">'+$(this).attr('data-name')+'</a>'
                bindInfoW(marker, this_url, infowindow);  
                count++;

        });
    }
    else
    {
        input_lat = 44.60160400000000180398;
        input_lng = 33.52378000000000213277;
        var latlng = new google.maps.LatLng(input_lat,input_lng);
            var options = {
                zoom: 10,
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
    }
}

$(document).ready(function() {
    $('#map_knopke').click(function(){
       
        if($('#map_div').css('display') == 'none')
        {
            if(clicked == false)
            {
                initialize();
                clicked = true;
            }
            $('#map_div').css('display','');
        }
        else
        {
            $('#map_div').css('display','none');
        }
    });

});





            function bindInfoW(marker, contentString, infowindow)
            {
                    google.maps.event.addListener(marker, 'click', function() {
                        infowindow.setContent(contentString);
                        infowindow.open(map, marker);
                    });
            }
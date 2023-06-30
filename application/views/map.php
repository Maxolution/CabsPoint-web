<!DOCTYPE html>
<html>
<body>
<!-- Search input -->
<input id="searchInput" class="controls" type="text" placeholder="Enter a location">




<!-- Google map -->
<div id="map"></div>




<!-- Display geolocation data -->
<ul class="geo-data">
    <li>Full Address: <span id="location"></span></li>
    <li>Postal Code: <span id="postal_code"></span></li>
    <li>Country: <span id="country"></span></li>
    <li>Latitude: <span id="lat"></span></li>
    <li>Longitude: <span id="lon"></span></li>
</ul>




</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>




<script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyDtlldyYN_2AswQa9BwWdJBFsB-PncOw50
&callback=initMap" async defer></script>
<script>
function initMap() {
    var map = new google.maps.Map(document.getElementById('map'));
    var input = document.getElementById('searchInput');
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
    var options = {
        componentRestrictions: {
            country: 'uk'
        }
    };




   var autocomplete = new google.maps.places.Autocomplete(input,options);
    autocomplete.bindTo('bounds', map);




   var infowindow = new google.maps.InfoWindow();
    autocomplete.addListener('place_changed', function() {
        infowindow.close();
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            window.alert("Autocomplete's returned place contains no geometry");
            return;
        }
        // Location details
        for (var i = 0; i < place.address_components.length; i++) {
            if(place.address_components[i].types[0] == 'postal_code'){
                document.getElementById('postal_code').innerHTML = place.address_components[i].long_name;
            }
            if(place.address_components[i].types[0] == 'country'){
                document.getElementById('country').innerHTML = place.address_components[i].long_name;
            }
        }
        document.getElementById('location').innerHTML = place.formatted_address;
        document.getElementById('lat').innerHTML = place.geometry.location.lat();
        document.getElementById('lon').innerHTML = place.geometry.location.lng();
    });
}
</script>




</html>
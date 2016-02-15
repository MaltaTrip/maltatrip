var from_place, to_place;

$(function() {
    bindShowHide();
    bindEvents();
});

function bindEvents() {
    bindRouteForm();
    initMap();
}

function bindShowHide() {

}

function bindRouteForm() {
    var defaultBounds = new google.maps.LatLngBounds(
        new google.maps.LatLng(36.000, 14.22),
        new google.maps.LatLng(35.500, 14.32));

    from_place = $('#from');
    to_place = $('#to');

    from_autocomplete = new google.maps.places.Autocomplete(from_place[0], {bounds: defaultBounds, types: ['geocode'], componentRestrictions: {country: 'mt'}});
    to_autocomplete = new google.maps.places.Autocomplete(to_place[0], {bounds: defaultBounds, types: ['geocode'], componentRestrictions: {country: 'mt'}});
}

function initMap() {
    var directionsService = new google.maps.DirectionsService;
    var directionsDisplay = new google.maps.DirectionsRenderer;
    var map = new google.maps.Map(document.getElementById('showMap'), {
        zoom: 10,
        center: {lat: 35.8833, lng: 14.5000}
    });
    directionsDisplay.setMap(map);

    to_place.focusout(function() {
        if(from_place.val() != "" && to_place.val() != "") {
            calculateAndDisplayRoute(directionsService, directionsDisplay);
        }
    });
}

function calculateAndDisplayRoute(directionsService, directionsDisplay) {
    directionsService.route({
        origin: from_place.val(),
        destination: to_place.val(),
        travelMode: google.maps.TravelMode.DRIVING
    }, function(response, status) {
        if (status === google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
        } else {
            window.alert('Directions request failed due to ' + status);
        }
    });
}
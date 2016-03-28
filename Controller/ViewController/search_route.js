var directionsResponse;
var directionsDisplay = new google.maps.DirectionsRenderer;
var directionsService = new google.maps.DirectionsService;

$(function() {
    bindShowHide();
    bindEvents();
});

function bindEvents() {
    bindSearchChange();
    initMap();
}

function bindShowHide() {
    if (typeof g_searchFrom !== 'undefined' && g_searchTo !== 'undefined' && g_searchDate !== 'undefined') {
        calculateAndDisplayRoute();
    }
}

function initMap() {
    var map = new google.maps.Map(document.getElementById('showMap'), {
        zoom: 10,
        center: {lat: 35.8833, lng: 14.5000}
    });
    directionsDisplay.setMap(map);

    var from_place = $('#from');
    var to_place = $('#to');

    to_place.focusout(function() {
        if(from_place.val() != "" && to_place.val() != "") {
            g_searchFrom = from_place.val();
            g_searchTo = to_place.val();
            calculateAndDisplayRoute();
        }
    });
}

function calculateAndDisplayRoute() {
    //TODO: check for updated values in form
    directionsService.route({
        origin: g_searchFrom,
        destination: g_searchTo,
        travelMode: google.maps.TravelMode.DRIVING
    }, function(response, status) {
        if (status === google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
            directionsResponse = response;
            doSearch();
        } else {
            console.log('Directions request failed due to ' + status);
        }
    });
}

function doSearch() {
    var route = directionsResponse.routes[0].legs[0];
    var routeLines = [];
    $.each(route.steps, function(key, step) {
        routeLines.push(step.encoded_lat_lngs);
    });

    $.ajax({
        type: 'POST',
        url: '/trip/search/',
        data: {from: g_searchFrom, to: g_searchTo, pickup_date: g_searchDate, routeLines: JSON.stringify(routeLines)}
    }).done(function(results) {
        console.log(results);
    }).fail(function(error) {
        console.log(error);
        $('#error-alert').fadeIn();
        $('#error-alert .alert-content').html($.parseJSON(error.responseText).error);
    });
}

function bindSearchChange() {
    var defaultBounds = new google.maps.LatLngBounds(
        new google.maps.LatLng(36.000, 14.22),
        new google.maps.LatLng(35.500, 14.32));

    from_autocomplete = new google.maps.places.Autocomplete($("#from")[0], {bounds: defaultBounds, types: ['geocode'], componentRestrictions: {country: 'mt'}});
    to_autocomplete = new google.maps.places.Autocomplete($("#to")[0], {bounds: defaultBounds, types: ['geocode'], componentRestrictions: {country: 'mt'}});

    $('#from').val(g_searchFrom);
    $('#to').val(g_searchTo);
    $('#date').val(g_searchDate);
}
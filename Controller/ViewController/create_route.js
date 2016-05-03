var from_place, to_place;
var directionsResponse;

$(function() {
    bindShowHide();
    bindEvents();
});

function bindEvents() {

    $('#pickup_date').datetimepicker({
        dateFormat: "dd/mm/yy",
        minDate: 0
    });
    $('#return_date').datetimepicker({
        dateFormat: "dd/mm/yy",
        minDate: 0
    });

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

    $('#createTrip').validate({
        rules: {
            from: "required",
            to: "required",
            pickup_date: "required"
        },
        submitHandler: function (form, event) {
            event.preventDefault();
            addTrip();
            return false;
        }
    });
}

function initMap() {
    var directionsDisplay = new google.maps.DirectionsRenderer;
    var directionsService = new google.maps.DirectionsService;
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
            directionsResponse = response;
        } else {
            console.log('Directions request failed due to ' + status);
        }
    });
}

function addTrip() {
    var from = $('#from').val();
    var to = $('#to').val();

    var inputPickupDate = moment($('#pickup_date').val(), "DD/MM/YYYY HH:mm");
    var inputReturnDate = moment($('#return_date').val(), "DD/MM/YYYY HH:mm");
    var pickupDate = inputPickupDate.format("YYYY-MM-DD HH:mm:ss");
    var returnDate = inputReturnDate.format("YYYY-MM-DD HH:mm:ss");

    var nPass = $('#nPass').val();

    var frequency = 'once';
    if ($('#workdays').is(':checked')) {
        frequency = 'workdays';
    } else if ($('#daily').is(':checked')) {
        frequency = 'daily';
    }

    var route = directionsResponse.routes[0].legs[0];
    var routeLines = [];
    $.each(route.steps, function(key, step) {
        routeLines.push(step.encoded_lat_lngs);
    });

    $.ajax({
        type: 'POST',
        url: '/trip/create/',
        data: {from: from, to: to, pickup_date: pickupDate, return_date: returnDate, frequency: frequency, nPass: nPass,
                routeLines: JSON.stringify(routeLines)}
    }).done(function() {
        loadContent('welcome');
    }).fail(function(error) {
        console.log(error);
        $('#error-alert').fadeIn();
        $('#error-alert .alert-content').html($.parseJSON(error.responseText).error);
    });
}
var directionsResponse;
var directionsDisplay = new google.maps.DirectionsRenderer;
var directionsService = new google.maps.DirectionsService;

var l_email = null;
var l_dialog = null;

$(function() {
    bindShowHide();
    bindEvents();
});

function bindEvents() {
    $( "#date" ).datepicker({
        dateFormat: "dd/mm/yy",
        minDate: 0
    });

    bindSearchChange();
    initMap();
}

function bindShowHide() {
    if (typeof g_searchFrom !== 'undefined' && g_searchTo !== 'undefined' && g_searchDate !== 'undefined') {
        calculateAndDisplayRoute();
    }

    l_dialog = $( "#dialog-form" ).dialog({
        autoOpen: false,
        height: 640,
        width: 480,
        modal: true,
        buttons: {
            "Send Request": sendEmail,
            Cancel: function() {
                l_dialog.dialog( "close" );
            }
        }
    });

    var form = l_dialog.find( "form" ).on( "submit", function( event ) {
        event.preventDefault();
        sendEmail();
    });
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
        showRoutes(results);
    }).fail(function(error) {
        console.log(error);
        $('#error-alert').fadeIn();
        $('#error-alert .alert-content').html($.parseJSON(error.responseText).error);
    });
}

function showRoutes(routes) {
    var routeList = $.parseJSON(routes);
    var content = "";
    $.each(routeList, function(key, route) {
        var box = "<div class=\"routeBox\">";
        box += "<span class=\"routeBox-label\">Pickup Date</span>";
        box += "<span class=\"routeBox-info\">" + route.pickupDate + "</span><br>";
        box += "<span class=\"routeBox-label\">Return Date</span>";
        box += "<span class=\"routeBox-info\">" + route.returnDate + "</span><br>";
        box += "<span class=\"routeBox-label\">Departing From</span>";
        box += "<span class=\"routeBox-info\">" + route.fromPlace + "</span><br>";
        box += "<span class=\"routeBox-label\">Arriving To</span>";
        box += "<span class=\"routeBox-info\">" + route.toPlace + "</span><br>";
        box += "<span class=\"routeBox-label\">Trip Frequency</span>";
        box += "<span class=\"routeBox-info\">" + route.frequency + "</span><br>";
        box += "<span class=\"routeBox-label\">Passengers</span>";
        box += "<span class=\"routeBox-info\">" + route.nPass + "</span><br>";
        box += "<span class=\"routeBox-label\">Driver</span>";
        box += "<span class=\"routeBox-info\">" + route.driver + "</span><br>";
        box += "<span class=\"routeBox-label\">Contact Driver</span>";
        box += "<span class=\"routeBox-info\">" +
            "<button type=\"button\" class=\"btn btn-confirm\" style=\"font-size: 25px\" onclick=\"contactDriver("
            + route.id + ")\">Contact Driver</button></span><br>";
        box += "</div>";
        content += box;
    });

    $('#routeList').html(content);
}

function bindSearchChange() {
    var defaultBounds = new google.maps.LatLngBounds(
        new google.maps.LatLng(36.000, 14.22),
        new google.maps.LatLng(35.500, 14.32));

    from_autocomplete = new google.maps.places.Autocomplete($("#from")[0], {bounds: defaultBounds, types: ['geocode'], componentRestrictions: {country: 'mt'}});
    to_autocomplete = new google.maps.places.Autocomplete($("#to")[0], {bounds: defaultBounds, types: ['geocode'], componentRestrictions: {country: 'mt'}});

    $('#from').val(g_searchFrom);
    $('#to').val(g_searchTo);
    var rawDate = moment(g_searchDate, "YYYY-MM-DD");
    $('#date').val(rawDate.format("DD/MM/YYYY"));
}

function contactDriver(routeId) {
    $.ajax({
        type: 'POST',
        url: '/trip/contactDriver/'+routeId+'/',
        data: {from: g_searchFrom, to: g_searchTo, pickup_date: g_searchDate}
    }).done(function(result) {
        showEmailDialog(result);
    }).fail(function(error) {
        console.log(error);
        $('#error-alert').fadeIn();
        $('#error-alert .alert-content').html($.parseJSON(error.responseText).error);
    });
}

function showEmailDialog(rawEmail) {
    l_email = $.parseJSON(rawEmail);
    $('#emailBody').val(l_email.body);
    l_dialog.dialog('open');
}

function sendEmail() {
    $.ajax({
        type: 'POST',
        url: '/trip/emailDriver/',
        data: {email: JSON.stringify(l_email)}
    }).done(function() {
        $('#success-alert').fadeIn();
        $('#success-alert .alert-content').html("E-mail sent to driver!");
    }).fail(function(error) {
        console.log(error);
        $('#error-alert').fadeIn();
        $('#error-alert .alert-content').html($.parseJSON(error.responseText).error);
    });
}
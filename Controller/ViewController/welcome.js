var g_searchFrom, g_searchTo, g_searchDate;

$(function() {
    bindShowHide();
    bindEvents();
});

function bindEvents() {
    bindSearchTrip();

    $('#btnOfferTrip').click(function() {
        loadContent('create_route');
    });
    
    $('#searchTrip').validate({
        rules: {
            from_place: "required",
            to_place: "required",
            date: "required"
        },
        submitHandler: function (form, event) {
            event.preventDefault();
            g_searchFrom = $('#from_place').val();
            g_searchTo = $('#to_place').val();
            g_searchDate = $('#date').val();
            loadContent('search_route');
            return false;
        }
    });
}

function bindShowHide() {

}

function bindSearchTrip() {
    var defaultBounds = new google.maps.LatLngBounds(
        new google.maps.LatLng(36.000, 14.22),
        new google.maps.LatLng(35.500, 14.32));

    var from_place = document.getElementById('from_place');
    var to_place = document.getElementById('to_place');

    from_autocomplete = new google.maps.places.Autocomplete($("#from_place")[0], {bounds: defaultBounds, types: ['geocode'], componentRestrictions: {country: 'mt'}});
    to_autocomplete = new google.maps.places.Autocomplete($("#to_place")[0], {bounds: defaultBounds, types: ['geocode'], componentRestrictions: {country: 'mt'}});
}
$(function() {
    bindShowHide();
    bindEvents();
});

function bindEvents() {

}

function bindShowHide() {
    $.get('View/includes/login.php', function(data) {
        $('.container').html(data);
    });
}

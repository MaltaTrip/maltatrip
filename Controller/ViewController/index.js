$(function() {
    bindShowHide();
    bindEvents();
});

function bindEvents() {


}

function bindShowHide() {
    $.get('View/includes/login.php', function(data) {
        $('.bodyContainer').html(data);
    });
}

function loadContent(page) {
    $.get('View/includes/'+page+'.php', function(html) {
        $('.bodyContainer').html(html);
    });
}

function loadHeaderContent(page) {
    $.get('View/includes/'+page+'.php', function(html) {
        $('.navContainer').html(html);
    });
}

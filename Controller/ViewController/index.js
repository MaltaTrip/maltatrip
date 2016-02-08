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

function loadContent(page) {
    $.get('View/includes/'+page+'.php', function(html) {
        $('.container').html(html);
    });
}

function loadHeaderContent(page) {
    $.get('View/includes/'+page+'.php', function(html) {
        $('.navContainer').html(html);
    });
}

$(function() {
    bindShowHide();
    bindEvents();
});

function bindEvents() {

}

function bindShowHide() {
    $.get('/user/loggedin/', function(response) {
        if (response == "true") {
            loadHeaderContent('navbar');
            loadContent('welcome');
        } else {
            loadContent('login');
        }
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

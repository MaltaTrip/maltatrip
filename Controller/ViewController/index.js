$(function() {
    bindShowHide();
    bindEvents();
});

function bindEvents() {

}

function bindShowHide() {
    $.get('/user/loggedin/')
        .done(function() {
            loadHeaderContent('navbar');
            loadContent('welcome');
        }).error(function() {
            loadContent('login');
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

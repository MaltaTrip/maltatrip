$(function() {
    bindShowHide();
    bindEvents();
});

function bindEvents() {
    bindLogin();
}

function bindShowHide() {

}

function bindLogin() {
    $('#login').click(function() {
        loadContent('welcome');
        loadHeaderContent('navbar');
    });
}
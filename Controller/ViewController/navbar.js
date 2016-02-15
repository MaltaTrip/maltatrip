$(function() {
    bindShowHide();
    bindEvents();
});

function bindShowHide() {}

function bindEvents() {
    $('#navbar li a').click(function() {
        var page = $(this).attr("href").substring(1);
        loadContent(page);
    });
}
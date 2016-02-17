$(function() {
    bindShowHide();
    bindEvents();
});

function bindShowHide() {}

function bindEvents() {
    $('#navbar li a').click(function() {
        var page = $(this).attr("href").substring(1);
        if (page=='logout')
        {logout();

        }
        else loadContent(page);
    });
}

function logout(){
    $.get('/user/logout/')
        .done(function(response) {
            console.log(response);
            loadContent('login');
            $('.navContainer').html(null);
        }).error(function() {
            loadContent('welcome');
    });
}

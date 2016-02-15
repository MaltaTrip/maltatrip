
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
    $('#register').click(function(){
        loadContent('register');
    });

    $("#loginform").validate({
        rules:
        {
            inputPassword: {
                required: true,
                rangelength: [6,20]
            },
            inputEmail: {
                required: true,
                email: true
            }
        },
        messages:
        {
            inputPassword:{
                rangelength: "Password needs to be at least 6 characters long",
                required: "Please enter your password"
            },
            inputEmail:
            {
                required:"Please enter your email address",
                email:"Please enter a valid email address"
            }
        },
        submitHandler: submitForm
    });

    function submitForm() {
        var username = $('#loginform #inputEmail').val();
        var password = Sha1.hash($('#loginform #inputPassword').val());

        $.ajax({
            type: 'POST',
            url: '/user/login/',
            data: {email: username, password: password}
        }).done(function() {
            loadContent('welcome');
            loadHeaderContent('navbar');
        }).fail(function(error) {
            console.log(error);
            $('#error-alert').fadeIn();
            $('#error-alert .alert-content').html($.parseJSON(error.responseText).error);
        });
    }
    return false;

}
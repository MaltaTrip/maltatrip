
$(function() {
    bindShowHide();
    bindEvents();
});

function bindEvents() {
    bindRegister();
}

function bindShowHide() {

}

function bindRegister() {
    $("#registerform").validate({
        rules:
        {
            name: {
                required:true,
                rangelength: [2,20]
            },
            surname: {
                required:true,
                rangelength: [2,20]
            },
            locality: {
                required:true,
                rangelength: [4,20]
            },
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
            name:"Please enter a valid name",
            surname:"Please enter a valid surname",
            locality:"Please enter a valid locality",
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

        var regForm = $('#registerform');
        var name = regForm.find('#name').val();
        var surname = regForm.find('#surname').val();
        var locality = regForm.find('#locality').val();
        var email = regForm.find('#inputEmail').val();
        var password = Sha1.hash(regForm.find('#inputPassword').val());


        $.ajax({
            type: 'POST',
            url: '/user/register/',
            data: {name:name, surname:surname, locality:locality, email:email,password:password}
        }).done(function(response) {
            loadContent('welcome');
            loadHeaderContent('navbar');
        }).fail(function(error) {
            $('#error-alert').fadeIn();
            $('#error-alert .alert-content').html($.parseJSON(error.responseText).error);
        });
    }
    return false;
}


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
    $('document').ready(function()
    {
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
            var data = $("#loginform").serialize();

            $.ajax({

                type: 'POST',
                url: 'View/includes/login.php',
                data: data,

                success: function (response) {
                    alert(response);
                    if (response == "ok") {
                        loadContent('welcome');
                        loadHeaderContent('navbar');
                    }
                    else {
                        loadContent('login');
                    }
                }
            });
        }
        return false;
    });



}
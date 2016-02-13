
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
    $('document').ready(function()
    {
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
            var data = $("#registerform").serialize();

            $.ajax({

                type: 'POST',
                url: 'View/includes/register.php',
                data: data,

                success: function (response) {
                    if (response == '1') {
                        loadContent('welcome');
                        loadHeaderContent('navbar');
                    }
                    else {
                        loadContent('register');
                    }
                }
            });
        }
        return false;
    });



}

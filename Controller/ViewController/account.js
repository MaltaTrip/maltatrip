/**
 * Created by Kelly on 04/05/2016.
 */

$(function() {
    bindShowHide();
    bindEvents();
});

function bindEvents() {
   getAccountInfo();


}

function bindShowHide() {

}


function getAccountInfo() {
    $.ajax({
        type: 'POST',
        url: '/user/loggedinuser/'
    }).done(function (data) {
        console.log(data);
        var user = $.parseJSON(data);
        var acc= '<div class=\"accoutinfo\">';
        acc+= '<form action="post" target= "accoutinfo" class="form-horizontal" id="accountform" > <br><br> <h2 class="">My Account</h2>';
        acc+='<div class="form-group"><label class="control-label col-md-1" for="Name">Name:</label><div class="col-md-4"> <input type="text" name="name" id="name" class="form-control" value='+user.name+' required autofocus></div></div>';
        acc+='<input type="hidden" name="id" id="id"   value='+ user.userID+' >';
        acc+='<div class="form-group"><label class="control-label col-md-1" for="Surname">Surname:</label><div class="col-md-4"> <input type="text" name="surname" id="surname" class="form-control" value='+user.surname+' required autofocus></div></div>';
        acc+='<div class="form-group"><label class="control-label col-md-1" for="Locality">Locality:</label><div class="col-md-4"> <input type="text" name="locality" id="locality" class="form-control" value='+user.locality+' required autofocus></div></div>';
        acc+='<div class="form-group"><label class="control-label col-md-1" for="Email">Email:</label><div class="col-md-4"> <input type="email" name="email" id="email" class="form-control" value='+user.email+' required autofocus></div></div> <br><br>';
        acc+='<div class="form-group"><label class="control-label col-md-1" for="Password">New Password:</label><div class="col-md-4"><input type="password" name="password" id="password" class="form-control" placeholder="password" required autofocus></div></div> <br>';
        acc+='  <button type="submit" class="btn btn-warning col-md-1 col-md-offset-1"   id="save">Save Changes</button>  </form></div>';


        $('#accountinfo').html(acc);
        bindSave();
    }).fail(function (error) {
        console.log(error);
        $('#error-alert').fadeIn();
        $('#error-alert .alert-content').html($.parseJSON(error.responseText).error);
    });
}

function bindSave() {
    console.log('hello');
    $("#accountform").validate({
        rules: {
            name: {
                required: true,
                rangelength: [2, 20]
            },

            surname: {
                required: true,
                rangelength: [2, 20]
            },
            locality: {
                required: true,
                rangelength: [4, 20]
            },
            password: {
                required: true,
                rangelength: [6, 20]
            },
            email: {
                required: true,
                email: true
            }
        },
        messages: {
            name: "Please enter a valid name",
            surname: "Please enter a valid surname",
            locality: "Please enter a valid locality",
            password: {
                rangelength: "Password needs to be at least 6 characters long",
                required: "Please enter your password"
            },
            email: {
                required: "Please enter your email address",
                email: "Please enter a valid email address"
            }
        },
        submitHandler: submitForm
    });

    function submitForm() {
        console.log('fjfgjfgj');
        var regForm = $('#accountform');
        var name = regForm.find('#name').val();
        var surname = regForm.find('#surname').val();
        var locality = regForm.find('#locality').val();
        var email = regForm.find('#email').val();
        var password = Sha1.hash(regForm.find('#password').val());
        var id = regForm.find('#id').val();
        console.log ('submitted');

        $.ajax({
            type: 'POST',
            url: '/user/updateUser/',
            data: {name:name, surname:surname, locality:locality, email:email,password:password, id: id}
        }).done(function() {
            loadContent('welcome');
            loadHeaderContent('navbar');
        }).fail(function(error) {
            $('#error-alert').fadeIn();
            $('#error-alert .alert-content').html($.parseJSON(error.responseText).error);
        });
    }
    return false;
}


<?php
namespace maltatrip;
require_once("../../model/User.php");
session_start();

if (isset ($_POST['inputEmail']))
{
    $u=new User();
    $user= $u->insertUser($_POST['name'],$_POST['surname'],$_POST['locality'],$_POST['inputEmail'],sha1($_POST['inputPassword']));

    if ($user!=null)
        echo $user;
    else
        echo "failed";

}
else{


    ?>

    <form action="post" target= "container" class="form-signin" id="registerform" >
        <h2 class="form-signin-heading">Please enter your details below</h2>
        <label for="name" class="sr-only">First Name</label>
        <input type="text" name="name" id="name" class="form-control" placeholder="First Name" required autofocus>
        <label for="surname" class="sr-only">Last Name</label>
        <input type="text" name="surname" id=surname" class="form-control" placeholder="Last Name" required autofocus>
        <label for="locality" class="sr-only">Locality</label>
        <input type="text" name="locality" id="locality" class="form-control" placeholder="Locality" required autofocus>

        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" name="inputEmail" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="inputPassword" id="inputPassword" class="form-control" placeholder="Password" required>

        <button class="btn btn-lg btn-primary btn-block"  id="register">Register</button>
    </form>


    <!-- Controller Script -->
    <script src="Controller/ViewController/register.js"></script>

<?php } ?>
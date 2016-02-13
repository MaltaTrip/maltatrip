<?php
 session_start();
    if (isset ($_POST['inputEmail']))
    {
        echo "ok";

        $_SESSION['user'] = $_POST['inputEmail'];
    }
    else{


?>

<form action="post" target= "container" class="form-signin" id="loginform" >
    <h2 class="form-signin-heading">Please sign in</h2>
    <label for="inputEmail" class="sr-only">Email address</label>
    <input type="email" name="inputEmail" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" name="inputPassword" id="inputPassword" class="form-control" placeholder="Password" required>
    <div class="checkbox">
        <label>
            <input type="checkbox" value="remember-me"> Remember me
        </label>
    </div>
    <button class="btn btn-lg btn-primary btn-block"  id="login">Sign in</button>
</form>


        <!-- Controller Script -->
        <script src="Controller/ViewController/login.js"></script>

<?php } ?>
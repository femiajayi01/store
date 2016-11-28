<?php

require_once("includes/initialize.php");

if ($session->is_logged_in()) {
    redirect_to("index.php");
}
$done = FALSE;
if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $found_user = Customer::authenticate($email, $password);

    if ($found_user) {
        $done = TRUE;
        $session->login($found_user);
        $returnUrl = isset($_GET['returnurl']) ? $_GET['returnurl'] : $_GET['returnUrl'];
        $returnUrl = isset($returnUrl) ? $returnUrl : "/";
        redirect_to($returnUrl);
    } else {
        $errMessage = "Email/Password combination incorrect";
    }
} else {
    $email = "";
    $password = "";
}

require('layout/header.php');

?>


    <br/>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="well">
                <div class="panel-body">
                    <h3 style="text-align: center; color: orange; font-family: 'Book Antiqua'">Sign In</h3>

                    <form id="userForm" method="post" action="" class="form-horizontal">
                        <?php if ($done == TRUE) { ?>
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                               
                            </div>
                        <?php } else if (empty($errMessage) == FALSE and isset($errMessage)) {
                            ?>
                            <div class="alert alert-warning alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                                <?php echo $errMessage; ?>
                            </div>
                            <?php
                        } ?>

                        <div class="form-group">
                            <label style="font-size: large" for="email" class="control-label col-md-2">Email </label>
                            <div class="col-md-10" style="width: 300px">
                                <input type="email" class="form-control" id="email" name="email"
                                       placeholder="Email Address" required maxlength="30">
                            </div>
                        </div>

                        <div class="form-group">
                            <label style="font-size: large" for="password" class="control-label col-md-2">Password </label>
                            <div class="col-md-10" style="width: 300px">
                                <input type="password" class="form-control" id="password" name="password"
                                       placeholder="Password" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-10">
                                <input type="submit" name="submit" value="submit" class="btn btn-warning"/>
                            </div>
                        </div>

                    </form>
                    <br/><br/>
                    <p>Don't have an account? <a href="register.php">Sign Up</a></p>
                    <a href="#">Forgot Your Password?</a>
                </div>

            </div>
        </div>
    </div>
    <div class="col-md-4"></div>
    </div>


<?php
require('layout/footer.php');



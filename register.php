<?php
include 'header.php';
include 'inc/User.php';
Session::checkLogin();

///instantiate `User` class object
$user = new User();

if($_SERVER['REQUEST_METHOD']== "POST" && isset($_POST['register'])){
    $userReg = $user -> getUserRegistration($_POST);
}

?>

<section class="mt-4">
    <div class="row">
        <div class="col-md-10 col-lg-10 col-sm-10 m-auto">
            <div class="card bg-light mb-3">
                <div class="card-header mb-2"><h3>User Registration Form</h3></div>

            <!--  user registration return warning/success message box -->
                <div class="col-md-6 col-lg-6 col-sm-8 m-auto">
                <?php
                    if(isset($userReg)){
                        echo $userReg;
                    }
                ?>
                </div>

                <div class="card-body">
                    <h5 class="card-title"> </h5>
                    <div class="row">
                        <div class="col-md-8 col-lg-8 col-sm-11 m-auto">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="userFullName">Your Full Name</label>
                                    <input type="text" name="full_name" class="form-control" placeholder="write your full name...">
                                </div>
                                <div class="form-group">
                                    <label for="userName">User Name</label>
                                    <input type="text" name="user_name" class="form-control" placeholder="write an username...">
                                </div>
                                <div class="form-group">
                                    <label for="userEmail">Your Email Address</label>
                                    <input type="email" name="email_addr" class="form-control" placeholder="write your email address...">
                                </div>
                                <div class="form-group">
                                    <label for="securityPassword">Security Password</label>
                                    <input type="password" name="secure_password" class="form-control" placeholder="enter your security password...">
                                </div>
                                <div class="form-group">
                                    <label for="confirmPassword">Confirm Password</label>
                                    <input type="password" name="confirm_password" class="form-control" placeholder="confirm your password...">
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="register" class="btn btn-primary">Register</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<?php
include 'footer.php';
?>
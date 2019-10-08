<?php
include 'header.php';
include 'inc/User.php';
Session::checkLogin();

$user = new User();
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])){
    $loginUser = $user -> getUserLogin($_POST);
}

?>

<section class="mt-4">
    <div class="row">
        <div class="col-md-10 col-lg-10 col-sm-10 m-auto">
            <div class="card bg-light mb-3">
                <div class="card-header mb-2"><h3>User Login Form</h3></div>

                <!--  user registration return warning message box -->
                <div class="col-md-6 col-lg-6 col-sm-8 m-auto">
                    <?php
                    if(isset($loginUser)){
                        echo $loginUser;
                    }
                    ?>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 col-lg-8 col-sm-11 m-auto">
                            <form action="" method="post">

                                <div class="form-group">
                                    <label for="userEmail">Your Email Address</label>
                                    <input type="email" name="user_email" class="form-control" placeholder="Your Email Address...">
                                </div>

                                <div class="form-group">
                                    <label for="confirmPassword">Your Password</label>
                                    <input type="password" name="user_password" class="form-control" placeholder="Your Password...">
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="login" class="btn btn-primary">Login</button>
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
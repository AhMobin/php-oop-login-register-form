<?php
include 'header.php';
include 'inc/User.php';
Session::checkSession();

if(isset($_GET['id'])) {
    $id = (int)$_GET['id'];
}

//instantiate User class
$user = new User();

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])){
    $updateUser = $user -> updateUserData($id, $_POST);
}

?>

<section class="mt-4">
    <div class="row">
        <div class="col-md-10 col-lg-10 col-sm-10 m-auto">
            <div class="card bg-light mb-3">
                <div class="card-header mb-2"><p class="heading2">All User's Details</p> <a href="index.php" class="card_header_right back-btn btn btn-secondary btn-sm">Back</a> </div>
                <div class="card-body">
                    <h5 class="card-title"> </h5>
                    <div class="row">
                        <div class="col-md-8 col-lg-8 col-sm-11 m-auto">

                            <?php
                                if(isset($updateUser)){
                                    echo $updateUser;
                                }

                                $getUserData = $user -> getUserDataById($id);
                                if($getUserData == true){
                            ?>

                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="userFullName">User Full Name</label>
                                    <input type="text" name="full_name" class="form-control" value="<?php echo $getUserData->user_full_name ?>">
                                </div>
                                <div class="form-group">
                                    <label for="userName">User Name</label>
                                    <input type="text" name="user_name" class="form-control" value="<?php echo $getUserData->user_name ?>">
                                </div>
                                <div class="form-group">
                                    <label for="userEmail">User Email Address</label>
                                    <input type="email" name="email_addr" class="form-control" value="<?php echo $getUserData->user_email ?>" readonly>
                                    <small class="form-text text-muted">Email Cannot Be Changed.</small>
                                </div>

                                <?php  if($id == Session::get('userId')){ ?>
                                <div class="form-group">
                                    <button type="submit" name="update" class="btn btn-info">Update</button>
                                    <a href="change-pass.php?id=<?php echo $id ?>" class="btn btn-success">Change Password</a>
                                </div>
                                <div class="form-group">

                                </div>
                                <?php } ?>

                            </form>

                            <?php } ?>
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
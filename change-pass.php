<?php
include 'header.php';
include 'inc/User.php';
Session::checkSession();

if(isset($_GET['id'])) {
    $id = (int)$_GET['id'];
}

$sesId = Session::get("userId");
if($id != $sesId){
    header("location: change-pass.php?id=".$sesId);
}

$user = new User();

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_pass'])){
    $updatePass = $user -> updateUserPassword($id, $_POST);
}

?>

<section class="mt-4">
    <div class="row">
        <div class="col-md-10 col-lg-10 col-sm-10 m-auto">
            <div class="card bg-light mb-3">
                <div class="card-header mb-2"><p class="heading2">Change Password</p> <a href="profile.php?id=<?php echo $sesId ?>" class="card_header_right back-btn btn btn-secondary btn-sm">Back</a> </div>
                <div class="card-body">
                    <h5 class="card-title"> </h5>
                    <div class="row">
                        <div class="col-md-8 col-lg-8 col-sm-11 m-auto">

                            <?php
                            if(isset($updatePass)){
                                echo $updatePass;
                            }?>

                        <form action="" method="post">
                            <div class="form-group">
                                <label for="currentPassword">Current Password</label>
                                <input type="password" name="curr_password" class="form-control" placeholder="Enter Current Password">
                            </div>
                            <div class="form-group">
                                <label for="newPassword">New Password</label>
                                <input type="password" name="new_password" class="form-control" placeholder="Enter Current Password">
                            </div>
                            <div class="form-group">
                                <label for="userEmail">Confirm Password</label>
                                <input type="password" name="confirm_password" class="form-control" placeholder="Enter Current Password">
                            </div>


                                <div class="form-group">
                                    <button type="submit" name="update_pass" class="btn btn-primary">Password Update</button>
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
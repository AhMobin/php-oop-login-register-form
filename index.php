<?php
include 'header.php';
include 'inc/User.php';
Session::checkSession();

?>

    <section> <!-- Start Registration Section -->
        <div class="card bg-light my-3"> <!-- Start Card -->
            <div class="card-header"> <!-- Start Card Header -->
                <p class="heading2">All User's Details</p> <span class="card_header_right">Welcome!!  <b>
                        <?php
                            $user = Session::get("userName");
                            if(isset($user)){
                                echo $user;
                            }
                        ?>
                </b></span>
            </div> <!-- End Card Header -->

            <div class="card-body"> <!-- Start Card Body -->
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Full Name</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $user = new User();
                        $userData = $user -> getUsersData();
                        if($userData == true){
                            $i = 0;
                            foreach ($userData as $data){
                                $i++; ?>
                    <tr>
                        <th scope="row"><?php echo $i ?></th>
                        <td><?php echo $data['user_name'] ?></td>
                        <td><?php echo $data['user_full_name'] ?></td>
                        <td><?php echo $data['user_email'] ?></td>
                        <td><a href="profile.php?id=<?php echo $data['user_id'] ?>" class="btn btn-primary">View</a></td>
                    </tr>
                    <?php }
                        }else{ ?>
                            <tr>
                                <td colspan="5">No Data Found</td>
                            </tr>
                    <?php  } ?>


                    </tbody>
                </table>
            </div> <!-- End Card Body-->
        </div> <!-- End Card -->
    </section> <!-- End Registration Section --><section></section>



<?php
include 'footer.php';
?>
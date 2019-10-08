<?php
include_once 'inc/Session.php';
Session::init();

//logout user action//

if(isset($_GET['action'])=='logout'){
    Session::destroy();
    header('location: login.php');
}

?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">

    <title>Login Registration Form - PHP OOP Practise</title>
</head>
<body class="container">

<header>
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="index.php">Login Registration System</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <?php
                    $id = Session::get("userId");
                    $userLogged = Session::get("login");
                    if($userLogged == true){
                ?>
                <li class="nav-item active">
                    <a class="nav-link" href="profile.php?id=<?php echo $id ?>">Profile</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="?action=logout">Logout</a>
                </li>
                <?php
                    } else{
                ?>
                <li class="nav-item active">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="register.php">Register</a>
                </li>

                <?php } ?>
            </ul>
        </div>
    </nav>
</header>


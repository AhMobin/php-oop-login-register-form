<?php
include 'Database.php';
include_once 'Session.php';

class User{
    private $db_conn;
    public function __construct(){
        $this->db_conn = new Database();
    }

//user registration method//
    public function getUserRegistration($data)
    {

        //getting user inputted data//
        $fullName = $data['full_name'];
        $userName = $data['user_name'];
        $userEmail = $data['email_addr'];
        $userPassword = $data['secure_password'];
        $confirmPassword = $data['confirm_password'];

        //get result from checkEmail() method - checking email exist or not//
        $checkEmailExist = $this->checkEmail($userEmail);

        //form validations//
        if (empty($fullName) || empty($userName) || empty($userEmail) || empty($userPassword) || empty($confirmPassword)) {
            $msg = "<div class='alert alert-warning' role='alert'><b>Error!</b> Fields Must Not Be Empty.</div>";
            return $msg;
        } elseif (strlen($userName) < 4) {
            $msg = "<div class='alert alert-warning' role='alert'><b>Error!</b> Username Should Not Less Than 4 Characters.</div>";
            return $msg;
        } elseif (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
            $msg = "<div class='alert alert-warning' role='alert'><b>Error!</b> Invalid Email Address.</div>";
            return $msg;
        } elseif ($checkEmailExist == true){
            $msg = "<div class='alert alert-warning' role='alert'><b>Error!</b> Email Is Already Exist.</div>";
            return $msg;
        }elseif ($userPassword != $confirmPassword){
            $msg = "<div class='alert alert-warning' role='alert'><b>Error!</b> Password Did Not Match.</div>";
            return $msg;
        }else{
            //password encryption (md5 hashed)
            $passwordEncrypt = md5($userPassword);

            //insert into database `users` table
            $sql = "INSERT INTO users (user_full_name, user_name, user_email, user_password) VALUES (:user_full_name, :user_name, :user_email,:user_password)";
            $query = $this->db_conn->pdo->prepare($sql);
            $query-> bindValue(':user_full_name', $fullName);
            $query-> bindValue(':user_name', $userName);
            $query-> bindValue(':user_email', $userEmail);
            $query-> bindValue(':user_password', $passwordEncrypt);
            $result = $query -> execute();

            if($result == true){
                $msg = "<div class='alert alert-success' role='alert'><b>Success!</b> Registration Successful. You Can Login Now</div>";
                return $msg;
            }else{
                $msg = "<div class='alert alert-warning' role='alert'><b>Error!</b> Some Error Has Been Occurred. Please Try Again</div>";
                return $msg;
            }

        }

    }
//user email has already exist or not - checking email address method//
    public function checkEmail($email){
        $sql = "SELECT user_email FROM users WHERE user_email = :user_email";
        $query = $this->db_conn->pdo->prepare($sql);
        $query -> bindValue(':user_email', $email);
        $query -> execute();
        if($query->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }

//user login method//
    public function getUserLogin($data){
        //getting user inputted data//
        $emailAddr = $data['user_email'];
        $password  = $data['user_password'];
        $hashed = md5($password);

        //get result from checkEmail() method - checking email exist or not//
        $checkEmailExist = $this -> checkEmail($emailAddr);

        // Form validation//
        if(empty($emailAddr) || empty($password)){
            $msg = "<div class='alert alert-warning' role='alert'><b>Error !</b> Fields Must Not Be Empty.</div>";
            return $msg;
        }elseif ($checkEmailExist == false){
            $msg = "<div class='alert alert-warning' role='alert'><b>Invalid User !</b> Email Does Not Exist.</div>";
            return $msg;
        }elseif(!filter_var($emailAddr, FILTER_VALIDATE_EMAIL)){
            $msg = "<div class='alert alert-warning' role='alert'><b>Error !</b> Invalid Email Address.</div>";
            return $msg;
        }else{
            $result = $this -> checkUserValidity($emailAddr, $hashed);
            if($result){
                Session::init();
                Session::set("login", true);
                Session::set("userId", $result -> user_id);
                Session::set("userName", $result -> user_name);
                Session::set("userEmail", $result -> user_email);
                header('Location: index.php');
            }else{
                $msg = "<div class='alert alert-warning' role='alert'><b>Error !</b> Invalid Email Or Password.</div>";
                return $msg;
            }
        }
    }

//user's validity check for login //
    public function checkUserValidity($emailAddr, $password){
        $sql = "SELECT * FROM users WHERE user_email = :user_email AND user_password = :user_pass LIMIT 1";
        $query = $this -> db_conn -> pdo -> prepare($sql);
        $query -> bindValue(':user_email', $emailAddr);
        $query -> bindValue(':user_pass', $password);
        $query -> execute();
        $result = $query -> fetch(PDO::FETCH_OBJ);
        return $result;
    }


// get all users data//
    public function getUsersData(){
        $sql = "SELECT * FROM users ORDER BY user_id ASC";
        $query = $this -> db_conn -> pdo -> prepare($sql);
        $query -> execute();
        $result = $query -> fetchAll();
        return $result;
    }


// get all users data//
    public function getUserDataById($id){
        $sql = "SELECT * FROM users WHERE user_id = :id";
        $query = $this -> db_conn -> pdo -> prepare($sql);
        $query -> bindValue(':id', $id);
        $query -> execute();
        $result = $query -> fetch(PDO::FETCH_OBJ);
        return $result;
    }


// update user data//
    public function updateUserData($id, $data){
        $fullName = $data['full_name'];
        $username = $data['user_name'];

        //validation//
        if(empty($fullName) || empty($username)){
            $msg = "<div class='alert alert-warning' role='alert'><b>Error !</b> Fields Must Not Be Empty.</div>";
            return $msg;
        }else{
            $sql = "UPDATE users SET user_full_name = :full_name, user_name = :user_name WHERE user_id = :id";
            $query = $this -> db_conn -> pdo -> prepare($sql);
            $query -> bindValue(':full_name', $fullName);
            $query -> bindValue(':user_name', $username);
            $query -> bindValue(':id', $id);
            $result = $query -> execute();
            if($result == true){
                $msg = "<div class='alert alert-success' role='alert'><b>Success !</b> Information Update Successful.</div>";
                return $msg;
            }
        }
    }

//update user password//
    public function updateUserPassword($id, $data){
        $currentPassword  = md5($data['curr_password']);
        $newPassword      = $data['new_password'];
        $confirmPassWord  = $data['confirm_password'];

        //return boolean from checkCurrentPass() - check current password..
        $checkCurrent = $this -> checkCurrentPass($id, $currentPassword);

        if(empty($currentPassword) || empty($newPassword) || empty($confirmPassWord)){
            $msg = "<div class='alert alert-warning' role='alert'><b>Error !</b> Field Must Not Be Empty.</div>";
            return $msg;
        }elseif($checkCurrent == false){
            $msg = "<div class='alert alert-warning' role='alert'><b>Error !</b> Invalid Current Password.</div>";
            return $msg;
        }elseif ($newPassword != $confirmPassWord){
            $msg = "<div class='alert alert-warning' role='alert'><b>Error !</b> New Password Did Not Match.</div>";
            return $msg;
        }else{
            $hashedPassword = md5($newPassword);
            $sql = "UPDATE users SET user_password = :password WHERE user_id = :id";
            $query = $this -> db_conn -> pdo -> prepare($sql);
            $query -> bindValue(':password', $hashedPassword);
            $query -> bindValue(':id', $id);
            $result = $query -> execute();
            if($result == true){
                $msg = "<div class='alert alert-success' role='alert'><b>Success !</b> Password Successfully Changed.</div>";
                return $msg;
            }else{
                $msg = "<div class='alert alert-warning' role='alert'><b>Error !</b> An Unknown Error Occurred. Please Try Again</div>";
                return $msg;
            }
        }
    }

//check current password.. //
    public function checkCurrentPass($id, $currPass){
        $sql = "SELECT * FROM users WHERE user_id = :id AND user_password = :password";
        $query = $this -> db_conn -> pdo -> prepare($sql);
        $query -> bindValue(':id', $id);
        $query -> bindValue(':password', $currPass);
        $query -> execute();
        if($query -> rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }

}
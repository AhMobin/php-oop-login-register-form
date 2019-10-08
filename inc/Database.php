<?php

class Database{
    private $hostname = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname   = "oop_login_reg";
    public $pdo;

    public function __construct(){
        if(!isset($this -> pdo)){
            try{
                $conn = new PDO("mysql:host=".$this->hostname.";dbname=".$this->dbname,$this->username,$this->password);
                $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $conn -> exec("SET CHARACTER SET utf8");
                $this -> pdo = $conn;
            }catch (PDOException $error){
                echo "Database Connection Not Established ".$error->getMessage();
            }
        }
    }
}
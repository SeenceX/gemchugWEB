<?php
include_once "../config/Database.php";
include_once "../objects/User.php";

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$login = $_POST["username"];
$password = $_POST["password"];

if($user->signIn($login, $password)){
    echo "success";
}else{
    echo "failure";
}



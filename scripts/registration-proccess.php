<?php

// Подключение к базе данных и классу User
include_once "../config/Database.php";
include_once "../objects/User.php";

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$login = $_POST["login"];
$password = $_POST["password"];
$fio = $_POST["fio"];

if ($user->signUp($login, $password, $fio)) {
    echo "success";
} else {
    echo "failure";
}
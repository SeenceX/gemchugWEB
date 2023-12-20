<?php

// Подключение к базе данных и классу User
include_once "../config/Database.php";
include_once "../objects/Services.php";

$database = new Database();
$db = $database->getConnection();

$services = new Services($db);

$serviceId = $_POST["serviceId"];
$selectedDateTime = $_POST["selectedDateTime"];
$userId = $_POST["userId"];

if ($services->recordUser($serviceId, $selectedDateTime, $userId)) {
    echo "success";
} else {
    echo "Не удалось записаться на указанную дату и время. Возможно они уже заняты.";
}
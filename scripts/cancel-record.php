<?php
// Подключение к базе данных и классу Services
include_once "../config/Database.php";
include_once "../objects/Services.php";

$database = new Database();
$db = $database->getConnection();

$services = new Services($db);

// Получаем ID записи для отмены
$recordId = isset($_POST['recordId']) ? $_POST['recordId'] : null;

// Проверяем, что ID записи передан корректно
if ($recordId) {
    // Пытаемся отменить запись
    if ($services->cancelRecord($recordId)) {
        echo "success";
    } else {
        echo "failure";
    }
} else {
    echo "Invalid record ID";
}
?>

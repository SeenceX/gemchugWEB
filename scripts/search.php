<?php
session_start();
$userId = $_SESSION['user_id'];
include_once "../config/Database.php";
include_once "../objects/Services.php";

$database = new Database();
$db = $database->getConnection();


$text = $_POST["text"];

$sql = "SELECT service_catalog.name AS name, service_catalog.price AS price, services.name AS service FROM service_catalog LEFT JOIN services ON service_catalog.service_id = services.service_id WHERE service_catalog.name LIKE '%$text%' AND service_catalog.price IS NOT NULL";

$stmt = $db->prepare($sql);

$stmt->execute();

$data = "<table class='table table-striped table-bordered table-hover'><thead><tr><th scope='col'>Вид услуги</th><th scope='col'>Цена, руб.</th><th scope='col'>Подразделение</th></tr></thead><tbody>'";

$num = $stmt->rowCount();

if($num > 0){
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $data .= "<tr><td>".$row['name']."</td><td>".$row['price']."</td><td>".$row['service']."</td></tr>";
    }
}

$data .= "</tbody></table>";

echo $data;




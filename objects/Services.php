<?php

class Services
{
    private $conn;
    private $table_service = "services";
    private $table_catalog = "service_catalog";
    private $table_records = "records";
    public $name;
    public $description;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    function readAll(){
        $query = "SELECT name, description FROM ".$this->table_service;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    function readAllCatalog($id){
        $query = "SELECT ".$this->table_catalog.".id, ".$this->table_catalog.".name, ".$this->table_catalog.".price FROM ".$this->table_catalog." WHERE ".$this->table_catalog.".service_id = ".$id." ORDER BY ".$this->table_catalog.".service_id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function recordUser($serviceId, $selectedDateTime, $userId): bool
    {
        // Проверяем, есть ли кто-то уже записанный на это время и услугу
        if (!$this->isSlotOccupied($serviceId, $selectedDateTime)) {
            // Разделяем дату и время
            list($date, $time) = explode(" ", $selectedDateTime);

            // Формируем строки для даты и времени в формате MySQL
            $dateFormatted = date("Y-m-d", strtotime($date));
            $timeFormatted = date("H:i:s", strtotime($time));
            // Если свободно, выполняем вставку записи в базу данных
            $query = "INSERT INTO " . $this->table_records . " (userId, serviceId, date, time) VALUES (:userId, :serviceId, :date, :time)";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':userId', $userId);
            $stmt->bindParam(':serviceId', $serviceId);
            $stmt->bindParam(':date', $dateFormatted);
            $stmt->bindParam(':time', $timeFormatted);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    private function isSlotOccupied($serviceId, $selectedDateTime) {
        // Проверяем, есть ли кто-то уже записанный на это время и услугу
        list($date, $time) = explode(" ", $selectedDateTime);

        // Формируем строки для даты и времени в формате MySQL
        $dateFormatted = date("Y-m-d", strtotime($date));
        $timeFormatted = date("H:i:s", strtotime($time));
        $query = "SELECT COUNT(*) FROM ". $this->table_records ." WHERE serviceId = :serviceId AND date = :date AND time = :time";
        $stmt = $this->conn->prepare($query);


        $stmt->bindParam(':serviceId', $serviceId);
        $stmt->bindParam(':date', $dateFormatted);
        $stmt->bindParam(':time', $timeFormatted);

        $stmt->execute();
        $count = $stmt->fetchColumn();

        return $count > 0;
    }

    function getUserRecords($userId){
        $query = "SELECT records.*, service_catalog.name AS service_name
              FROM " . $this->table_records . "
              JOIN " . $this->table_catalog . " ON records.serviceId = service_catalog.id
              WHERE records.userId = :userId
              ORDER BY records.date ASC, records.time ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();

        return $stmt;
    }

    public function cancelRecord($recordId)
    {
        // Попытка удалить запись из базы данных
        $query = "DELETE FROM " . $this->table_records . " WHERE id = :recordId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':recordId', $recordId);

        return $stmt->execute();
    }


}
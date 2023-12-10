<?php

class Specialists
{
    private $conn;
    private $table_name = "specialists";
    public $fio;
    public $work_experience;
    public $position;
    public $photo;

    public function __construct($db){
        $this->conn = $db;
    }

    function readAll(){
        $query = "SELECT fio, work_experience, position, photo FROM ".$this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
}
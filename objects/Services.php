<?php

class Services
{
    private $conn;
    private $table_service = "services";
    private $table_catalog = "service_catalog";
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
        $query = "SELECT ".$this->table_catalog.".name, ".$this->table_catalog.".price FROM ".$this->table_catalog." WHERE ".$this->table_catalog.".service_id = ".$id." ORDER BY ".$this->table_catalog.".service_id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
}
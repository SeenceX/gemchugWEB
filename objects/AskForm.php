<?php

class AskForm
{
    private $conn;
    private $table_name = "queries";

    public $email;
    public $fio;
    public $ask;
    public $timestamp;

    public function __construct($db){
        $this->conn = $db;
    }

    function createAsk(){
        $query = "INSERT INTO gemchug." . $this->table_name . " (email, fio, ask, created) VALUES (:email, :fio, :ask, :created)";

        $stmt = $this->conn->prepare($query);

        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->fio = htmlspecialchars(strip_tags($this->fio));
        $this->ask = htmlspecialchars(strip_tags($this->ask));
        $this->timestamp = date("Y-m-d H:i:s");

        if($stmt->execute(array(
            ":email" => $this->email,
            ":fio" => $this->fio,
            ":ask" => $this->ask,
            ":created" => $this->timestamp)
        )){
            return true;
        }else{
            return false;
        }
    }
}
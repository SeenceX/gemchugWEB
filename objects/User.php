<?php

class User
{
    private $conn;
    private $table_users = "users";
    public $login;
    public $password;
    public $fio;
    public $timestamp;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    function signUp()
    {

    }

    function signIn()
    {


    }
}
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

    function signIn($login, $password)
    {
        $query = "SELECT * FROM " . $this->table_users . " WHERE login = :login";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':login', $login);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user){
            $hashedPassword = $user['password'];

            if(password_verify($password, $hashedPassword)){

                session_start();

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['login'] = $user['login'];
                $_SESSION['fio'] = $user['fio'];

                //cookie
                $token = bin2hex(random_bytes(32));
                setcookie("auth_token", $token, time() + 3600, "/");

                $userId = $user['id'];
                $this->saveTokenDB($userId, $token);

                return true; // signIn done
            }
        }
        return false; // signIn fail
    }

    private function saveTokenDB($userId, $token): void
    {
        $query = "UPDATE ".$this->table_users." SET auth_token = :token WHERE id = :userId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
    }
}
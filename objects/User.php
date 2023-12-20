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

    function signUp($login, $password, $fio)
    {
        $queryCheck = "SELECT * FROM " . $this->table_users . " WHERE login = :login";
        $stmtCheck = $this->conn->prepare($queryCheck);

        if (!$stmtCheck) {
            echo "Ошибка при подготовке запроса";
            return false;
        }

        $stmtCheck->bindParam(':login', $login);
        $stmtCheck->execute();

        if ($stmtCheck->rowCount() > 0) {
            return false; // Пользователь с таким логином уже существует
        }

        // хешируем пароль
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // вставляем пользователя в бд
        $queryInsert = "INSERT INTO " . $this->table_users . " (login, password, fio, auth_token, created) VALUES (:login, :password, :fio, NULL, :now)";
        $stmtInsert = $this->conn->prepare($queryInsert);

        if (!$stmtInsert) {
            //ошибка при подготовке запроса
            return false;
        }

        $timestamp = date("Y-m-d H:i:s");

        $stmtInsert->bindParam(':login', $login);
        $stmtInsert->bindParam(':password', $hashedPassword);
        $stmtInsert->bindParam(':fio', $fio);
        $stmtInsert->bindParam(':now', $timestamp);

        if ($stmtInsert->execute()) {
            return true; // регистрация успешна
        }

        // Ошибка при выполнении запроса
        return false; // ошибка регистрации
    }

    function signIn($login, $password)
    {
        $query = "SELECT * FROM " . $this->table_users . " WHERE login = :login";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':login', $login);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $hashedPassword = $user['password'];

            if (password_verify($password, $hashedPassword)) {
                // Успешная аутентификация

                // Начинаем сессию
                session_start();

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['login'] = $user['login'];
                $_SESSION['fio'] = $user['fio'];

                // Создаем и устанавливаем куки
                $token = bin2hex(random_bytes(32));
                // Установка куки с токеном
                setcookie("auth_token", $token, time() + 3600, "/");

                return true; // signIn done
            }
        }
        return false; // signIn fail
    }

}
<?php
session_start();
//var_dump($_SESSION);

include_once "config/Database.php";
include_once "objects/User.php";

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

if (!isset($_COOKIE['auth_token']) || strtotime($_COOKIE['auth_token']) <= time()){
    // Сессия не уничтожается, но можно выполнить другие действия по необходимости
}


?>

    <!doctype html>
    <html class="h-100" lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title><?= $page_title ?></title>
        <link rel="stylesheet" href="./css/bootstrap.css">
        <link rel="stylesheet" href="./css/style.css">
        <link rel="icon" href="./img/favicon.png">
        <script src="js/bootstrap.bundle.js"></script>
        <script src="js/jquery-3.7.1.min.js"></script>
        <script src="js/login.js"></script>
        <script src="js/registration.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://npmcdn.com/flatpickr/dist/l10n/ru.js"></script>
        <script src="js/record.js"></script>
        <script src="js/liveSearch.js"></script>
    </head>
<body class="d-flex flex-column h-100">
<header class="p-2" style="border-bottom: 1px solid rgba(38, 187, 157, 1);">
    <div class="container d-flex justify-content-between align-items-center">
        <a class="navbar-brand" href="index.php"><img src="./img/logo.svg" alt="logo"></a>
        <div class="d-flex align-items-center">
            <?php

            if(!isset($_SESSION["user_id"])){
            echo '<button type="button"
                    class="btn text-light me-2 px-2 align-items-center d-flex align-items-center justify-content-center"
                    style="background-color: rgba(38, 187, 157, 1); width: 80px; height: 32px;" data-bs-toggle="modal"
                    data-bs-target="#exampleModalAuth">
                Войти
            </button>
            <button type="button"
                    class="btn text-light px-2 align-items-center d-flex align-items-center justify-content-center"
                    style="background-color: rgba(38, 187, 157, 1);  height: 32px;" data-bs-toggle="modal"
                    data-bs-target="#exampleModalRegister">
                Зарегистрироваться
            </button>';}
            else{
                $fio = $_SESSION["fio"];
                $fio_parts = explode(" ", $fio);

                $initials = "";
                $initials .= $fio_parts[0] . " "; // Первое слово полностью

                for ($i = 1; $i < count($fio_parts); $i++) {
                    $initials .= mb_substr($fio_parts[$i], 0, 1) . ".";
                }
                echo '<p class="me-3 fw-bold fs-6 text-uppercase">'.$initials.'</p>';
                echo '<div class="d-flex align-items-center">';
                echo '<a href="records.php" class="btn text-light me-2 px-3 align-items-center d-flex justify-content-center" style="background-color: rgba(38, 187, 157, 1); height: 32px;">Записи</a>';
                echo '<form action="./scripts/clear-session.php" class="d-flex align-items-center" method="post">';
                echo '<button type="submit" class="btn text-light me-2 px-2 align-items-center d-flex align-self-center justify-content-center" style="background-color: rgba(38, 187, 157, 1); height: 32px;" name="exit">Выйти</button>';
                echo '</form>';
                echo '</div>';

            }
            ?>

        </div>
    </div>
</header>
<div class="container-fluid">
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <!--<a class="navbar-brand" href="#"><img src="./img/logo.svg" alt="logo"></a>-->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                    aria-controls="navbarText" aria-expanded="false" aria-label="Переключатель навигации">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end align-content-end" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 w-100 justify-content-between">
                    <li class="nav-item">
                        <a class="nav-link text-uppercase fw-bold" aria-current="page" href="about.php">о клинике</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-uppercase fw-bold" href="specialists.php">наши специалисты</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-uppercase fw-bold" href="services.php">услуги</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-uppercase fw-bold" href="discounts.php">выгодные предложения</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-uppercase fw-bold" href="photogallery.php">фотогалерея</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-uppercase fw-bold" href="contacts.php">контакты</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>

<div class="modal fade col-6" id="exampleModalAuth" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <section class="container-fluid">
                    <section class="row justify-content-center">
                        <section class="col-12 col-sm-8 col-md-8">

                            <form class="form-container" action=""
                                  method="post">
                                <div class="form-group mb-3">
                                    <h4 class="text-center font-weight-bold"> Вход </h4>
                                    <label for="Inputuser1">Почта</label>
                                    <input type="email" name="loignIn" class="form-control" id="Inputuser1"
                                           aria-describeby="usernameHelp" placeholder="example@yandex.ru">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="InputPassword1">Пароль</label>
                                    <input type="password" name="passwordIn" class="form-control" id="InputPassword1"
                                           placeholder="********">
                                </div>
                                <button type="button" onclick="submitLoginForm()" class="btn btn-primary btn-block">Войти</button>
                            </form>
                        </section>
                    </section>
                </section>
            </div>
        </div>
    </div>
</div>

<div class="modal fade col-6" id="exampleModalRegister" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <section class="container-fluid">
                    <section class="row justify-content-center">
                        <section class="col-12 col-sm-8 col-md-8">

                            <form class="form-container" action=""
                                  method="post">
                                <div class="form-group mb-3">
                                    <h4 class="text-center font-weight-bold"> Регистрация </h4>
                                    <label for="Inputuser1">Почта</label>
                                    <input type="email" name="login" class="form-control" id="Inputuser2"
                                           aria-describeby="usernameHelp" placeholder="example@yandex.ru">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="InputFio">ФИО</label>
                                    <input type="text" name="fio" class="form-control" id="InputFio"
                                           placeholder="Иванов Иван Иванович">

                                    <label for="InputPassword1">Пароль</label>
                                    <input type="password" name="password" class="form-control" id="InputPassword2"
                                           placeholder="********">
                                </div>
                                <button type="button" onclick="submitRegistrationForm()" class="btn btn-primary btn-block">Зарегистрироваться</button>
                            </form>
                        </section>
                    </section>
                </section>
            </div>
        </div>
    </div>
</div>


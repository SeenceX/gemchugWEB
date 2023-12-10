<?php

session_start();

include_once "config/Database.php";
include_once "objects/User.php";

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

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
    </head>
<body class="d-flex flex-column h-100">
<header class="p-2" style="border-bottom: 1px solid rgba(38, 187, 157, 1);">
    <div class="container d-flex justify-content-between align-items-center">
        <a class="navbar-brand" href="index.php"><img src="./img/logo.svg" alt="logo"></a>
        <div class="auth d-flex flex-md-row flex-column">
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
                echo '<p>'.explode(" ", $_SESSION["user_name"])[1].'</p>';
                echo '<form action="./scripts/clear-session.php" method="post">';
                echo '<button type="submit" name="exit">Выйти</button>';
                echo '</form>';
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
                        <a class="nav-link text-uppercase fw-bold" href="discounts.html">выгодные предложения</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-uppercase fw-bold" href="photogallery.html">фотогалерея</a>
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

                            <?php
                            if (isset($_POST["loignIn"]) && isset($_POST["loignIn"])) {
                                $user->login = $_POST["loignIn"];
                                $user->password = md5($_POST["passwordIn"]);
                                $stmt = $user->signIn();

                                $num = $stmt->rowCount();
                                if ($num > 0) {
                                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                        extract($row);
                                        $_SESSION["user_id"] = $id;
                                        $_SESSION["user_name"] = $fio;
                                    }

                                    echo '<script>';
                                    echo 'alert("Авторизация успешна!")';
                                    echo '</script>';
                                } else {
                                    echo '<script>';
                                    echo 'alert("Неправильный логин или пароль")';
                                    echo '</script>';
                                }
                            }
                            ?>

                            <form class="form-container" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>"
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
                                <button type="submit" class="btn btn-primary btn-block">Войти</button>
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

                            <?php
                            if (isset($_POST["login"]) && isset($_POST["password"]) && isset($_POST["fio"])) {
                                $user->login = $_POST["login"];
                                $user->password = $_POST["password"];
                                $user->fio = $_POST["fio"];
                                if ($user->signUp()) {
                                    echo '<script>';
                                    echo 'alert("Регистрация успешна!!")';
                                    echo '</script>';
                                } else {
                                    echo '<script>';
                                    echo 'alert("Что-то пошло не так :(")';
                                    echo '</script>';
                                }
                            }
                            ?>

                            <form class="form-container" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>"
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
                                <button type="submit" class="btn btn-primary btn-block">Зарегистрироваться</button>
                            </form>
                        </section>
                    </section>
                </section>
            </div>
        </div>
    </div>
</div>
<?php

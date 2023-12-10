<?php
$page_title = "Специалисты";
require_once "header.php";

include_once "config/Database.php";
include_once "objects/Specialists.php";

$database = new Database();
$db = $database->getConnection();

$specialists = new Specialists($db);

$stmt = $specialists->readAll();
$num = $stmt->rowCount();
?>


    <div class="container" style="flex: 1">
        <div class="row">
            <div class="col-3">
                <aside class="rounded-3 py-3 p-3" style="background-color: rgba(38, 187, 157, 0.5);">
                    <ul class="nav flex-column">
                        <li class="nav-item aside-item mb-2"><a href="#"
                                                                class="nav-link aside-link p-1 text-light">Терапия</a>
                        </li>
                        <li class="nav-item aside-item mb-2"><a href="#"
                                                                class="nav-link aside-link p-1 text-light">Хирургия</a>
                        </li>
                        <li class="nav-item aside-item mb-2"><a href="#" class="nav-link aside-link p-1 text-light">Протезирование</a>
                        </li>
                        <li class="nav-item aside-item mb-2"><a href="#" class="nav-link aside-link p-1 text-light">Исправление
                                прикуса</a></li>
                        <li class="nav-item aside-item mb-2"><a href="#" class="nav-link aside-link p-1 text-light">Лечение
                                пародонтита</a></li>
                        <li class="nav-item aside-item mb-2"><a href="#" class="nav-link aside-link p-1 text-light">Имплантация
                                зубов</a></li>
                        <li class="nav-item aside-item mb-2"><a href="#" class="nav-link aside-link p-1 text-light">Детская
                                стоматология</a></li>
                        <li class="nav-item aside-item mb-2"><a href="#" class="nav-link aside-link p-1 text-light">Лечения
                                под наркозом</a></li>
                        <li class="nav-item aside-item mb-2"><a href="#" class="nav-link aside-link p-1 text-light">Отбеливание</a>
                        </li>
                        <li class="nav-item aside-item mb-2"><a href="#" class="nav-link aside-link p-1 text-light">Рентгенкабинет</a>
                        </li>
                    </ul>
                </aside>
            </div>
            <div class="col-9">
                <div class="row gy-1 justify-content-between">

                    <h2>Наши специалисты:</h2>


                    <?php

                    if ($num > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            extract($row);

                            echo '<div class="card col-12 col-md-6" style="width: 18rem;">';
                            echo '<div class="card-body d-flex flex-column justify-content-between">';
                            echo '<img src="./' . $photo . '" class="card-img-top" alt="...">';
                            echo '<h5 class="card-title">' . $fio . '</h5>';
                            echo '<p class="card-text">' . $position . '</p>';
                            echo '<p class="card-text">Опыт работы: ' . $work_experience . '.</p>';
                            echo '</div>';
                            echo '</div>';
                        }
                    }
                    ?>


                </div>
            </div>
        </div>
    </div>


<?php require_once "footer.php" ?>
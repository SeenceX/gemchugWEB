<?php
$page_title = "Услуги";
require_once "header.php";

include_once "config/Database.php";
include_once "objects/Services.php";

$database = new Database();
$db = $database->getConnection();

$services = new Services($db);

?>

    <div class="container search py-3" style="flex: 1">
        <form class="d-flex">
            <input class="form-control me-2" id="getService" type="text" placeholder="Поиск услуг..." aria-label="Search">
        </form>
        <div class="container search-container"></div>
    </div>
    <div class="container content">
        <div class="row">
            <div class="col-3 py-5">
                <aside class="rounded-3 py-3 p-3" style="background-color: rgba(38, 187, 157, 0.5);">
                    <ul class="nav flex-column">
                        <?php
                        $stmt = $services->readAll();
                        $num = $stmt->rowCount();
                        if($num > 0){
                            $count = 1;
                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                extract($row);
                                echo '<li class="nav-item aside-item mb-2"><a href=""
                                                            class="nav-link aside-link p-1 text-light" data-bs-toggle="modal"
                                                            data-bs-target="#exampleModal'.$count.'">'.$name.'</a></li>';
                                $count++;
                            }
                        }
                        ?>
                    </ul>
                </aside>
            </div>
            <div class="col-9">
                <div class="row py-5 gy-3 justify-content-between">


                    <?php
                    $stmt = $services->readAll();
                    $num = $stmt->rowCount();
                    if($num > 0) {
                        $count = 1;
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                            extract($row);
                            echo '<div class="card" style="width: 18rem;">';
                            echo '<div class="card-body d-flex flex-column justify-content-between">';
                            echo '<h5 class="card-title">' . $name . '</h5>';
                            echo '<p class="card-text">' . $description . '</p>';
                            echo '<button type="button" class="btn text-light" style="background-color: rgba(38, 187, 157, 1);" data-bs-toggle="modal"
                                data-bs-target="#exampleModal' . $count . '">
                            Перейти
                        </button>';
                            echo '</div>';
                            echo '</div>';
                            $count++;
                        }
                    }

                    ?>
                    <!-- Модальные окна -->
                    <!--Терапия-->


                    <?php
                    $stmt = $services->readAll();
                    $num = $stmt->rowCount();
                    if($num > 0){
                        $count = 1;
                        while($row_serv = $stmt->fetch(PDO::FETCH_ASSOC)){
                            extract($row_serv);
                            echo '<div class="modal fade" id="exampleModal'.$count.'" tabindex="-1" aria-labelledby="exampleModalLabel"
                     aria-hidden="true">';
                            echo '<div class="modal-dialog">';
                            echo '<div class="modal-content">';
                            echo '<div class="modal-header">';
                            echo '<h1 class="modal-title fs-5" id="exampleModalLabel'.$count.'">'.$name.'</h1>';
                            echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>';
                            echo '</div>';
                            echo '<div class="modal-body">';
                            echo '<table class="table table-striped table-bordered table-hover">';
                            echo '<thead><tr><th scope="col">Вид услуги</th><th scope="col">Цена, руб.</th><th scope="col">Дата</th><th scope="col">Запись</th></tr></thead>';
                            echo '<tbody>';

                            $catalog = $services->readAllCatalog($count);
                            $num_cat = $stmt->rowCount();


                            if($num_cat > 0){
                                while($row_cat = $catalog->fetch(PDO::FETCH_ASSOC)){
                                    extract($row_cat);
                                    echo '<tr>';
                                    echo '<td>'.$name.'</td>';
                                    echo '<td>'.$price.'</td>';
                                    echo '<td><input type="text" class="datetime-picker" /></td>';
                                    echo '<td><button type="button" class="btn btn-primary" onclick="record(' . $id . ', '.$_SESSION["user_id"].', this)">Записаться</button></td>';
                                    echo '</tr>';
                                }
                            }
                            echo '</tbody>';
                            echo '</table>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            $count++;
                        }

                    }

                    ?>

                </div>
            </div>
        </div>
    </div>

<?php require_once "footer.php"?>
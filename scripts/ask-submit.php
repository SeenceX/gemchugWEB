<?php
include_once "config/Database.php";
include_once "objects/AskForm.php";

$database = new Database();
$db = $database->getConnection();

$ask = new AskForm($db);

if($_POST){

    $ask->email = $_POST["email"];
    $ask->fio = $_POST["fio"];
    $ask->ask = $_POST["ask"];

    if($ask->createAsk()){
        echo '<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Готово!</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Сообщение было успешно отправлено!
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                            </div>
                        </div>
                    </div>
                </div>';
    }
    else{
        echo '<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Ошибка</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Не удалось отправить сообщение!
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                            </div>
                        </div>
                    </div>
                </div>';
    }
}

?>

<div class="row d-flex justify-content-center mt-5">
    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post" class="form col-6 d-flex flex-column align-content-end"
          style="background-color: rgba(38, 187, 157, 0.1);">
        <div class="mb-3 p-3">
            <label for="exampleFormControlInput1" class="form-label">Адрес электронной почты:</label>
            <input name="email" type="email" class="form-control" id="exampleFormControlInput1"
                   placeholder="name@example.com" required>
        </div>
        <div class="mb-3 p-3">
            <label for="exampleFormControlInput2" class="form-label">ФИО:</label>
            <input name="fio" type="text" class="form-control" id="exampleFormControlInput2"
                   placeholder="Иванов Иван Иванович" required>
        </div>
        <div class="mb-3 p-3">
            <label for="exampleFormControlTextarea1" class="form-label">Вопрос:</label>
            <textarea name="ask" class="form-control" id="exampleFormControlTextarea1" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn m-2 p-2 text-light" style="background-color: rgba(38, 187, 157, 0.9);">
            Отправить
        </button>
        <!--<button type="submit" class="btn m-2 p-2 text-light" data-bs-toggle="modal" style="background-color: rgba(38, 187, 157, 0.9);"
                data-bs-target="#exampleModal">
            Отправить
        </button>-->
    </form>
</div>



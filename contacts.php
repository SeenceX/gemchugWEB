<?php
$page_title = "Контакты";
require_once "header.php";


include_once "config/Database.php";
include_once "objects/AskForm.php";

$database = new Database();
$db = $database->getConnection();

$ask = new AskForm($db);


?>


<div class="container" style="flex: 1;">
    <h1 class="fs-1 mb-5">Контакты</h1>
    <h2 class="fs-2 fw-normal mb-4">Общество с ограниченной ответственностью "Жемчуг"</h2>
    <div class="row">
        <div class="col-xl-6 col-12">
            <div class="director col d-flex flex-row justify-content-start align-items-start">
                <div class="icon me-3">
                    <img src="./img/telephone.svg" width="24" height="24" alt="">
                </div>
                <div class="info">
                    <p>Генеральный директор</p>
                    <p>Худат-Заде Солтан Ахмедович</p>
                    <p>Телефон: <a href="tel:+74954906252">+7 (495) 490-62-52</a></p>
                </div>
            </div>
            <div class="work-time col d-flex flex-row justify-content-start align-items-start">
                <div class="icon me-3">
                    <img src="./img/clock.svg" width="24" height="24" alt="">
                </div>
                <div class="info">
                    <p>Время работы:</p>
                    <p>понедельник - пятница с 09:00 до 19:00</p>
                    <p>в субботу — с 10:00 до 16:00</p>
                    <p>выходной — воскресенье.</p>
                </div>
            </div>
            <div class="email col d-flex flex-row justify-content-start align-items-start">
                <div class="icon me-3">
                    <img src="./img/email.svg" width="24" height="24" alt="">
                </div>
                <div class="info">
                    <p>Email: <a href="mailto:info@gemchug93.ru">info@gemchug93.ru</a></p>
                </div>
            </div>
            <div class="reception col d-flex flex-row justify-content-start align-items-start">
                <div class="icon me-3">
                    <img src="./img/telephone.svg" width="24" height="24" alt="">
                </div>
                <div class="info">
                    <p>Телефоны регистратуры:</p>
                    <p><a href="tel:+74954910794">+7 (495) 491-07-94</a></p>
                    <p><a href="tel:+74951070387">+7 (495) 107-03-87</a></p>
                </div>
            </div>
            <div class="address col d-flex flex-row justify-content-start align-items-start">
                <div class="icon me-3">
                    <img src="./img/pin-map.svg" width="24" height="24" alt="">
                </div>
                <div class="info">
                    <p>Адрес: Москва, ул. Свободы, д. 19/1.</p>
                    <ul>
                        <li>м. Сокол, троллейбус № 70 до остановки «Улица Мещерякова»</li>
                        <li>м. Сходненская, трамвай № 6 до остановки «Улица Мещерякова»</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-12 d-flex justify-content-center align-items-center"
             style="background-color: rgba(38, 187, 157, 0.5);">
            <script type="text/javascript" charset="utf-8" async
                    src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3Afd4c3ffec5e04e6c49e9a1d161a3c1f04099f17f6ae40deedcbf75c006fdb0f1&amp;width=500&amp;height=400&amp;lang=ru_RU&amp;scroll=true"></script>
        </div>

        <!--ТУТ ФОРМА ОТПРАВКИ-->
        <?php
        if ($_POST) {

            $ask->email = $_POST["email"];
            $ask->fio = $_POST["fio"];
            $ask->ask = $_POST["ask"];

            if ($ask->createAsk()) {
                echo '<script>';
                echo 'alert("Форма успешно отправлена!")';
                echo '</script>';
            } else {
                echo '<script>';
                echo 'alert("Что-то пошло не так :(")';
                echo '</script>';
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
                <!--<button type="submit" class="btn m-2 p-2 text-light" style="background-color: rgba(38, 187, 157, 0.9);">
                    Отправить
                </button>-->
                <button type="submit" class="btn m-2 p-2 text-light" data-bs-toggle="modal" style="background-color: rgba(38, 187, 157, 0.9);"
                        data-bs-target="#exampleModal">
                    Отправить
                </button>
            </form>
        </div>

    </div>
</div>


<?php require_once "footer.php"?>
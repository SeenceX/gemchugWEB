<?php
$page_title = "Мои записи";
require_once "header.php";
include_once "objects/Services.php";
$services = new Services($db);
?>

    <div class="container" style="flex: 1;">
        <!-- Ваш основной контент страницы -->

        <?php
        // Проверяем, авторизован ли пользователь
        if (isset($_SESSION['user_id'])) {
            // Если авторизован, получаем записи пользователя из базы данных
            $userId = $_SESSION['user_id'];
            $userRecords = $services->getUserRecords($userId);

            // Проверяем, есть ли записи
            if ($userRecords->rowCount() > 0) {
                ?>
                <h2>Ваши записи:</h2>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">Услуга</th>
                        <th scope="col">Дата</th>
                        <th scope="col">Время</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    while ($row = $userRecords->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        echo '<tr>';
                        echo '<td>' . $service_name . '</td>';
                        echo '<td>' . $date . '</td>';
                        echo '<td>' . $time . '</td>';
                        echo '<td><button class="btn btn-danger" onclick="cancelRecord(' . $id . ')">Отменить запись</button></td>';
                        echo '</tr>';
                    }
                    ?>
                    </tbody>
                </table>
                <?php
            } else {
                echo '<p>Вы еще не записаны на услуги.</p>';
            }
        }
        ?>

    </div>

    <script>
        function cancelRecord(recordId) {
            // Отправляем данные через AJAX
            $.ajax({
                type: "POST",
                url: "../scripts/cancel-record.php", // Укажите путь к вашему PHP-обработчику отмены записи
                data: { recordId: recordId },
                success: function(response) {
                    if (response === "success") {

                        location.reload();
                    } else {
                        alert('Не удалось отменить запись');
                    }
                }
            });
        }
    </script>

<?php require_once "footer.php"?>
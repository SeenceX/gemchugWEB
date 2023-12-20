document.addEventListener('DOMContentLoaded', function() {
    flatpickr(".datetime-picker", {
        enableTime: true,
        minDate: new Date().fp_incr(1),
        dateFormat: "d-m-Y H:i",
        disable: [
            function(date) {
                // Выключаем воскресенье
                return date.getDay() === 0;
            }
        ],
        minTime: "10:00",
        maxTime: "18:30",
        time_24hr: true,
        minuteIncrement: 30,
        locale: "ru"
    });
});

function record(serviceId, userId, button) {
    const selectedDateTime = $(button).closest('tr').find('.datetime-picker').val();
    console.log(userId, serviceId, selectedDateTime);

    // Проверка, чтобы убедиться, что у вас есть user_id в сессии
    if (userId !== null) {
        // Отправляем данные через AJAX
        $.ajax({
            type: "POST",
            url: "../scripts/record-proccess.php",
            data: { serviceId: serviceId, selectedDateTime: selectedDateTime, userId: userId },
            success: function(response) {
                if(response === "success"){
                    alert('Запись успешна');
                }
                else{
                    alert(response);
                }
            }
        });
    } else {
        alert("Не удалось получить user_id из сессии.");
    }
}

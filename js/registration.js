function submitRegistrationForm(){
    var login = $("#Inputuser2").val();
    var password = $("#InputPassword2").val();
    var fio = $("#InputFio").val();

    console.log(login, password, fio);
    $.ajax({
        type: "POST",
        url: "../scripts/registration-proccess.php",
        data: {login: login, password: password, fio: fio},
        success: function (response){
            if(response === "success"){
                alert("Регистрация успешна!");
                window.location.reload();
            }
            else{
                alert("Ошибка регистрации. Возможно, пользователь с таким логином уже существует.");
            }
        }
    });
}
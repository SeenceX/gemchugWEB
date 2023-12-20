function submitLoginForm(){
    var username = $("#Inputuser1").val();
    var password = $("#InputPassword1").val();
    console.log(username, password);
    $.ajax({
        type: "POST",
        url: "../scripts/login-proccess.php",
        data: {username: username, password: password},
        success: function (response){
            if(response === "success"){
                alert("авторизация успешна!");
                window.location.reload();
            }
            else{
                alert("Неверные данные для входа");
            }
        }
    });

}
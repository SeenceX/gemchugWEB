function submitLoginForm(){
    var username = $("#Inputuser1").val();
    var password = $("#InputPassword1").val();

    $.ajax({
        type: "POST",
        url: "../scripts/login-proccess.php",
        data: {username:username, password:password},
        success: function (response){
            if(response === "success"){
                alert("авторизация успешна!");
            }
            else{
                alert("Неверные данные для входа");
            }
        }
    })
}
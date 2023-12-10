$(document).ready(function (){
    $('#getService').on("keyup", function(){

        var text = $(this).val();

        var notFound = "<div id='notFound' class='alert alert-info mt-3'>По Вашему запросу не найдено ни одной услуги.</div>";

        $(".content").css("display", text === "" ? "block" : "none");
        $(".search-container").css("display", text === "" ? "none" : "block");

        if(text !== ""){
            $.ajax({
                method: "POST",
                url: '../scripts/search.php',
                data: {text: text},
                success:function(response){
                    if (response.trim() === ""){
                        $(".search-container").html(notFound);
                    }
                    else {
                        $(".search-container").html(response);
                    }
                }
            })
        }
    })
})


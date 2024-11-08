$(document).ready(function(){
    $("#hide-show").click(function(){
        $("#box").toggle();
    });

    $("#fade").click(function(){
        $("#box").fadeToggle();
    });

    $("#slide").click(function(){
        $("#box").slideToggle();
    });

    $("#animate").click(function(){
        $("#box").animate({left: '250px'});
    });

    $("#stop").click(function(){
        $("#box").stop();
    });

    $("#callback").click(function(){
        $("#box").slideUp(1000, function(){
            alert("The slideUp effect is complete.");
        });
    });

    $("#chaining").click(function(){
        $("#box").css("background-color", "red")
                 .slideUp(1000)
                 .slideDown(1000);
    });
});

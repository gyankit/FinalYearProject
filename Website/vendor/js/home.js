//Home Page Ajax / Jquery

$("#device-display").hide();
$("#table-user").hide();
$("#table-temp").show();

if(th[0]>34) {
    $(".card-temp").addClass("bg-danger");
} else if(th[0]>28) {
    $(".card-temp").addClass("bg-warning");
} else {
    $(".card-temp").addClass("bg-success");
}

if(th[1]>=70) {
    $(".card-humd").addClass("bg-success");
} else if(th[1]>=40) {
    $(".card-humd").addClass("bg-warning");
} else {
    $(".card-humd").addClass("bg-danger");
}

//To Display Temperature Table
$("#btn-temp").click(function(e){
    e.preventDefault();

    $("#table-user").hide();
    $("#table-temp").show();
});

//To Display User Table
$("#btn-user").click(function(e){
    e.preventDefault();

    $("#table-temp").hide();
    $("#table-user").show();
});

//On Click Automatic Control Button
$("#automatic").click(function(e){
    e.preventDefault();
    $("#device-display").toggle();
});
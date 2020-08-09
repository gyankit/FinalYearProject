//Device Page Ajax / Jquery
$("#room-form").hide();
$("#device-form").hide();

$("#btn-room").click(function(e){
    e.preventDefault();

    $("#room-form").toggle();
});

$("#btn-device").click(function(e){
    e.preventDefault();

    $("#device-form").toggle();
});

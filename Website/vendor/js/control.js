//Device Page Ajax / Jquery

$(".control-btn").click(function(e){
    e.preventDefault();

    var id = $(this).val();
    //console.log(id);
    $.ajax({
        url: "request/web.php",
        type: "post",
        data: {
        	"btn": "control" ,
        	"id": id
        },
        success: function(res) {
        	if(res === '1') {
        		location.reload(true);
            } else {
            	alert("Error Occur !!!");
            }
        }
    });
});


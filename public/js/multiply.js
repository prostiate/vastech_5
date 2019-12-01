$(document).on("change", ".unit-price, .qty", function () {
    
    var qty = +$(".qty").val();
    var unit = +$(".unit-price").val();
    var sum = 0;


    $(".unit-price").each(function(i, dom){
        sum = qty * unit ;
        $(".total-price").val(sum);
    });  
    
});


//asli
$(document).on("change", ".unit-price, .qty", function() {
    var sum = 0;

    /*$(".total-price").each(function(){
        sum += +$(this).val();
    });*/

    sum = $(".qty").val() * $(".unit-price").val();


    $(".total-price").val(sum);
    $(".subtotal").text('Rp.'+sum);
});
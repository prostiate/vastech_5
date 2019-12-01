$(document).on("change", ".total-price", function() {
    var result = 0;

    $(".total-price").each(function(){
        sum += +$(this).val();
    });
    $(".subtotal").text('Rp.' + sum);
    
    function addDays(date, days) {
        var result = new Date(date);
        result.setDate(result.getDate() + days);
        return result;
    }

});
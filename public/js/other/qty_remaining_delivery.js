$(document).ready(function() {
    $(".r_qty").val(0);

    $(".neworderbody").on("keyup change", ".qty", function() {
        var tr = $(this)
            .parent()
            .parent();
        var r_qty = tr.find(".qty").attr("r_val") - 0;
        var qty = tr.find(".qty").val() - 0;
        //var rqtyy = tr.find(".rqtyy").val() - 0;
        var qtyy = tr.find(".qtyy").val() - 0;
        //var tambah = (rqtyy + qtyy);
        //var total = tambah - qty;
        var total = r_qty + (qtyy - qty);
        
        tr.find(".remaining").html(total);
        tr.find(".r_qty").val(total);
    });
});

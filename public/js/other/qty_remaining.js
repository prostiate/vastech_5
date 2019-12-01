$(document).ready(function() {
    $(".r_qty").val(10);

    $(".neworderbody").on("keyup change", ".qty", function() {
        var tr = $(this)
            .parent()
            .parent();
        var r_qty = tr.find(".qty").attr("r_val");
        var qty = tr.find(".qty").val() - 0;

        tr.find(".remaining").html(r_qty - qty);
        tr.find(".r_qty").val(r_qty - qty);
    });
});

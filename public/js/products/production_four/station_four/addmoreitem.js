$(function() {
    $(".add").click(function() {
        var product = $(".product_id").html();
        var unit = $(".unit_id").html();
        tr =
            "<tr>" +
            "<td>" +
            '<div class="form-group">' +
            '<select class="form-control selectproduct product_id" name="product[]">' +
            product +
            "</select>" +
            "</div>" +
            "</td>" +
            "<td>" +
            '<input onClick="this.select();" type="number" class="examount form-control qty" name="qty[]">' +
            '<input type="text" class="amount" hidden>' +
            "</td>" +
            "<td>" +
            '<div class="form-group">' +
            '<select class="form-control unit_id" name="operator[]">' +
            '<option value="1">X</option>' +
            '<option value="2">/</option>' +
            '<option value="3">+</option>' +
            '<option value="4">-</option>' +
            "</select>" +
            "</div>" +
            "</td>" +
            "<td>" +
            '<input type="button" class="btn btn-danger delete" value="x">' +
            "</td>" +
            "</tr>";

        $(".neworderbody").append(tr);

        $(".product_id").select2({
            width: "100%",
            placeholder: "Select Account"
        });

        $(".unit_id").select2({
            width: "100%",
            placeholder: "Select Unit"
        });
    });

    $(".neworderbody").on("click", ".delete", function() {
        $(this)
            .parent()
            .parent()
            .remove();
    });

    /*$('.neworderbody').on('keyup', '.amount', function () {
        totalAmount();
    });*/

    $(".neworderbody").on("keyup keydown change", ".examount", function() {
        var tr = $(this)
            .parent()
            .parent();
        var qty = tr.find(".examount").val() - 0;
        var total = qty;
        tr.find(".amount").val(total);
    });
});

/*'<div class="form-group">' +
            '<select class="form-control selectunit unit_id" name="unit1">' +
            unit +
            "</select>" +
            "</div>" +
            "</td>" +*/

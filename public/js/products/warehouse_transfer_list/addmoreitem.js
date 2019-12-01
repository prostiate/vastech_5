$(function() {
    $(".add-item").click(function() {
        var product = $(".product_id").html();
        tr =
            "<tr>" +
            "<td>" +
            '<select name="product[]" class="form-control col-md-12 col-xs-12 selectproduct_normal product_id">' +
            product +
            "</select>" +
            "</td>" +
            "<td>" +
            '<input type="text" class="qty_transfer form-control" name="qty[]">' +
            "</td>" +
            "<td>" +
            '<input type="button" class="delete btn btn-danger" value="x">' +
            "</td>" +
            "</tr>";
        $(".neworderbody").append(tr);
        $(".product_id").select2({
            placeholder: "Select Product",
            width: "100%"
            //minimumInputLength: 1,
        });
    });

    $(".neworderbody").on("click", ".delete", function() {
        $(this)
            .parent()
            .parent()
            .remove();
    });
});

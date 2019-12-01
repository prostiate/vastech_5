$(document).ready(function() {
    $(function() {
        $(".add-item").click(function() {
            var product = $(".product_id").html();
            tr =
                "<tr>" +
                "<td>" +
                '<div class="form-group">' +
                '<select class="form-control selectproduct_normal product_id" name="product[]">' +
                product +
                "</select>" +
                " </div>" +
                "</td>" +
                '<td>' +
                    '<input type="text" class="form-control recorded_qty" name="recorded_qty[]" readonly>' +
                '</td>' +
                "<td>" +
                '<input onClick="this.select();" type="number" class="form-control qty" name="actual_qty[]" value="0">' +
                "</td>" +
                "<td>" +
                '<input type="button" class="btn btn-danger delete" value="x">' +
                "</td>" +
                "</tr>";
            $(".neworderbody1").append(tr);
            $(".product_id").select2({
                placeholder: "Select Product",
                width: "100%",
                minimumInputLength: 1
            });
        });

        $(".neworderbody1").on("click", ".delete", function() {
            $(this)
                .parent()
                .parent()
                .remove();
        });

        $(".neworderbody1").on(
            "change select2-selecting",
            ".product_id",
            function() {
                var tr = $(this).closest("tr");
                var code = tr.find(".product_id option:selected").attr("code");
                var qty = tr.find(".product_id option:selected").attr("qty");
                var avgprice = tr
                    .find(".product_id option:selected")
                    .attr("avgprice");
                tr.find(".product_code").html(code);
                tr.find(".recorded_qty").val(qty);
                tr.find(".avg_price").html(avgprice);
            }
        );
    });
});

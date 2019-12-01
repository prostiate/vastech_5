$(document).ready(function() {
    $(function() {
        $(".add-item").click(function() {
            //var product = $(".product_id").html();
            tr =
                "<tr>" +
                "<td>" +
                '<div class="form-group">' +
                '<select class="form-control select_product product_id" name="product_id[]">' +
                //product +
                "</select>" +
                '<input class="selected_product_id" hidden>' +
                '<input class="selected_product_avg_price" hidden>' +
                '<input class="tampungan_product_id" hidden>' +
                '<input class="tampungan_product_avg_price" hidden>' +
                " </div>" +
                "</td>" +
                "<td>" +
                '<input onClick="this.select();" type="number" class="form-control qty" name="product_qty[]" value="0">' +
                "</td>" +
                "<td>" +
                '<input onClick="this.select();" type="text" class="form-control product_price_display" value="0" readonly>' +
                '<input type="text" class="hidden_product_id" name="product_id2[]" hidden>' +
                '<input type="text" class="hidden_product_price" name="product_price[]" value="0" hidden>' +
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
                var avgprice = tr.find(".product_id option:selected").attr("avgprice");
                tr.find(".span_product_code").html(code);
                tr.find(".span_recorded_qty").html(qty);
                tr.find(".span_avg_price").html(avgprice);
            }
        );
    });
});

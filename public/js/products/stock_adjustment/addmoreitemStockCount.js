function inputMasking() {
    Inputmask.extendAliases({
        numeric: {
            prefix: "Rp",
            digits: 2,
            digitsOptional: false,
            decimalProtect: true,
            groupSeparator: ",",
            radixPoint: ".",
            radixFocus: true,
            autoGroup: true,
            autoUnmask: true,
            removeMaskOnSubmit: true
        }
    });

    Inputmask.extendAliases({
        IDR: {
            alias: "numeric",
            prefix: "Rp "
        }
    });

    $(".avg_price_display").inputmask("IDR");
}

$(document).ready(function () {
    inputMasking();
    
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
                "<td>" +
                '<h5 class="product_code"></h5>' +
                "</td>" +
                "<td>" +
                '<input type="text" class="form-control recorded_qty" name="recorded_qty[]" readonly>' +
                "</td>" +
                "<td>" +
                '<input onClick="this.select();" type="number" class="form-control qty" name="actual_qty[]" value="0">' +
                "</td>" +
                "<td>" +
                '<input onClick="this.select();" type="text" class="form-control avg_price_display" readonly>"' +
                '<input type="text" class="form-control avg_price" name="avg_price[]" hidden>' +
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

            inputMasking();
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
            ".avg_price_display",
            function() {
                var tr = $(this).closest("tr");
                var code = tr.find(".product_id option:selected").attr("code");
                var qty = tr.find(".product_id option:selected").attr("qty");
                var avgprice = tr.find(".product_id option:selected").attr("avgprice");
                tr.find(".product_code").html(code);
                tr.find(".recorded_qty").val(qty);
                tr.find(".avg_price_display").val(avgprice);
                tr.find(".avg_price").val(avgprice);
            }
        );

        $(".neworderbody1").on(
            "change",
            ".avg_price_display",
            function() {
                var tr = $(this).closest("tr");
                var avgprice = tr.find(".avg_price_display").val();
                tr.find(".avg_price").val(avgprice);
            }
        );
    });
});

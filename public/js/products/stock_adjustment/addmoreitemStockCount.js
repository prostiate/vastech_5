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
$(document).ready(function() {
    inputMasking();
    $(function() {
        $(".add-item").click(function() {
            var product = $(".product_id").html();
            tr =
                "  <tr>" +
                "    <td>" +
                '  <div class="form-group">' +
                '   <h5><a href="/products/{{$a->product_id}}"> {{$a->product->name}} </a></h5>' +
                '  <input type="text class="product_id form-control" name="product_id[]" hidden>' +
                " </div>" +
                " </td>" +
                " <td>" +
                ' <div class="form-group">' +
                " <h5> {{$a->product->code}} </h5>" +
                '<input type="text" class="product_code form-control" name="product_code[]" hidden>' +
                "</div>" +
                "</td>" +
                "<td>" +
                '<div class="form-group">' +
                "<h5> {{$a->recorded}} </h5>" +
                '<input type="text" value="{{$a->recorded}}" class="recorded_qty form-control" name="recorded_qty[]" hidden>' +
                " </div>" +
                "</td>" +
                "<td>" +
                ' <input value="{{$a->actual}}" type="text" class="actual_qty form-control" name="actual_qty[]">' +
                "</td>" +
                "<td>" +
                '<div class="form-group">' +
                '<input onClick="this.select();" type="text" value="{{$a->avg_price}}" class="avg_price_display form-control">' +
                '<input type="text" value="{{$a->avg_price}}" class="avg_price_hidden" name="avg_price[]">' +
                "</div>" +
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
        $(".neworderbody1").on(
            "keyup change",
            ".avg_price_display",
            function() {
                var tr = $(this).closest("tr");
                var avg_price = tr.find(".avg_price_display").val() - 0;
                tr.find(".avg_price_hidden").val(avg_price);
            }
        );
    });
});

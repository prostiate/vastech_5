function inputMaskingTotal() {
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

    $(".wip_product_price_display").inputmask("IDR");
    $(".wip_product_total_price_display").inputmask("IDR");
    $(".wip_total_price_display").inputmask("IDR");
}

function inputMaskingTotal2() {
    Inputmask.extendAliases({
        numeric: {
            prefix: "",
            suffix: "",
            digits: 2,
            digitsOptional: false,
            decimalProtect: true,
            groupSeparator: ",",
            radixPoint: ".",
            radixFocus: true,
            autoGroup: true,
            autoUnmask: true,
            removeMaskOnSubmit: true,
            clearMaskOnLostFocus: true
        }
    });

    $(".wip_total_price_hidden_pure").inputmask("numeric");
}

function inputMaskingMarginRp() {
    Inputmask.extendAliases({
        numeric: {
            prefix: "Rp ",
            suffix: "",
            digits: 0,
            digitsOptional: false,
            decimalProtect: true,
            groupSeparator: ",",
            radixPoint: ".",
            radixFocus: true,
            autoGroup: true,
            autoUnmask: true,
            removeMaskOnSubmit: true,
            clearMaskOnLostFocus: true
        }
    });

    $(".wip_margin_display").inputmask("numeric");
}

function inputMaskingMarginPer() {
    Inputmask.extendAliases({
        numeric: {
            prefix: "",
            suffix: " %",
            digits: 0,
            digitsOptional: false,
            decimalProtect: true,
            groupSeparator: "",
            radixPoint: "",
            radixFocus: true,
            autoGroup: true,
            autoUnmask: true,
            removeMaskOnSubmit: true,
            clearMaskOnLostFocus: true
        }
    });

    $(".wip_margin_display").inputmask("numeric");
}

function totalPrice(tr) {
    var price_display = tr.find(".wip_product_price_display").val() - 0;
    var qty_display = tr.find(".wip_req_qty_display").val() - 0;
    //var qty = $(".product_qty").val() - 0;
    var subtotal = price_display * qty_display;
    tr.find(".wip_product_price").val(price_display);
    tr.find(".wip_product_total_price_display").val(subtotal);
    tr.find(".wip_product_total_price").val(subtotal);
    totalGrandAll();
}

function totalGrandAll(a) {
    var t = 0;
    $(".wip_product_total_price_display").each(function(i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });

    //var qty = $(".product_qty").val() - 0;
    var margin = $(".wip_margin_display").val() - 0;
    var total = t + margin;

    $(".wip_total_price_display").val(total);
    $(".wip_total_price_hidden_pure").val(total);
    $(".wip_total_price_hidden_pure_input").val($(".wip_total_price_hidden_pure").val() - 0);
    $(".wip_total_price_hidden_grand").val(t);
}

function selectProduct() {
    $(".product_id").select2({
        placeholder: "Select Product",
        width: "100%",
    });
}

$(function() {
    totalGrandAll(0);
    inputMaskingMarginRp();
    inputMaskingTotal();
    inputMaskingTotal2();
    selectProduct();

    $(".add").click(function() {
        var product = $(".product_id").html();
        tr =
            "<tr>" +
            "<td>" +
            '<div class="form-group">' +
            '<select class="form-control selectproduct_normal product_id" name="wip_product_id[]">' +
            product +
            "</select>" +
            "</div>" +
            "</td>" +
            "<td>" +
            '<input onClick="this.select();" type="number" class="wip_req_qty_display form-control qty" name="wip_product_req_qty[]" value="0">' +
            "</td>" +
            "<td>" +
            '<input onClick="this.select();" type="text" class="wip_product_price_display form-control" value="0">' +
            '<input type="text" class="wip_product_price" name="wip_product_price[]" value="0" hidden>' +
            "</td>" +
            "<td>" +
            '<input onClick="this.select();" type="text" class="wip_product_total_price_display form-control" value="0" readonly>' +
            '<input type="text" class="wip_product_total_price" name="wip_product_total_price[]" value="0" hidden>' +
            "</td>" +
            "<td>" +
            '<input type="button" class="btn btn-danger delete" value="x">' +
            "</td>" +
            "</tr>";

        $(".neworderbody").append(tr);

        selectProduct();
        inputMaskingMarginRp();
        inputMaskingTotal();
    });

    //$(".product_qty").on("keyup change", function() {
    //    totalGrandAll();
    //});

    $(".neworderbody").on(
        "keyup change",
        ".wip_req_qty_display, .wip_product_price_display",
        function() {
            var tr = $(this).closest("tr");
            totalPrice(tr);
        }
    );

    $(".neworderfoot").on(
        "keyup change",
        "#margin, .wip_margin_display",
        function() {
            var tr = $(this).closest("tr");
            var margin = tr
                .find("#margin")
                .find("option:selected")
                .val();
            var marginValue = tr.find(".wip_margin_display").val() - 0;
            if (margin == "rp") {
                inputMaskingMarginRp();
                var grandTotalBeforeMargin =
                    $(".wip_total_price_hidden_pure").val() - 0;
                var grandTotal = marginValue + grandTotalBeforeMargin;
                $(".wip_margin_hidden_per").val(marginValue);
                $(".wip_margin_hidden_total").val(marginValue);
                $(".wip_total_price_display").val(grandTotal);
            } else {
                inputMaskingMarginPer();
                var grandTotalBeforeMargin =
                    $(".wip_total_price_hidden_pure").val() - 0;
                var grandTotal =
                    (marginValue * grandTotalBeforeMargin) / 100 +
                    grandTotalBeforeMargin;
                var marginTotal = (marginValue * grandTotalBeforeMargin) / 100;
                $(".wip_margin_hidden_per").val(marginValue);
                $(".wip_margin_hidden_total").val(marginTotal);
                $(".wip_total_price_display").val(grandTotal);
            }
        }
    );

    $(".neworderbody").on(
        "keyup change select2-selecting",
        ".product_id",
        function() {
            var tr = $(this).closest("tr");
            var price = tr.find('.product_id').find('option:selected').attr('unitprice');
            tr.find(".wip_product_price_display").val(price);
            tr.find(".wip_product_price").val(price);
            totalPrice(tr);
        }
    );
});

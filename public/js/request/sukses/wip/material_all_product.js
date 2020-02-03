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

    $(".wip_product_price_display_all").inputmask("IDR");
    $(".wip_product_total_price_display_all").inputmask("IDR");
    $(".wip_total_price_display_all").inputmask("IDR");
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

    $(".wip_total_price_hidden_pure_all").inputmask("numeric");
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

    $(".wip_margin_display_all").inputmask("numeric");
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

    $(".wip_margin_display_all").inputmask("numeric");
}

function totalPrice(tr) {
    var price_display = tr.find(".wip_product_price_display_all").val() - 0;
    var qty_display = tr.find(".wip_req_qty_display_all").val() - 0;
    var qty = $(".product_qty").val() - 0;
    var subtotal = price_display * qty_display;
    tr.find(".wip_product_price_all").val(price_display);
    tr.find(".wip_product_total_price_display_all").val(subtotal);
    tr.find(".wip_product_total_price_all").val(subtotal);
    totalGrandAll();
}

function totalGrandAll(a) {
    var t = 0;
    $(".wip_product_total_price_display_all").each(function(i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });

    var qty = $(".product_qty").val() - 0;
    var margin = $(".wip_margin_display_all").val() - 0;
    var total = t / qty + margin;

    $(".wip_total_price_display_all").val(total);
    $(".wip_total_price_hidden_pure_all").val(total);
    $(".wip_total_price_hidden_pure_input_all").val(
        $(".wip_total_price_hidden_pure_all").val() - 0
    );
    $(".wip_total_price_hidden_grand_all").val(t);
}

function selectProduct() {
    $(".product_id_all").select2({
        placeholder: "Select Product",
        width: "100%",
        minimumInputLength: 1
    });
}

$(function() {
    totalGrandAll(0);
    inputMaskingMarginRp();
    inputMaskingTotal();
    inputMaskingTotal2();
    selectProduct();

    $(".add_all").click(function() {
        var product = $(".product_id_all").html();
        tr =
            "<tr>" +
            "<td>" +
            '<div class="form-group">' +
            '<select class="form-control selectproduct_normal product_id_all" name="wip_product_id_all[]">' +
            product +
            "</select>" +
            "</div>" +
            "</td>" +
            "<td>" +
            '<input onClick="this.select();" type="number" class="wip_req_qty_display_all form-control qty_all" name="wip_product_req_qty_all[]" value="0">' +
            '<span class="red span_alert_qty_all" hidden><strong>Stock is not enough!</strong></span>' +
            '<input class="force_submit_all" name="force_submit_item_all[]" type="number" value="1" disabled hidden>' +
            "</td>" +
            "<td>" +
            '<input class="product_unit_all form-control" type="text" readonly>' +
            "</td>" +
            "<td>" +
            '<input onClick="this.select();" type="text" class="wip_product_price_display_all form-control" value="0">' +
            '<input type="text" class="wip_product_price_all" name="wip_product_price_all[]" value="0" hidden>' +
            "</td>" +
            "<td>" +
            '<input onClick="this.select();" type="text" class="wip_product_total_price_display_all form-control" value="0" readonly>' +
            '<input type="text" class="wip_product_total_price_all" name="wip_product_total_price_all[]" value="0" hidden>' +
            "</td>" +
            "<td>" +
            '<input type="button" class="btn btn-danger delete_all" value="x">' +
            "</td>" +
            "</tr>";

        $(".neworderbody_all").append(tr);

        selectProduct();
        inputMaskingMarginRp();
        inputMaskingTotal();
    });

    $(".neworderbody_all").on("click", ".delete_all", function() {
        $(this)
            .parent()
            .parent()
            .remove();
        totalGrandAll();
        var tr = $(this).closest("tr");
        totalPrice_per(tr);
    });

    $(".product_qty").on("keyup change", function() {
        totalGrandAll();
        $(".text_product_qty").html($(".product_qty").val() - 0);
    });

    $(".neworderbody_all").on(
        "keyup change",
        ".wip_req_qty_display_all, .wip_product_price_display_all",
        function() {
            var tr = $(this).closest("tr");
            totalPrice(tr);
            var input_qty = tr.find(".wip_req_qty_display_all").val() - 0;
            var product_qty = tr
                .find(".product_id_all")
                .find("option:selected")
                .attr("qty");
            if (input_qty > product_qty) {
                tr.find(".span_alert_qty_all").prop("hidden", false);
                tr.find(".force_submit_all").prop("disabled", false);
            } else {
                tr.find(".span_alert_qty_all").prop("hidden", true);
                tr.find(".force_submit_all").prop("disabled", true);
            }
        }
    );

    $(".neworderfoot_all").on(
        "keyup change",
        "#margin_all, .wip_margin_display_all",
        function() {
            var tr = $(this).closest("tr");
            var margin = tr
                .find("#margin_all")
                .find("option:selected")
                .val();
            var marginValue = tr.find(".wip_margin_display_all").val() - 0;
            if (margin == "rp") {
                inputMaskingMarginRp();
                var grandTotalBeforeMargin =
                    $(".wip_total_price_hidden_pure_all").val() - 0;
                var grandTotal = marginValue + grandTotalBeforeMargin;
                $(".wip_margin_hidden_per_all").val(marginValue);
                $(".wip_margin_hidden_total_all").val(marginValue);
                $(".wip_total_price_display_all").val(grandTotal);
            } else {
                inputMaskingMarginPer();
                var grandTotalBeforeMargin =
                    $(".wip_total_price_hidden_pure_all").val() - 0;
                var grandTotal =
                    (marginValue * grandTotalBeforeMargin) / 100 +
                    grandTotalBeforeMargin;
                var marginTotal = (marginValue * grandTotalBeforeMargin) / 100;
                $(".wip_margin_hidden_per_all").val(marginValue);
                $(".wip_margin_hidden_total_all").val(marginTotal);
                $(".wip_total_price_display_all").val(grandTotal);
            }
        }
    );

    $(".neworderbody_all").on(
        "keyup change select2-selecting",
        ".product_id_all",
        function() {
            var tr = $(this).closest("tr");
            var price = tr
                .find(".product_id_all")
                .find("option:selected")
                .attr("unitprice");
            var unit = tr
                .find(".product_id_all")
                .find("option:selected")
                .attr("unit");
            tr.find(".product_unit_all").val(unit);
            tr.find(".wip_product_price_display_all").val(price);
            tr.find(".wip_product_price_all").val(price);
            totalPrice(tr);
        }
    );
});

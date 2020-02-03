function inputMaskingTotal_per() {
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

    $(".wip_product_price_display_per").inputmask("IDR");
    $(".wip_product_total_price_display_per").inputmask("IDR");
    $(".wip_total_price_display_per").inputmask("IDR");
}

function inputMaskingTotal2_per() {
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

    $(".wip_total_price_hidden_pure_per").inputmask("numeric");
}

function inputMaskingMarginRp_per() {
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

    $(".wip_margin_display_per").inputmask("numeric");
}

function inputMaskingMarginPer_per() {
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

    $(".wip_margin_display_per").inputmask("numeric");
}

function totalPrice_per(tr) {
    var price_display = tr.find(".wip_product_price_display_per").val() - 0;
    var qty_display = tr.find(".wip_req_qty_display_per").val() - 0;
    //var qty = $(".product_qty").val() - 0;
    var subtotal = price_display * qty_display;
    tr.find(".wip_product_price_per").val(price_display);
    tr.find(".wip_product_total_price_display_per").val(subtotal);
    tr.find(".wip_product_total_price_per").val(subtotal);
    totalGrandAll_per();
}

function totalGrandAll_per(a) {
    var t = 0;
    $(".wip_product_total_price_display_per").each(function(i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });

    //var qty = $(".product_qty").val() - 0;
    var margin = $(".wip_margin_display_per").val() - 0;
    var total = t + margin;

    $(".wip_total_price_display_per").val(total);
    $(".wip_total_price_hidden_pure_per").val(total);
    $(".wip_total_price_hidden_pure_input_per").val(
        $(".wip_total_price_hidden_pure_per").val() - 0
    );
    $(".wip_total_price_hidden_grand_per").val(t);
}

function selectProduct_per() {
    $(".product_id_per").select2({
        placeholder: "Select Product",
        width: "100%",
        minimumInputLength: 1
    });
}

$(function() {
    totalGrandAll_per(0);
    inputMaskingMarginRp_per();
    inputMaskingTotal_per();
    inputMaskingTotal2_per();
    selectProduct_per();

    $(".add_per").click(function() {
        var product = $(".product_id_per").html();
        tr =
            "<tr>" +
            "<td>" +
            '<div class="form-group">' +
            '<select class="form-control selectproduct_normal product_id_per" name="wip_product_id_per[]">' +
            product +
            "</select>" +
            "</div>" +
            "</td>" +
            "<td>" +
            '<input onClick="this.select();" type="number" class="wip_req_qty_display_per form-control qty_per" name="wip_product_req_qty_per[]" value="0">' +
            '<span class="red span_alert_qty_per" hidden><strong>Stock is not enough!</strong></span>' +
            '<input class="force_submit_per" name="force_submit_item_per[]" type="text" value="1" disabled hidden>' +
            "</td>" +
            "<td>" +
            '<input class="product_unit_per form-control" type="text" readonly>' +
            "</td>" +
            "<td>" +
            '<input onClick="this.select();" type="text" class="wip_product_price_display_per form-control" value="0">' +
            '<input type="text" class="wip_product_price_per" name="wip_product_price_per[]" value="0" hidden>' +
            "</td>" +
            "<td>" +
            '<input onClick="this.select();" type="text" class="wip_product_total_price_display_per form-control" value="0" readonly>' +
            '<input type="text" class="wip_product_total_price_per" name="wip_product_total_price_per[]" value="0" hidden>' +
            "</td>" +
            "<td>" +
            '<input type="button" class="btn btn-danger delete_per" value="x">' +
            "</td>" +
            "</tr>";

        $(".neworderbody_per").append(tr);

        selectProduct_per();
        inputMaskingMarginRp_per();
        inputMaskingTotal_per();
    });

    //$(".product_qty").on("keyup change", function() {
    //    totalGrandAll();
    //});

    $(".neworderbody_per").on("click", ".delete_per", function() {
        $(this)
            .parent()
            .parent()
            .remove();
        totalGrandAll();
        var tr = $(this).closest("tr");
        totalPrice_per(tr);
    });

    $(".neworderbody_per").on(
        "keyup change",
        ".wip_req_qty_display_per, .wip_product_price_display_per",
        function() {
            var tr = $(this).closest("tr");
            totalPrice_per(tr);
            var input_qty = tr.find(".wip_req_qty_display_per").val() - 0;
            var result_qty = $(".product_qty").val() - 0;
            var product_qty = tr
                .find(".product_id_per")
                .find("option:selected")
                .attr("qty");
            var hasil_qty = input_qty * result_qty;
            if (hasil_qty > product_qty) {
                tr.find(".span_alert_qty_per").prop("hidden", false);
                tr.find(".force_submit_per").prop("disabled", false);
            } else {
                tr.find(".span_alert_qty_per").prop("hidden", true);
                tr.find(".force_submit_per").prop("disabled", true);
            }
        }
    );

    $(".neworderfoot_per").on(
        "keyup change",
        "#margin_per, .wip_margin_display_per",
        function() {
            var tr = $(this).closest("tr");
            var margin = tr
                .find("#margin_per")
                .find("option:selected")
                .val();
            var marginValue = tr.find(".wip_margin_display_per").val() - 0;
            if (margin == "rp") {
                inputMaskingMarginRp_per();
                var grandTotalBeforeMargin =
                    $(".wip_total_price_hidden_pure_per").val() - 0;
                var grandTotal = marginValue + grandTotalBeforeMargin;
                $(".wip_margin_hidden_per_per").val(marginValue);
                $(".wip_margin_hidden_total_per").val(marginValue);
                $(".wip_total_price_display_per").val(grandTotal);
            } else {
                inputMaskingMarginPer_per();
                var grandTotalBeforeMargin =
                    $(".wip_total_price_hidden_pure_per").val() - 0;
                var grandTotal =
                    (marginValue * grandTotalBeforeMargin) / 100 +
                    grandTotalBeforeMargin;
                var marginTotal = (marginValue * grandTotalBeforeMargin) / 100;
                $(".wip_margin_hidden_per_per").val(marginValue);
                $(".wip_margin_hidden_total_per").val(marginTotal);
                $(".wip_total_price_display_per").val(grandTotal);
            }
        }
    );

    $(".neworderbody_per").on(
        "keyup change select2-selecting",
        ".product_id_per",
        function() {
            var tr = $(this).closest("tr");
            var price = tr
                .find(".product_id_per")
                .find("option:selected")
                .attr("unitprice");
            var unit = tr
                .find(".product_id_per")
                .find("option:selected")
                .attr("unit");
            tr.find(".product_unit_per").val(unit);
            tr.find(".wip_product_price_display_per").val(price);
            tr.find(".wip_product_price_per").val(price);
            totalPrice_per(tr);
        }
    );
});

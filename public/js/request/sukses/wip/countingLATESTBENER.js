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
    var qty = $(".product_qty").val() - 0;
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

    var qty = $(".product_qty").val() - 0;
    var margin = $(".wip_margin_display").val() - 0;
    var total = t / qty + margin;

    $(".wip_total_price_display").val(total);
    $(".wip_total_price_hidden_pure").val(total);
    $(".wip_total_price_hidden_pure_input").val($(".wip_total_price_hidden_pure").val() - 0);
    $(".wip_total_price_hidden_grand").val(t);
}

function selectProduct() {
    $(".select_product").select2({
        placeholder: "Select Product",
        width: "100%",
        //minimumInputLength: 1,
        delay: 250,
        allowClear: true,
        ajax: {
            url: "/wip/select_product",
            dataType: "json",
            data: function(params) {
                return {
                    term: params.term || "",
                    page: params.page || 1
                };
            },
            processResults: function(data, params) {
                params.page = params.page || 1;

                return {
                    results: data.results,
                    pagination: {
                        more: params.page * 10 < data.total_count
                    }
                };
            },
            cache: true
        },
        templateResult: formatResult,
        templateSelection: formatRepoSelection
    });

    function formatRepoSelection(repo) {
        $(".selected_product_id").val(repo.id);
        $(".selected_product_price").val(repo.avg_price);
        if (repo.code) {
            return (
                repo.code + " - " + repo.text || repo.code + " - " + repo.text
            );
        } else {
            return (
                repo.text || repo.text
            );
        }
    }

    function formatResult(result) {
        //console.log('%o', result);
        if (result.loading) return result.text;
        if(result.code){
            var html = "<a>" + result.code + " - " + result.text + "</a>";

        }else{
            var html = "<a>" + result.text + "</a>";

        }
        //return html;
        return $(html);
    }
}

$(function() {
    totalGrandAll(0);
    inputMaskingMarginRp();
    inputMaskingTotal();
    inputMaskingTotal2();
    selectProduct();

    $(".add").click(function() {
        tr =
            "<tr>" +
            "<td>" +
            '<div class="form-group">' +
            '<select class="form-control select_product product_id" name="wip_product_id[]">' +
            "</select>" +
            '<input class="selected_product_id" hidden>' +
            '<input class="selected_product_price" hidden>' +
            '<input class="tampungan_product_id" name="wip_product_id2[]" hidden>' +
            '<input class="tampungan_product_price" hidden>' +
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

    $(".product_qty").on("keyup change", function() {
        totalGrandAll();
    });

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
            var id = $(".selected_product_id").val();
            var price = $(".selected_product_price").val();
            tr.find(".tampungan_product_id").val(id);
            tr.find(".tampungan_product_price").val(price);
            var tampungan_price = tr.find(".tampungan_product_price").val();
            tr.find(".wip_product_price_display").val(tampungan_price);
            tr.find(".wip_product_price").val(tampungan_price);
            totalPrice(tr);
        }
    );
});

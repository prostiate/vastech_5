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

    $(".wip_total_price_display").inputmask("IDR");
}

function inputMaskingMarginRp() {
    Inputmask.extendAliases({
        numeric: {
            prefix: "Rp",
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
            clearMaskOnLostFocus:true,
        }
    });

    Inputmask.extendAliases({
        IDR: {
            alias: "numeric",
            prefix: "Rp "
        }
    });

    $(".wip_margin_display").inputmask("IDR");
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
            clearMaskOnLostFocus:true,
        }
    });

    $(".wip_margin_display").inputmask("numeric");
}

function totalGrand(a) {
    var t = 0;
    $(".wip_product_total_price").each(function(i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });
    $(".wip_total_price_display").val(t + a);
    $(".wip_total_price_hidden").val(t + a);
    $(".wip_total_price_hidden_2").val(t + a);
    $(".wip_total_price_hidden_3").val(t + a);
}

function totalGrand2(a) {
    var t = 0;
    $(".wip_product_total_price").each(function(i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });
    $(".wip_total_price_display").val(t + a);
    $(".wip_total_price_hidden").val(t + a);
}

function select() {
    $select = $("#margin").on("change");
    $select.on("change", function(e) {
        //alert("you selected :" + $(this).val());
        if ($(this).val() == "rp") {
            $(".wip_margin_display").val(0);
            $(".wip_margin_hidden_per").val(0);
            $(".wip_margin_hidden_total").val(0);
            inputMaskingMarginRp();
            $(".neworderfoot").on(
                "keyup keydown change",
                ".wip_margin_display",
                function() {
                    var tr = $(this)
                        .parent()
                        .parent();
                    var wip_margin_hidden = tr.find(".wip_margin_display").val() - 0;
                    tr.find(".wip_margin_hidden_total").val(wip_margin_hidden);
                    totalGrand2(wip_margin_hidden);
                }
            );
        } else {
            $(".wip_margin_display").val(0);
            $(".wip_margin_hidden_per").val(0);
            $(".wip_margin_hidden_total").val(0);
            inputMaskingMarginPer();
            $(".neworderfoot").on(
                "keyup keydown change",
                ".wip_margin_display",
                function() {
                    var tr = $(this)
                        .parent()
                        .parent();
                    var wip_margin_hidden = tr.find(".wip_margin_display").val() - 0;
                    tr.find(".wip_margin_hidden_per").val(wip_margin_hidden);
                    //totalGrand2(wip_margin_hidden);
                    var grand_total = $(".wip_total_price_hidden_2").val();
                    var total_margin = (grand_total * wip_margin_hidden) / 100;
                    tr.find(".wip_margin_hidden_total").val(total_margin);
                    totalGrand2(total_margin);

                }
            );
        }
    });
}

$(document).ready(function() {
    inputMaskingMarginRp();
    inputMaskingTotal();
    
    var initial = 0;
    totalGrand(initial);

    var product_qty = $('.product_qty').val();
    var total_price_hidden_2 = $('.wip_total_price_hidden_2').val();
    var grandtotal = total_price_hidden_2 / product_qty;
    $('.wip_total_price_display').val(grandtotal);
    $('.wip_total_price_hidden_3').val(grandtotal);

    $(".neworderfoot").on(
        "keyup keydown change",
        ".wip_margin_display",
        function() {
            var tr = $(this)
                .parent()
                .parent();
            var wip_margin_hidden = tr.find(".wip_margin_display").val() - 0;
            tr.find(".wip_margin_hidden_total").val(wip_margin_hidden);
            var product_qty = $(".product_qty").val();
            var total = wip_margin_hidden * product_qty;
            totalGrand2(wip_margin_hidden);
        }
    );

    select();
});

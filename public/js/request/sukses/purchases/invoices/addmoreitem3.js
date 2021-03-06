function totalAmount() {
    var t = 0;
    $(".order_amount_display").each(function(i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });

    $(".balance").val(t);
    $(".balance_input").val(t);
}

function totalAmountOrder() {
    var t = 0;
    $(".amount_display").each(function(i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });

    $(".balance2").val(t);
    $(".balance_input2").val(t);
}

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

    $(".amount_display").inputmask("IDR");
    $(".total_cost_display").inputmask("IDR");
    $(".unit_price_display").inputmask("IDR");
    $(".cost_amount_display").inputmask("IDR");
    $(".balance").inputmask("IDR");
    $(".order_amount_display").inputmask("IDR");
    $(".balance2").inputmask("IDR");
}

$(document).ready(function() {
    inputMasking();
    totalAmount();
    totalAmountOrder();

    $(".neworderbody").on(
        "keyup change",
        ".qtydateng_display, .unit_price, .amount_display",
        function() {
            var tr = $(this).closest("tr");
            var amount_order = tr.find(".amount_display").val() - 0;
            var amount = tr.find(".qtydateng_display").val() - 0;
            var unit_price = tr.find(".unit_price").val() - 0;
            var total = amount * unit_price;
            tr.find(".order_amount_display").val(total);
            tr.find(".order_amount").val(total);
            tr.find(".amount").val(amount_order);
            totalAmount();
            totalAmountOrder();
        }
    );


});

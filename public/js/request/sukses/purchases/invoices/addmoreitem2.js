function totalAmount() {
    var t = 0;
    $(".amount").each(function(i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });

    $(".balance").val(t);
    $(".balance_input").val(t);
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
}

$(document).ready(function() {
    inputMasking();
    totalAmount();

    $(".neworderbody").on(
        "keyup change",
        ".amount_display",
        function() {
            var tr = $(this).closest("tr");
            var amount = tr.find(".amount_display").val() - 0;
            tr.find(".amount").val(amount);
            totalAmount();
        }
    );
});

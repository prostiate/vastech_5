function totalAmount() {
    var t = 0;
    $(".amount").each(function(i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });
    $(".subtotal_input").val(t);
}

function totalTax() {
    var t = 0;
    $(".amounttax").each(function(i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });
    $(".total").val(t);
    $(".total_input").val(t);
}

function totalSub() {
    var t = 0;
    $(".amountsub").each(function(i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });
    $(".subtotal").val(t);
    //$(".subtotal_display").html($(".subtotal").val());
}

function totalGrand() {
    var t = 0;
    $(".amountgrand").each(function(i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });
    $(".balance").val(t);
    $(".balance_input").val(t);

    var balancedue = $(".balancedue_input_get").val();
    var total = balancedue - t
    $(".balancedue").val(total);
    $(".balancedue_input_post").val(total);
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

    $(".unit_price_display").inputmask("IDR");
    $(".amount_display").inputmask("IDR");
    $(".subtotal").inputmask("IDR");
    $(".total").inputmask("IDR");
    $(".balance").inputmask("IDR");
    $(".invoice_amount").inputmask("IDR");
    $(".balancedue").inputmask("IDR");
}

$(document).ready(function() {
    inputMasking();
    totalAmount();
    totalTax();
    totalSub();
    totalGrand();

    $(".neworderbody").on("keyup change", ".qty", function() {
        var tr = $(this).closest("tr");
        var tax = tr.find(".taxes").attr("rate");
        var price = tr.find(".unit_price").val() - 0;
        var qty = tr.find(".qty").val();
        var subtotal = qty * price; //(qty * price) - ((qty * price * tax) / 100);
        var taxtotal = (qty * price * tax) / 100;
        var total = subtotal + taxtotal; //(qty * price);
        tr.find(".amount_display").val(subtotal);
        tr.find(".unit_price").val(price);
        tr.find(".amount").val(subtotal);
        tr.find(".amountsub").val(subtotal);
        tr.find(".amounttax").val(taxtotal);
        tr.find(".amountgrand").val(total);
        totalAmount();
        totalTax();
        totalSub();
        totalGrand();
    });
});

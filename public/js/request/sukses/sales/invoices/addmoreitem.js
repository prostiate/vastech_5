function totalAmount() {
    var t = 0;
    $(".amount").each(function(i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });
    var cost = $(".costtotal_input").val() - 0;
    var total = t + cost;

    $(".balance").val(total);
    $(".balance_input").val(total);
}

function totalAmountCost() {
    var t = 0;
    $(".cost_amount").each(function(i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });
    var cost = $(".total_cost_hidden").val() - 0;
    var total = t + cost;

    $(".costtotal").val(t);
    $(".costtotal_input").val(t);
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
    //$(".harga_beda").inputmask("IDR");
    // INI PUNYA COST
    $(".cost_unit_price_display").inputmask("IDR");
    $(".costtotal").inputmask("IDR");
    $(".cost_total_price_display").inputmask("IDR");
}

$(document).ready(function() {
    inputMasking();
    totalAmount();

    /*$(".add-cost").click(function() {
        var cost = $(".cost_id").html();
        tr =
            "<tr>" +
            '<td colspan="2">' +
            '<div class="form-group">' +
            '<select class="form-control selectaccount cost_id" name="cost_acc[]">' +
            cost +
            "</select>" +
            "</div>" +
            "</td>" +
            "<td>" +
            '<input onClick="this.select();" type="text" class="form-control cost_amount_display" value="0">' +
            '<input type="text" class="hidden_cost_amount" name="cost_amount[]" value="0" hidden>' +
            "</td>" +
            "<td>" +
            '<input type="button" class="btn btn-danger delete3" value="x">' +
            "</td>" +
            "</tr>";
        $(".neworderbody2").append(tr);
        $(".cost_id").select2({
            width: "100%",
            placeholder: "Select Account"
        });
        inputMasking();
    });*/

    $(".neworderbody").on(
        "keyup change",
        ".qty, .cost_unit_price_display",
        function() {
            var tr = $(this).closest("tr");
            var price_display = tr.find(".unit_price_display").val() - 0;
            tr.find(".unit_price").val(price_display);
            var price = tr.find(".unit_price").val() - 0;
            var qty_display = tr.find(".qty").val() - 0;
            var subtotal = price * qty_display;
            tr.find(".amount_display").val(subtotal);
            tr.find(".amount").val(subtotal);
            totalAmount();
            // PUNYANYA SI COST
            var price_display = tr.find(".cost_unit_price_display").val() - 0;
            tr.find(".cost_unit_price").val(price_display);
            var price = tr.find(".cost_unit_price").val() - 0;
            var qty_display = tr.find(".qty").val() - 0;
            var subtotal = price * qty_display;
            tr.find(".cost_amount_display").val(subtotal);
            tr.find(".cost_amount").val(subtotal);
            totalAmountCost();
        }
    );

    /*$(".neworderbody2").on("keyup change", ".cost_amount_display", function() {
        var t = 0;
        $(".cost_amount_display").each(function(i, e) {
            var amt = $(this).val() - 0;
            t += amt;
        });
        $(".total_cost_display").val(t);
        $(".total_cost_hidden").val(t);
        totalAmount();
    });

    $(".neworderbody2").on("click", ".delete1", function() {
        $(this)
            .parent()
            .parent()
            .remove();
        totalAmount();
    });

    $(".neworderbody2").on("click", ".delete2", function() {
        $(this)
            .parent()
            .parent()
            .remove();
        totalAmount();
    });

    $(".neworderbody2").on("click", ".delete3", function() {
        $(this)
            .parent()
            .parent()
            .remove();
        totalAmount();
    });

    $(".neworderbody2").on("keyup change", ".cost_amount_display", function() {
        var tr = $(this)
            .parent()
            .parent();
        var hidden_cost_amount = tr.find(".cost_amount_display").val() - 0;
        tr.find(".hidden_cost_amount").val(hidden_cost_amount);
        //totalCost();
        //totalGrand();
    });*/
});

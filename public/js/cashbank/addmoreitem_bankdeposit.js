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
}

function totalGrand() {
    var t = 0;
    $(".amountgrand").each(function(i, e) {
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

    $(".examount").inputmask("IDR");
    $(".subtotal").inputmask("IDR");
    $(".total").inputmask("IDR");
    $(".balance").inputmask("IDR");
}

$(document).ready(function() {
    inputMasking();
    totalAmount();
    totalTax();
    totalSub();
    totalGrand();
});

$(function() {
    $(".getmoney").change(function() {
        var total = $(".total").html();
        var getmoney = $(this).val();
        var t = getmoney - total;
        $(".backmoney")
            .val(t)
            .toFixed(2);
    });

    $(".add").click(function() {
        var expense = $(".expense_id").html();
        var tax = $(".taxes").html();
        var n = $(".neworderbody tr").length - 0 + 1;
        tr =
            "<tr><td>" +
            '<div class="form-group">' +
            '<select class="select2 form-control form-control-sm product_id" id="productTable"' +
            'aria-placeholder="Select Product" name="expense_acc[]" required>' +
            expense +
            "</select>" +
            "</div>" +
            "</td>" +
            "<td>" +
            '<textarea class="form-control" id="descTable" rows="1" name="desc_acc[]"></textarea>' +
            "</td>" +
            "<td>" +
            '<div class="form-group">' +
            '<select class="select2 form-control form-control-sm taxes" id="productTable"' +
            'aria-placeholder="Select Product" name="tax_acc[]">' +
            tax +
            "</select>" +
            "</div>" +
            "</td>" +
            "<td>" +
            '<input onClick="this.select();" type="text" class="examount form-control form-control-sm" id="numberForm">' +
            '<input type="text" class="amount" name="amount_acc[]" hidden>' +
            '<input type="text" class="amounttax" name="total_amount_tax[]" hidden>' +
            '<input type="text" class="amountsub" name="total_amount_sub[]" hidden>' +
            '<input type="text" class="amountgrand" name="total_amount_grand[]" hidden>' +
            "<td>" +
            '<input type="button" class="btn btn-danger delete" value="x">' +
            "</td>" +
            "</tr>";

        $(".neworderbody").append(tr);

        $(".product_id").select2({
            width: "100%",
            placeholder: "Select Account"
        });

        $(".taxes").select2({
            width: "100%",
            placeholder: "Select Tax"
        });
        inputMasking();
    });

    $(".neworderbody").on("click", ".delete", function() {
        $(this)
            .parent()
            .parent()
            .remove();
        totalAmount();
        totalTax();
        totalSub();
        totalGrand();
    });

    /*$('.neworderbody').on('keyup', '.amount', function () {
        totalAmount();
    });*/

    $(".neworderbody").on(
        "keyup keydown change",
        ".taxes, .examount",
        function() {
            var tr = $(this).closest("tr");
            var tax = tr.find(".taxes option:selected").attr("rate");
            var price = tr.find(".unit_price").val() - 0;
            var qty = tr.find(".examount").val() - 0;
            //var total = (qty /* price*/) - ((qty /* price */ * tax) / 100);
            //var subtotal = (qty /* price*/);
            //var taxtotal = ((qty /* price*/ * tax) / 100);
            var subtotal = qty; //(qty * price) - ((qty * price * tax) / 100);
            var taxtotal = (qty * tax) / 100;
            var total = subtotal + taxtotal;
            tr.find(".amount").val(subtotal);
            tr.find(".amountsub").val(subtotal);
            tr.find(".amounttax").val(taxtotal);
            tr.find(".amountgrand").val(total);
            totalAmount();
            totalTax();
            totalSub();
            totalGrand();
        }
    );

    $("#hideshow").on("click", function(event) {
        $("#content").removeClass("hidden");
        $("#content").addClass("show");
        $("#content").toggle("show");
    });
});

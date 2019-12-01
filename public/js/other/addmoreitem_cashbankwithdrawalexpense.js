function totalAmount() {
    var t = 0;
    $(".amount").each(function(i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });
    //$('.subtotal').html(t);
    $(".subtotal_input").val(t);
    //$('.total').html(t);
    //$('.ppn_input').html(t);
    $(".total_input").val(t);
    $(".balance").html("Rp " + t);
    $(".balance_input").val(t);
}

function totalTax() {
    var t = 0;
    $(".amounttax").each(function(i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });
    $(".total").html(t);
}

function totalSub() {
    var t = 0;
    $(".amountsub").each(function(i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });
    $(".subtotal").html("Rp " + t);
}

$(function() {
    var x = 1;
    $(".add").click(function() {
        var expense = $(".expense_id").html();
        tr =
            "<tr><td>" +
            '<div class="form-group">' +
            '<select class="select2 form-control form-control-sm expense_id selectexpense selected_expense_add" name="expense_acc[]" required>' +
            expense +
            "</select>" +
            "</div>" +
            "</td>" +
            "<td>" +
            '<textarea class="dec form-control" id="descTable" rows="1" name="desc_acc[]"></textarea>' +
            "</td>" +
            "<td>" +
            '<h5 class="view_selected_expense_grandtotal_add">Rp 0,00</h5>' +
            '<input hidden class="input_selected_expense_grandtotal_add form-control" type="text" name="grandtotal[]">' +
            "</td>" +
            "<td>" +
            '<h5 class="view_selected_expense_balancedue_add">Rp 0,00</h5>' +
            '<input hidden class="input_selected_expense_balancedue_add form-control" type="text" name="balance_due[]">' +
            "</td>" +
            "<td>" +
            '<input hidden type="text" class="form-control text12" id="warnOnDecimalsEntered22">' +
            '<input type="text" class="examount form-control text22" name="amount_acc[]">' +
            '<input type="hidden" class="amount">' +
            '<input type="hidden" class="amountsub">' +
            "<td>" +
            '<input type="button" class="btn btn-danger delete" value="x">' +
            "</td>" +
            "</tr>";

        $(".neworderbody").append(tr);

        $(".expense_id").select2({
            width: "100%",
            placeholder: "Select Expense"
        });

        /*$(function() {
            $("#warnOnDecimalsEntered22")
                .blur(function() {
                    $("#warnOnDecimalsEnteredNotification22").html(null);
                    $(this).formatCurrency({
                        roundToDecimalPlace: 2,
                        eventOnDecimalsEntered: true
                    });
                })
                .bind("decimalsEntered", function(e, cents) {
                    var errorMsg =
                        "Please do not enter any cents (0." + cents + ")";
                    $("#warnOnDecimalsEnteredNotification22").html(errorMsg);
                    log("Event on decimals entered: " + errorMsg);
                });
        });*/
    });

    $(".neworderbody").on("change", ".selected_expense_add", function() {
        var tr = $(this)
            .parent()
            .parent();
        var grtot = tr.find("option:selected").attr("grandtotal");
        $(".view_selected_expense_grandtotal_add").html("Rp " + grtot + ",00");
        $(".input_selected_expense_grandtotal_add").val(grtot);
        var bld = $("option:selected", this).attr("balance_due");
        $(".view_selected_expense_balancedue_add").html("Rp " + bld + ",00");
        $(".input_selected_expense_balancedue_add").val(bld);
    });

    $(".neworderbody").on("click", ".delete", function() {
        $(this)
            .parent()
            .parent()
            .remove();
        totalAmount();
    });

    /*$(".neworderbody").on(
        "keyup keydown change",
        ".text12, .text22",
        function() {
            $(".text12, .text22")
                .not(this)
                .val(this.value);
        }
    );*/

    $(".neworderbody").on(
        "keyup keydown change",
        ".examount, .text12, .text22, .text1, .text2",
        function() {
            var tr = $(this)
                .parent()
                .parent();
            //var tax = tr.find('.taxes option:selected').attr('rate');
            //var price = tr.find('.unit_price').val() - 0;
            //var qty = tr.find('.qty').val() - 0;
            //var total = (qty * price) - ((qty * price * tax) / 100);
            var payment_amount = tr.find(".examount").val() - 0;
            var total = payment_amount;
            //var subtotal = (qty * price);
            //var taxtotal = ((qty * price * tax) / 100);
            tr.find(".amount").val(total);
            tr.find(".amountsub").val(total);
            //tr.find('.amounttax').val(taxtotal);
            totalAmount();
            //totalTax();
            totalSub();
        }
    );
});

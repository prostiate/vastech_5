function checkNetProfit() {
    console.log("checknetprofit==================================");
    var income_debit = $(".in_debit_total").val() - 0;
    var income_credit = $(".in_credit_total").val() - 0;
    var total = Math.abs((income_debit - income_credit).toFixed(2));
    var retained_id = $('#retained_earning_acc').val();
    var retained_data = $('#retained_earning_acc').data('last');

    if (income_debit >= income_credit) {
        $(".net_credit").val(total)
        $(".sub_net_credit").val(total)
        $("#net_credit").html(total)
    } else { 
        $(".net_debit").val(total)        
        $(".sub_net_debit").val(total)        
        $("#net_debit").html(total)
    }

    if (retained_data != 0) {
        if (income_debit <= income_credit) {
            var curr_credit = $(".bs_credit").eq(retained_id).val() - 0;
            var credit = curr_credit + total;
            $(".bs_credit_display").eq(retained_id).html(credit);
            $(".bs_credit").eq(retained_id).val(credit);
        } else {       
            var curr_debit = $(".bs_debit").eq(retained_id).val() - 0;
            var debit = curr_debit + total;
            $(".bs_debit_display").eq(retained_id).html(debit);
            $(".bs_debit").eq(retained_id).val(debit);
        }
    }

}

function removeNetProfit(id, old_id) {
    console.log("removenetprofit==================================");
    if (old_id != 0) {
        var income_debit = $(".in_debit_total").val() - 0;
        var income_credit = $(".in_credit_total").val() - 0;
        var total = Math.abs((income_debit - income_credit).toFixed(2))
        if (income_debit <= income_credit) {
            var curr_credit = $(".bs_credit").eq(old_id).val();
            var credit = curr_credit - total;
            $(".bs_credit_display").eq(old_id).html(credit);
            $(".bs_credit").eq(old_id).val(credit);
        } else {
            var curr_debit = $(".bs_debit").eq(old_id).val();
            var debit = curr_debit - total;
            $(".bs_debit_display").eq(old_id).html(debit)
            $(".bs_debit").eq(old_id).val(debit)
        }
        $('#retained_earning_acc').data("last", id);
        console.log('id id rm_netprofit ' + old_id);
    }

    moveNetProfit(id);
}

function moveNetProfit(id) {
    console.log("movenetprofit==================================");
    var income_debit = $(".in_debit_total").val() - 0;
    var income_credit = $(".in_credit_total").val() - 0;
    var total = Math.abs((income_debit - income_credit).toFixed(2))
    if (income_debit <= income_credit) {
        
        var curr_credit = $(".bs_credit").eq(id).val() - 0;
        var credit = curr_credit + total;
        $(".bs_credit_display").eq(id).html(credit);
        $(".bs_credit").eq(id).val(credit);
    } else {
       
        var curr_debit = $(".bs_debit").eq(id).val() - 0;
        var debit = curr_debit + total;
        $(".bs_debit_display").eq(id).html(debit);
        $(".bs_debit").eq(id).val(debit);
    }
    $('#retained_earning_acc').data("last", id);
    totalBalanceSheet();
}

function totalBalanceSheet() {
    console.log("tota1==================================");
    var d = 0;
    var c = 0;
    $('.bs_debit').each(function (i, e) {
        var amt = $(this).val() - 0;
        d += amt;
        console.log("bs_debit setelah total balance sheet "+amt);
    });
    $('.bs_credit').each(function (i, e) {
        var amt = $(this).val() - 0;
        c += amt;
    });
    //$('.subtotal').html(t);
    $('#balance_debit').html(d);
    $('#balance_credit').html(c);
    $('.net_debit').val(d);
    $('.net_credit').val(c);
    //$('.total').html(t);
    //$('.ppn_input').html(t);
    console.log("net_Debit setelah balancaesheet "+d);
}

$(document).ready(function () {
    checkNetProfit();
    totalBalanceSheet();

    $('#retained_earning_acc').on('change select2-selecting', function () {
        var id = $(this).val();
        var old_id = $(this).data("last");

        removeNetProfit(id, old_id);
        //moveNetProfit(id);
        //$(this).totalBalanceSheet();
    });    


});

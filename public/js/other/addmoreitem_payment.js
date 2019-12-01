function totalAmount() {
    var t = 0;
    $('.amount').each(function (i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });
    //$('.subtotal').html(t);
    $('.subtotal_input').val(t);
    //$('.total').html(t);
    //$('.ppn_input').html(t);
    $('.total_input').val(t);
    $('.balance').val(t);
    $('.balance_input').val(t);
}

function totalTax() {
    var t = 0;
    $('.amounttax').each(function (i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });
    $('.total').html(t);
}

function totalSub() {
    var t = 0;
    $('.amountsub').each(function (i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });
    $('.subtotal').html(t);
}

function inputMasking() {
    Inputmask.extendAliases({
        "numeric":
        {
            "prefix": "Rp",
            "digits": 2,
            "digitsOptional": false,
            "decimalProtect": true,
            "groupSeparator": ",",
            "radixPoint": ".",
            "radixFocus": true,
            "autoGroup": true,
            "autoUnmask": true,
            "removeMaskOnSubmit": true
        }
    });

    Inputmask.extendAliases({
        "IDR":
        {
            "alias": "numeric",
            "prefix": "Rp "
        }
    }); 

    $(".payment_amount_display").inputmask("IDR");
    $(".balance").inputmask("IDR");
}

$(document).ready(function () {    
    inputMasking();
    totalAmount();
});

$(function () { 
    $('.neworderbody').on('keyup keydown change', '.payment_amount_display', function () {
        var tr = $(this).parent().parent();
        //var tax = tr.find('.taxes option:selected').attr('rate');     
        //var price = tr.find('.unit_price').val() - 0;
        //var qty = tr.find('.qty').val() - 0;
        //var total = (qty * price) - ((qty * price * tax) / 100);
        var payment_amount = tr.find('.payment_amount_display').val() - 0;
        var total = payment_amount;
        //var subtotal = (qty * price);
        //var taxtotal = ((qty * price * tax) / 100);
        tr.find('.payment_amount').val(total);
        tr.find('.amount').val(total);
        //tr.find('.amountsub').val(subtotal);
        //tr.find('.amounttax').val(taxtotal);
        totalAmount();
        //totalTax();
        //totalSub();
    });    

    $('#hideshow').on('click', function (event) {
        $('#content').removeClass('hidden');
        $('#content').addClass('show');
        $('#content').toggle('show');
    });
});

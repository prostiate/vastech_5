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
    //$('.balance').html(t);
    $('.balance_input').val(t);
}

$(function () {
    $('.getmoney').change(function () {
        var total = $('.total').html();
        var getmoney = $(this).val();
        var t = getmoney - total;
        $('.backmoney').val(t).toFixed(2);
    });
    
    $('.neworderbody').on('keyup change', '.taxes, .qty, .unit_price', function () {
        var tr = $(this).parent().parent();
        var tax = tr.find('.taxes').attr('rate');     
        var price = tr.find('.unit_price').val() - 0;
        var qty = tr.find('.qty').val() - 0;
        var total = (qty * price) - ((qty * price * tax) / 100);
        var subtotal = (qty * price);
        var taxtotal = ((qty * price * tax) / 100);
        tr.find('.amount').val(total);
        totalAmount();
    });    

    $('#hideshow').on('click', function (event) {
        $('#content').removeClass('hidden');
        $('#content').addClass('show');
        $('#content').toggle('show');
    });
});

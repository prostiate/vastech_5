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
    $('.balance').html('Rp ' + t);
    $('.balance_input').val(t);
}

function totalTax() {
    var t = 0;
    $('.amounttax').each(function (i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });
    $('.total').html('Rp ' + t);
}

function totalSub() {
    var t = 0;
    $('.amountsub').each(function (i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });
    $('.subtotal').html('Rp ' + t);
}

$(function () {
    $('.getmoney').change(function () {
        var total = $('.total').html();
        var getmoney = $(this).val();
        var t = getmoney - total;
        $('.backmoney').val(t).toFixed(2);
    });     
    $('.add').click(function () {
        var product = $('.product_id').html();
        var units = $('.units').html();
        var taxes = $('.taxes').html();
        var n = ($('.neworderbody tr').length - 0) + 1;
        tr = '<tr><td>' +
            '<div class="form-group" >' +
            '<select class="select2 form-control form-control-sm product_id" name="products[]" aria-placeholder="Select Product" required>' +
            product +
            '</select>' +
            '</div>' +
            '</td>' +
            '<td>' +
            '<textarea class="form-control desc" name="desc[]" rows="1"></textarea>' +
            '</td>' +
            '<td>' +
            '<input type="number" class="qty form-control form-control-sm" value="1" name="qty[]">' +
            '</td>' +
            '<td>' +
            '<div class="form-group">' +
            '<select class="select2 form-control form-control-sm units" name="units[]" aria-placeholder="Select Product" required>' +
            units +
            '</select>' +
            '</div>' +
            '</td>' +
            '<td>' +
            '<input type="number" class="unit_price form-control form-control-sm" name="unit_price[]" required>' +
            '<input type="hidden" class="amounttax">' +
            '<input type="hidden" class="amountsub">' +
            '</td>' +
            '<td>' +
            '<div class="form-group">' +
            '<select class="taxes select2 form-control form-control-sm" name="tax[]" aria-placeholder="Select Product">' +
            taxes +
            '</select>' +
            '</div>' +
            '</td>' +
            '<td>' +
            '<input type="text" class="amount form-control form-control-sm " name="total_price[]" readonly> ' +
            '</td>' +
            '<td>' +
            '<input type="button" class="btn btn-danger delete" value="x">' +
            '</td>' +
            '</tr>';

        $('.neworderbody').append(tr);
        
        $(".product_id").select2({
            width: "100%",
            placeholder: "Select Product"
        });
    
        $(".units").select2({
            width: "100%",
            placeholder: "Select Unit"
        });
    
        $(".taxes").select2({
            width: "100%",
            placeholder: "Select Tax"
        });

        $(".currency").blur(function() {
            $(".currency").formatCurrency({
                symbol: "Rp",
                positiveFormat: "%s%n",
                negativeFormat: "(%s%n)",
                decimalSymbol: ",",
                digitGroupSymbol: ".",
                groupDigits: true
            });
        });
    });

    $('.neworderbody').on('click', '.delete', function () {
        $(this).parent().parent().remove();
        totalAmount();
    });
    /*
    $('.neworderbody').on('change', '.product_id', function () {
        var tr = $(this).parent().parent();
        var price = tr.find('.product_id option:selected').attr('value');
        
        tr.find('.desc').val(price);
        totalAmount();
    });*/
    
    $('.neworderbody').on('keyup change', '.taxes, .qty, .unit_price', function () {
        var tr = $(this).parent().parent();
        var tax = tr.find('.taxes option:selected').attr('rate');     
        var price = tr.find('.unit_price').val() - 0;
        var qty = tr.find('.qty').val() - 0;
        var subtotal = (qty * price);//(qty * price) - ((qty * price * tax) / 100);
        var taxtotal = ((qty * price * tax) / 100);
        var total = subtotal + taxtotal;//(qty * price);
        tr.find('.amount').val(total);
        tr.find('.amountsub').val(subtotal);
        tr.find('.amounttax').val(taxtotal);
        totalAmount();
        totalTax();
        totalSub();
    });    

    $('#hideshow').on('click', function (event) {
        $('#content').removeClass('hidden');
        $('#content').addClass('show');
        $('#content').toggle('show');
    });
});

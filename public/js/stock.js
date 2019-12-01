function totalAmount() {
    var t = 0;
    $('.amount').each(function (i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });
    $('.subtotal').html(t);
    $('.subtotal_input').val(t);
    $('.total').html(t);
    $('.total_input').val(t);
    $('.balance').html(t);
    $('.balance_input').val(t);
}

$(function () {    
    $( document ).ready(function() {
        var cat = $(this).val();

        if (cat == 1) {
            var tr = $('.account').val(140);
        }else {
            var tr = $('.account').val(140);
        };
    });
    $('.getmoney').change(function () {
        var total = $('.total').html();
        var getmoney = $(this).val();
        var t = getmoney - total;
        $('.backmoney').val(t).toFixed(2);
    });
    $('.add').click(function () {
        var product = $('.product').html();
        var n = ($('.neworderbody tr').length - 0) + 1;
        tr = '<tr> ' +
            '<td> ' +
            '<select class="select2 form-control form-control-sm product" ' +
            'aria-placeholder="Select Product" name="product[]" required> ' +
            product +
            '</select> ' +
            '</td> ' +
            '<td class="code"> ' +
            '<input type="text" class="form-control form-control-sm code" disabled> ' +
            '</td> ' +
            '<td class="qty"> ' +
            '<input type="text" class="form-control form-control-sm qty" disabled> ' +
            '</td> ' +
            '<td> ' +
            '<input type="text" class="form-control form-control-sm actual" name="actual[]"> ' +
            '</td> ' +
            '<td> ' +
            '<input type="text" class="form-control form-control-sm difference" name="difference[]" ' +
            'disabled> ' +
            '</td> ' +
            '<td class="avg_price"> ' +
            '<input type="text" class="form-control form-control-sm avg_price" name="avg_price[]">' +
            '</td> ' +
            '</tr>';


        $('.neworderbody').append(tr);
        $('.product').select2();

    });
    $('.neworderbody').on('click', '.delete', function () {
        $(this).parent().parent().remove();
        totalAmount();
    });
    $('.neworderbody').on('change', '.product, .actual', function () {
        var tr = $(this).parent().parent();
        var code = tr.find('.product option:selected').attr('code');
        var qty = tr.find('.product option:selected').attr('qty');
        var actual_qty = tr.find('.actual').val() - 0;
        var diff_qty = tr.find('.difference').val() - 0;

        var total = (actual_qty - qty);

        tr.find('.code').val(code);
        tr.find('.qty').val(qty);
        tr.find('.difference').val(total);
        totalAmount();
    });
    $('.category').on('ready, change', function () {
        var cat = $(this).val();

        if (cat == 1) {
            var tr = $('.account').val(140);
        } else if (cat == 2) {
            var tr = $('.account').val(132);
        } else if (cat == 3) {
            var tr = $('.account').val(74);
        } else if (cat == 4) {
            var tr = $('.account').val(7);
        } else {
            var tr = $('.account').val(140);
        };
    });
    $('.neworderbody').on('keyup', '.qty, .unit_price', function () {
        var tr = $(this).parent().parent();

        var price = tr.find('.unit_price').val() - 0;
        var qty = tr.find('.qty').val() - 0;
        //var tax = tr.find('.dis').val() - 0;

        var total = (qty * price);
        tr.find('.amount').val(total);
        totalAmount();
    });

    $('#hideshow').on('click', function (event) {
        $('#content').removeClass('hidden');
        $('#content').addClass('show');
        $('#content').toggle('show');
    });
});

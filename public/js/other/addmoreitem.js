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
}

function totalTax() {
    var t = 0;
    $('.amounttax').each(function (i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });
    $('.total').html('Rp ' + t);
    $('.total_input').val(t);
}

function totalSub() {
    var t = 0;
    $('.amountsub').each(function (i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });
    $('.subtotal').html('Rp ' + t);
}

function totalGrand() {
    var t = 0;
    $('.amountgrand').each(function (i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });
    $('.balance').html('Rp ' + t);
    $('.balance_input').val(t);
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

    $(".unit_price_display").inputmask("IDR");
    $(".amount_display").inputmask("IDR");
}

$(document).ready(function () {    

    inputMasking();
    totalAmount();
    totalTax();
    totalSub();
    totalGrand();

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
            '<select class="select2 form-control form-control-sm product_id" id="selectproduct" name="products[]" aria-placeholder="Select Product" required>' +
            product +
            '</select>' +
            '</div>' +
            '</td>' +
            '<td>' +
            '<textarea class="form-control desc" name="desc[]" rows="1"></textarea>' +
            '</td>' +
            '<td>' +
            '<input onClick="this.select();" type="text" id="qtyproduct" class="qty form-control form-control-sm" value="1" name="qty[]">' +
            '</td>' +
            '<td>' +
            '<div class="form-group">' +
            '<select class="select2 form-control form-control-sm units" name="units[]" aria-placeholder="Select Product" required>' +
            units +
            '</select>' +
            '</div>' +
            '</td>' +
            '<td>' +
            '<input onClick="this.select();" type="text" class="unit_price_display form-control" name="unit_price_display[]" required>' +
            '<input type="text" class="unit_price form-control form-control-sm" name="unit_price[]" hidden>' +
            '<input type="hidden" class="amounttax" name="total_price_tax[]">' +
            '<input type="hidden" class="amountsub" name="total_price_sub[]">' +
            '<input type="hidden" class="amountgrand" name="total_price_grand[]">' +
            '</td>' +
            '<td>' +
            '<div class="form-group">' +
            '<select class="taxes select2 form-control form-control-sm" name="tax[]" aria-placeholder="Select Product">' +
            taxes +
            '</select>' +
            '</div>' +
            '</td>' +
            '<td>' +
            '<input type="text" class="amount_display form-control" name="total_price_display[]" ' +
            'style="text-align: right;" readonly></input> ' +
            '<input type="text" class="amount form-control form-control-sm " name="total_price[]" hidden> ' +
            '</td>' +
            '<td>' +
            '<input type="button" class="btn btn-danger delete" value="x">' +
            '</td>' +
            '</tr>';

        $('.neworderbody').append(tr);
        
        $(".product_id").select2({
            placeholder: "Select Product",
            width: "100%",
            minimumInputLength: 1,
            delay: 250,
            ajax: {
                url: "/selectProduct",
                dataType: "json",
                data: function(params) {
                    return {
                        term: params.term || "",
                        page: params.page || 1
                    };
                },
                cache: true
            }
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
        inputMasking();
    });

    $('.neworderbody').on('click', '.delete', function () {
        $(this).parent().parent().remove();
        totalAmount();
        totalTax();
        totalSub();
        totalGrand();
    });
    
    /*$('.neworderbody').on('change', '.product_id', function () {
        var tr = $(this).parent().parent();
        var price = tr.find('.product_id option:selected').data('unitprice');
        tr.find('.desc_input').val(price);
        console.log(price);
    });*/

    /*$('.neworderbody').on('change', '#selectproduct', function () {
        //Getting Value
        var selValue = $(this).children(':selected').data('unitprice');
        //Setting Value
        $("#qtyproduct").val(selValue);
        console.log(selValue);
        totalAmount();
    });*/
    
    $('.neworderbody').on('keyup change', '.taxes, .qty, .unit_price_display', function () {
        var tr = $(this).parent().parent();
        var tax = tr.find('.taxes option:selected').attr('rate');     
        var price = tr.find('.unit_price_display').val() - 0;
        var qty = tr.find('.qty').val() - 0;
        var subtotal = (qty * price);//(qty * price) - ((qty * price * tax) / 100);
        var taxtotal = ((qty * price * tax) / 100);
        var total = subtotal + taxtotal;//(qty * price);
        tr.find('.amount_display').val(subtotal);
        tr.find('.unit_price').val(price);
        tr.find('.amount').val(subtotal);
        tr.find('.amountsub').val(subtotal);
        tr.find('.amounttax').val(taxtotal);
        tr.find('.amountgrand').val(total);
        totalAmount();
        totalTax();
        totalSub();
        totalGrand();
    });    

    $('#hideshow').on('click', function (event) {
        $('#content').removeClass('hidden');
        $('#content').addClass('show');
        $('#content').toggle('show');
    });
});

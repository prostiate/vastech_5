$(document).ready(function () {
    var dig = $('.dig').val();
    $('.selectaccount').val(dig).trigger('change');

    $('.selectadjustmentcategory').change(function () {
        var selectedValue = $(this).val();
        var di  = $('.di').val();
        var dig = $('.dig').val();
        var diw = $('.diw').val();
        var dip = $('.dip').val();

        if (selectedValue == "General")
            $('.selectaccount').val(dig).trigger('change');
        else if (selectedValue == "Waste")
            $('.selectaccount').val(diw).trigger('change');
        else if (selectedValue == "Production")
            $('.selectaccount').val(dip).trigger('change');
        else if (selectedValue == "Opening Quantity")
            $('.selectaccount').val(di).trigger('change');
    });
});

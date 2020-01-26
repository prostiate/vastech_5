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

    $(".asset_cost_display").inputmask("IDR");
    $(".depreciate_accumulated_display").inputmask("IDR");
}

$(document).ready(function () {
    inputMasking();

    $('#check_depreciable').click(function() {
        var chk = $('#check_depreciable').is(':checked');

        if (chk) {
            $("[name='depreciate_method']").prop("disabled", true);
            $("[name='depreciate_life']").prop("disabled", true);
            $("[name='depreciate_rate']").prop("disabled", true);
            $("[name='depreciate_account']").prop("disabled", true);
            $("[name='depreciate_accumulated_account']").prop("disabled", true);
            $("[name='depreciate_accumulated_display']").prop("disabled", true);
            $("[name='depreciate_accumulated']").prop("disabled", true);
            $("[name='depreciate_date']").prop("disabled", true);
        } else {
            $("[name='depreciate_method']").prop("disabled", false);
            $("[name='depreciate_life']").prop("disabled", false);
            $("[name='depreciate_rate']").prop("disabled", false);
            $("[name='depreciate_account']").prop("disabled", false);
            $("[name='depreciate_accumulated_account']").prop("disabled", false);
            $("[name='depreciate_accumulated_display']").prop("disabled", false);
            $("[name='depreciate_accumulated']").prop("disabled", false);
            $("[name='depreciate_date']").prop("disabled", false);
        }
    });
    
    $(".neworderbody").find('.difference_qty').prop("disabled", true);
   
    $(".asset_cost_display").on(
        "change",
        function() {
            var asset_cost = $(this).val();
            $(".asset_cost").val(asset_cost);
        }
    );

    $(".depreciate_accumulated_display").on(
        "change",
        function() {
            var depreciate_accumulated = $(this).val();
            $(".depreciate_accumulated").val(depreciate_accumulated);
        }
    );

    $(".depreciate_life").on(
        "change",
        function() {
            var life = $(this).val();
            var rate = 100 / life;
            $(".depreciate_rate").val(rate.toFixed(2));
        }
    );

    $(".depreciate_rate").on(
        "change",
        function() {
            var rate = $(this).val();
            var life = 100 / rate;
            $(".depreciate_life").val(life.toFixed(2));
        }
    );


});

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
    $(".amount_display").inputmask("IDR");
}

$(document).ready(function() {
    inputMasking();

    $(".neworderbody").on("keyup change", ".amount_display", function() {
        var tr = $(this).closest("tr");
        var amount = tr.find(".amount_display").val() - 0;
        tr.find(".amount_hidden").val(amount);
    });
});

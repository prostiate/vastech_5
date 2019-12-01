$(document).ready(function() {
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

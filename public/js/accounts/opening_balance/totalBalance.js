//UNTUK FORMAT CURRENY
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

    $("#selisih").inputmask("IDR");
    $(".debit_display").inputmask("IDR");
    $(".credit_display").inputmask("IDR");
    $(".total-debit-display").inputmask("IDR");
    $(".total-credit-display").inputmask("IDR");
}

function notNull() {
    $(".debit").each(function (i, e) {
        var amt = $(this).val() - 0;
        $(".debit_display").eq(i).val(amt);
    });
    $(".credit").each(function (i, e) {
        var amt = $(this).val() - 0;
        $(".credit_display").eq(i).val(amt);
    });    
}

//READ DEBIT AND CREDIT, SUM IT
function count() {
    var t = 0;
    var u = 0;

    $(".debit").each(function (i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });
    $(".credit").each(function (i, e) {
        var amt = $(this).val() - 0;
        u += amt;
    });

    $(".total-debit").val(t);
    $(".total-credit").val(u);
    $(".total-debit-display").val(t);
    $(".total-credit-display").val(u);
}

//CHECK BALANCE BETWEEN DEBIT AND CREDIT
 /** 
function publish() {
    var debit = $(".total-debit").val() - 0;
    var credit = $(".total-credit").val() - 0;
    var selisih = Math.abs(debit - credit);
    
    if (debit > credit) {
        var total = selisih + credit;
        $(".credit").eq(63).val(selisih);
        $(".total-credit").val(total);
    } else if (debit < credit) {
        var total = selisih + debit;
        $(".debit").eq(63).val(selisih);
        $(".total-debit").val(total);
    }
}
 * 
*/

//CONFIRM MODAL
function confirm() {
    var debit = $(".total-debit").val() - 0;
    var credit = $(".total-credit").val() - 0;
    var selisih = Math.abs(debit - credit).toFixed(2);
    var selisih_view = selisih.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

    if (debit < credit) {
        $("#type").html('<strong>debit</strong>');
        $("#selisih").html('<strong>' + selisih_view + '<strong>');
    }
    if (debit > credit) {
        $("#type").html('<strong>credit</strong>');
        $("#selisih").html('<strong>Rp ' + selisih_view + '<strong>');
    }

}

$(document).ready(function () {
    inputMasking();
    count();
    notNull();
    confirm();

    $(".row").on("keyup change", ".debit_display, .credit_display", function () {
        var tr = $(this).closest('tr');
        var debit_display = tr.find(".debit_display").val();
        var credit_display = tr.find(".credit_display").val();
        tr.find(".debit").val(debit_display);
        tr.find(".credit").val(credit_display);
        
        count();
    });
});

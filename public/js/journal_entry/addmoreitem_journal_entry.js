function totalDebit() {
    var t = 0;
    $(".deb").each(function(i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });
    $(".total_debit").html(t);
    $(".total_debit_display").val(t);
    $(".total_debit_input").val(t);
}
function totalCredit() {
    var t = 0;
    $(".cre").each(function(i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });
    $(".total_credit").html(t);
    $(".total_credit_display").val(t);
    $(".total_credit_input").val(t);
}

$(document).ready(function() {
    inputMasking();
    totalDebit();
    totalCredit();
});

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

    $(".debita_display").inputmask("IDR");
    $(".credita_display").inputmask("IDR");
    $(".total_debit_display").inputmask("IDR");
    $(".total_credit_display").inputmask("IDR");
}

$(function() {
    $(".add").click(function() {
        var account = $(".account_id").html();
        tr =
            "<tr>" +
            "<td>" +
            '<div class="form-group">' +
            '<select class="form-control account_id selectaccount" name="account[]">' +
            account +
            "</select>" +
            "</div>" +
            "</td>" +
            "<td>" +
            '<textarea class="form-control" rows="1" name="desc[]"></textarea>' +
            "</td>" +
            "<td>" +
            '<input onClick="this.select();" value="0" type="text" class="debita_display form-control">' +
            '<input value="0" type="text" class="debita" name="debit[]" hidden>' +
            '<input value="0" type="text" class="deb" hidden>' +
            "</td>" +
            "<td>" +
            '<input onClick="this.select();" value="0" type="text" class="credita_display form-control">' +
            '<input value="0" type="text" class="credita" name="credit[]" hidden>' +
            '<input value="0" type="text" class="cre" hidden>' +
            "</td>" +
            "<td>" +
            '<input type="button" class="btn btn-danger delete" value="x">' +
            "</td>" +
            "</tr>";

        $(".neworderbody").append(tr);

        $(".account_id").select2({
            width: "100%",
            placeholder: "Select Account"
        });
        inputMasking();
    });

    $(".neworderbody").on("click", ".delete", function() {
        $(this)
            .parent()
            .parent()
            .remove();
        totalDebit();
    });

    $(".neworderbody").on(
        "keyup keydown change",
        ".debita_display",
        function() {
            var tr = $(this)
                .parent()
                .parent();
            var debit = tr.find(".debita_display").val() - 0;
            var total = debit;
            tr.find(".debita").val(total);
            tr.find(".deb").val(total);
            totalDebit();
        }
    );
    $(".neworderbody").on(
        "keyup keydown change",
        ".credita_display",
        function() {
            var tr = $(this)
                .parent()
                .parent();
            var debit = tr.find(".credita_display").val() - 0;
            var total = debit;
            tr.find(".credita").val(total);
            tr.find(".cre").val(total);
            totalCredit();
        }
    );
});

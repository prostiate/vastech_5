function totalGrand() {
    var t = 0;
    $(".price_hidden").each(function(i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });
    $(".grandtotal_display").val(t);
    $(".grandtotal_hidden").val(t);
}

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

    $(".grandtotal_display").inputmask("IDR");
    $(".price_display").inputmask("IDR");
}

$(document).ready(function() {
    inputMasking();
    totalGrand();

    $(".add").click(function() {
        tr =
            "<tr>" +
            "<td>" +
            '<input onClick="this.select();" type="text" class="form-control" name="working_description[]">' +
            "</td>" +
            "<td>" +
            '<input onClick="this.select();" type="text" class="form-control" name="specification[]">' +
            "</td>" +
            "<td>" +
            '<input onClick="this.select();" type="text" class="form-control price_display" name="price_display[]" value="0">' +
            '<input type="text" class="price_hidden" name="price[]" value="0" hidden>' +
            "</td>" +
            "<td>" +
            '<input type="button" class="btn btn-danger delete" value="x">' +
            "</td>" +
            "</tr>";

        $(".neworderbody").append(tr);
        inputMasking();
    });

    $(".neworderbody").on("click", ".delete", function() {
        $(this)
            .parent()
            .parent()
            .remove();
        totalGrand();
    });

    $(".neworderbody").on(
        "keyup change",
        ".price_display",
        function() {
            var tr = $(this).closest("tr");
            var price = tr.find(".price_display").val() - 0;
            tr.find(".price_hidden").val(price);
            totalGrand();
        }
    );
});

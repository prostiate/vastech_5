function totalGrand() {
    var t = 0;
    $(".price_hidden").each(function(i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });
    $(".grandtotal_display").val(t);
    $(".grandtotal_hidden").val(t);
}

function totalSub() {
    var t = 0;
    $(".neworderbody").each(function (i, e) {
        var newbody = $(this);
        newbody.find(".price_hidden").each(function(i, e) {
            var amt = $(this).val() - 0;
            t += amt;
        });
        newbody.find(".sub_display").val(t);
        newbody.find(".sub_hidden").val(t);
        t = 0;
    });
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
    $(".sub_display").inputmask("IDR");
    $(".price_display").inputmask("IDR");
}

$(document).ready(function() {
    inputMasking();
    totalGrand();
    totalSub();

    //$(".add").click(function() {
    $(".neworderbody").on("click", ".add", function () {
        
        var k = $(this).closest("tbody").find(".kon").val();

        tr =
            "<tr>" +
            "<td>" +
            "<input value="+k+" class='kon' hidden>" +
            '<input onClick="this.select();" type="text" class="form-control" name="working_detail[]['+k+']">' +
            "</td>" +
            "<td>" +
            '<input onClick="this.select();" type="number" class="form-control" name="duration[]['+k+']" value="0">' +
            "</td>" +
            "<td>" +
            '<input onClick="this.select();" type="text" class="form-control price_display" value="0">' +
            '<input type="text" class="price_hidden" name="price[]['+k+']" value="0" hidden>' +
            "</td>" +
            "<td>" +
            '<input type="button" class="btn btn-danger delete" value="x">' +
            "</td>" +
            "</tr>";

        $(this).closest("tbody").find(".outputbody").before(tr);
        inputMasking();
    });

    $(".neworderbody").on("click", ".delete", function() {
        $(this).closest("tr").remove();
        totalGrand();
        totalSub();
    });

    $(".neworderbody").on("keyup change", ".price_display", function() {
        var tr = $(this).closest("tr");
        var price = tr.find(".price_display").val() - 0;
        tr.find(".price_hidden").val(price);
        totalGrand();
        totalSub();
    });
});

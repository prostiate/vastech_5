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
    $(".neworderbody").each(function(i, e) {
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

function warnAmount() {
    $(".neworderbody").each(function(i, e) {
        var body = $(this);
        var subtotal = body.find(".sub_hidden").val() - 0;
        var amount = body.find(".offering_letter_amount").val() - 0;

        if (subtotal > amount) {
            body.find("tr.warning").prop("hidden", false);
        } else {
            body.find("tr.warning").prop("hidden", true);
        }
        //console.log('sub_total = '+subtotal+' amount = '+amount);
        //('sub_total = '+subtotal+' amount = '+amount);
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
    warnAmount();

    //$(".add").click(function() {
    $(".neworderbody").on("click", ".add", function() {
        var k = $(this)
            .closest("tbody")
            .find(".kon")
            .val();
        tr =
            "<tr>" +
            "<td>" +
            "<input value=" +
            k +
            " class='kon' name='offering_letter_detail_id[]' hidden>" +
            '<input onClick="this.select();" type="text" class="form-control" name="working_detail[]">' +
            "</td>" +
            "<td>" +
            '<input onClick="this.select();" type="number" class="form-control" name="duration[]" value="0">' +
            "</td>" +
            "<td>" +
            '<input onClick="this.select();" type="text" class="form-control price_display" name="price_display[]" value="0">' +
            '<input type="text" class="price_hidden" name="price[]" value="0" hidden>' +
            "</td>" +
            "<td>" +
            '<input type="button" class="btn btn-danger delete" value="x">' +
            "</td>" +
            "</tr>";

        $(this)
            .closest("tbody")
            .find(".warning")
            .before(tr);
        inputMasking();
    });

    $(".neworderbody").on("click", ".delete", function() {
        $(this)
            .closest("tr")
            .remove();
        totalGrand();
        totalSub();
        warnAmount();
    });

    $(".neworderbody").on("change", ".price_display", function() {
        var tr = $(this).closest("tr");
        var price = tr.find(".price_display").val() - 0;
        tr.find(".price_hidden").val(price);
        totalGrand();
        totalSub();
        warnAmount();
    });
});

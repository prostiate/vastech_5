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
    $(".examount").inputmask("IDR");
    $(".total_raw_display").inputmask("IDR");
    $(".cost_est").inputmask("IDR");
    $(".cost_total").inputmask("IDR");
    $(".total_cost_display").inputmask("IDR");
    $(".total_grand_display").inputmask("IDR");
}

$(document).ready(function() {
    inputMasking();
    totalAmountRaw();
    totalAmountCost();
    totalGrand();
});

function multiplier(a) {
    var cost_multi_display = document.getElementById('cost_multi_display');
    var cost_multi_hidden = document.getElementById('cost_multi_hidden');
    cost_multi_display.value = a.value;
    cost_multi_hidden.value = a.value;
}

function totalAmountRaw() {
    var t = 0;
    $(".amount").each(function(i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });
    $(".total_raw_display").val(t);
    $(".total_raw_hidden").val(t);
}

function totalAmountCost() {
    var t = 0;
    $(".hidden_cost_total").each(function(i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });
    $(".total_cost_display").val(t);
    $(".total_cost_hidden").val(t);
}

function totalGrand() {
    var t = 0;
    var r = 0;
    $(".total_raw_hidden").each(function(i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });
    $(".total_cost_hidden").each(function(i, e) {
        var amt = $(this).val() - 0;
        r += amt;
    });
    $(".total_grand_display").val(t+r);
    $(".total_grand_hidden").val(t+r);
}

$(function() {
    $(".add-item").click(function() {
        tr =
            "<tr>" +
            "<td>" +
            '<div class="form-group">' +
            '<select class="form-control selectproduct product_id" name="raw_product[]">' +
            "</select>" +
            "</div>" +
            "</td>" +
            "<td>" +
            '<input onClick="this.select();" type="number" class="form-control qty" name="raw_qty[]">' +
            "</td>" +
            "<td>" +
            '<input onClick="this.select();" type="text" class="examount form-control">' +
            '<input type="text" class="amount" name="raw_amount[]" hidden>' +
            "</td>" +
            "<td>" +
            '<input type="button" class="btn btn-danger delete" value="x">' +
            "</td>" +
            "</tr>";
        $(".neworderbody1").append(tr);
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
        inputMasking();
    });

    $(".neworderbody1").on("click", ".delete", function() {
        $(this)
            .parent()
            .parent()
            .remove();
        totalAmountRaw();
        totalGrand();
    });

    $(".neworderbody1").on("keyup keydown change", ".examount", function() {
        var tr = $(this)
            .parent()
            .parent();
        var amount = tr.find(".examount").val() - 0;
        tr.find(".amount").val(amount);
        totalAmountRaw();
        totalGrand();
    });
});

$(function() {
    $(".add-cost").click(function() {
        var cost = $(".cost_id").html();
        var multi = $(".result_qty").val();
        tr =
            "<tr>" +
            "<td>" +
            '<div class="form-group">' +
            '<select class="form-control selectaccount cost_id" name="cost_acc[]">' +
            cost +
            "</select>" +
            "</div>" +
            "</td>" +
            "<td>" +
            '<input onClick="this.select();" type="text" class="form-control cost_est">' +
            '<input type="text" class="hidden_cost_est" name="cost_est[]" hidden>' +
            "</td>" +
            "<td>" +
            '<input id="cost_multi_display" onClick="this.select();" type="number" class="form-control cost_multi" value="'+ multi +'" >' +
            '<input id="cost_multi_hidden" type="text" class="hidden_cost_multi" name="cost_multi[]" value="'+ multi +'" hidden>' +
            "</td>" +
            "<td>" +
            '<input onClick="this.select();" type="text" class="form-control cost_total">' +
            '<input type="text" class="hidden_cost_total" name="cost_total[]" hidden>' +
            "</td>" +
            "<td>" +
            '<input type="button" class="btn btn-danger delete" value="x">' +
            "</td>" +
            "</tr>";
        $(".neworderbody2").append(tr);
        $(".cost_id").select2({
            width: "100%",
            placeholder: "Select Account"
        });
        inputMasking();
    });

    $(".neworderbody2").on("click", ".delete", function() {
        $(this)
            .parent()
            .parent()
            .remove();
        totalAmountCost();
        totalGrand();
    });

    $(".neworderbody2").on(
        "keyup keydown change",
        ".cost_est, .cost_multi",
        function() {
            var tr = $(this)
                .parent()
                .parent();
            var cost_est = tr.find(".cost_est").val() - 0;
            var cost_multi = tr.find(".cost_multi").val() - 0;
            var cost_total = cost_est * cost_multi;
            tr.find(".hidden_cost_est").val(cost_est);
            tr.find(".hidden_cost_multi").val(cost_multi);
            tr.find(".cost_total").val(cost_total);
            tr.find(".hidden_cost_total").val(cost_total);
            totalAmountCost();
            totalGrand();
        }
    );
});

function selectProduct() {
    $(".select_product").select2({
        placeholder: "Select Product",
        width: "100%",
        //minimumInputLength: 1,
        delay: 250,
        allowClear: true,
        ajax: {
            url: "/purchases_invoice/select_product",
            dataType: "json",
            data: function (params) {
                return {
                    term: params.term || "",
                    page: params.page || 1
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;

                return {
                    results: data.results,
                    pagination: {
                        more: params.page * 10 < data.total_count
                    }
                };
            },
            cache: true
        },
        templateResult: formatResult,
        templateSelection: formatRepoSelection
    });

    function formatRepoSelection(repo) {
        $(".selected_product_id").val(repo.id);
        $(".selected_product_unit").val(repo.other_unit_id);
        if (repo.code) {
            return (
                repo.code + " - " + repo.text || repo.code + " - " + repo.text
            );
        } else {
            return repo.text || repo.text;
        }
    }

    function formatResult(result) {
        //console.log('%o', result);
        if (result.loading) return result.text;
        if (result.code) {
            var html = "<a>" + result.code + " - " + result.text + "</a>";
        } else {
            var html = "<a>" + result.text + "</a>";
        }
        //return html;
        return $(html);
    }
}

function selectProduct2() {
    $(".product_id").select2({
        placeholder: "Select Product",
        width: "100%",
        //minimumInputLength: 1,
        delay: 250,
        allowClear: true,
        ajax: {
            url: "/purchases_invoice/select_product",
            dataType: "json",
            data: function (params) {
                return {
                    term: params.term || "",
                    page: params.page || 1
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;

                return {
                    results: data.results,
                    pagination: {
                        more: params.page * 10 < data.total_count
                    }
                };
            },
            cache: true
        },
        templateResult: formatResult,
        templateSelection: formatRepoSelection
    });

    function formatRepoSelection(repo) {
        $(".selected_product_id").val(repo.id);
        $(".selected_product_unit").val(repo.other_unit_id);
        if (repo.code) {
            return (
                repo.code + " - " + repo.text || repo.code + " - " + repo.text
            );
        } else {
            return repo.text || repo.text;
        }
    }

    function formatResult(result) {
        //console.log('%o', result);
        if (result.loading) return result.text;
        if (result.code) {
            var html = "<a>" + result.code + " - " + result.text + "</a>";
        } else {
            var html = "<a>" + result.text + "</a>";
        }
        //return html;
        return $(html);
    }
}

function totalAmount() {
    var t = 0;
    $(".neworderbody").each(function (i, e) {
        var newbody = $(this);
        newbody.find(".total_price_hidden").each(function (i, e) {
            var amt = $(this).val() - 0;
            t += amt;
        });
        newbody.find(".sub_display").val(t);
        newbody.find(".sub_hidden").val(t);
        t = 0;
    });
}

function totalGrand() {
    var t = 0;
    $(".price_hidden").each(function (i, e) {
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
        newbody.find(".total_price_hidden").each(function (i, e) {
            var amt = $(this).val() - 0;
            t += amt;
        });
        newbody.find(".sub_display").val(t);
        newbody.find(".sub_hidden").val(t);
        t = 0;
    });
}

function warnAmount() {
    $(".neworderbody").each(function (i, e) {
        var body = $(this);
        var subtotal = body.find(".sub_hidden").val() - 0;
        var amount = body.find(".budget_plan_detail_price").val() - 0;

        /*if (subtotal > amount) {
            body.find("tr.warning").prop('hidden', false);
        } else {
            body.find("tr.warning").prop('hidden', true);
        }*/
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
    $(".total_price_display").inputmask("IDR");
}

$(document).ready(function () {
    selectProduct();
    inputMasking();
    totalAmount();
    totalGrand();
    totalSub();

    //$(".add").click(function() {
    $(".neworderbody").on("click", ".add", function () {
        var unit = $(".unit").html();

        tr =
            "<tr>" +
            "<td>" +
            '<div class="form-group" >' +
            '<select class="form-control product_id" name="product[]">' +
            "</select>" +
            '<input class="selected_product_id" hidden>' +
            '<input class="selected_product_unit" hidden>' +
            '<input class="tampungan_product_id" name="product2[]" hidden>' +
            '<input class="tampungan_product_unit" hidden>' +
            "</div>" +
            "</td>" +
            "<td>" +
            '<div class="form-group">' +
            '<select class="form-control unit" name="unit[]">' +
            unit +
            "</select>" +
            "</div>" +
            "</td>" +
            "<td>" +
            '<input onClick="this.select();" type="text" class="form-control qty" name="quantity[]" value="0">' +
            "</td>" +
            "<td>" +
            '<input onClick="this.select();" type="text" class="form-control price_display" name="price_display[]" value="0">' +
            '<input type="text" class="price_hidden" name="price[]" value="0" hidden>' +
            "</td>" +
            "<td>" +
            '<input type="text" class="form-control total_price_display" value="0" readonly>' +
            '<input type="text" class="total_price_hidden" name="total_price[]" value="0" hidden>' +
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
        selectProduct2();
        $(".unit").select2({
            width: "100%",
            placeholder: "Select Unit"
        });
    });

    $(".neworderbody").on("click", ".delete", function () {
        $(this)
            .closest("tr")
            .remove();
        totalGrand();
        totalSub();
        warnAmount();
    });

    $(".neworderbody").on(
        "change select2-selecting",
        ".product_id",
        function() {
            var tr = $(this).closest("tr");
            var id = $(".selected_product_id").val();
            var unit = $(".selected_product_unit").val();
            tr.find(".tampungan_product_id").val(id);
            tr.find(".tampungan_product_unit").val(unit);
            var tampungan_unit = tr.find(".tampungan_product_unit").val();
            tr.find(".unit")
                .val(tampungan_unit)
                .change();
        }
    );

    $(".neworderbody").on("keyup change", ".price_display, .qty", function () {
        var tr = $(this).closest("tr");
        var qty = tr.find(".qty").val() - 0;
        var price = tr.find(".price_display").val() - 0;
        var total = qty * price;
        tr.find(".price_hidden").val(price);
        tr.find(".total_price_display").val(total);
        tr.find(".total_price_hidden").val(total);
        totalAmount();
        totalGrand();
        totalSub();
        warnAmount();
    });
});

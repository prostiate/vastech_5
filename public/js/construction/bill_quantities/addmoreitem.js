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
            data: function(params) {
                return {
                    term: params.term || "",
                    page: params.page || 1
                };
            },
            processResults: function(data, params) {
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
            data: function(params) {
                return {
                    term: params.term || "",
                    page: params.page || 1
                };
            },
            processResults: function(data, params) {
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
    selectProduct();
    inputMasking();
    totalGrand();
    totalSub();

    //$(".add").click(function() {
    $(".neworderbody").on("click", ".add", function() {
        var unit = $(".unit").html();
        var k = $(this)
            .closest("tbody")
            .find(".kon")
            .val();

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
            '<input onClick="this.select();" type="text" class="form-control" name="quantity[]" value="0">' +
            "</td>" +
            "<td>" +
            '<input onClick="this.select();" type="text" class="form-control price_display" value="0">' +
            '<input type="text" class="price_hidden" name="price[]" value="0" hidden>' +
            "</td>" +
            "<td>" +
            '<input type="button" class="btn btn-danger delete" value="x">' +
            "</td>" +
            "</tr>";

        $(this)
            .closest("tbody")
            .find(".outputbody")
            .before(tr);
        inputMasking();
        selectProduct2();
    });

    $(".neworderbody").on("click", ".delete", function() {
        $(this)
            .closest("tr")
            .remove();
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

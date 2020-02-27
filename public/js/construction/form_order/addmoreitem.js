function selectProduct() {
    $(".select_product").select2({
        placeholder: "Select Product",
        width: "100%",
        //minimumInputLength: 1,
        delay: 250,
        allowClear: true,
        ajax: {
            url: "/construction/bill_quantities/select_product",
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
            url: "/construction/bill_quantities/select_product",
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
    $(".price_hidden").each(function(i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });
    $(".sub_display").val(t);
    $(".sub_hidden").val(t);
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

    $(".neworderbody").on("click", ".delete", function() {
        $(this)
            .parent()
            .parent()
            .remove();
        totalGrand();
        totalSub();
    });

    /**
    $(".neworderbody").on("keyup change", ".order_progress", function() {
        var tr = $(this).closest("tr");
        var t = tr.find('.order_duration').val() - 0;
        var d = tr.find('.order_days').val() - 0;
        var p = tr.find('.order_progress').val() - 0;

        //kalau hitung progress real otomatis
        var bulan = ((p / 100) * t).toFixed(2);
        tr.find('.order_days').val(bulan - 0);
    });

    $(".neworderbody").on("keyup change", ".order_days", function() {
        var tr = $(this).closest("tr");
        var t = tr.find('.order_duration').val() - 0;
        var d = tr.find('.order_days').val() - 0;
        var p = tr.find('.order_progress').val() - 0;

        //kalau hitung progress real otomatis
        var persen = ((d / t) * 100).toFixed(2);
        if (persen > 100) {
            persen = 100;
        };
        tr.find('.order_progress').val(persen - 0);

        //hitung keterlambatan
    });
    */
    $(".neworderbody").on("keyup change", ".order_days, .order_progress", function() {
        var tr = $(this).closest("tr");
        var t = tr.find('.order_duration').val() - 0;
        var d = tr.find('.order_days').val() - 0;
        var p = tr.find('.order_progress').val() - 0;

        //kalau hitung progress real otomatis
        var persen = ((d / t) * 100).toFixed(2);
        if (persen > 100) {
            persen = 100;
        };
        var persen = persen - 0;
        tr.find('.order_days').attr("data-original-title", "Progress : " + persen + " %");

        //hitung keterlambatan
        var k = persen - p - 0;
        if (k < 0) {
            k = 0;
        };
        tr.find('.order_late').val(k);
    });

    $(".neworderbody").on(
        "keyup change select2-selecting",
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
});

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
    $(".buy_unit_price_display").inputmask("IDR");
    $(".sell_unit_price_display").inputmask("IDR");
    $(".product_price_display_production").inputmask("IDR");
    $(".total_price_display_production").inputmask("IDR");
    $(".discount_price_display_a").inputmask("IDR");
    $(".discount_price_display_b").inputmask("IDR");
    $(".discount_price_display_c").inputmask("IDR");
    $(".discount_price_display_d").inputmask("IDR");
}

$(document).ready(function() {
    $(".select_product_production").select2({
        placeholder: "Select Product",
        width: "100%",
        //minimumInputLength: 1,
        delay: 250,
        allowClear: true,
        ajax: {
            url: "/products/select_product",
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
        $(".selected_product_id_production").val(repo.id);
        return repo.text || repo.text;
    }

    function formatResult(result) {
        //console.log('%o', result);
        if (result.loading) return result.text;
        var html = "<a>" + result.text + "</a>";
        //return html;
        return $(html);
    }
    inputMasking();
});

$(function() {
    $(".add-item_production").click(function() {
        //var product = $(".product_id").html();
        tr =
            "<tr>" +
            "<td>" +
            '<div class="form-group">' +
            '<select class="form-control select_product_production product_id_production" name="product_id_production[]">' +
            //product +
            "</select>" +
            '<input class="selected_product_id_production" hidden>' +
            '<input class="tampungan_product_id_production" name="product_id_production2[]" hidden>' +
            " </div>" +
            "</td>" +
            "<td>" +
            '<input onClick="this.select();" type="number" class="form-control qty_production" name="product_qty_production[]" value="0">' +
            "</td>" +
            "<td>" +
            '<input onClick="this.select();" type="text" class="form-control product_price_display_production" value="0">' +
            '<input type="text" class="hidden_product_price_production" name="product_price_production[]" value="0"  hidden>' +
            "</td>" +
            "<td>" +
            '<input type="button" class="btn btn-danger delete_production" value="x">' +
            "</td>" +
            "</tr>";
        $(".neworderbody_production").append(tr);
        $(".product_id_production").select2({
            placeholder: "Select Product",
            width: "100%",
            //minimumInputLength: 1,
            delay: 250,
            allowClear: true,
            ajax: {
                url: "/products/select_product",
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
            $(".selected_product_id_production").val(repo.id);
            return repo.text || repo.text;
        }

        function formatResult(result) {
            //console.log('%o', result);
            if (result.loading) return result.text;
            var html = "<a>" + result.text + "</a>";
            //return html;
            return $(html);
        }
        inputMasking();
    });

    $(".neworderbody_production").on("click", ".delete_production", function() {
        $(this)
            .parent()
            .parent()
            .remove();
    });

    $(".neworderbody_production").on(
        "keyup change select2-selecting",
        ".product_id_production",
        function() {
            var tr = $(this).closest("tr");
            var id = $(".selected_product_id_production").val();
            tr.find(".tampungan_product_id_production").val(id);
        }
    );
    $(".neworderbody_production").on(
        "keyup change",
        ".product_price_display_production",
        function() {
            var tr = $(this).closest("tr");
            var hidden_product_price = tr
                .find(".product_price_display_production")
                .val();
            tr.find(".hidden_product_price_production").val(
                hidden_product_price
            );
        }
    );
});

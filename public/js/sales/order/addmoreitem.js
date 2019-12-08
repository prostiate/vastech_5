function totalAmount() {
    var t = 0;
    $(".amount").each(function(i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });
    $(".subtotal_input").val(t);
}

function totalTax() {
    var t = 0;
    $(".amounttax").each(function(i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });
    $(".total").val(t);
    $(".total_input").val(t);
}

function totalSub() {
    var t = 0;
    $(".amountsub").each(function(i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });
    $(".subtotal").val(t);
}

function totalGrand() {
    var t = 0;
    $(".amountgrand").each(function(i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });
    $(".balance").val(t);
    $(".balance_input").val(t);
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

    $(".unit_price_display").inputmask("IDR");
    $(".amount_display").inputmask("IDR");
    $(".subtotal").inputmask("IDR");
    $(".total").inputmask("IDR");
    $(".balance").inputmask("IDR");
}

function selectProduct() {
    $(".select_product").select2({
        placeholder: "Select Product",
        width: "100%",
        //minimumInputLength: 1,
        delay: 250,
        allowClear: true,
        ajax: {
            url: "/sales_order/select_product",
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
        $(".selected_product_desc").val(repo.desc);
        $(".selected_product_unit").val(repo.other_unit_id);
        $(".selected_product_price").val(repo.sell_price);
        $(".selected_product_tax").val(repo.sell_tax);
        $(".selected_product_is_lock_sales").val(repo.is_lock_sales);
        return repo.text || repo.text;
    }

    function formatResult(result) {
        //console.log('%o', result);
        if (result.loading) return result.text;
        var html = "<a>" + result.text + "</a>";
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
            url: "/sales_order/select_product",
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
        $(".selected_product_desc").val(repo.desc);
        $(".selected_product_unit").val(repo.other_unit_id);
        $(".selected_product_price").val(repo.sell_price);
        $(".selected_product_tax").val(repo.sell_tax);
        $(".selected_product_is_lock_sales").val(repo.is_lock_sales);
        return repo.text || repo.text;
    }

    function formatResult(result) {
        //console.log('%o', result);
        if (result.loading) return result.text;
        var html = "<a>" + result.text + "</a>";
        //return html;
        return $(html);
    }
}

function selectContact() {
    $(".select_contact").select2({
        placeholder: "Select Contact",
        width: "100%",
        //minimumInputLength: 1,
        delay: 250,
        allowClear: true,
        ajax: {
            url: "/sales_order/select_contact",
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
        templateResult: formatResult2,
        templateSelection: formatRepoSelection2
    });

    function formatRepoSelection2(repo) {
        $(".selected_contact_id").val(repo.id);
        $(".selected_contact_term").val(repo.term_id);
        $(".selected_email").val(repo.email);
        return repo.text || repo.text;
    }

    function formatResult2(result) {
        //console.log('%o', result);
        if (result.loading) return result.text;
        var html = "<a>" + result.text + "</a>";
        //return html;
        return $(html);
    }
}

$(document).ready(function() {
    selectProduct();
    selectContact();
    inputMasking();
    totalAmount();
    totalTax();
    totalSub();
    totalGrand();

    $(".add").click(function() {
        //var product = $(".product_id").html();
        var units = $(".units").html();
        var taxes = $(".taxes").html();
        tr =
            "<tr><td>" +
            '<div class="form-group" >' +
            '<select class="form-control product_id" name="products[]">' +
            //product +
            "</select>" +
            '<input class="selected_product_id" hidden>' +
            '<input class="selected_product_desc" hidden>' +
            '<input class="selected_product_unit" hidden>' +
            '<input class="selected_product_price" hidden>' +
            '<input class="selected_product_tax" hidden>' +
            '<input class="selected_product_is_lock_sales" hidden>' +
            '<input class="tampungan_product_id" name="products2[]" hidden>' +
            '<input class="tampungan_product_desc" hidden>' +
            '<input class="tampungan_product_unit" hidden>' +
            '<input class="tampungan_product_price" hidden>' +
            '<input class="tampungan_product_tax" hidden>' +
            '<input class="tampungan_product_is_lock_sales" hidden>' +
            "</div>" +
            "</td>" +
            "<td>" +
            '<textarea class="form-control desc" name="desc[]" rows="1"></textarea>' +
            "</td>" +
            "<td>" +
            '<input onClick="this.select();" type="text" class="qty form-control" value="1" name="qty[]">' +
            "</td>" +
            "<td>" +
            '<div class="form-group">' +
            '<select class="form-control units" name="units[]">' +
            units +
            "</select>" +
            "</div>" +
            "</td>" +
            "<td>" +
            '<input onClick="this.select();" type="text" class="form-control unit_price_display" name="unit_price_display[]">' +
            '<input type="text" class="hidden_product_id" hidden>' +
            '<input type="text" class="hidden_product_desc" hidden>' +
            '<input type="text" class="hidden_product_unit" hidden>' +
            '<input type="text" class="unit_price" name="unit_price[]" hidden>' +
            '<input type="text" class="hidden_product_tax" hidden>' +
            "</td>" +
            "<td>" +
            '<div class="form-group">' +
            '<select class="form-control taxes" name="tax[]">' +
            taxes +
            "</select>" +
            "</div>" +
            "</td>" +
            "<td>" +
            '<input type="text" class="amount_display form-control" name="total_price_display[]" readonly></input> ' +
            '<input type="text" class="amount" name="total_price[]" hidden> ' +
            '<input type="text" class="amounttax" name="total_price_tax[]" hidden>' +
            '<input type="text" class="amountsub" name="total_price_sub[]" hidden>' +
            '<input type="text" class="amountgrand" name="total_price_grand[]" hidden>' +
            "</td>" +
            "<td>" +
            '<input type="button" class="btn btn-danger delete" value="x">' +
            "</td>" +
            "</tr>";

        $(".neworderbody").append(tr);

        selectProduct2();

        $(".units").select2({
            width: "100%",
            placeholder: "Select Unit"
        });

        $(".taxes").select2({
            width: "100%",
            placeholder: "Select Tax"
        });
        inputMasking();
    });

    $(".neworderbody").on("click", ".delete", function() {
        $(this)
            .parent()
            .parent()
            .remove();
        totalAmount();
        totalTax();
        totalSub();
        totalGrand();
    });

    $(".neworderbody").on(
        "keyup change",
        ".taxes, .qty, .unit_price_display",
        function() {
            var tr = $(this).closest("tr");
            var tax = tr.find(".taxes option:selected").attr("rate");
            var price = tr.find(".unit_price_display").val() - 0;
            var qty = tr.find(".qty").val() - 0;
            var subtotal = qty * price; //(qty * price) - ((qty * price * tax) / 100);
            var taxtotal = (qty * price * tax) / 100;
            var total = subtotal + taxtotal; //(qty * price);
            tr.find(".amount_display").val(subtotal);
            tr.find(".unit_price").val(price);
            tr.find(".amount").val(subtotal);
            tr.find(".amountsub").val(subtotal);
            tr.find(".amounttax").val(taxtotal);
            tr.find(".amountgrand").val(total);
            totalAmount();
            totalTax();
            totalSub();
            totalGrand();
        }
    );

    $(".neworderbody").on(
        "keyup change select2-selecting",
        ".product_id",
        function() {
            var tr = $(this).closest("tr");
            var id = $(".selected_product_id").val();
            var desc = $(".selected_product_desc").val();
            var unit = $(".selected_product_unit").val();
            var price = $(".selected_product_price").val();
            var tax = $(".selected_product_tax").val();
            var is_lock_sales = $(
                ".selected_product_is_lock_sales"
            ).val();
            tr.find(".tampungan_product_id").val(id);
            tr.find(".tampungan_product_desc").val(desc);
            tr.find(".tampungan_product_unit").val(unit);
            tr.find(".tampungan_product_price").val(price);
            tr.find(".tampungan_product_tax").val(tax);
            tr.find(".tampungan_product_is_lock_sales").val(
                is_lock_sales
            );
            var tampungan_desc = tr.find(".tampungan_product_desc").val();
            var tampungan_unit = tr.find(".tampungan_product_unit").val();
            var tampungan_price = tr.find(".tampungan_product_price").val();
            var tampungan_tax = tr.find(".tampungan_product_tax").val();
            var tampungan_is_lock_sales = tr
                .find(".tampungan_product_is_lock_sales")
                .val();
            if (tampungan_is_lock_sales == 1) {
                tr.find(".unit_price_display").prop("readonly", true);
            } else if (tampungan_is_lock_sales == 0) {
                tr.find(".unit_price_display").prop("readonly", false);
            }
            tr.find(".unit_price_display").val(tampungan_price);
            tr.find(".desc").val(tampungan_desc);
            tr.find(".units")
                .val(tampungan_unit)
                .change();
            tr.find(".unit_price").val(tampungan_price);
            tr.find(".taxes")
                .val(tampungan_tax)
                .change();
            var tax = tr.find(".taxes option:selected").attr("rate");
            var price = tr.find(".unit_price_display").val() - 0;
            var qty = tr.find(".qty").val() - 0;
            var subtotal = qty * price;
            var taxtotal = (qty * price * tax) / 100;
            var total = subtotal + taxtotal;
            tr.find(".amount_display").val(subtotal);
            tr.find(".unit_price").val(price);
            tr.find(".amount").val(subtotal);
            tr.find(".amountsub").val(subtotal);
            tr.find(".amounttax").val(taxtotal);
            tr.find(".amountgrand").val(total);
            totalAmount();
            totalTax();
            totalSub();
            totalGrand();
        }
    );

    $(".contact_id").on("change select2-selecting", function() {
        var tr = $(this).closest("tr");
        var id = $(".selected_contact_id").val();
        var term = $(".selected_contact_term").val();
        var email = $(".selected_email").val();
        $(".tampungan_contact_id").val(id);
        $(".tampungan_contact_term").val(term);
        $(".tampungan_email").val(email);
        var tampungan_term = $(".tampungan_contact_term").val();
        var tampungan_email = $(".tampungan_email").val();
        $(".term")
            .val(tampungan_term)
            .change();
        $(".email_text").val(tampungan_email);
    });
});

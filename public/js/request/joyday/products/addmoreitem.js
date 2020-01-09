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
    $(".product_price_display").inputmask("IDR");
    $(".total_price_display").inputmask("IDR");
    $(".cost_amount_display").inputmask("IDR");
    $(".total_cost_display").inputmask("IDR");
    $(".total_grand_display").inputmask("IDR");
}

$(document).ready(function() {
    $(".select_product").select2({
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
        $(".selected_product_id").val(repo.id);
        $(".selected_product_avg_price").val(repo.avg_price);
        if (repo.code) {
            return (
                repo.code + " - " + repo.text || repo.code + " - " + repo.text
            );
        } else {
            return (
                repo.text || repo.text
            );
        }
    }

    function formatResult(result) {
        //console.log('%o', result);
        if (result.loading) return result.text;
        if(result.code){
            var html = "<a>" + result.code + " - " + result.text + "</a>";

        }else{
            var html = "<a>" + result.text + "</a>";

        }
        //return html;
        return $(html);
    }
    inputMasking();
    totalPrice();
    totalCost();
    totalGrand();
});

function totalPrice() {
    var t = 0;
    $(".hidden_product_price").each(function(i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });
    $(".total_price_display").val(t);
    $(".total_price_hidden").val(t);
}

function totalCost() {
    var t = 0;
    $(".hidden_cost_amount").each(function(i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });
    $(".total_cost_display").val(t);
    $(".total_cost_hidden").val(t);
}

function totalGrand() {
    var t = 0;
    var r = 0;
    $(".total_price_hidden").each(function(i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });
    $(".total_cost_hidden").each(function(i, e) {
        var amt = $(this).val() - 0;
        r += amt;
    });
    $(".total_grand_display").val(t + r);
    $(".total_grand_hidden").val(t + r);
}

$(function() {
    $(".add-item").click(function() {
        //var product = $(".product_id").html();
        tr =
            "<tr>" +
            "<td>" +
            '<div class="form-group">' +
            '<select class="form-control select_product product_id" name="product_id[]">' +
            //product +
            "</select>" +
            '<input class="selected_product_id" hidden>' +
            '<input class="selected_product_avg_price" hidden>' +
            '<input class="tampungan_product_id" hidden>' +
            '<input class="tampungan_product_avg_price" hidden>' +
            " </div>" +
            "</td>" +
            "<td>" +
            '<input onClick="this.select();" type="number" class="form-control qty" name="product_qty[]" value="0">' +
            "</td>" +
            "<td>" +
            '<input onClick="this.select();" type="text" class="form-control product_price_display" value="0" readonly>' +
            '<input type="text" class="hidden_product_id" name="product_id2[]" hidden>' +
            '<input type="text" class="hidden_product_price" name="product_price[]" value="0" hidden>' +
            "</td>" +
            "<td>" +
            '<input type="button" class="btn btn-danger delete" value="x">' +
            "</td>" +
            "</tr>";
        $(".neworderbody1").append(tr);
        $(".product_id").select2({
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
            $(".selected_product_id").val(repo.id);
            $(".selected_product_avg_price").val(repo.avg_price);
            if (repo.code) {
                return (
                    repo.code + " - " + repo.text || repo.code + " - " + repo.text
                );
            } else {
                return (
                    repo.text || repo.text
                );
            }
        }
    
        function formatResult(result) {
            //console.log('%o', result);
            if (result.loading) return result.text;
            if(result.code){
                var html = "<a>" + result.code + " - " + result.text + "</a>";
    
            }else{
                var html = "<a>" + result.text + "</a>";
    
            }
            //return html;
            return $(html);
        }
        inputMasking();
    });

    $(".neworderbody1").on("click", ".delete", function() {
        $(this)
            .parent()
            .parent()
            .remove();
        totalPrice();
        totalGrand();
    });

    $(".neworderbody1").on(
        "keyup change select2-selecting",
        ".product_id, .product_price_display",
        function() {
            var tr = $(this).closest("tr");
            var hidden_product_price = tr.find(".product_price_display").val();
            tr.find(".hidden_product_price").val(hidden_product_price);
            var id = $(".selected_product_id").val();
            var avg_price = $(".selected_product_avg_price").val();
            tr.find(".tampungan_product_id").val(id);
            tr.find(".tampungan_product_avg_price").val(avg_price);
            var tampungan_id = tr.find(".tampungan_product_id").val();
            var tampungan_avgprice = tr
                .find(".tampungan_product_avg_price")
                .val();
            var qty = tr.find(".qty").val();
            var total = qty * tampungan_avgprice;
            //alert("you selected : " + avg_price);
            tr.find(".hidden_product_id").val(tampungan_id);
            tr.find(".product_price_display").val(total);
            tr.find(".hidden_product_price").val(total);
            totalPrice();
            totalGrand();
        }
    );
    $(".neworderbody1").on("keyup change", ".qty", function() {
        var tr = $(this).closest("tr");
        var hidden_product_price = tr.find(".product_price_display").val();
        tr.find(".hidden_product_price").val(hidden_product_price);
        var tampungan_id = tr.find(".tampungan_product_id").val();
        var tampungan_avgprice = tr.find(".tampungan_product_avg_price").val();
        var qty = tr.find(".qty").val();
        var total = qty * tampungan_avgprice;
        //alert("you selected : " + avg_price);
        tr.find(".hidden_product_id").val(tampungan_id);
        tr.find(".product_price_display").val(total);
        tr.find(".hidden_product_price").val(total);
        totalPrice();
        totalGrand();
    });
});

$(function() {
    $(".add-cost").click(function() {
        var cost = $(".cost_id").html();
        tr =
            "<tr>" +
            '<td colspan="2">' +
            '<div class="form-group">' +
            '<select class="form-control selectaccount cost_id" name="cost_acc[]">' +
            cost +
            "</select>" +
            "</div>" +
            "</td>" +
            "<td>" +
            '<input onClick="this.select();" type="text" class="form-control cost_amount_display" value="0">' +
            '<input type="text" class="hidden_cost_amount" name="cost_amount[]" value="0" hidden>' +
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
        totalCost();
        totalGrand();
    });

    $(".neworderbody2").on("keyup change", ".cost_amount_display", function() {
        var tr = $(this)
            .parent()
            .parent();
        var hidden_cost_amount = tr.find(".cost_amount_display").val() - 0;
        tr.find(".hidden_cost_amount").val(hidden_cost_amount);
        totalCost();
        totalGrand();
    });
});

$(".sell_unit_price_display").on("keyup change", function() {
    var tr = $(this)
        .parent()
        .parent();
    var hidden_sell_unit_price = tr.find(".sell_unit_price_display").val() - 0;
    tr.find(".hidden_sell_unit_price").val(hidden_sell_unit_price);
});

$(".buy_unit_price_display").on("keyup change", function() {
    var tr = $(this)
        .parent()
        .parent();
    var hidden_buy_unit_price = tr.find(".buy_unit_price_display").val() - 0;
    tr.find(".hidden_buy_unit_price").val(hidden_buy_unit_price);
});

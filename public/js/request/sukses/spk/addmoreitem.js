$(function() {
    $(".add").click(function() {
        //var product = $(".product_id").html();
        tr =
            "<tr>" +
            "<td>" +
            '<div class="form-group">' +
            '<select class="form-control product_id" name="product[]">' +
            //product +
            "</select>" +
            '<input class="selected_product_id" hidden>' +
            '<input class="tampungan_product_id" name="product2[]" hidden>' +
            "</div>" +
            "</td>" +
            "<td>" +
            '<input onClick="this.select();" type="number" class="examount form-control qty" name="qty[]">' +
            '<input type="text" class="amount" hidden>' +
            "</td>" +
            "<td>" +
            '<input type="button" class="btn btn-danger delete" value="x">' +
            "</td>" +
            "</tr>";
        $(".neworderbody").append(tr);
        $(".product_id").select2({
            placeholder: "Select Product",
            width: "100%",
            //minimumInputLength: 1,
            delay: 250,
            allowClear: true,
            ajax: {
                url: "/spk/select_product",
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
            //$(".selected_product_avg_price").val(repo.avg_price);
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
    });

    $(".neworderbody").on("click", ".delete", function() {
        $(this)
            .parent()
            .parent()
            .remove();
    });
});

function selectProduct() {
    $(".select_product").select2({
        placeholder: "Select Product",
        width: "100%",
        //minimumInputLength: 1,
        delay: 250,
        allowClear: true,
        ajax: {
            url: "/spk/select_product",
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
        //$(".selected_product_avg_price").val(repo.avg_price);
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
}

function selectContact() {
    $(".select_contact").select2({
        placeholder: "Select Contact",
        width: "100%",
        //minimumInputLength: 1,
        delay: 250,
        allowClear: true,
        ajax: {
            url: "/spk/select_contact",
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

    $(".neworderbody").on(
        "change select2-selecting",
        ".product_id",
        function() {
            var tr = $(this).closest("tr");
            var id = $(".selected_product_id").val();
            tr.find(".tampungan_product_id").val(id);
        }
    );

    $(".contact_id").on("change select2-selecting", function() {
        var id = $(".selected_contact_id").val();
        $(".tampungan_contact_id").val(id);
    });
});

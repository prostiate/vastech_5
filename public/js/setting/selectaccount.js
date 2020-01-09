function selectAccount() {
    $(".select_account").select2({
        placeholder: "Select Account",
        width: "100%",
        //minimumInputLength: 1,
        delay: 250,
        allowClear: true,
        ajax: {
            url: "/coa/select_account",
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
        $(".selected_sales_revenue").val(repo.id);
        $(".selected_sales_discount").val(repo.id);
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

$(document).ready(function() {
    selectAccount();
    $(".select_account").on("change select2-selecting", function() {
        var sales_revenue = $(".selected_sales_revenue").val();
        var sales_discount = $(".selected_sales_discount").val();
        $(".tampungan_sales_revenue").val(sales_revenue);
        $(".tampungan_sales_discount").val(sales_discount);
    });
});

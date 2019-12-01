$(document).ready(function() {
    $(".selectterm").select2({
        width: "100%",
        placeholder: "Select Term"
    });

    $(".selectcustomer").select2({
        width: "100%",
        placeholder: "Select Customer"
    });

    $(".selectvendor").select2({
        width: "100%",
        placeholder: "Select Vendor"
    });

    $(".selectcontact").select2({
        width: "100%",
        placeholder: "Select Contact"
    });

    $(".selectwarehouse").select2({
        width: "100%",
        placeholder: "Select Warehouse"
    });

    $(".selectproduct_normal").select2({
        width: "100%",
        placeholder: "Select Product"
    });

    $(".selectmargin").select2({
        minimumResultsForSearch: -1
    });

    $(".selectunit").select2({
        width: "100%",
        placeholder: "Select Unit"
    });

    $(".selecttax").select2({
        width: "100%",
        placeholder: "Select Tax"
    });

    $(".selectidenfitytype").select2({
        width: "100%",
        placeholder: "Select..."
    });

    $(".selectaccountreceivable").select2({
        width: "100%",
        placeholder: "Select..."
    });

    $(".selectaccountpayable").select2({
        width: "100%",
        placeholder: "Select..."
    });

    $(".selectdefaultpayment").select2({
        width: "100%",
        placeholder: "Select..."
    });

    $(".selectbankname").select2({
        width: "100%",
        placeholder: "Bank Name"
    });

    /*$(".selectProduct").select2({
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
    });*/

    $(".selectcategory").select2({
        width: "100%",
        placeholder: "Select Category"
    });

    $(".selectadjustmentcategory").select2({
        width: "100%",
        placeholder: "Select Adjustment Category"
    });

    $(".selectadjustmentaccount").select2({
        width: "100%",
        placeholder: "Select Account"
    });

    $(".selectaccount").select2({
        width: "100%",
        allowClear: true,
        placeholder: "Select Account"
    });

    $(".selectexpense").select2({
        width: "100%",
        placeholder: "Select Expense"
    });

    /// SELECT PRODUCT
    /*$(".selectproduct").select2({
        placeholder: "Select Product",
        width: "100%",
        //minimumInputLength: 1,
        delay: 250,
        allowClear: true,
        ajax: {
            url: "/selectProduct",
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
    });*/

    $(".selectproduct").select2({
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

    function formatRepoSelection(data) {
        $(".selected_product_id").val(data.id);
        $(".selected_product_avg_price").val(data.avg_price);
        return data.text || data.text;
    }

    function formatResult(data) {
        //console.log('%o', result);
        if (data.loading) return data.text;
        var html = "<a>" + data.text + "</a>";
        //return html;
        return $(html);
    }
});

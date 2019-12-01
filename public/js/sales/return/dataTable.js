$(document).ready(function() {
    $("#dataTable").DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [0, "desc"],
        ajax: {
            url: "/sales_return"
        },
        columns: [
            {
                data: "transaction_date",
                searchable: false,
                render: $.fn.dataTable.render.text(),
            },
            {
                data: "number",
                render: function(data, type, row) {
                    return (
                        '<a href="/sales_return/' +
                        row.id +
                        '"> Sales Return #' +
                        row.number +
                        "</a>"
                    );
                }
            },
            {
                data: "sale_invoice.number",
                render: function(data, type, row) {
                    return (
                        '<a href="/sales_invoice/' +
                        row.sale_invoice.id +
                        '">Sales Invoice #' +
                        row.sale_invoice.number +
                        "</a>"
                    );
                }
            },
            {
                data: "sale_invoice.transaction_date",
                searchable: false,
                render: $.fn.dataTable.render.text(),
            },
            {
                data: "sale_invoice.due_date",
                searchable: false,
                render: $.fn.dataTable.render.text(),
            },
            {
                data: "grandtotal",
                className: "text-right",
                render: $.fn.dataTable.render.number(".", ",", 2, "Rp "),
            },
        ]
    });
});
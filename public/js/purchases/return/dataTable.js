$(document).ready(function() {
    $("#dataTable").DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [0, "desc"],
        ajax: {
            url: "/purchases_return"
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
                        '<a href="/purchases_return/' +
                        row.id +
                        '"> Purchase Return #' +
                        row.number +
                        "</a>"
                    );
                }
            },
            {
                data: "purchase_invoice.number",
                render: function(data, type, row) {
                    return (
                        '<a href="/purchases_invoice/' +
                        row.purchase_invoice.id +
                        '">Purchase Invoice #' +
                        row.purchase_invoice.number +
                        "</a>"
                    );
                }
            },
            {
                data: "purchase_invoice.transaction_date",
                searchable: false,
                render: $.fn.dataTable.render.text(),
            },
            {
                data: "purchase_invoice.due_date",
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
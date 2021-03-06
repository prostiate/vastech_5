$(document).ready(function() {
    $("#dataTable").DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[0, "desc"], [7, "asc"]],
        ajax: {
            url: "/purchases_invoice"
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
                        '<a href="/purchases_invoice/' +
                        row.id +
                        '"> Purchase Invoice #' +
                        row.number +
                        "</a>"
                    );
                }
            },
            {
                data: "contact.display_name",
                render: function(data, type, row) {
                    return (
                        '<a href="/contacts/' +
                        row.contact.id +
                        '">' +
                        row.contact.display_name +
                        "</a>"
                    );
                }
            },
            {
                data: "warehouse.name",
                render: function(data, type, row) {
                    return (
                        '<a href="/warehouses/' +
                        row.warehouse.id +
                        '">' +
                        row.warehouse.name +
                        "</a>"
                    );
                }
            },
            {
                data: "due_date",
                searchable: false,
                render: $.fn.dataTable.render.text(),
            },
            {
                data: "balance_due",
                className: "text-right",
                render: $.fn.dataTable.render.number(".", ",", 2, "Rp "),
            },
            {
                data: "grandtotal",
                className: "text-right",
                render: $.fn.dataTable.render.number(".", ",", 2, "Rp "),
            },
            {
                data: "status.name",
                className: "text-center",
                searchable: false,
                render: $.fn.dataTable.render.text(),
            }
        ]
    });
});
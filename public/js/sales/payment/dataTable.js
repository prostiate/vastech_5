$(document).ready(function() {
    $("#dataTable").DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[0, "desc"]],
        ajax: {
            url: "/sales_payment"
        },
        columns: [
            {
                data: "transaction_date",
                render: $.fn.dataTable.render.text()
            },
            {
                data: "number",
                render: function(data, type, row) {
                    return (
                        '<a href="/sales_payment/' +
                        row.id +
                        '"> Sales Payment #' +
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
                data: "coa.name",
                render: function(data, type, row) {
                    return (
                        '<a href="/chart_of_accounts/' +
                        row.coa.id +
                        '">' +
                        row.coa.name +
                        "</a>"
                    );
                }
            },
            {
                data: "grandtotal",
                className: "text-right",
                render: $.fn.dataTable.render.number(".", ",", 2, "Rp "),
            },
            {
                data: "status.name",
                className: "text-center",
                render: $.fn.dataTable.render.text()
            }
        ]
    });
});

$(document).ready(function() {
    $("#dataTable").DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[6, "asc"], [0, "desc"]],
        ajax: {
            url: "/expenses"
        },
        columns: [
            {
                data: "transaction_date",
                searchable: false,
                render: $.fn.dataTable.render.text()
            },
            {
                data: "number",
                render: function(data, type, row) {
                    return (
                        '<a href="/expenses/' +
                        row.id +
                        '">Expense #' +
                        row.number +
                        "</a>"
                    );
                }
            },
            {
                data: "expense_contact.display_name",
                render: function(data, type, row) {
                    return (
                        '<a href="/contacts/' +
                        row.expense_contact.id +
                        '">' +
                        row.expense_contact.display_name +
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
                data: "balance_due",
                className: "text-right",
                render: $.fn.dataTable.render.number(".", ",", 2, "Rp ")
            },
            {
                data: "grandtotal",
                className: "text-right",
                render: $.fn.dataTable.render.number(".", ",", 2, "Rp ")
            },
            {
                data: "status.name",
                className: "text-center",
                searchable: false,
                render: $.fn.dataTable.render.text()
            }
        ]
    });
});

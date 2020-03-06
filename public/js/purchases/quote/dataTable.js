$(document).ready(function() {
    $("#dataTable").DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[0, "desc"], [5, "asc"]],
        ajax: {
            url: "/purchases_quote"
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
                        '<a href="/purchases_quote/' +
                        row.id +
                        '">Purchase Quote #' +
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
                data: "due_date",
                searchable: false,
                render: $.fn.dataTable.render.text()
            },
            {
                data: "grandtotal",
                className: "text-right",
                render: $.fn.dataTable.render.number(".", ",", 2, "Rp ")
            },
            {
                data: "status.name",
                className: "text-center",
                render: $.fn.dataTable.render.text()
            }
        ]
    });
});

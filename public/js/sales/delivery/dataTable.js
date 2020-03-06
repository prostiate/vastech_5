$(document).ready(function() {
    $("#dataTable").DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[0, "desc"], [3, "asc"]],
        ajax: {
            url: "/sales_delivery"
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
                        '<a href="/sales_delivery/' +
                        row.id +
                        '"> Sales Delivery #' +
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
                data: "status.name",
                className: "text-center",
                render: $.fn.dataTable.render.text()
            }
        ]
    });
});

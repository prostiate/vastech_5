$(document).ready(function() {
    $("#dataTable").DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[0, "desc"], [5, "asc"]],
        ajax: {
            url: "/sales_order"
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
                        '<a href="/sales_order/' +
                        row.id +
                        '">Sales Order #' +
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
            /*{
                data: "deposit",
                name: "deposit",
                render:function(data, type, row){
                    return '<a>Rp ' + row.deposit + '</a>'
                },
            },*/
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

$(document).ready(function() {
    $("#dataTable").DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[0, "asc"]],
        ajax: {
            url: "/contacts_other"
        },
        columns: [
            {
                data: "company_name",
                render: $.fn.dataTable.render.text()
            },
            {
                data: "display_name",
                render: function(data, type, row) {
                    return (
                        '<a href="/contacts/' +
                        row.id +
                        '">' +
                        row.display_name +
                        "</a>"
                    );
                }
            },
            {
                data: "billing_address",
                render: $.fn.dataTable.render.text()
            },
            {
                data: "shipping_address",
                render: $.fn.dataTable.render.text()
            },
            {
                data: "email",
                render: $.fn.dataTable.render.text()
            },
            {
                data: "handphone",
                render: $.fn.dataTable.render.text()
            },
            {
                data: "limit_balance",
                className: "text-right",
                render: $.fn.dataTable.render.number(".", ",", 2, "Rp "),
            },
            {
                data: "current_limit_balance",
                className: "text-right",
                render: $.fn.dataTable.render.number(".", ",", 2, "Rp "),
            }
        ]
    });
});

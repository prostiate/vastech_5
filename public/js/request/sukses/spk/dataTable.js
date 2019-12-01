$(document).ready(function() {
    $("#dataTable").DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[0, "desc"]],
        ajax: {
            url: "/spk"
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
                        '<a href="/spk/' +
                        row.id +
                        '">SPK #' +
                        row.number +
                        "</a>"
                    );
                }
            },
            {
                data: "vendor_ref_no",
                render: function(data, type, row) {
                    return (
                        '<a href="/spk/' +
                        row.id +
                        '">' +
                        row.vendor_ref_no +
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
                data: "desc",
                render: $.fn.dataTable.render.text()
            },
            {
                data: "spk_status.name",
                className: "text-center",
                searchable: false,
                render: $.fn.dataTable.render.text()
            }
        ]
    });
});

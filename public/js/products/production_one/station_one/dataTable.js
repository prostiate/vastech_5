$(document).ready(function() {
    $("#dataTable").DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[1, "asc"]],
        ajax: {
            url: "/production_one"
        },
        columns: [
            {
                data: "number",
                name: "number",
                render: function(data, type, row) {
                    if (row.number == null) {
                        return "<h5>-</h5>";
                    } else {
                        return (
                            '<h5><a href="/production_one/' +
                            row.id +
                            '">Production One #' +
                            row.number +
                            "</a></h5>"
                        );
                    }
                }
            },
            {
                data: "transaction_date",
                name: "transaction_date",
                render: function(data, type, row) {
                    return (
                        '<h5><a href="/products/' +
                        row.id +
                        '">' +
                        row.transaction_date +
                        "</a></h5>"
                    );
                }
            },
            {
                data: "contact.display_name",
                name: "contact.display_name",
                render: function(data, type, row) {
                    return "<h5>" + row.contact.display_name + "</h5>";
                }
            },
            {
                data: "warehouse.name",
                name: "warehouse.name",
                render: function(data, type, row) {
                    return "<h5>" + row.warehouse.name + "</h5>";
                }
            },
            {
                data: "desc",
                name: "desc",
                render: function(data, type, row) {
                    return "<h5>" + row.desc + "</h5>";
                }
            },
            {
                data: "status.name",
                name: "status.name",
                render: function(data, type, row) {
                    return "<h5>" + row.status.name + "</h5>";
                }
            }
        ]
    });
});

$(document).ready(function() {
    $("#dataTable").DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[1, "asc"]],
        ajax: {
            url: "/production_three"
        },
        columns: [
            {
                data: "number",
                name: "number",
                render: function(data, type, row) {
                    if (row.number == null) {
                        return "<h5>-</h5>";
                    } else {
                        return '<h5><a href="/production_three/' + row.id + '">Production Three #' + row.number + '</a></h5>';
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
            },
            {
                data: "warehouse.name",
                name: "warehouse.name",
            },
            {
                data: "desc",
                name: "desc",
            },
            {
                data: "status.name",
                name: "status.name",
            },
        ]
    });
});

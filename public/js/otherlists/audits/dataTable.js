$(document).ready(function() {
    $("#dataTable").DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[0, "asc"]],
        ajax: {
            url: "/other/audits"
        },
        columns: [
            {
                data: "user.name",
                render: $.fn.dataTable.render.text()
            },
            {
                data: "event",
                render: $.fn.dataTable.render.text()
            },
            {
                data: "auditable_type",
                render: $.fn.dataTable.render.text()
            },
            {
                data: "old_values",
                render: $.fn.dataTable.render.text()
            },
            {
                data: "new_values",
                render: $.each("new_values", function(i, star) {
                    $("#stars").append(
                        '<input type="text" id="star" value="' + star + '" />'
                    );
                })
            },
            {
                data: "ip_address",
                render: $.fn.dataTable.render.text()
            }
        ]
    });
});

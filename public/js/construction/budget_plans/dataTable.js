$(document).ready(function() {
    $("#dataTable").DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[0, "asc"]],
        ajax: {
            url: "/construction/budget_plan"
        },
        columns: [
            {
                data: "project",
                render: function(data, type, row) {
                    return (
                        '<a href="/construction/project>' +
                        row.project.name +
                        "</a>"
                    );
                }
            },
            {
                data: "date",
                render: $.fn.dataTable.render.text()
            },
            {
                data: "status",
                render: $.fn.dataTable.render.text()
            }
        ]
    });
});

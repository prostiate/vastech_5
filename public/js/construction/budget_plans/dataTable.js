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
                data: "project_id",
                render: function(data, type, row) {
                    return (
                        '<a href="/construction/budget_plan/area/' +
                        row.id +
                        '">' +
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

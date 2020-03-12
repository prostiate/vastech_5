$(document).ready(function() {
    $("#dataTable").DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[0, "asc"]],
        ajax: {
            url: "/other/units"
        },
        columns: [
            {
                data: "name",
                name: "name"
            },
            {
                data: "action",
                name: "action"
            }
        ]
    });
});

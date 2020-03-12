$(document).ready(function() {
    $("#dataTable").DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[0, 'asc']],
        ajax: {
            url: "/other/audits"
        },
        columns: [
            {
                data: "user_id",
                name: "user_id",
            }
            ,
            {
                data: "event",
                name: "event",
            }
            ,
            {
                data: "auditable_type",
                name: "auditable_type",
            }
            ,
            {
                data: "old_values",
                name: "old_values",
            }
            ,
            {
                data: "new_values",
                name: "new_values",
            }
            ,
            {
                data: "ip_address",
                name: "ip_address",
            }
        ]
    });

});

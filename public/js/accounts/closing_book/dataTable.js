$(document).ready(function() {
    var user_id;
    user_id = $(this).attr('id');
    $("#dataTable").DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[0, 'asc']],
        ajax: {
            url: "/closing_book"
        },
        columns: [
            {
                data: "start_period",                
                render: function (data, type, row) {
                    if (row.status == 1) {
                        return '<a href="closing/statement">' + row.end_period + '  -  ' + row.start_period + '</a>'
                    } else {
                        return '<a>' + row.end_period + ' - ' + row.start_period + '</a>'
                    }
                }                
            },
            {
                data: "memo",
            },            
            {
                data: "net_profit",
            },  
            {
                data: "action",
                name: "action",
            }            
        ]
    });

    $(document).on('click', '.go', function () {
        tr = $(this).closest('tr');
        user_id = tr.find('.pilih').val();
        window.location.href = user_id;
    });

    var actions = [
        "Change Period",
        "Check Reconciliations",
        "Worksheet",
        "Delete Draft"
    ];    
});

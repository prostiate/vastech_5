$(document).ready(function() {
    var ids = document.getElementById('hidden_id').value ;
    $("#dataTable2").DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[0, 'asc']],
        ajax: {
            url: "/chart_of_accounts/" + ids
        },
        columns: [
            {
                data: "number",
                name: "number",
            },
            {
                data: "date",
                name: "date",
                searchable: false
            },
            {
                data: "contact_id",
                name: "contact_id",
            },
            {
                data: "debit",
                name: "debit",
                render:function(data, type, row){
                    return '<a>Rp ' + row.debit + '</a>'
                },
            },
            {
                data: "credit",
                name: "credit",
                render:function(data, type, row){
                    return '<a>Rp ' + row.credit + '</a>'
                },
            },
            {
                data: "balance",
                name: "balance",
                render:function(data, type, row){
                    return '<a>Rp ' + row.balance + '</a>'
                },
            },
            {
                data: "action",
                name: "action",
                orderable: false,
                searchable: false
            }
        ]
    });

    $(document).on('click', '.delete', function() {
        user_id = $(this).attr('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "/chart_of_accounts/delete/" + user_id,
                    success: function(data) {
                        var html = "";
                        var typeswal = "";
                        var titleswal = "";
                        if (data.errors) {
                            typeswal = "error";
                            titleswal = "Oops...";
                            html = data.errors;
                        }
                        if (data.success) {
                            typeswal = "success";
                            titleswal = "Success...";
                            html = data.success;
                            $('#dataTable').DataTable().ajax.reload();
                        }
                        Swal.fire({
                            type: typeswal,
                            title: titleswal,
                            html: html
                        });
                    }
                })
                Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                )
            }
        })
    });

    $(document).on('click', '.edit', function() {
        user_id = $(this).attr('id');
        window.location.href = '/chart_of_accounts/edit/' + user_id;
    });
});

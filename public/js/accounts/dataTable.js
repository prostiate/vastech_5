$(document).ready(function() {
    var user_id;
    user_id = $(this).attr('id');
    $("#dataTable").DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[0, 'asc']],
        ajax: {
            url: "/chart_of_accounts"
        },
        columns: [
            {
                data: "code",
                name: "code",
                
            },
            {
                data: "name",
                name: "name",
                render:function(data, type, row){
                    return '<a href="/chart_of_accounts/' + row.id + '">' + row.name + '</a>'
                },
            },
            {
                data: "coa_category.name",
                name: "coa_category.name",
                searchable: false
            },
            {
                data: "default_tax",
                name: "default_tax",
                searchable: false
            },
            {
                data: "balance",
                name: "balance",
                searchable: false
            },
            {
                data: "action",
                name: "action",
                orderable: false,
                searchable: false
            }
        ]
    });

    $("#dataTable2").DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[0, 'asc']],
        ajax: {
            url: "/chart_of_accounts/" + user_id
        },
        columns: [
            {
                data: "number",
                name: "number",
                
            },
            {
                data: "date",
                name: "date",
            },
            {
                data: "contact_id",
                name: "contact_id",
                searchable: false
            },
            {
                data: "debit",
                name: "debit",
                searchable: false
            },
            {
                data: "credit",
                name: "credit",
                searchable: false
            },
            {
                data: "balance",
                name: "balance",
                searchable: false
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

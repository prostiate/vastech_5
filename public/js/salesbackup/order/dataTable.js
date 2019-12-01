$(document).ready(function() {
    $("#dataTable").DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[1, 'asc']],
        ajax: {
            url: "/sales_order"
        },
        columns: [
            {
                data: "number",
                name: "number",
                render:function(data, type, row){
                    return '<a href="/sales_order/' + row.id + '">' + row.number + '</a>'
                },
            },
            {
                data: "transaction_date",
                name: "transaction_date",
            },
            {
                data: "contact.display_name",
                name: "contact.display_name",
                render:function(data, type, row){
                    return '<a href="/contacts/' + row.contact.id + '">' + row.contact.display_name + '</a>'
                },
            },
            {
                data: "due_date",
                name: "due_date",
                searchable: false
            },
            {
                data: "subtotal",
                name: "subtotal",
            },
            {
                data: "grandtotal",
                name: "grandtotal",
            },
            {
                data: "status",
                name: "status",
                orderable: false,
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

    var user_id;

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
                    url: "/sales_order/delete/" + user_id,
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
        window.location.href = '/sales_order/edit/' + user_id;
    });
});

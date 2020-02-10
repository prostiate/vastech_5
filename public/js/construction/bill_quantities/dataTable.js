$(document).ready(function() {
    $("#dataTable").DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[1, 'asc']],
        ajax: {
            url: "/expenses"
        },
        columns: [
            {
                data: "expense_number",
                name: "expense_number",
                render:function(data, type, row){
                    return '<a href="/expenses/' + row.id + '">' + row.expense_number + '</a>'
                },
            },
            {
                data: "expense_transaction_date",
                name: "expense_transaction_date",
            },
            {
                data: "expense_contact.display_name",
                name: "expense_contact.display_name",
                render:function(data, type, row){
                    return '<a href="/contacts/' + row.expense_contact.id + '">' + row.expense_contact.display_name + '</a>'
                },
            },
            {
                data: "expense_due_date",
                name: "expense_due_date",
                searchable: false
            },
            {
                data: "expense_subtotal",
                name: "expense_subtotal",
            },
            {
                data: "expense_grandtotal",
                name: "expense_grandtotal",
            },
            {
                data: "expense_memo",
                name: "expense_memo",
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
                    url: "/expenses/delete/" + user_id,
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
        window.location.href = '/expenses/edit/' + user_id;
    });
});

$(document).ready(function() {
    $("#dataTableActive").DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[0, "desc"]],
        ajax: {
            url: "/asset_managements"
        },
        columns: [
            {
                data: "asset_account",
                name: "asset_account"
            },
            {
                data: "date",
                name: "date"
            },
            {
                data: "name",
                name: "name"
            },
            {
                data: "cost",
                name: "cost"
            },
            {
                data: "cost",
                name: "cost"
            }
        ]
    }); /*

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
                    url: "/purchases_invoice/delete/" + user_id,
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
        window.location.href = '/purchases_invoice/edit/' + user_id;
    });*/
});

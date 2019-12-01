$(document).ready(function() {
    $("#dataTable").DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[1, 'asc']],
        ajax: {
            url: "/warehouses"
        },
        columns: [
            {
                data: "code",
                name: "code",
                render: function(data, type, row) {
                    if (row.code == null) {
                        return "<a>-</a>";
                    } else {
                        return "<a>" + row.code + "</a>";
                    }
                }
            },
            {
                data: "name",
                name: "name",
                render: function(data, type, row) {
                    if (row.name == null) {
                        return "<a>-</a>";
                    } else {
                        return '<a href="/warehouses/' + row.id + '">' + row.name + '</a></a>';
                    }
                }
                
            },
            {
                data: "address",
                name: "address",
                searchable: false,
                render: function(data, type, row) {
                    if (row.address == null) {
                        return "<a>-</a>";
                    } else {
                        return "<a>" + row.address + "</a>";
                    }
                }
            },
            {
                data: "desc",
                name: "desc",
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    if (row.desc == null) {
                        return "<a>-</a>";
                    } else {
                        return "<a>" + row.desc + "</a>";
                    }
                }
            },/*
            {
                data: "action",
                name: "action",
                orderable: false,
                searchable: false
            }*/
        ]
    });/*

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
                    url: "/warehouses/delete/" + user_id,
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
                        }
                        Swal.fire({
                            type: typeswal,
                            title: titleswal,
                            html: html
                        });
                        $('#dataTable').DataTable().ajax.reload();
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
        window.location.href = '/warehouses/edit/' + user_id;
    });*/
});

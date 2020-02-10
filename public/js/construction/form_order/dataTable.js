$(document).ready(function() {
    $("#dataTable").DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[0, 'asc']],
        ajax: {
            url: "/other/taxes"
        },
        columns: [
            {
                data: "name",
                name: "name",
                render:function(data, type, row){
                    return '<a href="/other/taxes/' + row.id + '">' + row.name + '</a>'
                },
            },
            {
                data: "rate",
                name: "rate",
                searchable: false
            },
            {
                data: "sell_tax_account",
                name: "sell_tax_account",
                render:function(data, type, row){
                    return '<a href="/chart_of_accounts/' + row.sell_tax_account + '">' + row.coa_sell.name + '</a>'
                },
            },
            {
                data: "buy_tax_account",
                name: "buy_tax_account",
                render:function(data, type, row){
                    return '<a href="/chart_of_accounts/' + row.buy_tax_account + '">' + row.coa_buy.name + '</a>'
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
                    url: "/other/taxes/delete/" + user_id,
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
        window.location.href = '/other/taxes/edit/' + user_id;
    });
});

$(document).ready(function() {
    $("#dataTable").DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[0, "asc"]],
        ajax: {
            url: "/construction/offering_letter"
        },
        columns: [
            {
                data: "name",
                render: function(data, type, row) {
                    return (
                        '<a href="/construction/offering_letter/' +
                        row.id +
                        '">' +
                        row.name +
                        "</a>"
                    );
                }
            },
            {
                data: "address",
                render: $.fn.dataTable.render.text()
            }
        ]
    });

    var user_id;

    $(document).on("click", ".delete", function() {
        user_id = $(this).attr("id");
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then(result => {
            if (result.value) {
                $.ajax({
                    url: "/other/payment_methods/delete/" + user_id,
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
                            $("#dataTable")
                                .DataTable()
                                .ajax.reload();
                        }
                        Swal.fire({
                            type: typeswal,
                            title: titleswal,
                            html: html
                        });
                    }
                });
                Swal.fire("Deleted!", "Your file has been deleted.", "success");
            }
        });
    });

    $(document).on("click", ".edit", function() {
        user_id = $(this).attr("id");
        window.location.href = "/other/payment_methods/edit/" + user_id;
    });
});

$(document).ready(function() {
    $("#dataTable").DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[0, "asc"]],
        ajax: {
            url: "/construction/form_order"
        },
        columns: [
            {
                data: "name",
                render: function(data, type, row) {
                    return (
                        '<a href="/construction/form_order/' +
                        row.id +
                        '">' +
                        row.name +
                        "</a>"
                    );
                }
            },
            {
                data: "bill_quantities_id",
                render: $.fn.dataTable.render.text()
            },
            {
                data: "status",
                render: $.fn.dataTable.render.text()
            },
            {
                data: "grandtotal",
                render: $.fn.dataTable.render.number(".", ",", 2, "Rp ")
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
                    url: "/construction/form_order/delete/" + user_id,
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
        window.location.href = "/construction/form_order/edit/" + user_id;
    });
});

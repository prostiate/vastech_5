$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    }
});

$(document).ready(function() {
    $("#dataTable").DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[0, "asc"]],
        ajax: {
            url: "/construction/project"
        },
        columns: [
            {
                data: "name",
                render: $.fn.dataTable.render.text()
            },
            {
                data: "number",
                render: $.fn.dataTable.render.text()
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
                    url: "/construction/project/delete/" + user_id,
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
            }
        });
    });

    $(document).on("click", ".edit", function() {
        user_id = $(this).attr("id");
        project_name = $(this).attr("project_name");
        project_number = $(this).attr("project_number");
        $("#name").val(project_name);
        $("#number").val(project_number);
        $("#hidden_id").val(user_id);
        $("#edit_modal").modal("show");
    });

    $(document).ready(function() {
        $("#click").click(function() {
            event.preventDefault();
            var form = document.getElementById("formCreate");
            $.ajax({
                url: "/construction/project/newPR",
                method: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                success: function(data) {
                    var html = "";
                    var typeswal = "";
                    var titleswal = "";
                    if (data.errors) {
                        typeswal = "error";
                        titleswal = "Oops...";
                        for (
                            var count = 0;
                            count < data.errors.length;
                            count++
                        ) {
                            html += data.errors[count];
                        }
                    }
                    if (data.success) {
                        typeswal = "success";
                        titleswal = "Success...";
                        html = data.success;
                        $("#dataTable")
                            .DataTable()
                            .ajax.reload();
                        $("#create_modal").modal("hide");
                    }
                    Swal.fire({
                        type: typeswal,
                        title: titleswal,
                        html: html
                    });
                }
            });
        });
        $("#clickUpdate").click(function() {
            event.preventDefault();
            var form = document.getElementById("formUpdate");
            $.ajax({
                url: "/construction/project/updatePR",
                method: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                success: function(data) {
                    var html = "";
                    var typeswal = "";
                    var titleswal = "";
                    if (data.errors) {
                        typeswal = "error";
                        titleswal = "Oops...";
                        for (
                            var count = 0;
                            count < data.errors.length;
                            count++
                        ) {
                            html += data.errors[count];
                        }
                    }
                    if (data.success) {
                        typeswal = "success";
                        titleswal = "Success...";
                        html = data.success;
                        $("#dataTable")
                            .DataTable()
                            .ajax.reload();
                        $("#edit_modal").modal("hide");
                    }
                    Swal.fire({
                        type: typeswal,
                        title: titleswal,
                        html: html
                    });
                }
            });
        });
    });
});

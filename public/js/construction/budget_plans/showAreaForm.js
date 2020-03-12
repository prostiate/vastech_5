$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    }
});
$(document).ready(function() {
    $("#clickDeleteSelectedArea").click(function() {
        event.preventDefault();
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
                    url:
                        "/construction/budget_plan/deleteArea/" +
                        $(this).attr("value"),
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
                            window.location.href =
                                "/construction/budget_plan/area/" + data.id;
                        }
                        Swal.fire({
                            type: typeswal,
                            title: titleswal,
                            html: html
                        });
                    }
                });
                //Swal.fire("Deleted!", "Your file has been deleted.", "success");
            }
        });
    });
    $("#clickExecute").click(function() {
        event.preventDefault();
        var form = document.getElementById("formCreate");
        $.ajax({
            url: "/construction/budget_plan/addOrUpdateAreaName",
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
                    for (var count = 0; count < data.errors.length; count++) {
                        html += data.errors[count];
                    }
                }
                if (data.success) {
                    typeswal = "success";
                    titleswal = "Success...";
                    html = data.success;
                    window.location.href =
                        "/construction/budget_plan/area/" + data.id;
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
function emptySelectedArea(id) {
    event.preventDefault();
    var form = document.getElementById("formCreate");
    $.ajax({
        url: "/construction/budget_plan/emptyArea/" + id,
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
                for (var count = 0; count < data.errors.length; count++) {
                    html += data.errors[count];
                }
            }
            if (data.success) {
                typeswal = "success";
                titleswal = "Success...";
                html = data.success;
                window.location.href =
                    "/construction/budget_plan/area/" + data.id;
            }
            Swal.fire({
                type: typeswal,
                title: titleswal,
                html: html
            });
        }
    });
}

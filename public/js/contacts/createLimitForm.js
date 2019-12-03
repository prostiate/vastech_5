$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    }
});
$(document).ready(function() {
    $("#clickLimit").click(function() {
        event.preventDefault();
        $("#clickLimit").prop("disabled", true);
        $("#clickLimit").html("Processing");
        var form = document.getElementById("formCreate");
        var id = document.getElementById("hidden_id").value;
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, create it!"
        }).then(result => {
            if (result.value) {
                $.ajax({
                    url: "/contacts/newContactLimit/" + id,
                    method: "POST",
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    timeout: 5000,
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
                            $("#clickLimit").prop("disabled", false);
                            $("#clickLimit").html("Create");
                        }
                        if (data.success) {
                            typeswal = "success";
                            titleswal = "Success...";
                            html = data.success;
                            window.location.href = "/contacts/" + data.id;
                        }
                        Swal.fire({
                            type: typeswal,
                            title: titleswal,
                            html: html
                        });
                    }
                });
                //Swal.fire("Deleted!", "Your file has been deleted.", "success");
            } else {
                $("#clickLimit").prop("disabled", false);
                $("#clickLimit").html("Create");
            }
        });
    });
});

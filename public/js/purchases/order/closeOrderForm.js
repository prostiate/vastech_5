$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    }
});
$(document).ready(function() {
    $("#clickClose").click(function() {
        event.preventDefault();
        $("#clickClose").prop("disabled", true);
        $("#clickClose").html("Processing");
        var user_id = document.getElementById("form_id").value;
        Swal.fire({
            title: "Are you sure to close this order?",
            text:
                "Once it is closed you will no longer be able to create invoice from this order.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, close it!"
        }).then(result => {
            if (result.value) {
                $.ajax({
                    url: "/purchases_order/closeOrder/" + user_id,
                    method: "POST",
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
                            $("#clickClose").prop("disabled", false);
                            $("#clickClose").html("Close Order");
                        }
                        if (data.success) {
                            typeswal = "success";
                            titleswal = "Success...";
                            html = data.success;
                            window.location.href =
                                "/purchases_order/" + data.id;
                        }
                        Swal.fire({
                            type: typeswal,
                            title: titleswal,
                            html: html
                        });
                    }
                });
            } else {
                $("#clickClose").prop("disabled", false);
                $("#clickClose").html("Close Order");
            }
        });
    });
});

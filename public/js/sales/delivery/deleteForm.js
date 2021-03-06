$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    }
});
$(document).ready(function() {
    $("#click").click(function() {
        event.preventDefault();
        $('#click').prop('disabled', true);
        $('#click').html('Processing');
        var user_id = document.getElementById("form_id").value;
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
                    url: "/sales_delivery/delete/" + user_id,
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
                            $('#click').prop('disabled', false);
                            $('#click').html('Delete');
                        }
                        if (data.success) {
                            typeswal = "success";
                            titleswal = "Success...";
                            html = data.success;
                            window.location.href = "/sales_delivery";
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
});

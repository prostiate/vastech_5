$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    }
});
$(document).ready(function() {
    $("#click").click(function() {
        event.preventDefault();
        var form = document.getElementById("formCreate");
        var hidden_id = $("#hidden_id").val();
        $.ajax({
            url: "/sales_order/updateSOrder",
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
                    for (var count = 0; count < data.errors.length; count++) {
                        html += "<br>" + data.errors[count] + "</br>";
                    }
                }
                if (data.success) {
                    typeswal = "success";
                    titleswal = "Success...";
                    html = data.success;
                    window.location.href = "/sales_order/"/* + hidden_id*/;
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

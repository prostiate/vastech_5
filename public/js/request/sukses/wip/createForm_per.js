$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    }
});
$(document).ready(function() {
    $("#click_per").click(function() {
        event.preventDefault();
        $("#click_per").prop("disabled", true);
        $("#click_per").html("Processing");
        var form = document.getElementById("formCreate");
        $.ajax({
            url: "/wip/newWIP_per",
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
                        html += data.errors[count];
                    }
                    $("#click_per").prop("disabled", false);
                    $("#click_per").html("Create");
                }
                if (data.success) {
                    typeswal = "success";
                    titleswal = "Success...";
                    html = data.success;
                    window.location.href = "/wip/" + data.id;
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
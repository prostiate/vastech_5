$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    }
});
$(document).ready(function() {
    $("#draft_btn").click(function() {
        event.preventDefault();
        $('#draft_btn').prop('disabled', true);
        $('#draft_btn').html('Processing');
        var form = document.getElementById("formCreate");
        $.ajax({
            url: "/conversion_balance/update",
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
                    $('#draft_btn').prop('disabled', false);
                    $('#draft_btn').html('Draft');
                }
                if (data.success) {
                    typeswal = "success";
                    titleswal = "Success...";
                    html = data.success;
                    $('#draft_btn').prop('disabled', false);
                    $('#draft_btn').html('Draft');
                }
                Swal.fire({
                    type: typeswal,
                    title: titleswal,
                    html: html
                });
            }
        });
    });

    $("#modal_draft_btn").click(function() {
        event.preventDefault();
        $('#modal_draft_btn').prop('disabled', true);
        $('#modal_draft_btn').html('Processing');
        var form = document.getElementById("formCreate");
        $.ajax({
            url: "/conversion_balance/update",
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
                    $('#modal_draft_btn').prop('disabled', false);
                    $('#modal_draft_btn').html('Draft');
                }
                if (data.success) {
                    typeswal = "success";
                    titleswal = "Success...";
                    html = data.success;
                    $('#modal_draft_btn').prop('disabled', false);
                    $('#modal_draft_btn').html('Draft');
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

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    }
});
$(document).ready(function() {
    $("#click").click(function() {
        event.preventDefault();
        $('#click').prop('disabled', true);
        $("#click").html("Processing");
        var form = document.getElementById("formCreate");
        $.ajax({
            url: "/cashbank/newBankAccount",
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
                    $('#click').prop('disabled', false);
                    $('#click').html('Create');
                }
                if (data.success) {
                    typeswal = "success";
                    titleswal = "Success...";
                    html = data.success;
                    window.location.href = "/cashbank/bank_withdrawal/" + data.id;
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

$(document).ready(function() {
    $("#clicknew").click(function() {
        event.preventDefault();
        $('#click').prop('disabled', true);
        $("#click").html("Processing");
        var form = document.getElementById("formCreate");
        $.ajax({
            url: "/cashbank/newBankAccount",
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
                    $('#click').prop('disabled', false);
                    $('#click').html('Create');
                }
                if (data.success) {
                    typeswal = "success";
                    titleswal = "Success...";
                    html = data.success;
                    window.location.href = "/cashbank/bank_transfer/new";
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

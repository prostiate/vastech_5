$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    }
});
$(document).ready(function() {
    $("#click").click(function() {
        //$("click").on("submit", function(event) {
        event.preventDefault();
        var form = document.getElementById("formCreate");
        $.ajax({
            url: "/sales_order/newSOrder",
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
                        html += "<br>" + data.errors[count] + "</br>";
                    }
                    //html = data.errors
                }
                if (data.success) {
                    typeswal = "success";
                    titleswal = "Success...";
                    html = data.success;
                    window.location.href = "/sales_order";
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
        //$("click").on("submit", function(event) {
        event.preventDefault();
        var form = document.getElementById("formCreate");
        $.ajax({
            url: "/sales_order/newSOrder",
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
                        html += "<br>" + data.errors[count] + "</br>";
                    }
                }
                if (data.success) {
                    typeswal = "success";
                    titleswal = "Success...";
                    html = data.success;
                }
                Swal.fire({
                    type: typeswal,
                    title: titleswal,
                    html: html
                });
                window.location.href = "/sales_order/new";
            }
        });
    });
});

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    }
});

function publish() {
    var equitas_d = $(".debit").eq(63).val();
    var equitas_c = $(".credit").eq(63).val();

    var debit = $(".total-debit").val() - 0;
    var credit = $(".total-credit").val() - 0;


    if (debit > credit) {
        var selisih = (debit - equitas_d) - (credit - equitas_c);
        if (selisih >= 0) {
            $(".debit").eq(63).val(0);
            $(".credit").eq(63).val(selisih);
            var total = selisih + credit;
            $(".total-credit").val(total);
        } else {
            $(".debit").eq(63).val(Math.abs(selisih));
            $(".credit").eq(63).val(0);
            var total = selisih + debit;
            $(".total-debit").val(total);
        }
    }

    if (debit < credit) {
        var selisih = (credit - equitas_c) - (debit - equitas_d);
        if (selisih >= 0) {
            $(".credit").eq(63).val(0);
            $(".debit").eq(63).val(selisih);
            var total = selisih + debit;
            $(".total-debit").val(total);
        } else {
            $(".credit").eq(63).val(Math.abs(selisih));
            $(".debit").eq(63).val(0);
            var total = selisih + credit;
            $(".total-credit").val(total);
        }
    }
}

$(document).ready(function () {
    $("#publish_btn").click(function () {
        publish();
        event.preventDefault();
        $('#draft_btn').prop('disabled', true);
        $('#draft_btn').html('Processing');
        var form = document.getElementById("formCreate");
        $.ajax({
            url: "/conversion_balance/publish",
            method: "POST",
            data: new FormData(form),
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            timeout: 5000,
            success: function (data) {
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
                    $('#click').html('Update');
                }
                if (data.success) {
                    typeswal = "success";
                    titleswal = "Success...";
                    html = data.success;
                    window.location.href = "/chart_of_accounts";
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

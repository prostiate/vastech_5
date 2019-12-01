$(document).ready(function () {
    $('#check_depreciable').click(function() {
        var chk = $('#check_depreciable').is(':checked');

        if (chk) {
            $("[name='address']").prop("disabled", true);
            $("[name='term']").prop("disabled", true);
        } else {
            $("[name='address']").prop("disabled", false);
            $("[name='term']").prop("disabled", false);
        }
    });
});

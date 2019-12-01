function totalInput() {
    var t = 0;
    $(".totinput").each(function(i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });
    $(".balance_input").val(t);
}
function totalView() {
    var t = 0;
    $(".totview").each(function(i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });
    $(".balance").html(t);
}

$(function() {
    $(".neworderbody").on(
        "change",
        ".examount, .viewajah",
        function() {
            var tr = $(this)
                .parent()
                .parent();
            var payment_amount = tr.find(".examount").val() - 0;
            var view = tr.find(".viewajah").val() - 0;
            var total = payment_amount;
            var vitot = view;
            tr.find(".totinput").val(total);
            tr.find(".totview").val(vitot);
            totalInput();
            totalView();
        }
    );
});

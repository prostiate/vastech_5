$(document).on("click", ".btn-add-row", function (e) {
    e.preventDefault();
    var row = $(".kolom").eq(0).clone().html();
    $("tbody").append(row);
})
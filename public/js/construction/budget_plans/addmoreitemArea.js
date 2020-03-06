$(document).ready(function() {
    $(".add").click(function() {
        tr =
            "<tr>" +
            "<td>" +
            '<input onClick="this.select();" type="text" class="form-control" name="name[]">' +
            "</td>" +
            "<td>" +
            '<input type="button" class="btn btn-danger delete" value="x">' +
            "</td>" +
            "</tr>";

        $(".neworderbody").append(tr);
    });

    $(".neworderbody").on("click", ".delete", function() {
        $(this)
            .parent()
            .parent()
            .remove();
    });
});

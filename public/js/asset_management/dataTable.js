$(document).ready(function() {
    $("#dataTable_active").DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[0, "desc"]],
        ajax: {
            url: "/asset_managements"
        },
        columns: [
            {
                data: "date",
                render: $.fn.dataTable.render.text()
            },
            {
                data: "coa.name",
                render: function(data, type, row) {
                    return (
                        '<a href="/chart_of_accounts/' +
                        row.coa.id +
                        '">' +
                        row.coa.name +
                        "</a>"
                    );
                }
            },
            {
                data: "name",
                render: function(data, type, row) {
                    return (
                        '<a href="/asset_managements/' +
                        row.id +
                        '">' +
                        row.name +
                        "</a>"
                    );
                }
            },
            {
                data: "cost",
                render: $.fn.dataTable.render.number(".", ",", 2, "Rp ")
            },
            {
                data: "actual_cost",
                render: $.fn.dataTable.render.number(".", ",", 2, "Rp ")
            }
        ]
    });
    $("#dataTable_disposed").DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[0, "desc"]],
        ajax: {
            url: "/asset_managements/disposed"
        },
        columns: [
            {
                data: "coa.name",
                render: function(data, type, row) {
                    return (
                        '<a href="/chart_of_accounts/' +
                        row.coa.id +
                        '">' +
                        row.coa.name +
                        "</a>"
                    );
                }
            },
            {
                data: "date",
                render: $.fn.dataTable.render.text()
            },
            {
                data: "name",
                render: function(data, type, row) {
                    return (
                        '<a href="/asset_managements/' +
                        row.id +
                        '">' +
                        row.name +
                        "</a>"
                    );
                }
            },
            {
                data: "cost",
                render: $.fn.dataTable.render.number(".", ",", 2, "Rp ")
            },
            {
                data: "cost",
                render: $.fn.dataTable.render.number(".", ",", 2, "Rp ")
            },
            {
                data: "action",
                name: "action"
            }
        ]
    });
    $("#dataTable_depreciation").DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[0, "desc"]],
        ajax: {
            url: "/asset_managements/depreciation"
        },
        columns: [
            {
                data: "asset_detail.[0].method",
                render: $.fn.dataTable.render.text()
            },
            {
                data: "name",
                render: function(data, type, row) {
                    return (
                        '<a href="/asset_managements/' +
                        row.id +
                        '">' +
                        row.name +
                        "</a>"
                    );
                }
            },
            {
                data: "asset_detail.[0].life",
                render: $.fn.dataTable.render.text()
            },
            {
                data: "asset_detail.[0].rate",
                render: $.fn.dataTable.render.text()
            },
            {
                data: "asset_detail.[0].method",
                render: $.fn.dataTable.render.text()
            },
            {
                data: "action",
                name: "action"
            }
        ]
    });

    var user_id;
    var asset_id;
    $(document).on("click", ".apply", function() {
        asset_id = $(this).attr("id");
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, apply it!"
        }).then(result => {
            if (result.value) {
                $.ajax({
                    url: "/asset_managements/apply_depreciation/" + asset_id,
                    success: function(data) {
                        var html = "";
                        var typeswal = "";
                        var titleswal = "";
                        if (data.errors) {
                            typeswal = "error";
                            titleswal = "Oops...";
                            html = data.errors;
                        }
                        if (data.success) {
                            typeswal = "success";
                            titleswal = "Success...";
                            html = data.success;
                            $("#dataTable_active")
                                .DataTable()
                                .ajax.reload();
                            $("#dataTable_disposed")
                                .DataTable()
                                .ajax.reload();
                            $("#dataTable_depreciation")
                                .DataTable()
                                .ajax.reload();
                        }
                        Swal.fire({
                            type: typeswal,
                            title: titleswal,
                            html: html
                        });
                    }
                });
                Swal.fire(
                    "Success!",
                    "Your asset has been depreciated.",
                    "success"
                );
            }
        });
    });

    $(document).on("click", ".edit", function() {
        user_id = $(this).attr("id");
        window.location.href = "/asset_managements/edit/" + user_id;
    });
});

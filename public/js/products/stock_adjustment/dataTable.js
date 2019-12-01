$(document).ready(function() {
    $("#dataTable").DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[0, "desc"]],
        ajax: {
            url: "/stock_adjustment"
        },
        columns: [
            {
                data: "date",
                render: $.fn.dataTable.render.text()
            },
            {
                data: "number",
                render: function(data, type, row) {
                    return (
                        '<a href="/stock_adjustment/' +
                        row.id +
                        '">Stock Adjustment #' +
                        row.number +
                        "</a>"
                    );
                }
            },
            {
                data: "adjustment_type",
                render: $.fn.dataTable.render.text()
            },
            {
                data: "coa.name",
                render: function(data, type, row) {
                    return (
                        '<a href="/chart_of_accounts/' +
                        row.id +
                        '">' +
                        row.coa.name +
                        "</a>"
                    );
                }
            },
            {
                data: "warehouse.name",
                render: function(data, type, row) {
                    return (
                        '<a href="/warehouses/' +
                        row.id +
                        '">' +
                        row.warehouse.name +
                        "</a>"
                    );
                }
            },
            {
                data: "memo",
                render: $.fn.dataTable.render.text()
            }
        ]
    });
});

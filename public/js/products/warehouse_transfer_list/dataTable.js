$(document).ready(function() {
    $("#dataTable").DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[0, 'asc']],
        ajax: {
            url: "/warehouses_transfer"
        },
        columns: [
            {
                data: "transaction_date",
                render: $.fn.dataTable.render.text()
            },
            {
                data: "number",
                render: function(data, type, row) {
                    return (
                        '<a href="/warehouses_transfer/' +
                        row.id +
                        '"> Warehouse Transfer #' +
                        row.number +
                        "</a>"
                    );
                }
            },
            {
                data: "from_warehouse",
                render: function(data, type, row) {
                    return (
                        '<a href="/warehouses/' +
                        row.from_warehouse.id +
                        '">' +
                        row.from_warehouse.name +
                        "</a>"
                    );
                }
            },
            {
                data: "to_warehouse",
                render: function(data, type, row) {
                    return (
                        '<a href="/warehouses/' +
                        row.to_warehouse.id +
                        '">' +
                        row.to_warehouse.name +
                        "</a>"
                    );
                }
            },
            {
                data: "memo",
                render: $.fn.dataTable.render.text()
            },
        ]
    });
});

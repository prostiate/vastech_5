$(document).ready(function() {
    $("#dataTable").DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[1, "asc"]],
        ajax: {
            url: "/products"
        },
        columns: [
            {
                data: "code",
                render: $.fn.dataTable.render.text()
            },
            {
                data: "name",
                render: function(data, type, row) {
                    return (
                        '<a href="/products/' +
                        row.id +
                        '">' +
                        row.name +
                        "</a>"
                    );
                }
            },
            {
                data: "qty",
                render: $.fn.dataTable.render.text()
            },
            {
                data: "other_unit.name",
                orderable: false,
                render: $.fn.dataTable.render.text()
            },
            {
                data: "avg_price",
                className: "text-right",
                render: $.fn.dataTable.render.number(".", ",", 2, "Rp "),
            },
            {
                data: "buy_price",
                className: "text-right",
                render: $.fn.dataTable.render.number(".", ",", 2, "Rp "),
            },
            {
                data: "sell_price",
                className: "text-right",
                render: $.fn.dataTable.render.number(".", ",", 2, "Rp "),
            },
            {
                data: "other_product_category.name",
                orderable: false,
                render: $.fn.dataTable.render.text()
            }
        ]
    });
});

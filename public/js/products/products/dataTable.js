$(document).ready(function() {
    $("#dataTable1").DataTable({
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
                /*render: function(data, type, row) {
                    var txt = "";
                    data.forEach(function(lalawd) {
                        if (txt.length > 0) {
                            txt += "</br> ";
                        }
                        txt += lalawd.qty;
                    });
                    return txt;
                }*/
            },
            {
                data: "other_unit.name",
                orderable: false,
                render: $.fn.dataTable.render.text()
            },
            {
                data: "avg_price",
                className: "text-right",
                render: $.fn.dataTable.render.number(".", ",", 2, "Rp ")
            },
            {
                data: "buy_price",
                className: "text-right",
                render: $.fn.dataTable.render.number(".", ",", 2, "Rp ")
            },
            {
                data: "sell_price",
                className: "text-right",
                render: $.fn.dataTable.render.number(".", ",", 2, "Rp ")
            },
            {
                data: "other_product_category.name",
                orderable: false,
                render: $.fn.dataTable.render.text()
            }
        ]
    });
    $("#dataTable2").DataTable({
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
                /*render: function(data, type, row) {
                    var txt = "";
                    data.forEach(function(lalawd) {
                        if (txt.length > 0) {
                            txt += "</br> ";
                        }
                        txt += lalawd.qty;
                    });
                    return txt;
                }*/
            },
            {
                data: "other_unit.name",
                orderable: false,
                render: $.fn.dataTable.render.text()
            },
            {
                data: "last_buy_price",
                className: "text-right",
                render: $.fn.dataTable.render.number(".", ",", 2, "Rp ")
            },
            {
                data: "buy_price",
                className: "text-right",
                render: $.fn.dataTable.render.number(".", ",", 2, "Rp ")
            },
            {
                data: "sell_price",
                className: "text-right",
                render: $.fn.dataTable.render.number(".", ",", 2, "Rp ")
            },
            {
                data: "other_product_category.name",
                orderable: false,
                render: $.fn.dataTable.render.text()
            }
        ]
    });
});

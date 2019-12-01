$(document).ready(function() {
    $("#dataTable").DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[0, "asc"]],
        ajax: {
            url: "/cashbank"
        },
        columns: [
            {
                data: "code",
                render: function(data, type, row) {
                    return (
                        '<a href="/chart_of_accounts/' +
                        row.id +
                        '">' +
                        row.code +
                        "</a>"
                    );
                }
            },
            {
                data: "name",
                render: function(data, type, row) {
                    return (
                        '<a href="/chart_of_accounts/' +
                        row.id +
                        '">' +
                        row.name +
                        "</a>"
                    );
                }
            },
            {
                data: "balance",
                className: "text-right",
                render: $.fn.dataTable.render.number(".", ",", 2, "Rp ")
            }
        ]
    });

    $("#dataTable2").DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[1, "desc"]],
        ajax: {
            url: "/cashbankListTransaction"
        },
        columns: [
            {
                data: "date",
                searchable: false,
                render: $.fn.dataTable.render.text()
            },
            {
                data: "number",
                render: function(data, type, row) {
                    if (row.bank_transfer == 1) {
                        return (
                            '<a href="/cashbank/bank_transfer/' +
                            row.id +
                            '">Bank Transfer #' +
                            row.number +
                            "</a>"
                        );
                    } else if (row.bank_deposit == 1) {
                        return (
                            '<a href="/cashbank/bank_deposit/' +
                            row.id +
                            '">Bank Deposit #' +
                            row.number +
                            "</a>"
                        );
                    } else {
                        return (
                            '<a href="/cashbank/bank_withdrawal/' +
                            row.id +
                            '">Bank Withdrawal #' +
                            row.number +
                            "</a>"
                        );
                    }
                }
            },
            {
                data: "contact.display_name",
                render: function(data, type, row) {
                    if (row.contact == null) {
                        return "<a></a>";
                    } else {
                        return (
                            '<a href="/contacts/' +
                            row.contact_id +
                            '">' +
                            row.contact.display_name +
                            "</a>"
                        );
                    }
                }
            },
            {
                data: "memo",
                render: $.fn.dataTable.render.text()
            },
            {
                data: "amount",
                className: "text-right",
                render: $.fn.dataTable.render.number(".", ",", 2, "Rp ")
            },
            {
                data: "status.name",
                className: "text-center",
                searchable: false,
                render: $.fn.dataTable.render.text()
            }
        ]
    });
});

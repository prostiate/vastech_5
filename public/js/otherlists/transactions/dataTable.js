$(document).ready(function() {
    $("#dataTable").DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[0, "desc"]],
        iDisplayLength: 25,
        ajax: {
            url: "/other/transactions"
        },
        columns: [
            {
                data: "transaction_date",
                searchable: false,
                render: $.fn.dataTable.render.text()
            },
            {
                data: "number_complete",
                render: function(data, type, row) {
                    if (row.number_complete == null) {
                        return "<a>-</a>";
                    } else {
                        if (row.type == "purchase quote") {
                            return (
                                '<a href="/purchases_quote/' +
                                row.ref_id +
                                '">' +
                                row.number_complete +
                                "</a>"
                            );
                        } else if (row.type == "purchase order") {
                            return (
                                '<a href="/purchases_order/' +
                                row.ref_id +
                                '">' +
                                row.number_complete +
                                "</a>"
                            );
                        } else if (row.type == "purchase delivery") {
                            return (
                                '<a href="/purchases_delivery/' +
                                row.ref_id +
                                '">' +
                                row.number_complete +
                                "</a>"
                            );
                        } else if (row.type == "purchase invoice") {
                            return (
                                '<a href="/purchases_invoice/' +
                                row.ref_id +
                                '">' +
                                row.number_complete +
                                "</a>"
                            );
                        } else if (row.type == "purchase payment") {
                            return (
                                '<a href="/purchases_payment/' +
                                row.ref_id +
                                '">' +
                                row.number_complete +
                                "</a>"
                            );
                        } else if (row.type == "purchase return") {
                            return (
                                '<a href="/purchases_return/' +
                                row.ref_id +
                                '">' +
                                row.number_complete +
                                "</a>"
                            );
                        } else if (row.type == "sales quote") {
                            return (
                                '<a href="/sales_quote/' +
                                row.ref_id +
                                '">' +
                                row.number_complete +
                                "</a>"
                            );
                        } else if (row.type == "sales order") {
                            return (
                                '<a href="/sales_order/' +
                                row.ref_id +
                                '">' +
                                row.number_complete +
                                "</a>"
                            );
                        } else if (row.type == "sales delivery") {
                            return (
                                '<a href="/sales_delivery/' +
                                row.ref_id +
                                '">' +
                                row.number_complete +
                                "</a>"
                            );
                        } else if (row.type == "sales invoice") {
                            return (
                                '<a href="/sales_invoice/' +
                                row.ref_id +
                                '">' +
                                row.number_complete +
                                "</a>"
                            );
                        } else if (row.type == "sales payment") {
                            return (
                                '<a href="/sales_payment/' +
                                row.ref_id +
                                '">' +
                                row.number_complete +
                                "</a>"
                            );
                        } else if (row.type == "sales return") {
                            return (
                                '<a href="/sales_return/' +
                                row.ref_id +
                                '">' +
                                row.number_complete +
                                "</a>"
                            );
                        } else if (row.type == "expense") {
                            return (
                                '<a href="/expenses/' +
                                row.ref_id +
                                '">' +
                                row.number_complete +
                                "</a>"
                            );
                        } else if (row.type == "banktransfer") {
                            return (
                                '<a href="/cashbank/bank_transfer/' +
                                row.ref_id +
                                '">' +
                                row.number_complete +
                                "</a>"
                            );
                        } else if (row.type == "bankdeposit") {
                            return (
                                '<a href="/cashbank/bank_deposit/' +
                                row.ref_id +
                                '">' +
                                row.number_complete +
                                "</a>"
                            );
                        } else if (row.type == "bankwithdrawalaccount") {
                            return (
                                '<a href="/cashbank/bank_withdrawal/' +
                                row.ref_id +
                                '">' +
                                row.number_complete +
                                "</a>"
                            );
                        } else if (row.type == "bankwithdrawalfromexpense") {
                            return (
                                '<a href="/cashbank/bank_withdrawal/' +
                                row.ref_id +
                                '">' +
                                row.number_complete +
                                "</a>"
                            );
                        } else if (row.type == "wip") {
                            return (
                                '<a href="/wip/' +
                                row.ref_id +
                                '">' +
                                row.number_complete +
                                "</a>"
                            );
                        } else if (row.type == "spk") {
                            return (
                                '<a href="/spk/' +
                                row.ref_id +
                                '">' +
                                row.number_complete +
                                "</a>"
                            );
                        } else if (row.type == "stock adjustment") {
                            return (
                                '<a href="/stock_adjustment/' +
                                row.ref_id +
                                '">' +
                                row.number_complete +
                                "</a>"
                            );
                        } else if (row.type == "warehouse transfer") {
                            return (
                                '<a href="/warehouses_transfer/' +
                                row.ref_id +
                                '">' +
                                row.number_complete +
                                "</a>"
                            );
                        }
                    }
                }
            },
            {
                data: "ot_contact.display_name",
                render: function(data, type, row) {
                    if (row.ot_contact == null) {
                        return "<a></a>";
                    } else {
                        return (
                            '<a href="/contacts/' +
                            row.ot_contact.id +
                            '">' +
                            row.ot_contact.display_name +
                            "</a>"
                        );
                    }
                }
            },
            {
                data: "memo",
                searchable: false,
                orderable: false,
                render: $.fn.dataTable.render.text()
            },
            {
                data: "due_date",
                searchable: false,
                render: $.fn.dataTable.render.text()
            },
            {
                data: "balance_due",
                className: "text-right",
                render: $.fn.dataTable.render.number(".", ",", 2, "Rp ")
            },
            {
                data: "total",
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

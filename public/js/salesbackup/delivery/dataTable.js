$(document).ready(function() {
    $("#dataTable").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "/sales_invoice"
        },
        columns: [
            {
                data: "number",
                name: "number"
            },
            {
                data: "transaction_date",
                name: "transaction_date",
            },
            {
                data: "vendor_id",
                name: "vendor_id",
                searchable: false
            },
            {
                data: "due_date",
                name: "due_date",
                searchable: false
            },
            {
                data: "subtotal",
                name: "subtotal",
            },
            {
                data: "grandtotal",
                name: "grandtotal",
            },
            {
                data: "grandtotal",
                name: "grandtotal",
                orderable: false,
                searchable: false
            },
            {
                data: "action",
                name: "action",
                orderable: false,
                searchable: false
            }
        ]
    });
});

$(document).ready(function() {
    $("#dataTable").DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[0, 'asc']],
        ajax: {
            url: "/contacts_vendor"
        },
        columns: [
            {
                data: "company_name",
                name: "company_name",
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    if (row.company_name == null) {
                        return "<a>-</a>";
                    } else {
                        return "<a>" + row.company_name + "</a>";
                    }
                }
            },
            {
                data: "display_name",
                name: "display_name",
                render: function(data, type, row) {
                    if (row.display_name == null) {
                        return "<a>-</a>";
                    } else {
                        return '<a href="/contacts/' + row.id + '">' + row.display_name + '</a></a>';
                    }
                }
            },
            {
                data: "billing_address",
                name: "billing_address",
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    if (row.billing_address == null) {
                        return "<a>-</a>";
                    } else {
                        return "<a>" + row.billing_address + "</a>";
                    }
                }
            },
            {
                data: "email",
                name: "email",
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    if (row.email == null) {
                        return "<a>-</a>";
                    } else {
                        return "<a>" + row.email + "</a>";
                    }
                }
            },
            {
                data: "handphone",
                name: "handphone",
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    if (row.handphone == null) {
                        return "<a>-</a>";
                    } else {
                        return "<a>" + row.handphone + "</a>";
                    }
                }
            },
            {
                data: "npwp",
                name: "npwp",
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    if (row.npwp == null) {
                        return "<a>-</a>";
                    } else {
                        return "<a>-</a>";
                    }
                }
            },
            {
                data: "npwp",
                name: "npwp",
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    if (row.npwp == null) {
                        return "<a>-</a>";
                    } else {
                        return "<a>-</a>";
                    }
                }
            },
            {
                data: "npwp",
                name: "npwp",
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    if (row.npwp == null) {
                        return "<a>-</a>";
                    } else {
                        return "<a>-</a>";
                    }
                }
            },
        ]
    });
});

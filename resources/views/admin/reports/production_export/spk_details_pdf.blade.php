<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style type="text/css">
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
        }

        table,
        th,
        td {
            border-collapse: collapse;
            border: none;
            padding: 10px 5px;
        }

        /* Float four columns side by side */
        .column-50 {
            float: left;
            width: 50%;
        }

        .column-33 {
            float: left;
            width: 33.33%;
        }

        .column-25 {
            float: left;
            width: 25%;
        }

        /* Remove extra left and right margins, due to padding in columns */
        .row {
            margin: 0 -5px;
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        /* Style the counter cards */
        .card {
            padding: 16px;
            text-align: center;
            margin-bottom: 20px;
            background-color: #fff;
            border: 1px solid transparent;
            border-radius: 4px;
            -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
        }

        .card.card-costumer {
            text-align: left;
        }

        .card-body {
            padding: 15px;
        }

        .card-heading {
            padding: 10px 15px;
            border-bottom: 1px solid transparent;
            border-top-left-radius: 3px;
            border-top-right-radius: 3px;
        }

        .card-heading>.dropdown .dropdown-toggle {
            color: inherit;
        }

        .card-title {
            margin-top: 0;
            margin-bottom: 0;
            font-size: 16px;
            color: inherit;
        }

        .card-title>a,
        .card-title>small,
        .card-title>.small,
        .card-title>small>a,
        .card-title>.small>a {
            color: inherit;
        }

        .card-footer {
            padding: 10px 15px;
            background-color: #f5f5f5;
            border-top: 1px solid #ddd;
            border-bottom-right-radius: 3px;
            border-bottom-left-radius: 3px;
        }

        .align-mid {
            margin-bottom: 0;
            text-align: center;
        }

        .table-head {
            padding: 50px 100px;
            border-bottom: 3px solid #000;
            border-spacing: 8px 10px
        }

        .table-foot {
            padding: 50px 100px;
            border-top: 3px solid #000;
            border-spacing: 8px 10px
        }

        .table-data {
            width: 100%;
        }

        .table-none tr td {
            padding: 2px;
            border: none;
        }

        .table-body>tr>td,
        .table-head>tr>th {
            text-align: center;
        }


        /* Responsive columns - one column layout (vertical) on small screens */
        @media screen and (max-width: 600px) {
            .column {
                width: 100%;
                display: block;
                margin-bottom: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th colspan="5" style="text-align: center;">
                        <strong>{{$company->name}}</strong>
                    </th>
                </tr>
                <tr>
                    <th colspan="5" style="text-align: center;">
                        <strong>Surat Perintah Kerja Details</strong>
                    </th>
                </tr>
                <tr>
                    <th colspan="5" style="text-align: center;">
                        <strong>{{$start}} / {{$end}}</strong>
                    </th>
                </tr>
            </thead>
            <thead>
                <tr class="btn-dark">
                    <th>Date</th>
                    <th class="text-left">Transaction Number</th>
                    <th class="text-left">Memo</th>
                    <th class="text-left">Customer</th>
                    <th class="text-left">Warehouse</th>
                    <th class="text-left">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($spk as $ot)
                <tr>
                    <td>{{$ot->transaction_date}}</td>
                    <td>Surat Perintah Kerja #{{$ot->number}}</td>
                    <td>{{$ot->memo}}</td>
                    <td>{{$ot->contact->display_name}}</td>
                    <td><a style="width: 100px">{{$ot->warehouse->name}}</a></td>
                    <td>{{$ot->spk_status->name}}</td>
                </tr>
                <thead>
                    <tr>
                        <th></th>
                        <th class="text-left" style="width: 100px">Product</th>
                        <th class="text-left">Requirement Quantity</th>
                        <th class="text-left">Quantity Remaining</th>
                        <th class="text-left">Status</th>
                        <th class="text-left"></th>
                    </tr>
                </thead>
            <tbody>
                @foreach($ot->spk_item as $otsi)
                <tr>
                    <td></td>
                    <td>{{$otsi->product->name}}</td>
                    <td>{{$otsi->qty}}</td>
                    <td>{{$otsi->qty_remaining}}</td>
                    <td>{{$otsi->spk_item_status->name}}</td>
                    <td></td>
                </tr>
                @endforeach
            </tbody>
            @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
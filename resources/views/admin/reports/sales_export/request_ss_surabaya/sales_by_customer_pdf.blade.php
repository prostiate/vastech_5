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
            border: 1px black solid;
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
        <table class="table">
            <thead>
                <tr>
                    <th colspan="6" style="text-align: center;">
                        <strong>{{$company->name}}</strong>
                    </th>
                </tr>
                <tr>
                    <th colspan="6" style="text-align: center;">
                        <strong>Sales by Customer</strong>
                    </th>
                </tr>
                <tr>
                    <th colspan="6" style="text-align: center;">
                        <strong>{{$start}} / {{$end}}</strong>
                    </th>
                </tr>
                <tr>
                    <th colspan="6" style="text-align: center;">
                        <strong>{{$today}}</strong>
                    </th>
                </tr>
                <tr class="btn-dark">
                    <th style="width:150px;">Customer / Date</th>
                    <th class="text-left">Product</th>
                    <th class="text-right">Qty</th>
                    <th class="text-left">Unit</th>
                    <th class="text-right">Unit Price</th>
                    <th class="text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php $grand_total = 0 ?>
                @forelse($customers as $customer)
                <tr>
                    <td colspan="6"><b>{{$customer->first()->first()->contact->display_name}} </b></td>
                </tr>
                <?php $cust_total = 0 ?>
                @foreach($customer as $k => $invoice)
                <tr>
                    <td colspan="6"><b>{{$invoice->first()->number}} </b></td>
                </tr>
                <?php $item_total = 0 ?>
                @foreach($invoice->first()->sale_invoice_item as $item)
                <tr>
                    <td class="text-left">{{$customer->first()->first()->contact->display_name}}</td>
                    <td class="text-left">{{$item->product->name}}</td>
                    <td class="text-right">{{$item->qty}}</td>
                    <td class="text-left">{{$item->unit->name}}</td>
                    <td class="text-right">@number($item->unit_price)</td>
                    <td class="text-right">@number($item->amount)</td>
                    <?php $item_total += $item->amount ?>
                </tr>
                @endforeach
                <?php $cust_total += $item_total ?>
                @endforeach
                <tr>
                    <td colspan="4" class="text-center"></td>
                    <td style="text-align: right;"><b>{{$customer->first()->first()->contact->display_name}} | Total
                            Sales</b></td>
                    <td style="text-align: right;"><b>@number($cust_total)</b></td>
                </tr>
                <?php $grand_total += $cust_total ?>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Data is not found</td>
                </tr>
                @endforelse
            </tbody>
            @if(count($si) >= 1)
            <tfoot>
                <tr>
                    <td colspan="4" class="text-center"></td>
                    <td style="text-align: right;"><b>Grand Total</b></td>
                    <td style="text-align: right;"><b>@number($grand_total)</b></td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</body>

</html>
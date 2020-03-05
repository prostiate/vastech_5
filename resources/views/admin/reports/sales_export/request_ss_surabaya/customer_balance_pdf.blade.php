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
                    <th colspan="6" style="text-align: center;">
                        <strong>{{$company->name}}</strong>
                    </th>
                </tr>
                <tr>
                    <th colspan="6" style="text-align: center;">
                        <strong>Customer Balance</strong>
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
                    <th class="text-left">Transaction</th>
                    <th class="text-left">No</th>
                    <th class="text-left">Due Date</th>
                    <th class="text-right">Amount</th>
                    <th class="text-right">Balance Due</th>
                </tr>
            </thead>
            <tbody>
                <?php $stop = 0 ?>
                <?php $total_grandtotal = 0 ?>
                <?php $total_balance_due = 0 ?>
                <?php $subtotal_grandtotal = 0 ?>
                <?php $subtotal_balance_due = 0 ?>
                @if(count($si) >= 1)
                @foreach($contact as $c)
                @foreach($si as $s)
                @if($s->contact_id == $c->id)
                @if($stop == 0)
                <?php $stop += 1 ?>
                <a>
                    <td colspan="6">
                        <a><strong>{{$c->display_name}}</strong></a>
                    </td>
                </a>
                @endif
                <tr>
                    <td><a>{{$s->transaction_date}}</a></td>
                    <td><a>Sales Invoice</a></td>
                    <td><a>{{$s->number}}</a></td>
                    <td><a>{{$s->due_date}}</a></td>
                    <td class="text-right"><a>@number($s->grandtotal)</a></td>
                    <td class="text-right"><a>@number($s->balance_due)</a></td>
                </tr>
                <?php $total_grandtotal += $s->grandtotal ?>
                <?php $total_balance_due += $s->balance_due ?>
                <?php $subtotal_grandtotal += $s->grandtotal ?>
                <?php $subtotal_balance_due += $s->balance_due ?>
                @endif
                @endforeach
                @if($subtotal_balance_due != 0)
                <tr>
                    <td colspan="4" class="text-right"><strong>Sub Total</strong></td>
                    <td colspan="1" class="text-right">@number($subtotal_grandtotal)</td>
                    <td colspan="1" class="text-right">@number($subtotal_balance_due)</td>
                </tr>
                @endif
                <?php $stop = 0 ?>
                <?php $subtotal_grandtotal = 0 ?>
                <?php $subtotal_balance_due = 0 ?>
                @endforeach
                @else
                <tr>
                    <td colspan="8" class="text-center">Data is not found</td>
                </tr>
                @endif
            </tbody>
            @if(count($si) >= 1)
            <tfoot>
                <tr>
                    <td colspan="3" class="text-center"></td>
                    <td style="text-align: right;"><b>Grand Total</b></td>
                    <td class="text-right"><b>@number($total_grandtotal)</b></td>
                    <td class="text-right"><b>@number($total_balance_due)</b></td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</body>

</html>
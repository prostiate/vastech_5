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
                        <strong>Expenses List</strong>
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
                    <th class="text-left">Date</th>
                    <th class="text-left">Transaction</th>
                    <th class="text-left">Number</th>
                    <th class="text-left">Category</th>
                    <th class="text-left">Description</th>
                    <th class="text-left">Beneficiary</th>
                    <th class="text-right">Amount</th>
                    <th class="text-right">Tax</th>
                    <th class="text-center">Status</th>
                    <th class="text-right">Balance Due</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total_grandtotal = 0;
                $total_balance_due = 0;
                ?>
                @foreach($expense as $exx)
                <?php
                $total_grandtotal += $exx->grandtotal;
                $total_balance_due += $exx->balance_due;
                ?>
                <tr>
                    <td class="text-left">{{$exx->transaction_date}}</td>
                    <td class="text-left">Expense</td>
                    <td class="text-left">{{$exx->number}}</td>
                    <td class="text-left">
                        @foreach($exx->expense_item as $exii)
                        {{$exii->coa->name}};
                        @endforeach
                    </td>
                    <td class="text-left">
                        @foreach($exx->expense_item as $exii)
                        {{$exii->desc}};
                        @endforeach
                    </td>
                    <td class="text-left">{{$exx->expense_contact->display_name}}</td>
                    <td class="text-right">@number($exx->grandtotal)</td>
                    <td class="text-right">@number($exx->balance_due)</td>
                    <td class="text-center">{{$exx->expense_status->name}}</td>
                    <td class="text-right">@number($exx->balance_due)</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" class="text-center"></td>
                    <td style="text-align: right;"><b>Grand Total</b></td>
                    <td class="text-right"><b>@number($total_grandtotal)</b></td>
                    <td></td>
                    <td></td>
                    <td class="text-right"><b>@number($total_balance_due)</b></td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>

</html>
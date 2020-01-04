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
                        <strong>Cash Flow</strong>
                    </th>
                </tr>
                <tr>
                    <th colspan="5" style="text-align: center;">
                        <strong>{{$start}} / {{$end}}</strong>
                    </th>
                </tr>
                <tr>
                    <th colspan="5" style="text-align: center;">
                        <strong>(in IDR)</strong>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="5" class="btn-dark"><b>Cash flow from Operating Activities</b></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3">Cash received from customers</td>
                    <td class="text-right">@if($cash_received_from_cust < 0) ( @number(abs($cash_received_from_cust)) ) @else @number($cash_received_from_cust) @endif</td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3">Other current assets</td>
                    <td class="text-right">@if($other_current_asset < 0) ( @number(abs($other_current_asset)) ) @else @number($other_current_asset) @endif</td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3">Cash paid to suppliers</td>
                    <td class="text-right">@if($cash_paid_to_supplier < 0) ( @number(abs($cash_paid_to_supplier)) ) @else @number($cash_paid_to_supplier) @endif</td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3">Credit cards and current liabilities</td>
                    <td class="text-right">@if($cc_and_current_liability < 0) ( @number(abs($cc_and_current_liability)) ) @else @number($cc_and_current_liability) @endif</td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3">Other incomes</td>
                    <td class="text-right">@if($other_income < 0) ( @number(abs($other_income)) ) @else @number($other_income) @endif</td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3">Operating expenses paid</td>
                    <td class="text-right">@if($operating_expense < 0) ( @number(abs($operating_expense)) ) @else @number($operating_expense) @endif</td>
                </tr>
                <tr>
                    <td colspan="4"><b>Net cash provided by Operating Activities</b></td>
                    <td class="text-right">@if($net_cash_operating_acti < 0) ( @number(abs($net_cash_operating_acti)) ) @else @number($net_cash_operating_acti) @endif</td>
                </tr>
                <tr>
                    <td colspan="5" class="btn-dark"><b>Cash flow from Investing Activities</b></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3">Purchase/Sales of assets</td>
                    <td class="text-right">@if($purchase_sale_asset < 0) ( @number(abs($purchase_sale_asset)) ) @else @number($purchase_sale_asset) @endif</td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3">Other investing activities</td>
                    <td class="text-right">@if($other_investing_asset < 0) ( @number(abs($other_investing_asset)) ) @else @number($other_investing_asset) @endif</td>
                </tr>
                <tr>
                    <td colspan="4"><b>Net cash provided by Investing Activities</b></td>
                    <td class="text-right">@if($net_cash_by_investing < 0) ( @number(abs($net_cash_by_investing)) ) @else @number($net_cash_by_investing) @endif</td>
                </tr>
                <tr>
                    <td colspan="5" class="btn-dark"><b>Cash flow from Financing Activities</b></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3">Repayment/Proceeds of loan</td>
                    <td class="text-right">@if($repayment_proceed_loan < 0) ( @number(abs($repayment_proceed_loan)) ) @else @number($repayment_proceed_loan) @endif</td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3">Equity/Capital</td>
                    <td class="text-right">@if($equity_capital < 0) ( @number(abs($equity_capital)) ) @else @number($equity_capital) @endif</td>
                </tr>
                <tr>
                    <td colspan="4"><b>Net cash provided by Financing Activities</b></td>
                    <td class="text-right">@if($net_cash_finan < 0) ( @number(abs($net_cash_finan)) ) @else @number($net_cash_finan) @endif</td>
                </tr>
                <tr>
                    <td colspan="4"><b>Increase (decrease) in cash</b></td>
                    <td class="text-right">@if($increase_dec_in_cash < 0) ( @number(abs($increase_dec_in_cash)) ) @else @number($increase_dec_in_cash) @endif</td>
                </tr>
                <!--<tr>
                    <td colspan="4"><b>Net bank revaluation</b></td>
                    <td class="text-right">0.00</td>
                </tr>-->
                <tr>
                    <td colspan="4"><b>Beginning cash balance</b></td>
                    <td class="text-right">@if($beginning_cash < 0) ( @number(abs($beginning_cash)) ) @else @number($beginning_cash) @endif</td>
                </tr>
                <tr>
                    <td colspan="4"><b>Ending cash balance</b></td>
                    <td class="text-right">@if($ending_cash < 0) ( @number(abs($ending_cash)) ) @else @number($ending_cash) @endif</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
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
            margin: 0;
            font-family: "Helvatica", sans-serif;
            font-size: 0.9rem;
            font-weight: 400;
            line-height: 1.6;
            color: #212529;
            text-align: left;
            background-color: #f8fafc;
        }

        table {
            border-collapse: collapse;
        }

        .container {
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        .table tbody+tbody {
            border-top: 2px solid #dee2e6;
        }

        .table-sm th,
        .table-sm td {
            padding: 0.3rem;
        }

        .table-bordered {
            border: 1px solid #dee2e6;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6;
        }

        .table-bordered thead th,
        .table-bordered thead td {
            border-bottom-width: 2px;
        }

        .table-borderless th,
        .table-borderless td,
        .table-borderless thead th,
        .table-borderless tbody+tbody {
            border: 0;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .table-hover tbody tr:hover {
            color: #212529;
            background-color: rgba(0, 0, 0, 0.075);
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

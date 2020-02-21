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
                    <strong>Profit Loss</strong>
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
                <td colspan="5" class="btn-dark"><b>Primary Income</b></td>
            </tr>
            @foreach($coa_detail as $c)
                @if($c->total != 0)
                    @if($c->coa->coa_category_id == 13)
                        <tr>
                            <td></td>
                            <td colspan="3"><a href="/chart_of_accounts/{{$c->id}}">{{$c->coa->code}} - {{$c->coa->name}}</a></td>
                            <td class="text-right">@number(abs($c->total))</td>
                        </tr>
                    @endif
                @endif
            @endforeach
            <tr>
                <td></td>
                <td colspan="3"><strong>Total Primary Income</strong></td>
                <td class="text-right"><strong>@if($total_primary_income < 0) 
                                                    ( @number(abs($total_primary_income)) )
                                                @else 
                                                    @number($total_primary_income) 
                                                @endif</strong></td>
            </tr>
            <tr>
                <td colspan="5"><b>Cost of Sales</b></td>
            </tr>
            @foreach($coa_detail as $c)
                @if($c->total != 0)
                    @if($c->coa->coa_category_id == 15)
                        <tr>
                            <td></td>
                            <td colspan="3"><a href="/chart_of_accounts/{{$c->id}}">{{$c->coa->code}} - {{$c->coa->name}}</a></td>
                            <td class="text-right">@if($c->total < 0) ( @number(abs($c->total)) ) @else @number($c->total) @endif</td>
                        </tr>
                    @endif
                @endif
            @endforeach
            <tr>
                <td></td>
                <td colspan="3"><strong>Total Cost of Sales</strong></td>
                <td class="text-right"><strong>@if($total_cost_of_sales < 0) 
                                                    ( @number(abs($total_cost_of_sales)) )
                                                @else 
                                                    @number($total_cost_of_sales) 
                                                @endif</strong></td>
            </tr>
            <tr>
                <td colspan="4"><b>Gross Profits</b></td>
                <td class="text-right"><strong>@if($gross_profit < 0) 
                                                    ( @number(abs($gross_profit)) )
                                                @else 
                                                    @number($gross_profit) 
                                                @endif</strong></td>
            </tr>
            <tr>
                <td colspan="5" class="btn-dark"><b>Operational Expense</b></td>
            </tr>
            @foreach($coa_detail as $c)
                @if($c->total != 0)
                    @if($c->coa->coa_category_id == 16)
                        <tr>
                            <td></td>
                            <td colspan="3"><a href="/chart_of_accounts/{{$c->id}}">{{$c->coa->code}} - {{$c->coa->name}}</a></td>
                            <td class="text-right">@if($c->total < 0) ( @number(abs($c->total)) ) @else @number($c->total) @endif</td>
                        </tr>
                    @endif
                @endif
            @endforeach
            <tr>
                <td></td>
                <td colspan="3">Total Operational Expenses</td>
                <td class="text-right"><strong>@if($total_operational_expense < 0) 
                                                    ( @number(abs($total_operational_expense)) )
                                                @else 
                                                    @number($total_operational_expense) 
                                                @endif</strong></td>
            </tr>
            <tr>
                <td colspan="4"><b>Net Operating Income</b></td>
                <td class="text-right"><strong>@if($net_operating_income < 0) 
                                                    ( @number(abs($net_operating_income)) )
                                                @else 
                                                    @number($net_operating_income) 
                                                @endif</strong></td>
            </tr>
            <tr>
                <td colspan="5" class="btn-dark"><b>Other Income</b></td>
            </tr>
            @foreach($coa_detail as $c)
                @if($c->total != 0)
                    @if($c->coa->coa_category_id == 14)
                        <tr>
                            <td></td>
                            <td colspan="3"><a href="/chart_of_accounts/{{$c->id}}">{{$c->coa->code}} - {{$c->coa->name}}</a></td>
                            <td class="text-right">@if($c->total < 0) ( @number(abs($c->total)) ) @else @number($c->total) @endif</td>
                        </tr>
                    @endif
                @endif
            @endforeach
            <tr>
                <td></td>
                <td colspan="3">Total Other Income</td>
                <td class="text-right"><strong>@if($total_other_income < 0) 
                                                    ( @number(abs($total_other_income)) )
                                                @else 
                                                    @number($total_other_income) 
                                                @endif</strong></td>
            </tr>
            <tr>
                <td colspan="5" class="btn-dark"><b>Other Expense</b></td>
            </tr>
            @foreach($coa_detail as $c)
                @if($c->total != 0)
                    @if($c->coa->coa_category_id == 17)
                        <tr>
                            <td></td>
                            <td colspan="3"><a href="/chart_of_accounts/{{$c->id}}">{{$c->coa->code}} - {{$c->coa->name}}</a></td>
                            <td class="text-right">@if($c->total < 0) ( @number(abs($c->total)) ) @else @number($c->total) @endif</td>
                        </tr>
                    @endif
                @endif
            @endforeach
            <tr>
                <td></td>
                <td colspan="3">Total Other Expense</td>
                <td class="text-right"><strong>@if($total_other_expense < 0) 
                                                    ( @number(abs($total_other_expense)) )
                                                @else 
                                                    @number($total_other_expense) 
                                                @endif</strong></td>
            </tr>
            <tr>
                <td colspan="4" class="btn-dark"><b>Net Income</b></td>
                <td class="text-right btn-dark"><strong>@if($net_income < 0) 
                                                    ( @number(abs($net_income)) )
                                                @else 
                                                    @number($net_income) 
                                                @endif</strong></td>
            </tr>
        </tbody>
    </table>
    </div>
</body>

</html>
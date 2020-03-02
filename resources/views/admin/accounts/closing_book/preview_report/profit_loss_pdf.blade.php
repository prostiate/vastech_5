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

        .table-primary,
        .table-primary>th,
        .table-primary>td {
            background-color: #c6e0f5;
        }

        .table-primary th,
        .table-primary td,
        .table-primary thead th,
        .table-primary tbody+tbody {
            border-color: #95c5ed;
        }

        .table-hover .table-primary:hover {
            background-color: #b0d4f1;
        }

        .table-hover .table-primary:hover>td,
        .table-hover .table-primary:hover>th {
            background-color: #b0d4f1;
        }

        .table-secondary,
        .table-secondary>th,
        .table-secondary>td {
            background-color: #d6d8db;
        }

        .table-secondary th,
        .table-secondary td,
        .table-secondary thead th,
        .table-secondary tbody+tbody {
            border-color: #b3b7bb;
        }

        .table-hover .table-secondary:hover {
            background-color: #c8cbcf;
        }

        .table-hover .table-secondary:hover>td,
        .table-hover .table-secondary:hover>th {
            background-color: #c8cbcf;
        }

        .table-success,
        .table-success>th,
        .table-success>td {
            background-color: #c7eed8;
        }

        .table-success th,
        .table-success td,
        .table-success thead th,
        .table-success tbody+tbody {
            border-color: #98dfb6;
        }

        .table-hover .table-success:hover {
            background-color: #b3e8ca;
        }

        .table-hover .table-success:hover>td,
        .table-hover .table-success:hover>th {
            background-color: #b3e8ca;
        }

        .table-info,
        .table-info>th,
        .table-info>td {
            background-color: #d6e9f9;
        }

        .table-info th,
        .table-info td,
        .table-info thead th,
        .table-info tbody+tbody {
            border-color: #b3d7f5;
        }

        .table-hover .table-info:hover {
            background-color: #c0ddf6;
        }

        .table-hover .table-info:hover>td,
        .table-hover .table-info:hover>th {
            background-color: #c0ddf6;
        }

        .table-warning,
        .table-warning>th,
        .table-warning>td {
            background-color: #fffacc;
        }

        .table-warning th,
        .table-warning td,
        .table-warning thead th,
        .table-warning tbody+tbody {
            border-color: #fff6a1;
        }

        .table-hover .table-warning:hover {
            background-color: #fff8b3;
        }

        .table-hover .table-warning:hover>td,
        .table-hover .table-warning:hover>th {
            background-color: #fff8b3;
        }

        .table-danger,
        .table-danger>th,
        .table-danger>td {
            background-color: #f7c6c5;
        }

        .table-danger th,
        .table-danger td,
        .table-danger thead th,
        .table-danger tbody+tbody {
            border-color: #f09593;
        }

        .table-hover .table-danger:hover {
            background-color: #f4b0af;
        }

        .table-hover .table-danger:hover>td,
        .table-hover .table-danger:hover>th {
            background-color: #f4b0af;
        }

        .table-light,
        .table-light>th,
        .table-light>td {
            background-color: #fdfdfe;
        }

        .table-light th,
        .table-light td,
        .table-light thead th,
        .table-light tbody+tbody {
            border-color: #fbfcfc;
        }

        .table-hover .table-light:hover {
            background-color: #ececf6;
        }

        .table-hover .table-light:hover>td,
        .table-hover .table-light:hover>th {
            background-color: #ececf6;
        }

        .table-dark,
        .table-dark>th,
        .table-dark>td {
            background-color: #c6c8ca;
        }

        .table-dark th,
        .table-dark td,
        .table-dark thead th,
        .table-dark tbody+tbody {
            border-color: #95999c;
        }

        .table-hover .table-dark:hover {
            background-color: #b9bbbe;
        }

        .table-hover .table-dark:hover>td,
        .table-hover .table-dark:hover>th {
            background-color: #b9bbbe;
        }

        .table-active,
        .table-active>th,
        .table-active>td {
            background-color: rgba(0, 0, 0, 0.075);
        }

        .table-hover .table-active:hover {
            background-color: rgba(0, 0, 0, 0.075);
        }

        .table-hover .table-active:hover>td,
        .table-hover .table-active:hover>th {
            background-color: rgba(0, 0, 0, 0.075);
        }

        .table .thead-dark th {
            color: #fff;
            background-color: #343a40;
            border-color: #454d55;
        }

        .table .thead-light th {
            color: #495057;
            background-color: #e9ecef;
            border-color: #dee2e6;
        }

        .table-dark {
            color: #fff;
            background-color: #343a40;
        }

        .table-dark th,
        .table-dark td,
        .table-dark thead th {
            border-color: #454d55;
        }

        .table-dark.table-bordered {
            border: 0;
        }

        .table-dark.table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(255, 255, 255, 0.05);
        }

        .table-dark.table-hover tbody tr:hover {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.075);
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
                    <td colspan="3"><a href="/chart_of_accounts/{{$c->id}}">{{$c->coa->code}} - {{$c->coa->name}}</a>
                    </td>
                    <td class="text-right">@number(abs($c->total))</td>
                </tr>
                @endif
                @endif
                @endforeach
                <tr>
                    <td></td>
                    <td colspan="3"><strong>Total Primary Income</strong></td>
                    <td class="text-right"><strong>@if($total_primary_income < 0) ( @number(abs($total_primary_income))
                                ) @else @number($total_primary_income) @endif</strong> </td> </tr> <tr>
                    <td colspan="5"><b>Cost of Sales</b></td>
                </tr>
                @foreach($coa_detail as $c)
                @if($c->total != 0)
                @if($c->coa->coa_category_id == 15)
                <tr>
                    <td></td>
                    <td colspan="3"><a href="/chart_of_accounts/{{$c->id}}">{{$c->coa->code}} - {{$c->coa->name}}</a>
                    </td>
                    <td class="text-right">@if($c->total < 0) ( @number(abs($c->total)) ) @else @number($c->total)
                            @endif</td>
                </tr>
                @endif
                @endif
                @endforeach
                <tr>
                    <td></td>
                    <td colspan="3"><strong>Total Cost of Sales</strong></td>
                    <td class="text-right"><strong>@if($total_cost_of_sales < 0) ( @number(abs($total_cost_of_sales)) )
                                @else @number($total_cost_of_sales) @endif</strong> </td> </tr> <tr>
                    <td colspan="4"><b>Gross Profits</b></td>
                    <td class="text-right"><strong>@if($gross_profit < 0) ( @number(abs($gross_profit)) ) @else
                                @number($gross_profit) @endif</strong> </td> </tr> <tr>
                    <td colspan="5" class="btn-dark"><b>Operational Expense</b></td>
                </tr>
                @foreach($coa_detail as $c)
                @if($c->total != 0)
                @if($c->coa->coa_category_id == 16)
                <tr>
                    <td></td>
                    <td colspan="3"><a href="/chart_of_accounts/{{$c->id}}">{{$c->coa->code}} - {{$c->coa->name}}</a>
                    </td>
                    <td class="text-right">@if($c->total < 0) ( @number(abs($c->total)) ) @else @number($c->total)
                            @endif</td>
                </tr>
                @endif
                @endif
                @endforeach
                <tr>
                    <td></td>
                    <td colspan="3">Total Operational Expenses</td>
                    <td class="text-right"><strong>@if($total_operational_expense < 0) (
                                @number(abs($total_operational_expense)) ) @else @number($total_operational_expense)
                                @endif</strong> </td> </tr> <tr>
                    <td colspan="4"><b>Net Operating Income</b></td>
                    <td class="text-right"><strong>@if($net_operating_income < 0) ( @number(abs($net_operating_income))
                                ) @else @number($net_operating_income) @endif</strong> </td> </tr> <tr>
                    <td colspan="5" class="btn-dark"><b>Other Income</b></td>
                </tr>
                @foreach($coa_detail as $c)
                @if($c->total != 0)
                @if($c->coa->coa_category_id == 14)
                <tr>
                    <td></td>
                    <td colspan="3"><a href="/chart_of_accounts/{{$c->id}}">{{$c->coa->code}} - {{$c->coa->name}}</a>
                    </td>
                    <td class="text-right">@if($c->total < 0) ( @number(abs($c->total)) ) @else @number($c->total)
                            @endif</td>
                </tr>
                @endif
                @endif
                @endforeach
                <tr>
                    <td></td>
                    <td colspan="3">Total Other Income</td>
                    <td class="text-right"><strong>@if($total_other_income < 0) ( @number(abs($total_other_income)) )
                                @else @number($total_other_income) @endif</strong> </td> </tr> <tr>
                    <td colspan="5" class="btn-dark"><b>Other Expense</b></td>
                </tr>
                @foreach($coa_detail as $c)
                @if($c->total != 0)
                @if($c->coa->coa_category_id == 17)
                <tr>
                    <td></td>
                    <td colspan="3"><a href="/chart_of_accounts/{{$c->id}}">{{$c->coa->code}} - {{$c->coa->name}}</a>
                    </td>
                    <td class="text-right">@if($c->total < 0) ( @number(abs($c->total)) ) @else @number($c->total)
                            @endif</td>
                </tr>
                @endif
                @endif
                @endforeach
                <tr>
                    <td></td>
                    <td colspan="3">Total Other Expense</td>
                    <td class="text-right"><strong>@if($total_other_expense < 0) ( @number(abs($total_other_expense)) )
                                @else @number($total_other_expense) @endif</strong> </td> </tr> <tr>
                    <td colspan="4" class="btn-dark"><b>Net Income</b></td>
                    <td class="text-right btn-dark"><strong>@if($net_income < 0) ( @number(abs($net_income)) ) @else
                                @number($net_income) @endif</strong> </td> </tr> </tbody> </table> </div> </body>
                                </html>

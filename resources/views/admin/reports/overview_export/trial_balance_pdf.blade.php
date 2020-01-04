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
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th colspan="5" style="text-align: center;">
                        <strong>{{$company->name}}</strong>
                    </th>
                </tr>
                <tr>
                    <th colspan="5" style="text-align: center;">
                        <strong>Trial Balance</strong>
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
            <thead>
                <tr class="btn-dark">
                    <th colspan="2" style="width: 250px"></th>
                    <th colspan="2" style="width: 100px; text-align: center">Opening Balance</th>
                    <th colspan="2" style="width: 100px; text-align: center">Movement</th>
                    <th colspan="2" style="width: 100px; text-align: center">End Balance</th>
                </tr>
                <tr class="btn-dark">
                    <th colspan="2" style="width: 250px"></th>
                    <th style="width: 120px; text-align: center">Debit</th>
                    <th style="width: 120px; text-align: center">Credit</th>
                    <th style="width: 120px; text-align: center">Debit</th>
                    <th style="width: 120px; text-align: center">Credit</th>
                    <th style="width: 120px; text-align: center">Debit</th>
                    <th style="width: 120px; text-align: center">Credit</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="8">
                        <a><strong>Asset</strong></a>
                    </td>
                </tr>
                <?php $move_debit = 0 ?>
                <?php $move_credit = 0 ?>
                <?php $total_asset_move_debit = 0 ?>
                <?php $total_asset_move_credit = 0 ?>
                <?php $end_debit = 0 ?>
                <?php $end_credit = 0 ?>
                <?php $total_asset_end_debit = 0 ?>
                <?php $total_asset_end_credit = 0 ?>
                @foreach($coa_detail2 as $cd => $cdd)
                    @if($cdd->sum('debit') != 0 or $cdd->sum('credit') != 0)
                    <tr>
                        @foreach($asset as $c)
                        <?php $move_debit = 0 ?>
                        <?php $move_credit = 0 ?>
                            @if($c->id == $cd)
                                <td colspan="2"><a>@foreach($coa as $coaa) @if($coaa->id == $cd) ({{$coaa->code}}) - {{$coaa->name}} @endif @endforeach</a></td>
                                <td class="text-right"><a>0.00</a></td>
                                <td class="text-right"><a>0.00</a></td>
                                @foreach($cdd as $cddd)
                                <?php $move_debit += $cddd->debit?>
                                <?php $move_credit += $cddd->credit?>
                                <?php $total_asset_move_debit += $cddd->debit ?>
                                <?php $total_asset_move_credit += $cddd->credit ?>
                                <?php $end_debit = $move_debit - $move_credit?>
                                <?php $end_credit = $move_debit - $move_credit?>
                                @endforeach
                                <td class="text-right"><a>@number($move_debit)</a></td>
                                <td class="text-right"><a>@number($move_credit)</a></td>
                                @if($end_debit < 0)
                                <td class="text-right"><a>0.00</a></td>
                                <td class="text-right"><a>@number(abs($end_credit))</a></td>
                                <?php $total_asset_end_credit += $end_credit ?>
                                @else
                                <td class="text-right"><a>@number($end_debit)</a></td>
                                <td class="text-right"><a>0.00</a></td>
                                <?php $total_asset_end_debit += $end_debit ?>
                                @endif
                            @endif
                        @endforeach
                    </tr>
                    @endif
                @endforeach
                <tr>
                    <td colspan="8">
                        <a><strong>Liability</strong></a>
                    </td>
                </tr>
                <?php $move_debit = 0 ?>
                <?php $move_credit = 0 ?>
                <?php $total_liability_move_debit = 0 ?>
                <?php $total_liability_move_credit = 0 ?>
                <?php $end_debit = 0 ?>
                <?php $end_credit = 0 ?>
                <?php $total_liability_end_debit = 0 ?>
                <?php $total_liability_end_credit = 0 ?>
                @foreach($coa_detail2 as $cd => $cdd)
                    @if($cdd->sum('debit') != 0 or $cdd->sum('credit') != 0)
                    <tr>
                        @foreach($liability as $c)
                        <?php $move_debit = 0 ?>
                        <?php $move_credit = 0 ?>
                            @if($c->id == $cd)
                                <td colspan="2"><a>@foreach($coa as $coaa) @if($coaa->id == $cd) ({{$coaa->code}}) - {{$coaa->name}} @endif @endforeach</a></td>
                                <td class="text-right"><a>0.00</a></td>
                                <td class="text-right"><a>0.00</a></td>
                                @foreach($cdd as $cddd)
                                <?php $move_debit += $cddd->debit?>
                                <?php $move_credit += $cddd->credit?>
                                <?php $total_liability_move_debit += $cddd->debit ?>
                                <?php $total_liability_move_credit += $cddd->credit ?>
                                <?php $end_debit = $move_debit - $move_credit?>
                                <?php $end_credit = $move_debit - $move_credit?>
                                @endforeach
                                <td class="text-right"><a>@number($move_debit)</a></td>
                                <td class="text-right"><a>@number($move_credit)</a></td>
                                @if($end_debit < 0)
                                <td class="text-right"><a>0.00</a></td>
                                <td class="text-right"><a>@number(abs($end_credit))</a></td>
                                <?php $total_liability_end_credit += $end_credit ?>
                                @else
                                <td class="text-right"><a>@number($end_debit)</a></td>
                                <td class="text-right"><a>0.00</a></td>
                                <?php $total_liability_end_debit += $end_debit ?>
                                @endif
                            @endif
                        @endforeach
                    </tr>
                    @endif
                @endforeach
                <tr>
                    <td colspan="8">
                        <a><strong>Equity</strong></a>
                    </td>
                </tr>
                <?php $move_debit = 0 ?>
                <?php $move_credit = 0 ?>
                <?php $total_equity_move_debit = 0 ?>
                <?php $total_equity_move_credit = 0 ?>
                <?php $end_debit = 0 ?>
                <?php $end_credit = 0 ?>
                <?php $total_equity_end_debit = 0 ?>
                <?php $total_equity_end_credit = 0 ?>
                @foreach($coa_detail2 as $cd => $cdd)
                    @if($cdd->sum('debit') != 0 or $cdd->sum('credit') != 0)
                    <tr>
                        @foreach($equity as $c)
                        <?php $move_debit = 0 ?>
                        <?php $move_credit = 0 ?>
                            @if($c->id == $cd)
                                <td colspan="2"><a>@foreach($coa as $coaa) @if($coaa->id == $cd) ({{$coaa->code}}) - {{$coaa->name}} @endif @endforeach</a></td>
                                <td class="text-right"><a>0.00</a></td>
                                <td class="text-right"><a>0.00</a></td>
                                @foreach($cdd as $cddd)
                                <?php $move_debit += $cddd->debit?>
                                <?php $move_credit += $cddd->credit?>
                                <?php $total_equity_move_debit += $cddd->debit ?>
                                <?php $total_equity_move_credit += $cddd->credit ?>
                                <?php $end_debit = $move_debit - $move_credit?>
                                <?php $end_credit = $move_debit - $move_credit?>
                                @endforeach
                                <td class="text-right"><a>@number($move_debit)</a></td>
                                <td class="text-right"><a>@number($move_credit)</a></td>
                                @if($end_debit < 0)
                                <td class="text-right"><a>0.00</a></td>
                                <td class="text-right"><a>@number(abs($end_credit))</a></td>
                                <?php $total_equity_end_credit += $end_credit ?>
                                @else
                                <td class="text-right"><a>@number($end_debit)</a></td>
                                <td class="text-right"><a>0.00</a></td>
                                <?php $total_equity_end_debit += $end_debit ?>
                                @endif
                            @endif
                        @endforeach
                    </tr>
                    @endif
                @endforeach
                <tr>
                    <td colspan="8">
                        <a><strong>Income</strong></a>
                    </td>
                </tr>
                <?php $move_debit = 0 ?>
                <?php $move_credit = 0 ?>
                <?php $total_income_move_debit = 0 ?>
                <?php $total_income_move_credit = 0 ?>
                <?php $end_debit = 0 ?>
                <?php $end_credit = 0 ?>
                <?php $total_income_end_debit = 0 ?>
                <?php $total_income_end_credit = 0 ?>
                @foreach($coa_detail2 as $cd => $cdd)
                    @if($cdd->sum('debit') != 0 or $cdd->sum('credit') != 0)
                    <tr>
                        @foreach($income as $c)
                        <?php $move_debit = 0 ?>
                        <?php $move_credit = 0 ?>
                            @if($c->id == $cd)
                                <td colspan="2"><a>@foreach($coa as $coaa) @if($coaa->id == $cd) ({{$coaa->code}}) - {{$coaa->name}} @endif @endforeach</a></td>
                                <td class="text-right"><a>0.00</a></td>
                                <td class="text-right"><a>0.00</a></td>
                                @foreach($cdd as $cddd)
                                <?php $move_debit += $cddd->debit?>
                                <?php $move_credit += $cddd->credit?>
                                <?php $total_income_move_debit += $cddd->debit ?>
                                <?php $total_income_move_credit += $cddd->credit ?>
                                <?php $end_debit = $move_debit - $move_credit?>
                                <?php $end_credit = $move_debit - $move_credit?>
                                @endforeach
                                <td class="text-right"><a>@number($move_debit)</a></td>
                                <td class="text-right"><a>@number($move_credit)</a></td>
                                @if($end_debit < 0)
                                <td class="text-right"><a>0.00</a></td>
                                <td class="text-right"><a>@number(abs($end_credit))</a></td>
                                <?php $total_income_end_credit += $end_credit ?>
                                @else
                                <td class="text-right"><a>@number($end_debit)</a></td>
                                <td class="text-right"><a>0.00</a></td>
                                <?php $total_income_end_debit += $end_debit ?>
                                @endif
                            @endif
                        @endforeach
                    </tr>
                    @endif
                @endforeach
                <tr>
                    <td colspan="8">
                        <a><strong>Expense</strong></a>
                    </td>
                </tr>
                <?php $move_debit = 0 ?>
                <?php $move_credit = 0 ?>
                <?php $total_expense_move_debit = 0 ?>
                <?php $total_expense_move_credit = 0 ?>
                <?php $end_debit = 0 ?>
                <?php $end_credit = 0 ?>
                <?php $total_expense_end_debit = 0 ?>
                <?php $total_expense_end_credit = 0 ?>
                @foreach($coa_detail2 as $cd => $cdd)
                    @if($cdd->sum('debit') != 0 or $cdd->sum('credit') != 0)
                    <tr>
                        @foreach($expense as $c)
                        <?php $move_debit = 0 ?>
                        <?php $move_credit = 0 ?>
                            @if($c->id == $cd)
                                <td colspan="2"><a>@foreach($coa as $coaa) @if($coaa->id == $cd) ({{$coaa->code}}) - {{$coaa->name}} @endif @endforeach</a></td>
                                <td class="text-right"><a>0.00</a></td>
                                <td class="text-right"><a>0.00</a></td>
                                @foreach($cdd as $cddd)
                                <?php $move_debit += $cddd->debit?>
                                <?php $move_credit += $cddd->credit?>
                                <?php $total_expense_move_debit += $cddd->debit ?>
                                <?php $total_expense_move_credit += $cddd->credit ?>
                                <?php $end_debit = $move_debit - $move_credit?>
                                <?php $end_credit = $move_debit - $move_credit?>
                                @endforeach
                                <td class="text-right"><a>@number($move_debit)</a></td>
                                <td class="text-right"><a>@number($move_credit)</a></td>
                                @if($end_debit < 0)
                                <td class="text-right"><a>0.00</a></td>
                                <td class="text-right"><a>@number(abs($end_credit))</a></td>
                                <?php $total_expense_end_credit += $end_credit ?>
                                @else
                                <td class="text-right"><a>@number($end_debit)</a></td>
                                <td class="text-right"><a>0.00</a></td>
                                <?php $total_expense_end_debit += $end_debit ?>
                                @endif
                            @endif
                        @endforeach
                    </tr>
                    @endif
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" class="text-left btn-dark"><strong>Total</strong></td>
                    <?php $grand_move_debit = $total_asset_move_debit + $total_liability_move_debit + $total_equity_move_debit + $total_income_move_debit + $total_expense_move_debit?>
                    <?php $grand_move_credit = $total_asset_move_credit + $total_liability_move_credit + $total_equity_move_credit + $total_income_move_credit + $total_expense_move_credit?>
                    <?php $grand_end_debit = $total_asset_end_debit + $total_liability_end_debit + $total_equity_end_debit + $total_income_end_debit + $total_expense_end_debit?>
                    <?php $grand_end_credit = $total_asset_end_credit + $total_liability_end_credit + $total_equity_end_credit + $total_income_end_credit + $total_expense_end_credit?>
                    <th class="btn-dark text-right" style="width: 120px">0.00</th>
                    <th class="btn-dark text-right" style="width: 120px">0.00</th>
                    <th class="btn-dark text-right" style="width: 120px">@number($grand_move_debit)</th>
                    <th class="btn-dark text-right" style="width: 120px">@number($grand_move_credit)</th>
                    <th class="btn-dark text-right" style="width: 120px">@number($grand_end_debit)</th>
                    <th class="btn-dark text-right" style="width: 120px">@number(abs($grand_end_credit))</th>
                </tr>
            </tfoot>
        </table>
    </div>
</body>

</html>
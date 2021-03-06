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
        <?php $total_current_assets = 0 ?>
        <?php $total_fixed_assets = 0 ?>
        <?php $total_depreciation = 0 ?>
        <?php $total_assets = 0 ?>
        <?php $total_liability = 0 ?>
        @foreach($coa_detail as $a)
        @if($a->coa->coa_category_id == 1 or $a->coa->coa_category_id == 2 or $a->coa->coa_category_id == 3 or
        $a->coa->coa_category_id == 4)
        <?php $total_current_assets += $a->total ?>
        @endif
        @if($a->coa->coa_category_id == 5 or $a->coa->coa_category_id == 6)
        <?php $total_fixed_assets += $a->total ?>
        @endif
        @if($a->coa->coa_category_id == 7)
        <?php $total_depreciation += $a->total ?>
        @endif
        @if($a->coa->coa_category_id == 8 or $a->coa->coa_category_id == 10 or $a->coa->coa_category_id == 17)
        <?php $total_liability += $a->total2 ?>
        @endif
        @endforeach
        <?php $total_assets = $total_current_assets + $total_fixed_assets - $total_depreciation ?>
        <?php $last_periode_total_current_assets = 0 ?>
        <?php $last_periode_total_fixed_assets = 0 ?>
        <?php $last_periode_total_depreciation = 0 ?>
        <?php $last_periode_total_assets = 0 ?>
        <?php $last_periode_total_liability = 0 ?>
        @foreach($last_periode_coa_detail as $a)
        @if($a->coa->coa_category_id == 1 or $a->coa->coa_category_id == 2 or $a->coa->coa_category_id == 3 or
        $a->coa->coa_category_id == 4)
        <?php $last_periode_total_current_assets += $a->total ?>
        @endif
        @if($a->coa->coa_category_id == 5 or $a->coa->coa_category_id == 6)
        <?php $last_periode_total_fixed_assets += $a->total ?>
        @endif
        @if($a->coa->coa_category_id == 7)
        <?php $last_periode_total_depreciation += $a->total ?>
        @endif
        @if($a->coa->coa_category_id == 8 or $a->coa->coa_category_id == 10 or $a->coa->coa_category_id == 17)
        <?php $last_periode_total_liability += $a->total2 ?>
        @endif
        @endforeach
        <?php $last_periode_total_assets    = $last_periode_total_current_assets + $last_periode_total_fixed_assets - $last_periode_total_depreciation ?>
        <?php $last_periode_earning         = 0; //$last_periode_total_assets - $last_periode_total_liability;
        ?>
        <?php $current_period_earning       = $total_assets - $total_liability; ?>
        <?php $total_equity2                = $current_period_earning + $last_periode_earning; ?>
        <?php $total_lia_eq                 = $total_liability + $total_equity2; ?>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th colspan="5" style="text-align: center;">
                        <strong>{{$company->name}}</strong>
                    </th>
                </tr>
                <tr>
                    <th colspan="5" style="text-align: center;">
                        <strong>Balance Sheet</strong>
                    </th>
                </tr>
                <tr>
                    <th colspan="5" style="text-align: center;">
                        <strong>{{$start}} - {{$end}}</strong>
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
                    <td colspan="5" class="btn-dark"><b>Assets</b></td>
                </tr>
                {{-- start CURRENT ASSETS--}}
                <tr>
                    <td></td>
                    <td colspan="4"><b>Current Assets</b></td>
                </tr>
                <?php $stop = 0 ?>
                @foreach($coa_detail as $a)
                @if($a->total != 0)
                @if($a->coa->coa_category_id == 1)
                @if($a->coa->is_parent == 1)
                @if($stop == 0)
                <?php $stop += 1 ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td>{{$a->coa->code}} - {{$a->coa->name}}</td>
                    <td></td>
                    <td class="text-right">@if($a->total < 0) ( @number(abs($a->total)) ) @else @number($a->total)
                            @endif</td>
                </tr>
                @endif
                @endif
                @endif
                @endif
                @endforeach
                <?php $stop = 0 ?>
                @foreach($coa_detail as $a)
                @if($a->total != 0)
                @if($a->coa->coa_category_id == 1)
                @if($a->coa->is_parent == 0)
                @if($stop == 0)
                <?php $stop += 1 ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td>1-10100 - Account Receivable (A/R)</td>
                    <td></td>
                    <td></td>
                </tr>
                @endif
                <tr>
                    <td></td>
                    <td></td>
                    <td style="padding-left:30px">{{$a->coa->code}} - {{$a->coa->name}}</td>
                    <td></td>
                    <td class="text-right">@if($a->total < 0) ( @number(abs($a->total)) ) @else @number($a->total)
                            @endif</td>
                </tr>
                @endif
                @endif
                @endif
                @endforeach
                <?php $stop = 0 ?>
                @foreach($coa_detail as $a)
                @if($a->total != 0)
                @if($a->coa->coa_category_id == 2)
                @if($a->coa->is_parent == 1)
                @if($stop == 0)
                <?php $stop += 1 ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td>{{$a->coa->code}} - {{$a->coa->name}}</td>
                    <td></td>
                    <td class="text-right">@if($a->total < 0) ( @number(abs($a->total)) ) @else @number($a->total)
                            @endif</td>
                </tr>
                @endif
                @endif
                @endif
                @endif
                @endforeach
                <?php $stop = 0 ?>
                @foreach($coa_detail as $a)
                @if($a->total != 0)
                @if($a->coa->coa_category_id == 2)
                @if($a->coa->is_parent == 0)
                @if($stop == 0)
                <?php $stop += 1 ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td>1-10300 - Other Current Assets</td>
                    <td></td>
                    <td></td>
                </tr>
                @endif
                <tr>
                    <td></td>
                    <td></td>
                    <td style="padding-left:30px">{{$a->coa->code}} - {{$a->coa->name}}</td>
                    <td></td>
                    <td class="text-right">@if($a->total < 0) ( @number(abs($a->total)) ) @else @number($a->total)
                            @endif</td>
                </tr>
                @endif
                @endif
                @endif
                @endforeach
                <?php $stop = 0 ?>
                @foreach($coa_detail as $a)
                @if($a->total != 0)
                @if($a->coa->coa_category_id == 3)
                @if($a->coa->is_parent == 1)
                @if($stop == 0)
                <?php $stop += 1 ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td>{{$a->coa->code}} - {{$a->coa->name}}</td>
                    <td></td>
                    <td class="text-right">@if($a->total < 0) ( @number(abs($a->total)) ) @else @number($a->total)
                            @endif</td>
                </tr>
                @endif
                @endif
                @endif
                @endif
                @endforeach
                <?php $stop = 0 ?>
                @foreach($coa_detail as $a)
                @if($a->total != 0)
                @if($a->coa->coa_category_id == 3)
                @if($a->coa->is_parent == 0)
                @if($stop == 0)
                <?php $stop += 1 ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td>1-10000 - Cash and Bank</td>
                    <td></td>
                    <td></td>
                </tr>
                @endif
                <tr>
                    <td></td>
                    <td></td>
                    <td style="padding-left:30px">{{$a->coa->code}} - {{$a->coa->name}}</td>
                    <td></td>
                    <td class="text-right">@if($a->total < 0) ( @number(abs($a->total)) ) @else @number($a->total)
                            @endif</td>
                </tr>
                @endif
                @endif
                @endif
                @endforeach
                <?php $stop = 0 ?>
                @foreach($coa_detail as $a)
                @if($a->total != 0)
                @if($a->coa->coa_category_id == 4)
                @if($a->coa->is_parent == 1)
                @if($stop == 0)
                <?php $stop += 1 ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td>{{$a->coa->code}} - {{$a->coa->name}}</td>
                    <td></td>
                    <td class="text-right">@if($a->total < 0) ( @number(abs($a->total)) ) @else @number($a->total)
                            @endif</td>
                </tr>
                @endif
                @endif
                @endif
                @endif
                @endforeach
                <?php $stop = 0 ?>
                @foreach($coa_detail as $a)
                @if($a->total != 0)
                @if($a->coa->coa_category_id == 4)
                @if($a->coa->is_parent == 0)
                @if($stop == 0)
                <?php $stop += 1 ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td>1-10200 - Inventory</td>
                    <td></td>
                    <td></td>
                </tr>
                @endif
                <tr>
                    <td></td>
                    <td></td>
                    <td style="padding-left:30px">{{$a->coa->code}} - {{$a->coa->name}}</td>
                    <td></td>
                    <td class="text-right">@if($a->total < 0) ( @number(abs($a->total)) ) @else @number($a->total)
                            @endif</td>
                </tr>
                @endif
                @endif
                @endif
                @endforeach
                <tr>
                    <td></td>
                    <td colspan="3"><b>Total Current Assets</b></td>
                    <td class="text-right"><b>@if($total_current_assets < 0) ( @number(abs($total_current_assets)) )
                                @else @number($total_current_assets) @endif</b> </td> </tr> {{-- end CURRENT ASSETS--}}
                                {{-- start FIXED ASSETS--}} @if($total_fixed_assets !=0) <tr>
                    <td></td>
                    <td colspan="4"><b>Fixed Assets</b></td>
                </tr>
                <?php $stop = 0 ?>
                @foreach($coa_detail as $a)
                @if($a->total != 0)
                @if($a->coa->coa_category_id == 5)
                @if($a->coa->is_parent == 1)
                @if($stop == 0)
                <?php $stop += 1 ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td>{{$a->coa->code}} - {{$a->coa->name}}</td>
                    <td></td>
                    <td class="text-right">@if($a->total < 0) ( @number(abs($a->total)) ) @else @number($a->total)
                            @endif</td>
                </tr>
                @endif
                @endif
                @endif
                @endif
                @endforeach
                <?php $stop = 0 ?>
                @foreach($coa_detail as $a)
                @if($a->total != 0)
                @if($a->coa->coa_category_id == 5)
                @if($a->coa->is_parent == 0)
                @if($stop == 0)
                <?php $stop += 1 ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td>1-10700 - Fixed Assets</td>
                    <td></td>
                    <td></td>
                </tr>
                @endif
                <tr>
                    <td></td>
                    <td></td>
                    <td style="padding-left:30px">{{$a->coa->code}} - {{$a->coa->name}}</td>
                    <td></td>
                    <td class="text-right">@if($a->total < 0) ( @number(abs($a->total)) ) @else @number($a->total)
                            @endif</td>
                </tr>
                @endif
                @endif
                @endif
                @endforeach
                <?php $stop = 0 ?>
                @foreach($coa_detail as $a)
                @if($a->total != 0)
                @if($a->coa->coa_category_id == 6)
                @if($a->coa->is_parent == 1)
                @if($stop == 0)
                <?php $stop += 1 ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td>{{$a->coa->code}} - {{$a->coa->name}}</td>
                    <td></td>
                    <td class="text-right">@if($a->total < 0) ( @number(abs($a->total)) ) @else @number($a->total)
                            @endif</td>
                </tr>
                @endif
                @endif
                @endif
                @endif
                @endforeach
                <?php $stop = 0 ?>
                @foreach($coa_detail as $a)
                @if($a->total != 0)
                @if($a->coa->coa_category_id == 6)
                @if($a->coa->is_parent == 0)
                @if($stop == 0)
                <?php $stop += 1 ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td>1-10800 - Other Assets</td>
                    <td></td>
                    <td></td>
                </tr>
                @endif
                <tr>
                    <td></td>
                    <td></td>
                    <td style="padding-left:30px">{{$a->coa->code}} - {{$a->coa->name}}</td>
                    <td></td>
                    <td class="text-right">@if($a->total < 0) ( @number(abs($a->total)) ) @else @number($a->total)
                            @endif</td>
                </tr>
                @endif
                @endif
                @endif
                @endforeach
                <tr>
                    <td></td>
                    <td colspan="3"><b>Total Fixed Assets</b></td>
                    <td class="text-right"><b>@if($total_fixed_assets < 0) ( @number(abs($total_fixed_assets)) ) @else
                                @number($total_fixed_assets) @endif</b> </td> </tr> @endif {{-- end FIXED ASSETS--}}
                                {{-- stat DEPRECIATION--}} @if($total_depreciation !=0) <tr>
                    <td></td>
                    <td colspan="4"><b>Depreciation and Amortization</b></td>
                </tr>
                <?php $stop = 0 ?>
                @foreach($coa_detail as $a)
                @if($a->total != 0)
                @if($a->coa->coa_category_id == 7)
                @if($a->coa->is_parent == 1)
                @if($stop == 0)
                <?php $stop += 1 ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td>{{$a->coa->code}} - {{$a->coa->name}}</td>
                    <td></td>
                    <td class="text-right">@if($a->total < 0) ( @number(abs($a->total)) ) @else @number($a->total)
                            @endif</td>
                </tr>
                @endif
                @endif
                @endif
                @endif
                @endforeach
                <?php $stop = 0 ?>
                @foreach($coa_detail as $a)
                @if($a->total != 0)
                @if($a->coa->coa_category_id == 7)
                @if($a->coa->is_parent == 0)
                @if($stop == 0)
                <?php $stop += 1 ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td>1-10750 - Depreciation and Amortization</td>
                    <td></td>
                    <td></td>
                </tr>
                @endif
                <tr>
                    <td></td>
                    <td></td>
                    <td style="padding-left:30px">{{$a->coa->code}} - {{$a->coa->name}}</td>
                    <td></td>
                    <td class="text-right">@if($a->total < 0) ( @number(abs($a->total)) ) @else @number($a->total)
                            @endif</td>
                </tr>
                @endif
                @endif
                @endif
                @endforeach
                <tr>
                    <td></td>
                    <td colspan="3"><b>Total Depreciation and Amortization</b></td>
                    <td class="text-right"><b>@if($total_depreciation < 0) ( @number(abs($total_depreciation)) ) @else
                                @number($total_depreciation) @endif</b> </td> </tr> @endif {{-- end DEPRECIATION--}}
                                {{-- start TOTAL ASSET--}} <tr>
                    <td colspan="4"><b>Total Assets</b></td>
                    <td class="text-right"><b>@if($total_assets < 0) ( @number(abs($total_assets)) ) @else
                                @number($total_assets) @endif</b> </td> </tr> {{-- end TOTAL ASSET--}} <tr>
                    <td colspan="5" class="btn-dark"><b>Liability and Equity</b></td>
                </tr>
                {{-- start CURRENT LIABILITY--}}
                @if($total_liability != 0)
                <tr>
                    <td></td>
                    <td colspan="4"><b>Current Liability</b></td>
                </tr>
                <?php $stop = 0 ?>
                @foreach($coa_detail as $a)
                @if($a->total != 0)
                @if($a->coa->coa_category_id == 8)
                @if($a->coa->is_parent == 1)
                @if($stop == 0)
                <?php $stop += 1 ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td>{{$a->coa->code}} - {{$a->coa->name}}</td>
                    <td></td>
                    <td class="text-right">@if($a->total < 0) ( @number(abs($a->total)) ) @else @number($a->total)
                            @endif</td>
                </tr>
                @endif
                @endif
                @endif
                @endif
                @endforeach
                <?php $stop = 0 ?>
                @foreach($coa_detail as $a)
                @if($a->total != 0)
                @if($a->coa->coa_category_id == 8)
                @if($a->coa->is_parent == 0)
                @if($stop == 0)
                <?php $stop += 1 ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td>2-20100 - Trade Payable</td>
                    <td></td>
                    <td></td>
                </tr>
                @endif
                <tr>
                    <td></td>
                    <td></td>
                    <td style="padding-left:30px">{{$a->coa->code}} - {{$a->coa->name}}</td>
                    <td></td>
                    <td class="text-right">@if($a->total < 0) ( @number(abs($a->total)) ) @else @number($a->total)
                            @endif</td>
                </tr>
                @endif
                @endif
                @endif
                @endforeach
                <?php $stop = 0 ?>
                @foreach($coa_detail as $a)
                @if($a->total != 0)
                @if($a->coa->coa_category_id == 10)
                @if($a->coa->is_parent == 1)
                @if($stop == 0)
                <?php $stop += 1 ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td>{{$a->coa->code}} - {{$a->coa->name}}</td>
                    <td></td>
                    <td class="text-right">@if($a->total < 0) ( @number(abs($a->total)) ) @else @number($a->total)
                            @endif</td>
                </tr>
                @endif
                @endif
                @endif
                @endif
                @endforeach
                <?php $stop = 0 ?>
                @foreach($coa_detail as $a)
                @if($a->total != 0)
                @if($a->coa->coa_category_id == 10)
                @if($a->coa->is_parent == 0)
                @if($stop == 0)
                <?php $stop += 1 ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td>2-20200 - Other Current Liabilities</td>
                    <td></td>
                    <td></td>
                </tr>
                @endif
                <tr>
                    <td></td>
                    <td></td>
                    <td style="padding-left:30px">{{$a->coa->code}} - {{$a->coa->name}}</td>
                    <td></td>
                    <td class="text-right">@if($a->total < 0) ( @number(abs($a->total)) ) @else @number($a->total)
                            @endif</td>
                </tr>
                @endif
                @endif
                @endif
                @endforeach
                <?php $stop = 0 ?>
                @foreach($coa_detail as $a)
                @if($a->total != 0)
                @if($a->coa->coa_category_id == 17)
                @if($a->coa->is_parent == 1)
                @if($stop == 0)
                <?php $stop += 1 ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td>{{$a->coa->code}} - {{$a->coa->name}}</td>
                    <td></td>
                    <td class="text-right">@if($a->total < 0) ( @number(abs($a->total)) ) @else @number($a->total)
                            @endif</td>
                </tr>
                @endif
                @endif
                @endif
                @endif
                @endforeach
                <?php $stop = 0 ?>
                @foreach($coa_detail as $a)
                @if($a->total != 0)
                @if($a->coa->coa_category_id == 17)
                @if($a->coa->is_parent == 0)
                @if($stop == 0)
                <?php $stop += 1 ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td>8-80000 - Other Expense</td>
                    <td></td>
                    <td></td>
                </tr>
                @endif
                <tr>
                    <td></td>
                    <td></td>
                    <td style="padding-left:30px">{{$a->coa->code}} - {{$a->coa->name}}</td>
                    <td></td>
                    <td class="text-right">@if($a->total < 0) ( @number(abs($a->total)) ) @else @number($a->total)
                            @endif</td>
                </tr>
                @endif
                @endif
                @endif
                @endforeach
                <tr>
                    <td></td>
                    <td colspan="3"><b>Total Liability</b></td>
                    <td class="text-right"><b>@if($total_liability < 0) ( @number(abs($total_liability)) ) @else
                                @number($total_liability) @endif</b> </td> </tr> @endif {{-- end CURRENT LIABILITY--}}
                                {{-- start EQUITY--}} <tr>
                    <td></td>
                    <td colspan="4"><b>Equity</b></td>
                </tr>
                <?php $stop = 0 ?>
                @foreach($coa_detail as $a)
                @if($a->total != 0)
                @if($a->coa->coa_category_id == 12)
                @if($a->coa->is_parent == 1)
                <tr>
                    <td></td>
                    <td></td>
                    <td>{{$a->coa->code}} - {{$a->coa->name}}</td>
                    <td></td>
                    <td class="text-right">@if($a->total < 0) ( @number(abs($a->total)) ) @else @number($a->total)
                            @endif</td>
                </tr>
                @endif
                @if($stop == 0)
                <?php $stop += 1 ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td>3-30000 - Equity</td>
                    <td></td>
                    <td></td>
                </tr>
                @endif
                @if($a->coa->is_parent == 0)
                <tr>
                    <td></td>
                    <td></td>
                    <td style="padding-left:30px">{{$a->coa->code}} - {{$a->coa->name}}</td>
                    <td></td>
                    <td class="text-right">@if($a->total < 0) ( @number(abs($a->total)) ) @else @number($a->total)
                            @endif</td>
                </tr>
                @endif
                @endif
                @endif
                @endforeach
                {{-- end EQUITY--}}
                <tr>
                    <td></td>
                    <td></td>
                    <td>Accumulated other comprehensive income</td>
                    <td></td>
                    <?php $accu = 0.00 ?>
                    <td class="text-right">@number($accu)</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>Earnings up to Last Period</td>
                    <td></td>
                    <td class="text-right"><b>@if($last_periode_earning < 0) ( @number(abs($last_periode_earning)) )
                                @else @number($last_periode_earning) @endif</b> </td> </tr> <tr>
                    <td></td>
                    <td></td>
                    <td>Current Period Earnings</td>
                    <td></td>
                    <td class="text-right"><b>@if($current_period_earning < 0) ( @number(abs($current_period_earning)) )
                                @else @number($current_period_earning) @endif</b> </td> </tr> <tr>
                    <td></td>
                    <td colspan="3"><b>Total Equity</b></td>
                    <td class="text-right"><b>@if($total_equity2 < 0) ( @number(abs($total_equity2)) ) @else
                                @number($total_equity2) @endif</b> </td> </tr> <tr>
                    <td colspan="4"><b>Total Liability and Equity</b></td>
                    <td class="text-right"><b>@if($total_lia_eq < 0) ( @number(abs($total_lia_eq)) ) @else
                                @number($total_lia_eq) @endif</b> </td> </tr> </tbody> </table> </div> </body> </html>

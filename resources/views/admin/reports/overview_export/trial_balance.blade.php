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
            <td colspan="2">
                <a><strong>Asset</strong></a>
            </td>
            <td>
                <a><strong></strong></a>
            </td>
            <td>
                <a><strong></strong></a>
            </td>
            <td>
                <a><strong></strong></a>
            </td>
            <td>
                <a><strong></strong></a>
            </td>
            <td>
                <a><strong></strong></a>
            </td>
            <td>
                <a><strong></strong></a>
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
            <td colspan="2">
                <a><strong>Liability</strong></a>
            </td>
            <td>
                <a><strong></strong></a>
            </td>
            <td>
                <a><strong></strong></a>
            </td>
            <td>
                <a><strong></strong></a>
            </td>
            <td>
                <a><strong></strong></a>
            </td>
            <td>
                <a><strong></strong></a>
            </td>
            <td>
                <a><strong></strong></a>
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
            <td colspan="2">
                <a><strong>Equity</strong></a>
            </td>
            <td>
                <a><strong></strong></a>
            </td>
            <td>
                <a><strong></strong></a>
            </td>
            <td>
                <a><strong></strong></a>
            </td>
            <td>
                <a><strong></strong></a>
            </td>
            <td>
                <a><strong></strong></a>
            </td>
            <td>
                <a><strong></strong></a>
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
            <td colspan="2">
                <a><strong>Income</strong></a>
            </td>
            <td>
                <a><strong></strong></a>
            </td>
            <td>
                <a><strong></strong></a>
            </td>
            <td>
                <a><strong></strong></a>
            </td>
            <td>
                <a><strong></strong></a>
            </td>
            <td>
                <a><strong></strong></a>
            </td>
            <td>
                <a><strong></strong></a>
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
            <td colspan="2">
                <a><strong>Expense</strong></a>
            </td>
            <td>
                <a><strong></strong></a>
            </td>
            <td>
                <a><strong></strong></a>
            </td>
            <td>
                <a><strong></strong></a>
            </td>
            <td>
                <a><strong></strong></a>
            </td>
            <td>
                <a><strong></strong></a>
            </td>
            <td>
                <a><strong></strong></a>
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
@extends('layouts/admin')

@section('contentheader')
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Trial Balance</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link">Start Date </a></li>
                    <li><input value="{{$start}}" type="date" id="datepicker1" class="form-control"></li>
                    <li><a class="collapse-link">End Date </a></li>
                    <li><input value="{{$end}}" type="date" id="datepicker2" class="form-control"></li>
                    <li>
                        <button type="button" id="click" class="btn btn-dark" onclick="next()">Filter</button>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="col-12 table-responsive">
                                    <table class="table table-bordered">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@push('scripts')
<script src="{{ asset('js/other/zebradatepicker.js') }}" charset="utf-8"></script>
<script>
    function next() {
        var start   = document.getElementById('datepicker1');
        var end     = document.getElementById('datepicker2');
        window.location.href = "/reports/trial_balance/" + start.value + '&' + end.value;
    }
</script>
@endpush
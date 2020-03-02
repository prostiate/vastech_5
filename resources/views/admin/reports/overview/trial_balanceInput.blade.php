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
                    <!--{{--<li>
                        <button class="btn btn-dark dropdown-toggle" type="button" onclick="window.location.href = '#';" data-toggle="modal" data-target=".bs-example-modal-lg">More Filter
                        </button>
                        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-md">
                                <form method="post" id="formCreate">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                            </button>
                                            <h3 class="modal-title" id="myModalLabel"><strong>Reports Filter</strong></h3>
                                        </div>
                                        <div class="modal-body">
                                            <div class="col-md-12">
                                                <div class="form-horizontal form-label-left">
                                                    <div class="form-group row">
                                                        <label>Start Date</label>
                                                        <input value="{{$start}}" type="date" id="datepicker3" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-horizontal form-label-left">
                                                    <div class="form-group row">
                                                        <label>End Date</label>
                                                        <input value="{{$end}}" type="date" id="datepicker4" class="form-control">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-horizontal form-label-left">
                                                    <div class="form-group row">
                                                        <label>Filter by Period</label>
                                                        <select name="type_limit_balance" class="form-control selectbankname">
                                                            <option value="custom" selected>Custom</option>
                                                            <option value="today">Today</option>
                                                            <option value="this_week">This Week</option>
                                                            <option value="this_month">This Month</option>
                                                            <option value="this_year">This Year</option>
                                                            <option value="yesterday">Yesterday</option>
                                                            <option value="last_week">Last Week</option>
                                                            <option value="last_month">Last Month</option>
                                                            <option value="last_year">Last Year</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <br>
                                            <div class="col-md-1 center-margin">
                                                <div class="form-horizontal">
                                                    <div class="form-group row">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                                            <button type="button" id="click" class="btn btn-dark" onclick="nextMoreFilter()">Filter</button>
                                            <input type="text" name="hidden_id" id="hidden_id" hidden>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </li>--}}-->
                    <li>
                        <button data-toggle="dropdown" class="btn btn-dark mr-5 dropdown-toggle" type="button" aria-expanded="false">Export
                        </button>
                        <ul role="menu" class="dropdown-menu">
                            <li><a onclick="excel()">Excel</a>
                            </li>
                            <li><a onclick="csv()">CSV</a>
                            </li>
                        </ul>
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
                                                <td colspan="8">
                                                    <a><strong>Asset</strong></a>
                                                </td>
                                            </tr>
                                            <?php $total_init_debit = 0 ?>
                                            <?php $total_init_credit = 0 ?>
                                            <?php $total_move_debit = 0 ?>
                                            <?php $total_move_credit = 0 ?>
                                            <?php $total_end_debit = 0 ?>
                                            <?php $total_end_credit = 0 ?>
                                            @foreach($asset as $i => $coa)
                                                @if(isset($coa_detail3[$coa->id]) || isset($coa_detail2[$coa->id]))
                                                <tr>
                                                    <!--UNTUK CARI CREDIT/DEBIT DARI COA DETAIL OPENING BALANCE-->
                                                    @if(isset($coa_detail3[$coa->id])){
                                                        <?php $init_debit = $coa_detail3[$coa->id]->first()->debit;
                                                              $init_credit = $coa_detail3[$coa->id]->first()->credit?>
                                                    }@else{
                                                        <?php $init_debit = 0; $init_credit = 0?>
                                                    }@endif
                                                    <!--UNTUK CARI CREDIT/DEBIT DARI COA DETAIL NON-OPENING BALANCE-->
                                                    @if(isset($coa_detail2[$coa->id])){
                                                        <?php $debit = $coa_detail2[$coa->id]->first()->debit;
                                                              $credit = $coa_detail2[$coa->id]->first()->credit?>
                                                    }@else{
                                                        <?php $debit = 0; $credit = 0;?>
                                                    }@endif
                                                    <?php
                                                     $init_balance = ($init_debit - $init_credit);
                                                     $move_balance = ($debit - $credit);
                                                     $end_balance = ($init_debit - $init_credit) + $move_balance;
                                                    ?>

                                                    <td colspan="2">({{$coa->code}}) - {{$coa->name}} </a></td>
                                                    @if($init_balance < 0)
                                                    <td class="text-right"><a>0.00</a></td>
                                                    <td class="text-right"><a>@number(abs($init_balance))</a></td>
                                                    <?php $total_init_credit += $init_balance ?>
                                                    @else
                                                    <td class="text-right"><a>@number($init_balance)</a></td>
                                                    <td class="text-right"><a>0.00</a></td>
                                                    <?php $total_init_debit += $init_balance ?>
                                                    @endif
                                                    @if($move_balance < 0)
                                                    <td class="text-right"><a>0.00</a></td>
                                                    <td class="text-right"><a>@number(abs($move_balance))</a></td>
                                                    <?php $total_move_credit += $move_balance ?>
                                                    @else
                                                    <td class="text-right"><a>@number($move_balance)</a></td>
                                                    <td class="text-right"><a>0.00</a></td>
                                                    <?php $total_move_debit += $move_balance ?>
                                                    @endif
                                                    @if($end_balance < 0)
                                                    <td class="text-right"><a>0.00</a></td>
                                                    <td class="text-right"><a>@number(abs($end_balance))</a></td>
                                                    <?php $total_end_credit += $end_balance ?>
                                                    @else
                                                    <td class="text-right"><a>@number($end_balance)</a></td>
                                                    <td class="text-right"><a>0.00</a></td>
                                                    <?php $total_end_debit += $end_balance ?>
                                                    @endif
                                                </tr>
                                                @endif
                                            @endforeach
                                            <tr>
                                                <td colspan="8">
                                                    <a><strong>Liability</strong></a>
                                                </td>
                                            </tr>
                                            @foreach($liability as $i => $coa)
                                                @if(isset($coa_detail3[$coa->id]) || isset($coa_detail2[$coa->id]))
                                                <tr>
                                                    <!--UNTUK CARI CREDIT/DEBIT DARI COA DETAIL OPENING BALANCE-->
                                                    @if(isset($coa_detail3[$coa->id])){
                                                        <?php $init_debit = $coa_detail3[$coa->id]->first()->debit;
                                                              $init_credit = $coa_detail3[$coa->id]->first()->credit?>
                                                    }@else{
                                                        <?php $init_debit = 0; $init_credit = 0?>
                                                    }@endif
                                                    <!--UNTUK CARI CREDIT/DEBIT DARI COA DETAIL NON-OPENING BALANCE-->
                                                    @if(isset($coa_detail2[$coa->id])){
                                                        <?php $debit = $coa_detail2[$coa->id]->first()->debit;
                                                              $credit = $coa_detail2[$coa->id]->first()->credit?>
                                                    }@else{
                                                        <?php $debit = 0; $credit = 0;?>
                                                    }@endif
                                                    <?php
                                                     $init_balance = ($init_debit - $init_credit);
                                                     $move_balance = ($debit - $credit);
                                                     $end_balance = ($init_debit - $init_credit) + $move_balance;
                                                    ?>

                                                    <td colspan="2">({{$coa->code}}) - {{$coa->name}} </a></td>
                                                    @if($init_balance < 0)
                                                    <td class="text-right"><a>0.00</a></td>
                                                    <td class="text-right"><a>@number(abs($init_balance))</a></td>
                                                    <?php $total_init_credit += $init_balance ?>
                                                    @else
                                                    <td class="text-right"><a>@number($init_balance)</a></td>
                                                    <td class="text-right"><a>0.00</a></td>
                                                    <?php $total_init_debit += $init_balance ?>
                                                    @endif
                                                    @if($move_balance < 0)
                                                    <td class="text-right"><a>0.00</a></td>
                                                    <td class="text-right"><a>@number(abs($move_balance))</a></td>
                                                    <?php $total_move_credit += $move_balance ?>
                                                    @else
                                                    <td class="text-right"><a>@number($move_balance)</a></td>
                                                    <td class="text-right"><a>0.00</a></td>
                                                    <?php $total_move_debit += $move_balance ?>
                                                    @endif
                                                    @if($end_balance < 0)
                                                    <td class="text-right"><a>0.00</a></td>
                                                    <td class="text-right"><a>@number(abs($end_balance))</a></td>
                                                    <?php $total_end_credit += $end_balance ?>
                                                    @else
                                                    <td class="text-right"><a>@number($end_balance)</a></td>
                                                    <td class="text-right"><a>0.00</a></td>
                                                    <?php $total_end_debit += $end_balance ?>
                                                    @endif
                                                </tr>
                                                @endif
                                            @endforeach
                                            <tr>
                                                <td colspan="8">
                                                    <a><strong>Equity</strong></a>
                                                </td>
                                            </tr>
                                            @foreach($equity as $i => $coa)
                                                @if(isset($coa_detail3[$coa->id]) || isset($coa_detail2[$coa->id]))
                                                <tr>
                                                    <!--UNTUK CARI CREDIT/DEBIT DARI COA DETAIL OPENING BALANCE-->
                                                    @if(isset($coa_detail3[$coa->id])){
                                                        <?php $init_debit = $coa_detail3[$coa->id]->first()->debit;
                                                              $init_credit = $coa_detail3[$coa->id]->first()->credit?>
                                                    }@else{
                                                        <?php $init_debit = 0; $init_credit = 0?>
                                                    }@endif
                                                    <!--UNTUK CARI CREDIT/DEBIT DARI COA DETAIL NON-OPENING BALANCE-->
                                                    @if(isset($coa_detail2[$coa->id])){
                                                        <?php $debit = $coa_detail2[$coa->id]->first()->debit;
                                                              $credit = $coa_detail2[$coa->id]->first()->credit?>
                                                    }@else{
                                                        <?php $debit = 0; $credit = 0;?>
                                                    }@endif
                                                    <?php
                                                     $init_balance = ($init_debit - $init_credit);
                                                     $move_balance = ($debit - $credit);
                                                     $end_balance = ($init_debit - $init_credit) + $move_balance;
                                                    ?>

                                                    <td colspan="2">({{$coa->code}}) - {{$coa->name}} </a></td>
                                                    @if($init_balance < 0)
                                                    <td class="text-right"><a>0.00</a></td>
                                                    <td class="text-right"><a>@number(abs($init_balance))</a></td>
                                                    <?php $total_init_credit += $init_balance ?>
                                                    @else
                                                    <td class="text-right"><a>@number($init_balance)</a></td>
                                                    <td class="text-right"><a>0.00</a></td>
                                                    <?php $total_init_debit += $init_balance ?>
                                                    @endif
                                                    @if($move_balance < 0)
                                                    <td class="text-right"><a>0.00</a></td>
                                                    <td class="text-right"><a>@number(abs($move_balance))</a></td>
                                                    <?php $total_move_credit += $move_balance ?>
                                                    @else
                                                    <td class="text-right"><a>@number($move_balance)</a></td>
                                                    <td class="text-right"><a>0.00</a></td>
                                                    <?php $total_move_debit += $move_balance ?>
                                                    @endif
                                                    @if($end_balance < 0)
                                                    <td class="text-right"><a>0.00</a></td>
                                                    <td class="text-right"><a>@number(abs($end_balance))</a></td>
                                                    <?php $total_end_credit += $end_balance ?>
                                                    @else
                                                    <td class="text-right"><a>@number($end_balance)</a></td>
                                                    <td class="text-right"><a>0.00</a></td>
                                                    <?php $total_end_debit += $end_balance ?>
                                                    @endif
                                                </tr>
                                                @endif
                                            @endforeach
                                            <tr>
                                                <td colspan="8">
                                                    <a><strong>Income</strong></a>
                                                </td>
                                            </tr>
                                            @foreach($income as $i => $coa)
                                                @if(isset($coa_detail3[$coa->id]) || isset($coa_detail2[$coa->id]))
                                                <tr>
                                                    <!--UNTUK CARI CREDIT/DEBIT DARI COA DETAIL OPENING BALANCE-->
                                                    @if(isset($coa_detail3[$coa->id])){
                                                        <?php $init_debit = $coa_detail3[$coa->id]->first()->debit;
                                                              $init_credit = $coa_detail3[$coa->id]->first()->credit?>
                                                    }@else{
                                                        <?php $init_debit = 0; $init_credit = 0?>
                                                    }@endif
                                                    <!--UNTUK CARI CREDIT/DEBIT DARI COA DETAIL NON-OPENING BALANCE-->
                                                    @if(isset($coa_detail2[$coa->id])){
                                                        <?php $debit = $coa_detail2[$coa->id]->first()->debit;
                                                              $credit = $coa_detail2[$coa->id]->first()->credit?>
                                                    }@else{
                                                        <?php $debit = 0; $credit = 0;?>
                                                    }@endif
                                                    <?php
                                                     $init_balance = ($init_debit - $init_credit);
                                                     $move_balance = ($debit - $credit);
                                                     $end_balance = ($init_debit - $init_credit) + $move_balance;
                                                    ?>

                                                    <td colspan="2">({{$coa->code}}) - {{$coa->name}} </a></td>
                                                    @if($init_balance < 0)
                                                    <td class="text-right"><a>0.00</a></td>
                                                    <td class="text-right"><a>@number(abs($init_balance))</a></td>
                                                    <?php $total_init_credit += $init_balance ?>
                                                    @else
                                                    <td class="text-right"><a>@number($init_balance)</a></td>
                                                    <td class="text-right"><a>0.00</a></td>
                                                    <?php $total_init_debit += $init_balance ?>
                                                    @endif
                                                    @if($move_balance < 0)
                                                    <td class="text-right"><a>0.00</a></td>
                                                    <td class="text-right"><a>@number(abs($move_balance))</a></td>
                                                    <?php $total_move_credit += $move_balance ?>
                                                    @else
                                                    <td class="text-right"><a>@number($move_balance)</a></td>
                                                    <td class="text-right"><a>0.00</a></td>
                                                    <?php $total_move_debit += $move_balance ?>
                                                    @endif
                                                    @if($end_balance < 0)
                                                    <td class="text-right"><a>0.00</a></td>
                                                    <td class="text-right"><a>@number(abs($end_balance))</a></td>
                                                    <?php $total_end_credit += $end_balance ?>
                                                    @else
                                                    <td class="text-right"><a>@number($end_balance)</a></td>
                                                    <td class="text-right"><a>0.00</a></td>
                                                    <?php $total_end_debit += $end_balance ?>
                                                    @endif
                                                </tr>
                                                @endif
                                            @endforeach
                                            <tr>
                                                <td colspan="8">
                                                    <a><strong>Expense</strong></a>
                                                </td>
                                            </tr>
                                            @foreach($expense as $i => $coa)
                                                @if(isset($coa_detail3[$coa->id]) || isset($coa_detail2[$coa->id]))
                                                <tr>
                                                    <!--UNTUK CARI CREDIT/DEBIT DARI COA DETAIL OPENING BALANCE-->
                                                    @if(isset($coa_detail3[$coa->id])){
                                                        <?php $init_debit = $coa_detail3[$coa->id]->first()->debit;
                                                              $init_credit = $coa_detail3[$coa->id]->first()->credit?>
                                                    }@else{
                                                        <?php $init_debit = 0; $init_credit = 0?>
                                                    }@endif
                                                    <!--UNTUK CARI CREDIT/DEBIT DARI COA DETAIL NON-OPENING BALANCE-->
                                                    @if(isset($coa_detail2[$coa->id])){
                                                        <?php $debit = $coa_detail2[$coa->id]->first()->debit;
                                                              $credit = $coa_detail2[$coa->id]->first()->credit?>
                                                    }@else{
                                                        <?php $debit = 0; $credit = 0;?>
                                                    }@endif
                                                    <?php
                                                     $init_balance = ($init_debit - $init_credit);
                                                     $move_balance = ($debit - $credit);
                                                     $end_balance = ($init_debit - $init_credit) + $move_balance;
                                                    ?>

                                                    <td colspan="2">({{$coa->code}}) - {{$coa->name}} </a></td>
                                                    @if($init_balance < 0)
                                                    <td class="text-right"><a>0.00</a></td>
                                                    <td class="text-right"><a>@number(abs($init_balance))</a></td>
                                                    <?php $total_init_credit += $init_balance ?>
                                                    @else
                                                    <td class="text-right"><a>@number($init_balance)</a></td>
                                                    <td class="text-right"><a>0.00</a></td>
                                                    <?php $total_init_debit += $init_balance ?>
                                                    @endif
                                                    @if($move_balance < 0)
                                                    <td class="text-right"><a>0.00</a></td>
                                                    <td class="text-right"><a>@number(abs($move_balance))</a></td>
                                                    <?php $total_move_credit += $move_balance ?>
                                                    @else
                                                    <td class="text-right"><a>@number($move_balance)</a></td>
                                                    <td class="text-right"><a>0.00</a></td>
                                                    <?php $total_move_debit += $move_balance ?>
                                                    @endif
                                                    @if($end_balance < 0)
                                                    <td class="text-right"><a>0.00</a></td>
                                                    <td class="text-right"><a>@number(abs($end_balance))</a></td>
                                                    <?php $total_end_credit += $end_balance ?>
                                                    @else
                                                    <td class="text-right"><a>@number($end_balance)</a></td>
                                                    <td class="text-right"><a>0.00</a></td>
                                                    <?php $total_end_debit += $end_balance ?>
                                                    @endif
                                                </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2" class="text-left btn-dark"><strong>Total</strong></td>
                                                <th class="btn-dark text-right" style="width: 120px">@number($total_init_debit)</th>
                                                <th class="btn-dark text-right" style="width: 120px">@number(abs($total_init_credit))</th>
                                                <th class="btn-dark text-right" style="width: 120px">@number($total_move_debit)</th>
                                                <th class="btn-dark text-right" style="width: 120px">@number(abs($total_move_credit))</th>
                                                <th class="btn-dark text-right" style="width: 120px">@number($total_end_debit)</th>
                                                <th class="btn-dark text-right" style="width: 120px">@number(abs($total_end_credit))</th>
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
<script src="{{ asset('js/other/zebradatepicker.js?v=5-20200302-1755') }}" charset="utf-8"></script>
<script>
    function next() {
        var date1   = document.getElementById('datepicker1');
        var date2     = document.getElementById('datepicker2');
        window.location.href = "/reports/trial_balance/start_date=" + date1.value + '&end_date=' + date2.value;
    }
    function nextMoreFilter() {
        var date3   = document.getElementById('datepicker3');
        var date4   = document.getElementById('datepicker4');
        window.location.href = "/reports/trial_balance/start_date=" + date3.value + '&end_date=' + date4.value;
    }
    function excel() {
        var date1   = document.getElementById('datepicker1');
        var date2   = document.getElementById('datepicker2');
        window.location.href = "/reports/trial_balance/excel/start_date=" + date1.value + '&end_date=' + date2.value;
    }
    function csv() {
        var date1   = document.getElementById('datepicker1');
        var date2   = document.getElementById('datepicker2');
        window.location.href = "/reports/trial_balance/csv/start_date=" + date1.value + '&end_date=' + date2.value;
    }
    function pdf() {
        var date1   = document.getElementById('datepicker1');
        var date2   = document.getElementById('datepicker2');
        window.open("/reports/trial_balance/pdf/start_date=" + date1.value + '&end_date=' + date2.value, '_blank');
    }
</script>
@endpush

@extends('layouts/admin')

@section('contentheader')
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>General Ledger</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link">Start Date </a></li>
                    <li><input value="{{$today}}" type="date" id="datepicker1" class="form-control"></li>
                    <li><a class="collapse-link">End Date </a></li>
                    <li><input value="{{$today}}" type="date" id="datepicker2" class="form-control"></li>
                    <li>
                        <button type="button" id="click" class="btn btn-dark" onclick="next()">Filter</button>
                    </li>
                    <li>
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
                                                        <input value="{{$today}}" type="date" id="datepicker3" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-horizontal form-label-left">
                                                    <div class="form-group row">
                                                        <label>End Date</label>
                                                        <input value="{{$today}}" type="date" id="datepicker4" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <!--{{--
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
                                            --}}-->
                                            <div class="col-md-12">
                                                <div class="form-horizontal form-label-left">
                                                    <div class="form-group row">
                                                        <label>Filter by Account</label>
                                                        <select name="filter_by_acc" id="filter_by_acc" class="form-control selectaccount" multiple>
                                                            <option></option>
                                                            @foreach($coa as $a)
                                                            <option value="{{$a->id}}">({{$a->code}}) - {{$a->name}} ({{$a->coa_category->name}})</option>
                                                            @endforeach
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
                    </li>
                    <li>
                        <button data-toggle="dropdown" class="btn btn-dark mr-5 dropdown-toggle" type="button" aria-expanded="false">Export
                        </button>
                        <ul role="menu" class="dropdown-menu">
                            <li><a onclick="excel()">Excel</a>
                            </li>
                            <li><a onclick="csv()">CSV</a>
                            </li>
                            <li><a onclick="pdf()">PDF</a>
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
                                    <table class="table table-hover">
                                        <thead>
                                            <tr class="btn-dark">
                                                <th style="width:150px; text-align: center">Account Name / Date</th>
                                                <th class="text-left">Transaction Number</th>
                                                <th class="text-right">Debit</th>
                                                <th class="text-right">Credit</th>
                                                <th class="text-right">Balance</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $grand_total_debit = 0 ?>
                                            <?php $grand_total_credit = 0 ?>
                                            <?php $balance = 0 ?>
                                            <?php $balance2 = 0 ?>
                                            <?php $total_balance = 0 ?>
                                            <?php $total_balance2 = 0 ?>
                                            <?php $category = 0 ?>
                                            @foreach($coa_detail as $cdb => $cdb2)
                                                @if($cdb2->sum('credit') != 0 or $cdb2->sum('debit') != 0)
                                                <?php $total_debit = 0 ?>
                                                <?php $total_credit = 0 ?>
                                                <tr>
                                                    <td colspan="6">
                                                        @foreach($coa as $ca)
                                                            @if($cdb == $ca->id)
                                                            <a href="/chart_of_accounts/{{$ca->id}}"><strong>({{$ca->code}}) - {{$ca->name}}</strong></a>
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                @foreach($cdb2 as $a)
                                                <?php $total_debit += $a->debit ?>
                                                <?php $total_credit += $a->credit ?>
                                                <?php $grand_total_debit += $a->debit ?>
                                                <?php $grand_total_credit += $a->credit ?>
                                                    @if($a->debit != 0 or $a->credit != 0)
                                                        @if($a->coa->coa_category_id == 13)
                                                        <?php $balance2 += $a->credit - $a->debit ?>
                                                        <?php $category += 1 ?>
                                                        <?php $total_balance2 += $a->credit - $a->debit ?>
                                                            <tr>
                                                                <td>
                                                                    <a>{{$a->date}}</a>
                                                                </td>
                                                                <td>
                                                                    <a>{{$a->number}}</a>
                                                                </td>
                                                                <td class="text-right">
                                                                    <a>@number($a->debit)</a>
                                                                </td>
                                                                <td class="text-right">
                                                                    <a>@number($a->credit)</a>
                                                                </td>
                                                                <td class="text-right">
                                                                    <a>@if($balance2 < 0) ( @number(abs($balance2)) ) @else @number($balance2) @endif</a>
                                                                </td>
                                                            </tr>
                                                        @else
                                                        <?php $balance += $a->debit - $a->credit ?>
                                                        <?php $category += 0 ?>
                                                        <?php $total_balance += $a->debit - $a->credit ?>
                                                            <tr>
                                                                <td>
                                                                    <a>{{$a->date}}</a>
                                                                </td>
                                                                <td>
                                                                    <a>{{$a->number}}</a>
                                                                </td>
                                                                <td class="text-right">
                                                                    <a>@number($a->debit)</a>
                                                                </td>
                                                                <td class="text-right">
                                                                    <a>@number($a->credit)</a>
                                                                </td>
                                                                <td class="text-right">
                                                                    <a>@if($balance < 0) ( @number(abs($balance)) ) @else @number($balance) @endif</a>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endif
                                                @endforeach
                                                <tr>
                                                    <td colspan="1" class="text-center"></td>
                                                    <td style="text-align: right;"><b>Ending Balance</b></td>
                                                    <td class="text-right"><b>@if($total_debit < 0 )( @number(abs($total_debit)) ) @else @number($total_debit) @endif</b></td>
                                                    <td class="text-right"><b>@if($total_credit < 0 )( @number(abs($total_credit)) ) @else @number($total_credit) @endif</b></td>
                                                    <td class="text-right"><b>@if($category > 0) 
                                                                                @if($total_balance2 < 0 )( @number(abs($total_balance2)) ) 
                                                                                @else @number($total_balance2)
                                                                                @endif
                                                                            @else 
                                                                                @if($total_balance < 0 )( @number(abs($total_balance)) ) 
                                                                                @else @number($total_balance)
                                                                                @endif
                                                                            @endif</b></td>
                                                </tr>
                                                <?php $balance = 0 ?>
                                                <?php $balance2 = 0 ?>
                                                <?php $total_balance = 0 ?>
                                                <?php $total_balance2 = 0 ?>
                                                @endif
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="1" class="text-center"></td>
                                                <td style="text-align: right;"><b>Grand Total</b></td>
                                                <td class="text-right"><b>@number($grand_total_debit)</b></td>
                                                <td class="text-right"><b>@number($grand_total_credit)</b></td>
                                                <td></td>
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
<script src="{{ asset('js/other/zebradatepicker.js?v=5-20200211-1624') }}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js?v=5-20200211-1624') }}" charset="utf-8"></script>
<script>
    function next() {
        var date1   = document.getElementById('datepicker1');
        var date2   = document.getElementById('datepicker2');
        var acc     = $('#filter_by_acc').val();
        window.location.href = "/reports/general_ledger/start_date=" + date1.value + '&end_date=' + date2.value + '&account_id=' + acc;
    }
    function nextMoreFilter() {
        var date3   = document.getElementById('datepicker3');
        var date4   = document.getElementById('datepicker4');
        var acc     = $('#filter_by_acc').val();
        /*var acc2    = [];
        for (var i = 0; i < acc.length; i++) {
            if (acc.options[i].selected) acc2.push(acc.options[i].value);
        }
        console.log(acc);*/
        window.location.href = "/reports/general_ledger/start_date=" + date3.value + '&end_date=' + date4.value + '&account_id=' + acc;
    }
    function excel() {
        var date1   = document.getElementById('datepicker1');
        var date2   = document.getElementById('datepicker2');
        var acc     = $('#filter_by_acc').val();
        window.location.href = "/reports/general_ledger/excel/start_date=" + date1.value + '&end_date=' + date2.value + '&account_id=' + acc;
    }
    function csv() {
        var date1   = document.getElementById('datepicker1');
        var date2   = document.getElementById('datepicker2');
        var acc     = $('#filter_by_acc').val();
        window.location.href = "/reports/general_ledger/csv/start_date=" + date1.value + '&end_date=' + date2.value + '&account_id=' + acc;
    }
    function pdf() {
        var date1   = document.getElementById('datepicker1');
        var date2   = document.getElementById('datepicker2');
        var acc     = $('#filter_by_acc').val();
        window.open("/reports/general_ledger/pdf/start_date=" + date1.value + '&end_date=' + date2.value + '&account_id=' + acc, '_blank');
    }
</script>
@endpush
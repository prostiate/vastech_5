@extends('layouts/admin')

@section('contentheader')
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Profit & Loss</h2>
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
        window.location.href = "/reports/profit_loss/start_date=" + date1.value + '&end_date=' + date2.value;
    }
    function nextMoreFilter() {
        var date3   = document.getElementById('datepicker3');
        var date4   = document.getElementById('datepicker4');
        window.location.href = "/reports/profit_loss/start_date=" + date3.value + '&end_date=' + date4.value;
    }
    function excel() {
        var date1   = document.getElementById('datepicker1');
        var date2   = document.getElementById('datepicker2');
        window.location.href = "/reports/profit_loss/excel/start_date=" + date1.value + '&end_date=' + date2.value;
    }
    function csv() {
        var date1   = document.getElementById('datepicker1');
        var date2   = document.getElementById('datepicker2');
        window.location.href = "/reports/profit_loss/csv/start_date=" + date1.value + '&end_date=' + date2.value;
    }
    function pdf() {
        var date1   = document.getElementById('datepicker1');
        var date2   = document.getElementById('datepicker2');
        window.open("/reports/profit_loss/pdf/start_date=" + date1.value + '&end_date=' + date2.value, '_blank');
    }
</script>
@endpush
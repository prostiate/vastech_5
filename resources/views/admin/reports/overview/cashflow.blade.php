@extends('layouts/admin')

@section('contentheader')
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Cash Flow</h2>
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
<script src="{{ asset('js/other/zebradatepicker.js?v=5-20200206-1313') }}" charset="utf-8"></script>
<script>
    function next() {
        var date1   = document.getElementById('datepicker1');
        var date2     = document.getElementById('datepicker2');
        window.location.href = "/reports/cashflow/start_date=" + date1.value + '&end_date=' + date2.value;
    }
    function nextMoreFilter() {
        var date3   = document.getElementById('datepicker3');
        var date4   = document.getElementById('datepicker4');
        window.location.href = "/reports/cashflow/start_date=" + date3.value + '&end_date=' + date4.value;
    }
    function excel() {
        var date1   = document.getElementById('datepicker1');
        var date2   = document.getElementById('datepicker2');
        window.location.href = "/reports/cashflow/excel/start_date=" + date1.value + '&end_date=' + date2.value;
    }
    function csv() {
        var date1   = document.getElementById('datepicker1');
        var date2   = document.getElementById('datepicker2');
        window.location.href = "/reports/cashflow/csv/start_date=" + date1.value + '&end_date=' + date2.value;
    }
    function pdf() {
        var date1   = document.getElementById('datepicker1');
        var date2   = document.getElementById('datepicker2');
        window.open("/reports/cashflow/pdf/start_date=" + date1.value + '&end_date=' + date2.value, '_blank');
    }
</script>
@endpush
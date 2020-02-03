@extends('layouts/admin')

@section('contentheader')
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Executive Summary</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link">Start Date </a></li>
                    <li><input value="{{$today}}" type="date" id="datepicker1" class="form-control"></li>
                    <li><a class="collapse-link">End Date </a></li>
                    <li><input value="{{$today}}" type="date" id="datepicker2" class="form-control"></li>
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
                                    <table class="table table-hover">
                                        <tbody>
                                            <tr>
                                                <td colspan="5" class="btn-dark"><b>Profit & Loss Summary</b></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">Revenues</td>
                                                <td class="text-right">@number($total_primary_income)</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">Cost of Sales</td>
                                                <td class="text-right">@number($total_cost_of_sales)</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">Operational Expense</td>
                                                <td class="text-right">@number($total_operational_expense)</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">Operating Profit</td>
                                                <td class="text-right">@number($net_operating_income)</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">Net Profit</td>
                                                <td class="text-right">@number($net_income)</td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" class="btn-dark"><b>Balance Sheet Summary</b></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">Current Assets</td>
                                                <td class="text-right">@number($total_current_assets)</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">Non Current Asset</td>
                                                <td class="text-right">@number($total_fixed_assets - $total_depreciation)</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">Current Liability</td>
                                                <td class="text-right">@number($total_liability)</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">Non Current Liabilities</td>
                                                <td class="text-right">@number($total_other_liability)</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">Equity</td>
                                                <td class="text-right">@number($total_lia_eq)</td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" class="btn-dark"><b>Cash Flow Summary</b></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">Operating Activities</td>
                                                <td class="text-right">@number($net_cash_operating_acti)</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">Non Operating Activities</td>
                                                <td class="text-right">@number($net_cash_by_investing)</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">Net Cash Movement</td>
                                                <td class="text-right">@number($increase_dec_in_cash)</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">Closing Balance</td>
                                                <td class="text-right">@number($ending_cash)</td>
                                            </tr>
                                            <!--<tr>
                                                <td colspan="5" class="btn-dark"><b>Insights</b></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">Gross Profit Margin</td>
                                                 gross profit = laba kotor = (omset - HPP)
                                                 operating profit = laba bersih opeartional = (gross profit - hpp) - biaya operational/expebnse
                                                 net profit = laba bersih = operating profit + (pendapatan - pengeluaran lain lain) 
                                                 kalau yang margin dibagi omset total 
                                                <td class="text-right"> %</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">Operating Profit Margin</td>
                                                <td class="text-right"> %</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">Net Profit Margin</td>
                                                <td class="text-right"> %</td>
                                            </tr>
                                            <tr>
                                                 current ration = (current asset(bukan fixed) / current liabilites(bukan other liabilities)) 
                                                <td colspan="3">Current Ratio</td>
                                                <td class="text-right">@number($net_income)</td>
                                            </tr>
                                            <tr>
                                                 DER = total liabilities / total equity 
                                                <td colspan="3">Debt to Equity Ratio</td>
                                                <td class="text-right">@number($net_income)</td>
                                            </tr>
                                            <tr>
                                                 ROA = net income(perbulan) / average total asset 
                                                 average total asset =( current + other )/ 2 (karena rata2) 
                                                 hasilnya percentage 
                                                <td colspan="3">Return on Asset</td>
                                                <td class="text-right">@number($net_income)</td>
                                            </tr>
                                            <tr>
                                                 ROA = net income(perbulan) / average total equity 
                                                 average total equity =( current + other )/ 2 (karena rata2) 
                                                 hasilnya percentage 
                                                <td colspan="3">Return on Equity</td>
                                                <td class="text-right">@number($net_income)</td>
                                            </tr>
                                            <tr>
                                                 orang yang hutangin 
                                                 (ar / revenue) * 365 
                                                <td colspan="3">Average Debtors Days</td>
                                                <td class="text-right">@number($net_income)</td>
                                            </tr>
                                            <tr>
                                                 orang yang hutangin 
                                                 (trade payable / cost of sales tahunan) * 365 
                                                <td colspan="3">Average Creditors Days</td>
                                                <td class="text-right">@number($net_income)</td>
                                            </tr>-->
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
<script src="{{ asset('js/other/zebradatepicker.js?v=5-03022020') }}" charset="utf-8"></script>
<script>
    function next() {
        var start   = document.getElementById('datepicker1');
        var end     = document.getElementById('datepicker2');
        window.location.href = "/reports/executive_summary/" + start.value + '&' + end.value;
    }
</script>
@endpush
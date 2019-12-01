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
                                    <table class="table table-hover">
                                        <tbody>
                                            <tr>
                                                <td colspan="5" class="btn-dark"><b>Cash flow from Operating Activities</b></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td colspan="3">Cash received from customers</td>
                                                <td class="text-right">@number($cash_received_from_cust)</td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td colspan="3">Other current assets</td>
                                                <td class="text-right">@number($other_current_asset)</td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td colspan="3">Cash paid to suppliers</td>
                                                <td class="text-right">@number($cash_paid_to_supplier)</td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td colspan="3">Credit cards and current liabilities</td>
                                                <td class="text-right">@number($cc_and_current_liability)</td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td colspan="3">Other incomes</td>
                                                <td class="text-right">@number($other_income)</td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td colspan="3">Operating expenses paid</td>
                                                <td class="text-right">@number($operating_expense)</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4"><b>Net cash provided by Operating Activities</b></td>
                                                <td class="text-right">@number($net_cash_operating_acti)</td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" class="btn-dark"><b>Cash flow from Investing Activities</b></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td colspan="3">Purchase/Sales of assets</td>
                                                <td class="text-right">@number($purchase_sale_asset)</td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td colspan="3">Other investing activities</td>
                                                <td class="text-right">@number($other_investing_asset)</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4"><b>Net cash provided by Investing Activities</b></td>
                                                <td class="text-right">@number($net_cash_by_investing)</td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" class="btn-dark"><b>Cash flow from Financing Activities</b></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td colspan="3">Repayment/Proceeds of loan</td>
                                                <td class="text-right">@number($repayment_proceed_loan)</td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td colspan="3">Equity/Capital</td>
                                                <td class="text-right">@number($equity_capital)</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4"><b>Net cash provided by Financing Activities</b></td>
                                                <td class="text-right">@number($net_cash_finan)</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4"><b>Increase (decrease) in cash</b></td>
                                                <td class="text-right">@number($increase_dec_in_cash)</td>
                                            </tr>
                                            <!--<tr>
                                                <td colspan="4"><b>Net bank revaluation</b></td>
                                                <td class="text-right">0.00</td>
                                            </tr>-->
                                            <tr>
                                                <td colspan="4"><b>Beginning cash balance</b></td>
                                                <td class="text-right">@number($beginning_cash)</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4"><b>Ending cash balance</b></td>
                                                <td class="text-right">@number($ending_cash)</td>
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
<script src="{{ asset('js/other/zebradatepicker.js') }}" charset="utf-8"></script>
<script>
    function next() {
        var start   = document.getElementById('datepicker1');
        var end     = document.getElementById('datepicker2');
        window.location.href = "/reports/cashflow/" + start.value + '&' + end.value;
    }
</script>
@endpush
@extends('layouts/admin')
@section('content')
@hasrole('Owner|Ultimate')
<div class="row">
    <div class="col-md-6 col-sm-6 col-xs-12">
        <!--<div class="x_panel">
            <div class="x_title">
                <h2>Cash Flow</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                @foreach($ending_cash as $c)
                <h2><b>Rp @number($c)</b></h2>
                @endforeach
                <h2><b>Rp </b></h2>
                <small>Cash In & Out Over Time</small>
                @foreach($ending_cash as $c)
                <input class="CF" value="{{$c}}" hidden>
                @endforeach
                <br>
                <br>
                <canvas id="chartCF" height="355" width="710" style="width: 568px; height: 284px;"></canvas>
            </div>
        </div>-->
        <div class="dashboard_graph x_panel">
            <div class="x_title">
                <h2>Cash Flow</h2>
                <div class="clearfix"></div>
                <!--
                <div class="col-md-9">
                    <ul class="nav navbar-right">
                        <li><a class="collapse-link">Start Date </a></li>
                        <li><input value="{{$year}}" type="text" id="datepicker1" class="form-control"></li>
                        <li><a class="collapse-link">End Date </a></li>                        
                        <li><input value="{{$last_year}}" type="text" id="datepicker2" class="form-control"></li>
                            <button type="button" id="click" class="btn btn-dark" onclick="next()">Filter</button>
                        </li>
                    </ul>
                </div>
            -->
            </div>
            <div class="x_content">
                <h2><b>Rp @number($total_cash_flow)</b></h2>
                <canvas id="chartCF" height="355" width="710" style="width: 568px; height: 284px;"></canvas>
                @foreach($ending_cash as $c)
                <input class="CF" value="{{$c}}" hidden>
                @endforeach
                <input class="CF_l_year" value="{{$last_year}}" type="text" hidden>
                <input class="CF_year" value="{{$year}}" type="text" hidden>

            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Expenses</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                @foreach($coa_ex_balance as $a)
                <input class="EX" value="{{$a}}" hidden>
                @endforeach
                @foreach($coa_ex_id as $a)
                <input class="EX_name" value="{{$a->coa->name}}" hidden>
                @endforeach
                <br>
                <br>
                <canvas id="chartEX" height="355" width="710" style="width: 568px; height: 284px;"></canvas>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Account Receivable</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <h2><b>Rp @number($coa_ar_total)</b></h2>
                <input class="AR_ly" value="{{$last_year}}" hidden>
                <input class="AR_cy" value="{{$year}}" hidden>
                @foreach($coa_ar_balance_last_year as $a)
                <input class="AR" value="{{$a}}" hidden>
                @endforeach
                @foreach($coa_ar_balance as $b)
                <input class="AR_1" value="{{$b}}" hidden>
                @endforeach
                <canvas id="chartAR" height="355" width="710" style="width: 568px; height: 284px;"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Account Payable</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <h2><b>Rp @number($coa_ap_total)</b></h2>
                <input class="AP_ly" value="{{$last_year}}" hidden>
                <input class="AP_cy" value="{{$year}}" hidden>
                @foreach($coa_ap_balance_last_year as $a)
                <input class="AP" value="{{$a}}" hidden>
                @endforeach
                @foreach($coa_ap_balance as $b)
                <input class="AP_1" value="{{$b}}" hidden>
                @endforeach
                <canvas id="chartAP" height="355" width="710" style="width: 568px; height: 284px;"></canvas>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Profit & Loss</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <h2><b>Rp @number($total_profit)</b></h2>
                <canvas id="chartNP" height="355" width="710" style="width: 568px; height: 284px;"></canvas>
                @foreach($net_income as $c)
                <input class="NP" value="{{$c}}" hidden>
                @endforeach
                <input class="NP_l_year" value="{{$last_year}}" type="text" hidden>
                <input class="NP_year" value="{{$year}}" type="text" hidden>

            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Sales Receivable</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <h2><b>Rp @number($total_sales_invoice)</b></h2>
                <small>Awaiting Payments</small>
                @foreach($sales_invoice as $a)
                <input class="TP" value="{{$a}}" hidden>
                @endforeach
                <canvas id="chartSR" height="750" width="710" style="width: 568px; height: 284px;"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Bills To Pay</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <h2><b>Rp @number($total_purchase_invoice)</b></h2>
                <small>Awaiting Payments</small>
                @foreach($purchase_invoice as $a)
                <input class="TP2" value="{{$a}}" hidden>
                @endforeach
                <canvas id="chartTP2" height="750" width="710" style="width: 568px; height: 284px;"></canvas>
            </div>
        </div>
    </div>
</div>
@endrole
@endsection

@push('scripts')
<script src="{{ asset('js/dashboard/chartAP.js?v=5-20200221-1431') }}" charset="utf-8"> </script>
<script src="{{ asset('js/dashboard/chartAR.js?v=5-20200221-1431') }}" charset="utf-8"> </script>
<script src="{{ asset('js/dashboard/chartEX.js?v=5-20200221-1431') }}" charset="utf-8"> </script>
<script src="{{ asset('js/dashboard/chartCF.js?v=5-20200221-1431') }}" charset="utf-8"> </script>
<script src="{{ asset('js/dashboard/chartNP.js?v=5-20200221-1431') }}" charset="utf-8"> </script>
<script src="{{ asset('js/dashboard/chartTP.js?v=5-20200221-1431') }}" charset="utf-8"> </script>
<script src="{{ asset('js/dashboard/chartTP2.js?v=5-20200221-1431') }}" charset="utf-8"> </script>
<script src="{{ asset('js/dashboard/all.js?v=5-20200221-1431') }}" charset="utf-8"> </script>
@endpush
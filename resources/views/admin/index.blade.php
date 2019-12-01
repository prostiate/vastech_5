@extends('layouts/admin')
@section('content')
@hasrole('Owner|Ultimate')
<div class="row">
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Cash Flow</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <h2><b>Rp @number($ending_cash)</b></h2>
                <small>Cash In & Out Over Time</small>
                <input class="CF" value="{{$ending_cash}}" hidden>
                <br>
                <br>
                <canvas id="chartCF" height="355" width="710" style="width: 568px; height: 284px;"></canvas>
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
                @foreach($coa_ar_balance as $a)
                <input class="AR" value="{{$a}}" hidden>
                @endforeach
                <br>
                <br>
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
                @foreach($coa_ap_balance as $a)
                <input class="AP" value="{{$a}}" hidden>
                @endforeach
                <br>
                <br>
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
                <h2><b>Rp @number($net_income)</b></h2>
                <small>Profit Over Time</small>
                <input class="NP" value="{{$net_income}}" hidden>
                <br>
                <br>
                <canvas id="chartNP" height="355" width="710" style="width: 568px; height: 284px;"></canvas>
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
                <br>
                <br>
                <canvas id="chartTP" height="750" width="710" style="width: 568px; height: 284px;"></canvas>
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
                <br>
                <br>
                <canvas id="chartTP2" height="750" width="710" style="width: 568px; height: 284px;"></canvas>
            </div>
        </div>
    </div>
</div>
@endrole
@endsection

@push('scripts')
<script src="{{ asset('js/dashboard/chartAP.js') }}" charset="utf-8"> </script>
<script src="{{ asset('js/dashboard/chartAR.js') }}" charset="utf-8"> </script>
<script src="{{ asset('js/dashboard/chartEX.js') }}" charset="utf-8"> </script>
<script src="{{ asset('js/dashboard/chartCF.js') }}" charset="utf-8"> </script>
<script src="{{ asset('js/dashboard/chartNP.js') }}" charset="utf-8"> </script>
<script src="{{ asset('js/dashboard/chartTP.js') }}" charset="utf-8"> </script>
<script src="{{ asset('js/dashboard/chartTP2.js') }}" charset="utf-8"> </script>
@endpush
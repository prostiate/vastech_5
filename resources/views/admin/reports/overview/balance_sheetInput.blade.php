@extends('layouts/admin')

@section('contentheader')
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Balance Sheet</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link">As Of </a></li>
                    <li><input value="{{$today2}}" type="date" id="datepicker1" class="form-control"></li>
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
                                    <table class="table table-condensed">
                                        <tbody>
                                            <tr>
                                                <td colspan="5" class="btn-dark"><b>Assets</b></td>
                                            </tr>
                                            {{-- start CURRENT ASSETS--}}
                                            <tr>
                                                <td></td>
                                                <td colspan="4"><b>Current Assets</b></td>
                                            </tr>
                                            <?php $stop = 0 ?>
                                            @foreach($coa_detail as $a)
                                                @if($a->total != 0)
                                                    @if($a->coa->coa_category_id == 1)
                                                        @if($a->coa->is_parent == 1)
                                                            @if($stop == 0)
                                                            <?php $stop += 1 ?>
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td><a href="/chart_of_accounts/{{$a->coa_id}}">{{$a->coa->code}} - {{$a->coa->name}}</a></td>
                                                                <td></td>
                                                                <td class="text-right">@if($a->total < 0) ( @number(abs($a->total)) ) @else @number($a->total) @endif</td>
                                                            </tr>
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endif
                                            @endforeach
                                            <?php $stop = 0 ?>
                                            @foreach($coa_detail as $a)
                                                @if($a->total != 0)
                                                    @if($a->coa->coa_category_id == 1)
                                                        @if($a->coa->is_parent == 0)
                                                            @if($stop == 0)
                                                            <?php $stop += 1 ?>
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td><a href="/chart_of_accounts/{{$a->coa_id}}">1-10100 - Account Receivable (A/R)</a></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            @endif
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td style="padding-left:30px"><a href="/chart_of_accounts/{{$a->coa_id}}">{{$a->coa->code}} - {{$a->coa->name}}</a></td>
                                                                <td></td>
                                                                <td class="text-right">@if($a->total < 0) ( @number(abs($a->total)) ) @else @number($a->total) @endif</td>
                                                            </tr>
                                                        @endif
                                                    @endif
                                                @endif
                                            @endforeach
                                            <?php $stop = 0 ?>
                                            @foreach($coa_detail as $a)
                                                @if($a->total != 0)
                                                    @if($a->coa->coa_category_id == 2)
                                                        @if($a->coa->is_parent == 1)
                                                            @if($stop == 0)
                                                            <?php $stop += 1 ?>
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td><a href="/chart_of_accounts/{{$a->coa_id}}">{{$a->coa->code}} - {{$a->coa->name}}</a></td>
                                                                <td></td>
                                                                <td class="text-right">@if($a->total < 0) ( @number(abs($a->total)) ) @else @number($a->total) @endif</td>
                                                            </tr>
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endif
                                            @endforeach
                                            <?php $stop = 0 ?>
                                            @foreach($coa_detail as $a)
                                                @if($a->total != 0)
                                                    @if($a->coa->coa_category_id == 2)
                                                        @if($a->coa->is_parent == 0)
                                                            @if($stop == 0)
                                                            <?php $stop += 1 ?>
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td><a href="/chart_of_accounts/{{$a->coa_id}}">1-10300 - Other Current Assets</a></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            @endif
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td style="padding-left:30px"><a href="/chart_of_accounts/{{$a->coa_id}}">{{$a->coa->code}} - {{$a->coa->name}}</a></td>
                                                                <td></td>
                                                                <td class="text-right">@if($a->total < 0) ( @number(abs($a->total)) ) @else @number($a->total) @endif</td>
                                                            </tr>
                                                        @endif
                                                    @endif
                                                @endif
                                            @endforeach
                                            <?php $stop = 0 ?>
                                            @foreach($coa_detail as $a)
                                                @if($a->total != 0)
                                                    @if($a->coa->coa_category_id == 3)
                                                        @if($a->coa->is_parent == 1)
                                                            @if($stop == 0)
                                                            <?php $stop += 1 ?>
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td><a href="/chart_of_accounts/{{$a->coa_id}}">{{$a->coa->code}} - {{$a->coa->name}}</a></td>
                                                                <td></td>
                                                                <td class="text-right">@if($a->total < 0) ( @number(abs($a->total)) ) @else @number($a->total) @endif</td>
                                                            </tr>
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endif
                                            @endforeach
                                            <?php $stop = 0 ?>
                                            @foreach($coa_detail as $a)
                                                @if($a->total != 0)
                                                    @if($a->coa->coa_category_id == 3)
                                                        @if($a->coa->is_parent == 0)
                                                            @if($stop == 0)
                                                            <?php $stop += 1 ?>
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td><a href="/chart_of_accounts/{{$a->coa_id}}">1-10000 - Cash & Bank</a></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            @endif
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td style="padding-left:30px"><a href="/chart_of_accounts/{{$a->coa_id}}">{{$a->coa->code}} - {{$a->coa->name}}</a></td>
                                                                <td></td>
                                                                <td class="text-right">@if($a->total < 0) ( @number(abs($a->total)) ) @else @number($a->total) @endif</td>
                                                            </tr>
                                                        @endif
                                                    @endif
                                                @endif
                                            @endforeach
                                            <?php $stop = 0 ?>
                                            @foreach($coa_detail as $a)
                                                @if($a->total != 0)
                                                    @if($a->coa->coa_category_id == 4)
                                                        @if($a->coa->is_parent == 1)
                                                            @if($stop == 0)
                                                            <?php $stop += 1 ?>
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td><a href="/chart_of_accounts/{{$a->coa_id}}">{{$a->coa->code}} - {{$a->coa->name}}</a></td>
                                                                <td></td>
                                                                <td class="text-right">@if($a->total < 0) ( @number(abs($a->total)) ) @else @number($a->total) @endif</td>
                                                            </tr>
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endif
                                            @endforeach
                                            <?php $stop = 0 ?>
                                            @foreach($coa_detail as $a)
                                                @if($a->total != 0)
                                                    @if($a->coa->coa_category_id == 4)
                                                        @if($a->coa->is_parent == 0)
                                                            @if($stop == 0)
                                                            <?php $stop += 1 ?>
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td><a href="/chart_of_accounts/{{$a->coa_id}}">1-10200 - Inventory</a></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            @endif
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td style="padding-left:30px"><a href="/chart_of_accounts/{{$a->coa_id}}">{{$a->coa->code}} - {{$a->coa->name}}</a></td>
                                                                <td></td>
                                                                <td class="text-right">@if($a->total < 0) ( @number(abs($a->total)) ) @else @number($a->total) @endif</td>
                                                            </tr>
                                                        @endif
                                                    @endif
                                                @endif
                                            @endforeach
                                            <tr>
                                                <td></td>
                                                <td colspan="3"><b>Total Current Assets</b></td>
                                                <td class="text-right"><b>@if($total_current_assets < 0) ( @number(abs($total_current_assets)) ) @else @number($total_current_assets) @endif</b></td>
                                            </tr>
                                            {{-- end CURRENT ASSETS--}}
                                            {{-- start FIXED ASSETS--}}
                                            @if($total_fixed_assets != 0)
                                            <tr>
                                                <td></td>
                                                <td colspan="4"><b>Fixed Assets</b></td>
                                            </tr>
                                            <?php $stop = 0 ?>
                                            @foreach($coa_detail as $a)
                                                @if($a->total != 0)
                                                    @if($a->coa->coa_category_id == 5)
                                                        @if($a->coa->is_parent == 1)
                                                            @if($stop == 0)
                                                            <?php $stop += 1 ?>
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td><a href="/chart_of_accounts/{{$a->coa_id}}">{{$a->coa->code}} - {{$a->coa->name}}</a></td>
                                                                <td></td>
                                                                <td class="text-right">@if($a->total < 0) ( @number(abs($a->total)) ) @else @number($a->total) @endif</td>
                                                            </tr>
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endif
                                            @endforeach
                                            <?php $stop = 0 ?>
                                            @foreach($coa_detail as $a)
                                                @if($a->total != 0)
                                                    @if($a->coa->coa_category_id == 5)
                                                        @if($a->coa->is_parent == 0)
                                                            @if($stop == 0)
                                                            <?php $stop += 1 ?>
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td><a href="/chart_of_accounts/{{$a->coa_id}}">1-10700 - Fixed Assets</a></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            @endif
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td style="padding-left:30px"><a href="/chart_of_accounts/{{$a->coa_id}}">{{$a->coa->code}} - {{$a->coa->name}}</a></td>
                                                                <td></td>
                                                                <td class="text-right">@if($a->total < 0) ( @number(abs($a->total)) ) @else @number($a->total) @endif</td>
                                                            </tr>
                                                        @endif
                                                    @endif
                                                @endif
                                            @endforeach
                                            <?php $stop = 0 ?>
                                            @foreach($coa_detail as $a)
                                                @if($a->total != 0)
                                                    @if($a->coa->coa_category_id == 6)
                                                        @if($a->coa->is_parent == 1)
                                                            @if($stop == 0)
                                                            <?php $stop += 1 ?>
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td><a href="/chart_of_accounts/{{$a->coa_id}}">{{$a->coa->code}} - {{$a->coa->name}}</a></td>
                                                                <td></td>
                                                                <td class="text-right">@if($a->total < 0) ( @number(abs($a->total)) ) @else @number($a->total) @endif</td>
                                                            </tr>
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endif
                                            @endforeach
                                            <?php $stop = 0 ?>
                                            @foreach($coa_detail as $a)
                                                @if($a->total != 0)
                                                    @if($a->coa->coa_category_id == 6)
                                                        @if($a->coa->is_parent == 0)
                                                            @if($stop == 0)
                                                            <?php $stop += 1 ?>
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td><a href="/chart_of_accounts/{{$a->coa_id}}">1-10800 - Other Assets</a></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            @endif
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td style="padding-left:30px"><a href="/chart_of_accounts/{{$a->coa_id}}">{{$a->coa->code}} - {{$a->coa->name}}</a></td>
                                                                <td></td>
                                                                <td class="text-right">@if($a->total < 0) ( @number(abs($a->total)) ) @else @number($a->total) @endif</td>
                                                            </tr>
                                                        @endif
                                                    @endif
                                                @endif
                                            @endforeach
                                            <tr>
                                                <td></td>
                                                <td colspan="3"><b>Total Fixed Assets</b></td>
                                                <td class="text-right"><b>@if($total_fixed_assets < 0) ( @number(abs($total_fixed_assets)) ) @else @number($total_fixed_assets) @endif</b></td>
                                            </tr>
                                            @endif
                                            {{-- end FIXED ASSETS--}}
                                            {{-- stat DEPRECIATION--}}
                                            @if($total_depreciation != 0)
                                            <tr>
                                                <td></td>
                                                <td colspan="4"><b>Depreciation & Amortization</b></td>
                                            </tr>
                                            <?php $stop = 0 ?>
                                            @foreach($coa_detail as $a)
                                                @if($a->total != 0)
                                                    @if($a->coa->coa_category_id == 7)
                                                        @if($a->coa->is_parent == 1)
                                                            @if($stop == 0)
                                                            <?php $stop += 1 ?>
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td><a href="/chart_of_accounts/{{$a->coa_id}}">{{$a->coa->code}} - {{$a->coa->name}}</a></td>
                                                                <td></td>
                                                                <td class="text-right">@if($a->total < 0) ( @number(abs($a->total)) ) @else @number($a->total) @endif</td>
                                                            </tr>
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endif
                                            @endforeach
                                            <?php $stop = 0 ?>
                                            @foreach($coa_detail as $a)
                                                @if($a->total != 0)
                                                    @if($a->coa->coa_category_id == 7)
                                                        @if($a->coa->is_parent == 0)
                                                            @if($stop == 0)
                                                            <?php $stop += 1 ?>
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td><a href="/chart_of_accounts/{{$a->coa_id}}">1-10750 - Depreciation & Amortization</a></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            @endif
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td style="padding-left:30px"><a href="/chart_of_accounts/{{$a->coa_id}}">{{$a->coa->code}} - {{$a->coa->name}}</a></td>
                                                                <td></td>
                                                                <td class="text-right">@if($a->total < 0) ( @number(abs($a->total)) ) @else @number($a->total) @endif</td>
                                                            </tr>
                                                        @endif
                                                    @endif
                                                @endif
                                            @endforeach
                                            <tr>
                                                <td></td>
                                                <td colspan="3"><b>Total Depreciation & Amortization</b></td>
                                                <td class="text-right"><b>@if($total_depreciation < 0) ( @number(abs($total_depreciation)) ) @else @number($total_depreciation) @endif</b></td>
                                            </tr>
                                            @endif
                                            {{-- end DEPRECIATION--}}
                                            {{-- start TOTAL ASSET--}}
                                            <tr>
                                                <td colspan="4"><b>Total Assets</b></td>
                                                <td class="text-right"><b>@if($total_assets < 0) ( @number(abs($total_assets)) ) @else @number($total_assets) @endif</b></td>
                                            </tr>
                                            {{-- end TOTAL ASSET--}}
                                            <tr>
                                                <td colspan="5" class="btn-dark"><b>Liability & Equity</b></td>
                                            </tr>
                                            {{-- start CURRENT LIABILITY--}}
                                            @if($total_liability != 0)
                                            <tr>
                                                <td></td>
                                                <td colspan="4"><b>Current Liability</b></td>
                                            </tr>
                                            <?php $stop = 0 ?>
                                            @foreach($coa_detail as $a)
                                                @if($a->total != 0)
                                                    @if($a->coa->coa_category_id == 8)
                                                        @if($a->coa->is_parent == 1)
                                                            @if($stop == 0)
                                                            <?php $stop += 1 ?>
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td><a href="/chart_of_accounts/{{$a->coa_id}}">{{$a->coa->code}} - {{$a->coa->name}}</a></td>
                                                                <td></td>
                                                                <td class="text-right">@if($a->total < 0) ( @number(abs($a->total)) ) @else @number($a->total) @endif</td>
                                                            </tr>
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endif
                                            @endforeach
                                            <?php $stop = 0 ?>
                                            @foreach($coa_detail as $a)
                                                @if($a->total != 0)
                                                    @if($a->coa->coa_category_id == 8)
                                                        @if($a->coa->is_parent == 0)
                                                            @if($stop == 0)
                                                            <?php $stop += 1 ?>
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td><a href="/chart_of_accounts/{{$a->coa_id}}">2-20100 - Trade Payable</a></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            @endif
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td style="padding-left:30px"><a href="/chart_of_accounts/{{$a->coa_id}}">{{$a->coa->code}} - {{$a->coa->name}}</a></td>
                                                                <td></td>
                                                                <td class="text-right">@if($a->total < 0) ( @number(abs($a->total)) ) @else @number($a->total) @endif</td>
                                                            </tr>
                                                        @endif
                                                    @endif
                                                @endif
                                            @endforeach
                                            <?php $stop = 0 ?>
                                            @foreach($coa_detail as $a)
                                                @if($a->total != 0)
                                                    @if($a->coa->coa_category_id == 10)
                                                        @if($a->coa->is_parent == 1)
                                                            @if($stop == 0)
                                                            <?php $stop += 1 ?>
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td><a href="/chart_of_accounts/{{$a->coa_id}}">{{$a->coa->code}} - {{$a->coa->name}}</a></td>
                                                                <td></td>
                                                                <td class="text-right">@if($a->total < 0) ( @number(abs($a->total)) ) @else @number($a->total) @endif</td>
                                                            </tr>
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endif
                                            @endforeach
                                            <?php $stop = 0 ?>
                                            @foreach($coa_detail as $a)
                                                @if($a->total != 0)
                                                    @if($a->coa->coa_category_id == 10)
                                                        @if($a->coa->is_parent == 0)
                                                            @if($stop == 0)
                                                            <?php $stop += 1 ?>
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td><a href="/chart_of_accounts/{{$a->coa_id}}">2-20200 - Other Current Liabilities</a></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            @endif
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td style="padding-left:30px"><a href="/chart_of_accounts/{{$a->coa_id}}">{{$a->coa->code}} - {{$a->coa->name}}</a></td>
                                                                <td></td>
                                                                <td class="text-right">@if($a->total < 0) ( @number(abs($a->total)) ) @else @number($a->total) @endif</td>
                                                            </tr>
                                                        @endif
                                                    @endif
                                                @endif
                                            @endforeach
                                            <?php $stop = 0 ?>
                                            @foreach($coa_detail as $a)
                                                @if($a->total != 0)
                                                    @if($a->coa->coa_category_id == 17)
                                                        @if($a->coa->is_parent == 1)
                                                            @if($stop == 0)
                                                            <?php $stop += 1 ?>
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td><a href="/chart_of_accounts/{{$a->coa_id}}">{{$a->coa->code}} - {{$a->coa->name}}</a></td>
                                                                <td></td>
                                                                <td class="text-right">@if($a->total < 0) ( @number(abs($a->total)) ) @else @number($a->total) @endif</td>
                                                            </tr>
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endif
                                            @endforeach
                                            <?php $stop = 0 ?>
                                            @foreach($coa_detail as $a)
                                                @if($a->total != 0)
                                                    @if($a->coa->coa_category_id == 17)
                                                        @if($a->coa->is_parent == 0)
                                                            @if($stop == 0)
                                                            <?php $stop += 1 ?>
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td><a href="/chart_of_accounts/{{$a->coa_id}}">8-80000 - Other Expense</a></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            @endif
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td style="padding-left:30px"><a href="/chart_of_accounts/{{$a->coa_id}}">{{$a->coa->code}} - {{$a->coa->name}}</a></td>
                                                                <td></td>
                                                                <td class="text-right">@if($a->total < 0) ( @number(abs($a->total)) ) @else @number($a->total) @endif</td>
                                                            </tr>
                                                        @endif
                                                    @endif
                                                @endif
                                            @endforeach
                                            <tr>
                                                <td></td>
                                                <td colspan="3"><b>Total Liability</b></td>
                                                <td class="text-right"><b>@if($total_liability < 0) ( @number(abs($total_liability)) ) @else @number($total_liability) @endif</b></td>
                                            </tr>
                                            @endif
                                            {{-- end CURRENT LIABILITY--}}
                                            {{-- start EQUITY--}}
                                            <tr>
                                                <td></td>
                                                <td colspan="4"><b>Equity</b></td>
                                            </tr>
                                            <?php $stop = 0 ?>
                                            @foreach($coa_detail as $a)
                                                @if($a->total != 0)
                                                    @if($a->coa->coa_category_id == 12)
                                                        @if($a->coa->is_parent == 1)
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td><a href="/chart_of_accounts/{{$a->coa_id}}">{{$a->coa->code}} - {{$a->coa->name}}</a></td>
                                                                <td></td>
                                                                <td class="text-right">@if($a->total < 0) ( @number(abs($a->total)) ) @else @number($a->total) @endif</td>
                                                            </tr>
                                                        @endif
                                                        @if($stop == 0)
                                                        <?php $stop += 1 ?>
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td><a href="/chart_of_accounts/{{$a->coa_id}}">3-30000 - Equity</a></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        @endif
                                                        @if($a->coa->is_parent == 0)
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td style="padding-left:30px"><a href="/chart_of_accounts/{{$a->coa_id}}">{{$a->coa->code}} - {{$a->coa->name}}</a></td>
                                                                <td></td>
                                                                <td class="text-right">@if($a->total < 0) ( @number(abs($a->total)) ) @else @number($a->total) @endif</td>
                                                            </tr>
                                                        @endif
                                                    @endif
                                                @endif
                                            @endforeach
                                            {{-- end EQUITY--}}
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td>Accumulated other comprehensive income</td>
                                                <td></td>
                                                <td class="text-right">0.00</td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td>Earnings up to Last Period</td>
                                                <td></td>
                                                <td class="text-right">0.00</td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td>Current Period Earnings</td>
                                                <td></td>
                                                <td class="text-right"><b>@if($current_period_earning < 0) ( @number(abs($current_period_earning)) ) @else @number($current_period_earning) @endif</b></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td colspan="3"><b>Total Equity</b></td>
                                                <td class="text-right"><b>@if($total_equity2 < 0) ( @number(abs($total_equity2)) ) @else @number($total_equity2) @endif</b></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4"><b>Total Liability & Equity</b></td>
                                                <td class="text-right"><b>@if($total_lia_eq < 0) ( @number(abs($total_lia_eq)) ) @else @number($total_lia_eq) @endif</b></td>
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
        var mulaidari = document.getElementById('datepicker1');
        window.location.href = "/reports/balance_sheet/" + mulaidari.value;
    }
</script>
@endpush
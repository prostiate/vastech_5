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
                            <div class="modal-dialog modal-sm">
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
                                                        <label>As Of</label>
                                                        <input value="{{$today2}}" type="date" id="datepicker2" class="form-control">
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
                                            <div class="col-md-12">
                                                <div class="form-horizontal form-label-left">
                                                    <div class="form-group row">
                                                        <label>Compare Period</label>
                                                        <select name="type_limit_balance" class="form-control selectbankname">
                                                            <option value="none" selected>None</option>
                                                            <option value="weekly">Weekly</option>
                                                            <option value="monthly">Monthly</option>
                                                            <option value="quarterly">Quarterly</option>
                                                            <option value="semi_yearly">Semi-Yearly</option>
                                                            <option value="yearly">Yearly</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-horizontal form-label-left">
                                                    <div class="form-group row">
                                                        <label>Period</label>
                                                        <select name="type_limit_balance" class="form-control selectbankname">
                                                            <option value="none" selected>None</option>
                                                            <option value="one">Previous 1 Periods</option>
                                                            <option value="two">Previous 2 Periods</option>
                                                            <option value="three">Previous 3 Periods</option>
                                                            <option value="four">Previous 4 Periods</option>
                                                            <option value="five">Previous 5 Periods</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-horizontal form-label-left">
                                                    <div class="form-group row">
                                                        <label>Period Order By</label>
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" class="flat" name="asc"> Ascending
                                                            </label>
                                                        </div>
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" class="flat" name="desc"> Descending
                                                            </label>
                                                        </div>
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
                            <input value="{{$startyear_last_periode}}" type="date" id="startyear_last_periode" hidden>
                            <input value="{{$endyear_last_periode}}" type="date" id="endyear_last_periode" hidden>
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
                                                @if($a->total2 != 0)
                                                    @if($a->coa->coa_category_id == 8)
                                                        @if($a->coa->is_parent == 1)
                                                            @if($stop == 0)
                                                            <?php $stop += 1 ?>
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td><a href="/chart_of_accounts/{{$a->coa_id}}">{{$a->coa->code}} - {{$a->coa->name}}</a></td>
                                                                <td></td>
                                                                <td class="text-right">@if($a->total2 < 0) ( @number(abs($a->total2)) ) @else @number($a->total2) @endif</td>
                                                            </tr>
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endif
                                            @endforeach
                                            <?php $stop = 0 ?>
                                            @foreach($coa_detail as $a)
                                                @if($a->total2 != 0)
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
                                                                <td class="text-right">@if($a->total2 < 0) ( @number(abs($a->total2)) ) @else @number($a->total2) @endif</td>
                                                            </tr>
                                                        @endif
                                                    @endif
                                                @endif
                                            @endforeach
                                            <?php $stop = 0 ?>
                                            @foreach($coa_detail as $a)
                                                @if($a->total2 != 0)
                                                    @if($a->coa->coa_category_id == 10)
                                                        @if($a->coa->is_parent == 1)
                                                            @if($stop == 0)
                                                            <?php $stop += 1 ?>
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td><a href="/chart_of_accounts/{{$a->coa_id}}">{{$a->coa->code}} - {{$a->coa->name}}</a></td>
                                                                <td></td>
                                                                <td class="text-right">@if($a->total2 < 0) ( @number(abs($a->total2)) ) @else @number($a->total2) @endif</td>
                                                            </tr>
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endif
                                            @endforeach
                                            <?php $stop = 0 ?>
                                            @foreach($coa_detail as $a)
                                                @if($a->total2 != 0)
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
                                                                <td class="text-right">@if($a->total2 < 0) ( @number(abs($a->total2)) ) @else @number($a->total2) @endif</td>
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
                                                <td class="text-right"><b>@if($last_periode_earning < 0) ( @number(abs($last_periode_earning)) ) @else @number($last_periode_earning) @endif</b></td>
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
<script src="{{ asset('js/other/zebradatepicker.js?v=5-20200315-0243') }}" charset="utf-8"></script>
<script>
    function next() {
        var date1 = document.getElementById('datepicker1');
        var date2 = document.getElementById('datepicker2');
        window.location.href = "/reports/ss_surabaya/balance_sheet/start_date=" + date1.value + "&end_date=" + date2.value;
    }

    function excel() {
        var date1 = document.getElementById('datepicker1');
        var date2 = document.getElementById('datepicker2');
        var startyear_last_periode = document.getElementById('startyear_last_periode');
        var endyear_last_periode = document.getElementById('endyear_last_periode');
        window.location.href = "/reports/ss_surabaya/balance_sheet/excel/start_date=" + date1.value + "&end_date=" + date2.value + "/start=" + startyear_last_periode.value + "&end=" + endyear_last_periode.value;
    }

    function csv() {
        var date1 = document.getElementById('datepicker1');
        var date2 = document.getElementById('datepicker2');
        var startyear_last_periode = document.getElementById('startyear_last_periode');
        var endyear_last_periode = document.getElementById('endyear_last_periode');
        window.location.href = "/reports/ss_surabaya/balance_sheet/csv/start_date=" + date1.value + "&end_date=" + date2.value + "/start=" + startyear_last_periode.value + "&end=" + endyear_last_periode.value;
    }

    function pdf() {
        var date1 = document.getElementById('datepicker1');
        var date2 = document.getElementById('datepicker2');
        var startyear_last_periode = document.getElementById('startyear_last_periode');
        var endyear_last_periode = document.getElementById('endyear_last_periode');
        window.open("/reports/ss_surabaya/balance_sheet/pdf/start_date=" + date1.value + "&end_date=" + date2.value + "/start=" + startyear_last_periode.value + "&end=" + endyear_last_periode.value, '_blank');
    }
</script>
@endpush

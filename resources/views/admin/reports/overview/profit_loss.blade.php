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
                                                <td colspan="5" class="btn-dark"><b>Primary Income</b></td>
                                            </tr>
                                            @foreach($coa_detail as $c)
                                                @if($c->total != 0)
                                                    @if($c->coa->coa_category_id == 13)
                                                        <tr>
                                                            <td></td>
                                                            <td colspan="3">{{$c->coa->code}} - {{$c->coa->name}}</td>
                                                            <td class="text-right">@number(abs($c->total))</td>
                                                        </tr>
                                                    @endif
                                                @endif
                                            @endforeach
                                            <tr>
                                                <td></td>
                                                <td colspan="3"><strong>Total Primary Income</strong></td>
                                                <td class="text-right"><strong>@if($total_primary_income < 0) 
                                                                                    @number(abs($total_primary_income)) 
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
                                                            <td colspan="3">{{$c->coa->code}} - {{$c->coa->name}}</td>
                                                            <td class="text-right">@if($c->total < 0) ( @number(abs($c->total)) ) @else @number($c->total) @endif</td>
                                                        </tr>
                                                    @endif
                                                @endif
                                            @endforeach
                                            <tr>
                                                <td></td>
                                                <td colspan="3"><strong>Total Cost of Sales</strong></td>
                                                <td class="text-right"><strong>@if($total_cost_of_sales < 0) 
                                                                                    @number(abs($total_cost_of_sales)) 
                                                                                @else 
                                                                                    @number($total_cost_of_sales) 
                                                                                @endif</strong></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4"><b>Gross Profits</b></td>
                                                <td class="text-right"><strong>@if($gross_profit < 0) 
                                                                                    @number(abs($gross_profit)) 
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
                                                            <td colspan="3">{{$c->coa->code}} - {{$c->coa->name}}</td>
                                                            <td class="text-right">@if($c->total < 0) ( @number(abs($c->total)) ) @else @number($c->total) @endif</td>
                                                        </tr>
                                                    @endif
                                                @endif
                                            @endforeach
                                            <tr>
                                                <td></td>
                                                <td colspan="3">Total Operational Expenses</td>
                                                <td class="text-right"><strong>@if($total_operational_expense < 0) 
                                                                                    @number(abs($total_operational_expense)) 
                                                                                @else 
                                                                                    @number($total_operational_expense) 
                                                                                @endif</strong></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4"><b>Net Operating Income</b></td>
                                                <td class="text-right"><strong>@if($net_operating_income < 0) 
                                                                                    @number(abs($net_operating_income)) 
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
                                                            <td colspan="3">{{$c->coa->code}} - {{$c->coa->name}}</td>
                                                            <td class="text-right">@if($c->total < 0) ( @number(abs($c->total)) ) @else @number($c->total) @endif</td>
                                                        </tr>
                                                    @endif
                                                @endif
                                            @endforeach
                                            <tr>
                                                <td></td>
                                                <td colspan="3">Total Other Income</td>
                                                <td class="text-right"><strong>@if($total_other_income < 0) 
                                                                                    @number(abs($total_other_income)) 
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
                                                            <td colspan="3">{{$c->coa->code}} - {{$c->coa->name}}</td>
                                                            <td class="text-right">@if($c->total < 0) ( @number(abs($c->total)) ) @else @number($c->total) @endif</td>
                                                        </tr>
                                                    @endif
                                                @endif
                                            @endforeach
                                            <tr>
                                                <td></td>
                                                <td colspan="3">Total Other Expense</td>
                                                <td class="text-right"><strong>@if($total_other_expense < 0) 
                                                                                    @number(abs($total_other_expense)) 
                                                                                @else 
                                                                                    @number($total_other_expense) 
                                                                                @endif</strong></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="btn-dark"><b>Net Income</b></td>
                                                <td class="text-right btn-dark"><strong>@if($net_income < 0) 
                                                                                    @number(abs($net_income)) 
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
<script src="{{ asset('js/other/zebradatepicker.js') }}" charset="utf-8"></script>
<script>
    function next() {
        var start   = document.getElementById('datepicker1');
        var end     = document.getElementById('datepicker2');
        window.location.href = "/reports/profit_loss/" + start.value + '&' + end.value;
    }
</script>
@endpush
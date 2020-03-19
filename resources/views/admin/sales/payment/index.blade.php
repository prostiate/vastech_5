@extends('layouts.admin')

@section('contentheader')
<div class="page-title">
    <div class="title_left">
        <h3>Sales Payment</h3>
    </div>
</div>
@endsection

@section('content')
@hasrole('Owner|Ultimate')
<div class="row">
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Summary In Chart</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <input hidden type="text" value="{{$open_po}}" id="open_po">
                <input hidden type="text" value="{{$payment_last}}" id="payment_last">
                <input hidden type="text" value="{{$overdue}}" id="overdue">
                <div id="hehehehe" style="height: 350px;"></div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Total Balance</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <button data-toggle="dropdown" class="btn btn-dark dropdown-toggle" type="button" aria-expanded="false">New Sales <span class="caret"></span>
                        </button>
                        <ul role="menu" class="dropdown-menu">
                            @if($user->company_id == 5)
                            <li><a href="/sales_invoice/newRS">Sales Invoice</a>
                            </li>
                            <li><a href="/sales_order/newRS">Sales Order</a>
                            </li>
                            <li><a href="/sales_quote/new">Sales Quote</a>
                            </li>
                            @else
                            <li><a href="/sales_invoice/new">Sales Invoice</a>
                            </li>
                            <li><a href="/sales_order/new">Sales Order</a>
                            </li>
                            <li><a href="/sales_quote/new">Sales Quote</a>
                            </li>
                            @endif
                        </ul>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row tile_count">
                    <div class="col-md-12 col-sm-6 col-xs-6 tile_stats_count">
                        <span class="count_top">Open Sales</span>
                        <div class="count">Rp @number($open_po_total)</div>
                    </div>
                    <div class="col-md-12 col-sm-6 col-xs-6 tile_stats_count">
                        <span class="count_top">Paid Sales Last 30 Days</span>
                        <div class="count">Rp @number($payment_last_total)</div>
                    </div>
                    <div class="col-md-12 col-sm-6 col-xs-6 tile_stats_count">
                        <span class="count_top">Sales Overdue</span>
                        <div class="count">Rp @number($overdue_total)</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endrole
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>List of Transactions</h2>
                @role('Sales Payment')
                @can('Create')
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <button data-toggle="dropdown" class="btn btn-dark dropdown-toggle" type="button" aria-expanded="false">New Sales <span class="caret"></span>
                        </button>
                        <ul role="menu" class="dropdown-menu">
                            @if($user->company_id == 5)
                            <li><a href="/sales_invoice/newRS">Sales Invoice</a>
                            </li>
                            <li><a href="/sales_order/newRS">Sales Order</a>
                            </li>
                            <li><a href="/sales_quote/new">Sales Quote</a>
                            </li>
                            @else
                            <li><a href="/sales_invoice/new">Sales Invoice</a>
                            </li>
                            <li><a href="/sales_order/new">Sales Order</a>
                            </li>
                            <li><a href="/sales_quote/new">Sales Quote</a>
                            </li>
                            @endif
                        </ul>
                    </li>
                </ul>
                @endcan
                @endrole
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-striped jambo_table bulk_action" id="dataTable" style="width:100%">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">Payment Date</th>
                                <th class="column-title">Payment Number</th>
                                <!--<th class="column-title">Deposit To</th>-->
                                <th class="column-title">Contact</th>
                                <th class="column-title">Pay From</th>
                                <th class="column-title">Total</th>
                                <th class="column-title">Payment Status</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{asset('js/sales/payment/dataTable.js?v=5-20200319-0916') }}" charset="utf-8"></script>
<script src="{{ asset('js/sales/payment/chartdiindex.js?v=5-20200319-0916') }}" charset="utf-8"></script>
@endpush
@extends('layouts.admin')

@section('contentheader')
<div class="page-title">
    <div class="title_left">
        <h3>Sales Quote</h3>
    </div>
    <!--<div class="title_right">
        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search for...">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button">Go!</button>
                </span>
            </div>
        </div>
    </div>-->
</div>
@endsection

@section('content')
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
                            <li><a href="/sales_invoice/new">Sales Invoice</a>
                            </li>
                            <li><a href="/sales_order/new">Sales Order</a>
                            </li>
                            <!--<li><a href="/sales_order/newRS">Sales Order Marketting</a>
                            </!--<li>-->
                            <li><a href="/sales_quote/new">Sales Quote</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            @hasrole('Owner|Ultimate')
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
                <!--<div class="row">
                    <div class="col-md-6">
                        <h5>Open Sales</h5>
                        <h2>{{$open_po}}</h2>
                        <br>
                        <h5>Paid Sales Last 30 Days</h5>
                        <h2>{{$payment_last}}</h2>
                        <br>
                        <h5>Sales Overdue</h5>
                        <h2>{{$overdue}}</h2>
                    </div>
                    <div class="col-md-6">
                        <h5>Balance Open Sales</h5>
                        <h2>Rp @number($open_po_total)</h2>
                        <br>
                        <h5>Balance Paid Sales Last 30 Days</h5>
                        <h2>Rp @number($payment_last_total)</h2>
                        <br>
                        <h5>Balance Sales Overdue</h5>
                        <h2>Rp @number($overdue_total)</h2>
                    </div>
                </div>-->
            </div>
            @endrole
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>List of Transactions</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-striped jambo_table bulk_action" id="dataTable" style="width:100%">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">Transaction Date</th>
                                <th class="column-title">Transaction Number</th>
                                <th class="column-title">Customer</th>
                                <th class="column-title">Expiration Date</th>
                                <th class="column-title">Total</th>
                                <th class="column-title">Status</th>
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
<script src="{{ asset('js/sales/quote/dataTable.js') }}" charset="utf-8"></script>
<script src="{{ asset('js/sales/quote/chartdiindex.js') }}" charset="utf-8"></script>
@endpush
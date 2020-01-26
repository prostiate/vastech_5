@extends('layouts.admin')

@section('contentheader')
<div class="page-title">
    <div class="title_left">
        <h3>Expenses</h3>
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
                        <button class="btn btn-dark dropdown-toggle" type="button" onclick="window.location.href = '/expenses/new';">New Expense
                        </button>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row tile_count">
                    <div class="col-md-12 col-sm-6 col-xs-6 tile_stats_count">
                        <span class="count_top">Open Expenses</span>
                        <div class="count">Rp @number($open_po_total)</div>
                    </div>
                    <div class="col-md-12 col-sm-6 col-xs-6 tile_stats_count">
                        <span class="count_top">Paid Expenses Last 30 Days</span>
                        <div class="count">Rp @number($payment_last_total)</div>
                    </div>
                    <div class="col-md-12 col-sm-6 col-xs-6 tile_stats_count">
                        <span class="count_top">Expenses This Month</span>
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
                @role('Expense')
                @can('Create')
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <button class="btn btn-dark dropdown-toggle" type="button" onclick="window.location.href = '/expenses/new';">New Expense
                        </button>
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
                                <th class="column-title">Transaction Date</th>
                                <th class="column-title">Transaction Number</th>
                                <th class="column-title">Beneficiary</th>
                                <th class="column-title">Pay From</th>
                                <th class="column-title">Balance Due</th>
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
<script src="{{ asset('js/expenses/dataTable.js?v=5-26012020') }}" charset="utf-8"></script>
<script src="{{ asset('js/expenses/chartdiindex.js?v=5-26012020') }}" charset="utf-8"></script>
@endpush
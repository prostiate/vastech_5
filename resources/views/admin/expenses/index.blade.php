@extends('layouts.admin')

@section('contentheader')
<div class="page-title">
    <div class="title_left">
        <h3>@lang("expense.index.title")</h3>
    </div>
</div>
@endsection

@section('content')
@hasrole('Owner|Ultimate')
<div class="row">
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>@lang("expense.index.summary_chart")</h2>
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
                <h2>@lang("expense.index.summary_number")</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <button class="btn btn-dark dropdown-toggle" type="button" onclick="window.location.href = '/expenses/new';">@lang("expense.index.new_button")
                        </button>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row tile_count">
                    <div class="col-md-12 col-sm-6 col-xs-6 tile_stats_count">
                        <span class="count_top">@lang("expense.index.summary_number_item_1")</span>
                        <div class="count">Rp @number($open_po_total)</div>
                    </div>
                    <div class="col-md-12 col-sm-6 col-xs-6 tile_stats_count">
                        <span class="count_top">@lang("expense.index.summary_number_item_2")</span>
                        <div class="count">Rp @number($payment_last_total)</div>
                    </div>
                    <div class="col-md-12 col-sm-6 col-xs-6 tile_stats_count">
                        <span class="count_top">@lang("expense.index.summary_number_item_3")</span>
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
                <h2>@lang("expense.index.list_transaction")</h2>
                @role('Expense')
                @can('Create')
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <button class="btn btn-dark dropdown-toggle" type="button" onclick="window.location.href = '/expenses/new';">@lang("expense.index.new_button")
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
                                <th class="column-title">@lang("expense.index.table.col_1")</th>
                                <th class="column-title">@lang("expense.index.table.col_2")</th>
                                <th class="column-title">@lang("expense.index.table.col_3")</th>
                                <th class="column-title">@lang("expense.index.table.col_4")</th>
                                <th class="column-title">@lang("expense.index.table.col_5")</th>
                                <th class="column-title">@lang("expense.index.table.col_6")</th>
                                <th class="column-title">@lang("expense.index.table.col_7")</th>
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
<script src="{{ asset('js/expenses/dataTable.js?v=5-20200312-1327') }}" charset="utf-8"></script>
<script src="{{ asset('js/expenses/chartdiindex.js?v=5-20200312-1327') }}" charset="utf-8"></script>
@endpush
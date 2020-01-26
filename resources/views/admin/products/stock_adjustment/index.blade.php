@extends('layouts.admin')

@section('contentheader')
<div class="page-title">
    <div class="title_left">
        <h3>Stock Adjustment</h3>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>List of Stock Adjustment</h2>
                @hasrole('Owner|Ultimate|Stock Adjustment')
                @can('Create')
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <button class="btn btn-dark dropdown-toggle" type="button" onclick="window.location.href = '/stock_adjustment/new';">New Stock Adjustment
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
                                <th class="column-title">Transaction Date </th>
                                <th class="column-title">Transaction No </th>
                                <th class="column-title">Adjustment Type </th>
                                <th class="column-title">Adjustment Account </th>
                                <th class="column-title">Warehouse </th>
                                <th class="column-title">Memo </th>
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
<<script src="{{ asset('js/products/stock_adjustment/dataTable.js?v=5-26012020') }}" charset="utf-8"></script>
@endpush
@extends('layouts.admin')

@section('contentheader')
<div class="page-title">
    <div class="title_left">
        <h3>Warehouse</h3>
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
                <input hidden type="text" value="{{$total_warehouse}}" id="open_po">
                <div id="hehehehe" style="height: 350px;"></div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Total Warehouses</h2>
                @hasrole('Owner|Ultimate|Warehouses')
                @can('Create')
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <button class="btn btn-dark dropdown-toggle" type="button" onclick="window.location.href = '/warehouses/new';">New Warehouse
                        </button>
                    </li>
                </ul>
                @endcan
                @endrole
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row tile_count">
                    <div class="col-md-12 col-sm-6 col-xs-6 tile_stats_count">
                        <span class="count_top">Total Warehouses</span>
                        <div class="count">{{$total_warehouse}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>List of Warehouse</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-striped jambo_table bulk_action" id="dataTable" style="width:100%">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">Code Werehouse </th>
                                <th class="column-title">Name Werehouse </th>
                                <th class="column-title">Address </th>
                                <th class="column-title">Description </th>
                                <!--<th class="column-title" style="width:90px">Action </th>-->
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
<script src="{{ asset('js/products/warehouses/dataTable.js?v=5-20200302-1755') }}" charset="utf-8"></script>
<script src="{{ asset('js/products/warehouses/chartdiindex.js?v=5-20200302-1755') }}" charset="utf-8"></script>
@endpush
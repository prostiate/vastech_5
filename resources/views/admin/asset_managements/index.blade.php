@extends('layouts.admin')

@section('contentheader')
<div class="page-title">
    <div class="title_left">
        <h3>Fixed Assets</h3>
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
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>List of Assets</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <button class="btn btn-dark dropdown-toggle" type="button" onclick="window.location.href = '/asset_managements/new';">Record Asset
                        </button>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_content1" role="tab" id="invoice-tab" data-toggle="tab" aria-expanded="true">Pending Assets</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content2" role="tab" id="delivery-tab" data-toggle="tab" aria-expanded="false">Active Assets</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content3" role="tab" id="order-tab2" data-toggle="tab" aria-expanded="false">Sold/Disposed</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content4" role="tab" id="quote-tab2" data-toggle="tab" aria-expanded="false">Depreciation</a>
                        </li>
                    </ul>
                    <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="invoice-tab">
                            <div class="table-responsive">
                                <table class="table table-striped jambo_table bulk_action">
                                    <thead>
                                        <tr class="headings">
                                            <th class="column-title">Invoice </th>
                                            <th class="column-title">Acquisition Date </th>
                                            <th class="column-title">Item </th>
                                            <th class="column-title">Acquisition Cost </th>
                                            <th class="column-title no-link last"><span class="nobr">Action</span></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="delivery-tab">
                            <div class="table-responsive">
                                <table class="table table-striped jambo_table bulk_action" id="dataTable2" style="width:100%">
                                    <thead>
                                        <tr class="headings">
                                            <th class="column-title">Asset Account </th>
                                            <th class="column-title">Acquisition Date </th>
                                            <th class="column-title">Asset Detail </th>
                                            <th class="column-title">Acquisition Cost </th>
                                            <th class="column-title">Book Value </th>
                                            <!--<th class="column-title no-link last"><span class="nobr">Action</span>-->
                                            </th>
                                        </tr>
                                    </thead>                                    
                                </table>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="order-tab">
                            <div class="table-responsive">
                                <table class="table table-striped jambo_table bulk_action">
                                    <thead>
                                        <tr class="headings">
                                            <th class="column-title">Transaction Number </th>
                                            <th class="column-title">Acquisition Date </th>
                                            <th class="column-title">Detail </th>
                                            <th class="column-title">Sell Price </th>
                                            <th class="column-title">Gain Loss </th>
                                            <th class="column-title no-link last"><span class="nobr">Action</span></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="quote-tab">
                            <div class="table-responsive">
                                <table class="table table-striped jambo_table bulk_action">
                                    <thead>
                                        <tr class="headings">
                                            <th class="column-title">Method </th>
                                            <th class="column-title">Detail </th>
                                            <th class="column-title">Period </th>
                                            <th class="column-title">Rate </th>
                                            <th class="column-title">Depreciation Method </th>
                                            <th class="column-title no-link last"><span class="nobr">Action</span></th>
                                        </tr>
                                    </thead>
                                </table>
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
<script src="{{ asset('js/asset_management/dataTable.js') }}" charset="utf-8"></script>
@endpush
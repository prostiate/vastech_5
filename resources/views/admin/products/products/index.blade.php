@extends('layouts.admin')

@section('contentheader')
<div class="page-title">
    <div class="title_left">
        <h3>@lang('product_1.index.title')</h3>
    </div>
    {{-- notifikasi form validasi --}}
    @if ($errors->has('file'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('file') }}</strong>
    </span>
    @endif
    {{-- notifikasi form error --}}
    @if ($error = Session::get('error'))
    <div class="alert alert-error alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $error }}</strong>
    </div>
    @endif
    {{-- notifikasi sukses --}}
    @if ($sukses = Session::get('sukses'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $sukses }}</strong>
    </div>
    @endif
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>@lang('product_1.index.summary_1')</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <input hidden type="text" value="{{$avail_stock}}" id="open_po">
                <input hidden type="text" value="{{$low_stock}}" id="payment_last">
                <input hidden type="text" value="{{$out_stock}}" id="overdue">
                <div id="hehehehe" style="height: 350px;"></div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>@lang('product_1.index.summary_2')</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        @hasrole('Owner|Ultimate|Good & Services')
                        @can('Create')
                        <button class="btn btn-dark dropdown-toggle" type="button" onclick="window.location.href = '/products/new';">@lang('product_1.index.new_btn')
                        </button>
                        @endcan
                        @endrole
                        <button data-toggle="dropdown" class="btn btn-dark mr-5 dropdown-toggle" type="button" aria-expanded="false"><span class="glyphicon glyphicon-wrench"></span>
                        </button>
                        <ul role="menu" class="dropdown-menu">
                            <li><a href="/products/export_excel">@lang('product_1.index.action.action_1')</a>
                            </li>
                            <li><a href="/products/export_csv">@lang('product_1.index.action.action_2')</a>
                            </li>
                            <li><a target="_blank" href="/products/export_pdf">@lang('product_1.index.action.action_3')</a>
                            </li>
                            <li class="divider"></li>
                            @hasrole('Owner|Ultimate|Good & Services')
                            @can('Create')
                            <li><a data-toggle="modal" data-target="#importExcel">@lang('product_1.index.action.action_4')</a>
                            </li>
                            @endcan
                            @endrole
                        </ul>
                        <div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <form method="post" action="/products/import_excel" enctype="multipart/form-data">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">@lang('product_1.index.action.action_4')</h5>
                                        </div>
                                        <div class="modal-body">
                                            {{ csrf_field() }}
                                            <label>@lang('product_1.index.upload')</label>
                                            <div class="form-group">
                                                <input type="file" name="file" required="required">
                                            </div>
                                            <a href="{{ url('/file_product/SampleProduct.xlsx') }}">@lang('product_1.index.sample')</a>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('product_1.index.close')</button>
                                            <button type="submit" class="btn btn-primary">@lang('product_1.index.import')</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row tile_count">
                    <div class="col-md-12 col-sm-6 col-xs-6 tile_stats_count">
                        <span class="count_top">@lang('product_1.index.summary_3')</span>
                        <div class="count">{{$avail_stock}}</div>
                    </div>
                    <div class="col-md-12 col-sm-6 col-xs-6 tile_stats_count">
                        <span class="count_top">@lang('product_1.index.summary_4')</span>
                        <div class="count">{{$low_stock}}</div>
                    </div>
                    <div class="col-md-12 col-sm-6 col-xs-6 tile_stats_count">
                        <span class="count_top">@lang('product_1.index.summary_5')</span>
                        <div class="count">{{$out_stock}}</div>
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
                <h2>@lang('product_1.index.list_transaction')</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-striped jambo_table bulk_action" @if($cs->is_avg_price == 1) id="dataTable1" @else id="dataTable2" @endif style="width:100%">
                        <thead>
                            <tr class="headings">
                                <!--<th class="column-title">Product Image </th>-->
                                <th class="column-title">@lang('product_1.index.table.col_1')</th>
                                <th class="column-title">@lang('product_1.index.table.col_2')</th>
                                <th class="column-title">@lang('product_1.index.table.col_3')</th>
                                <!--<th class="column-title">Minimum Stock </th>-->
                                <th class="column-title">@lang('product_1.index.table.col_4')</th>
                                @if($cs->is_avg_price == 1)
                                <th class="column-title">Average Price</th>
                                @else
                                <th class="column-title">Last Buy Price</th>
                                @endif
                                <!--<th class="column-title">Last Buy Price </th>-->
                                <th class="column-title">@lang('product_1.index.table.col_6')</th>
                                <th class="column-title">@lang('product_1.index.table.col_7')</th>
                                <th class="column-title">@lang('product_1.index.table.col_8')</th>
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
<script src="{{ asset('js/products/products/dataTable.js?v=5-20200319-0916') }}" charset="utf-8"></script>
<script src="{{ asset('js/products/products/chartdiindex.js?v=5-20200319-0916') }}" charset="utf-8"></script>
@endpush
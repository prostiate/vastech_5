@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>@lang('product_3.create.title')</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="post" id="formCreate" class="form-horizontal">
                    <div id="demo-form2" class="form-horizontal form-label-left">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="warehouse_name">@lang('product_3.create.name')
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="warehouse_name" name="warehouse_name" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="warehouse_code">@lang('product_3.create.code')
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="warehouse_code" name="warehouse_code" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="warehouse_address">@lang('product_3.create.address')
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="warehouse_address" name="warehouse_address" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="warehouse_description">@lang('product_3.create.desc')
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="warehouse_description" name="warehouse_description" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="col-md-12 text-center">
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <a href="{{ url('/warehouses') }}" class="btn btn-primary">@lang('product_3.create.cancel')</a>
                                <button type="button" id="click" class="btn btn-success">@lang('product_3.create.create')</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{asset('js/products/warehouses/createForm.js?v=5-20200315-0243') }}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js?v=5-20200315-0243') }}" charset="utf-8"></script>
<script src="{{asset('js/other/zebradatepicker.js?v=5-20200315-0243') }}" charset="utf-8"></script>
@endpush
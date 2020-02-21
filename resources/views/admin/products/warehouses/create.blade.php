@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Create New Warehouse</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="post" id="formCreate" class="form-horizontal">
                    <div id="demo-form2" class="form-horizontal form-label-left">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="warehouse_name">Warehouse Name <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input placeholder="Warehouse Name" type="text" id="warehouse_name" name="warehouse_name" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="warehouse_code">Warehouse Code
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input placeholder="Warehouse Code" type="text" id="warehouse_code" name="warehouse_code" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="warehouse_address">Warehouse Address
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input placeholder="Warehouse Address" type="text" id="warehouse_address" name="warehouse_address" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="warehouse_description">Warehouse Description
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input placeholder="Warehouse Description" type="text" id="warehouse_description" name="warehouse_description" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <a href="{{ url('/warehouses') }}" class="btn btn-primary">Cancel</a>
                            <button type="button" id="click" class="btn btn-success">Create</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{asset('js/products/warehouses/createForm.js?v=5-20200221-1431') }}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js?v=5-20200221-1431') }}" charset="utf-8"></script>
<script src="{{asset('js/other/zebradatepicker.js?v=5-20200221-1431') }}" charset="utf-8"></script>
@endpush
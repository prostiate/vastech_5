@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Edit Warehouse</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="post" id="formCreate" class="form-horizontal">
                    <div id="demo-form2" class="form-horizontal form-label-left">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="warehouse_name">Warehouse Name <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input value="{{$warehouses->name}}" placeholder="Warehouse Name" type="text" id="warehouse_name" name="warehouse_name" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="warehouse_code">Warehouse Code
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input value="{{$warehouses->code}}" placeholder="Warehouse Code" type="text" id="warehouse_code" name="warehouse_code" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="warehouse_address">Warehouse Address
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input value="{{$warehouses->address}}" placeholder="Warehouse Address" type="text" id="warehouse_address" name="warehouse_address" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="warehouse_description">Warehouse Description
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input value="{{$warehouses->desc}}" placeholder="Warehouse Description" type="text" id="warehouse_description" name="warehouse_description" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button class="btn btn-primary" type="button" onclick="window.location.href = '/warehouses/' + {{$warehouses->id}};">Cancel</button>
                            <button type="button" id="click" class="btn btn-success">Create</button>
                            <input value="{{$warehouses->id}}" type="hidden" name="hidden_id" id="hidden_id" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{asset('js/products/warehouses/updateForm.js')}}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js')}}" charset="utf-8"></script>
<script src="{{asset('js/other/zebradatepicker.js') }}" charset="utf-8"></script>
@endpush
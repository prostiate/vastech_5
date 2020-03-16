@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3>@lang('product_4.create_1.title')</h3>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="post" id="formCreate" class="form-horizontal">
                    <div id="demo-form2" class="form-horizontal form-label-left">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">@lang('product_4.create_1.from')
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select class="form-control selectwarehouse" id="warehouse_from">
                                    @foreach($warehouses as $a)
                                    <option value="{{$a->id}}">
                                        {{$a->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">@lang('product_4.create_1.to')
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select class="form-control selectwarehouse" id="warehouse_to">
                                    @foreach($warehouses as $a)
                                    <option value="{{$a->id}}">
                                        {{$a->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="col-md-12 text-center">
                        <div class="form-group">
                            <a href="{{ url('/warehouses_transfer') }}" class="btn btn-primary">@lang('product_4.create_1.cancel')</a>
                            <button type="button" id="click" class="btn btn-success" onclick="next()">@lang('product_4.create_1.next')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{asset('js/other/select2.js?v=5-20200315-0243') }}" charset="utf-8"></script>
<script>
    function next() {
        var warehouse_from = document.getElementById('warehouse_from');
        var warehouse_to = document.getElementById('warehouse_to');
        window.location.href = "/warehouses_transfer/new/" + warehouse_from.value + "_" + warehouse_to.value;
    }
</script>
@endpush
@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3>@lang('product_2.create_1.title')</h3>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="post" id="formCreate" class="form-horizontal">
                    <div id="demo-form2" class="form-horizontal form-label-left">
                        <div class="form-group">
                            <div class="form-horizontal form-label-left">
                                <div class="col-md-6">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang('product_2.create_1.type_1')</label>
                                    <div class="col-md-4 col-xs-12">
                                        <div class="radio">
                                            <label class="type1">
                                                <input id="type1" type="radio" class="flat type1" name="iCheck" value="1" checked>@lang('product_2.create_1.type_2')
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-xs-12" hidden>
                                        <div class="radio">
                                            <label class="type2">
                                                <input id="type2" type="radio" class="flat type2" name="iCheck" value="2">@lang('product_2.create_1.type_3')
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-horizontal form-label-left">
                                <div class="col-md-6">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang('product_2.create_1.category')</label>
                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                        <select id="cat" name="adjustment_category" class="form-control col-md-7 col-xs-12 selectadjustmentcategory">
                                            <option value="General">General</option>
                                            <option value="Waste">Waste</option>
                                            <option value="Production">Production</option>
                                            <option value="Opening Quantity">Opening Quantity</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-horizontal form-label-left">
                                <div class="col-md-6">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang('product_2.create_1.warehouse')</label>
                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                        <select id="war" class="form-control selectwarehouse" name="warehouse">
                                            @foreach($warehouses as $a)
                                            <option value="{{$a->id}}">
                                                {{$a->name}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="col-md-12 text-center">
                        <div class="form-group">
                            <a href="{{ url('/stock_adjustment') }}" class="btn btn-primary">@lang('product_2.create_1.cancel')</a>
                            <button type="button" id="click" class="btn btn-success" onclick="next()">@lang('product_2.create_1.next')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{asset('js/other/select2.js?v=5-20200305-1546') }}" charset="utf-8"></script>
<script>
    function next() {
        if (document.getElementById('type1').checked) {
            var type = document.getElementById('type1');
            var link = "/stock_adjustment/new/stock_count/"
        }
        if (document.getElementById('type2').checked) {
            var type = document.getElementById('type2');
            var link = "/stock_adjustment/new/stock_inout/"
        }
        var cat = document.getElementById('cat');
        var war = document.getElementById('war');
        window.location.href = link + type.value + "_" + cat.value + "&" + war.value;
    }
</script>
@endpush
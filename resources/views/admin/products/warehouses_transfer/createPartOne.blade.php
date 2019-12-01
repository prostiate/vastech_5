@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3>Create Warehouse Transfer</h3>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="post" id="formCreate" class="form-horizontal">
                    <div id="demo-form2" class="form-horizontal form-label-left">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">From Warehouse*</span>
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
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">To Warehouse*
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
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <a href="{{ url('/warehouses_transfer') }}" class="btn btn-primary">Cancel</a>
                            <button type="button" id="click" class="btn btn-success" onclick="next()">Next</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{asset('js/other/select2.js')}}" charset="utf-8"></script>
<script>
    function next() {
        var warehouse_from = document.getElementById('warehouse_from');
        var warehouse_to = document.getElementById('warehouse_to');
        window.location.href = "/warehouses_transfer/new/" + warehouse_from.value + "_" + warehouse_to.value;
    }
</script>
@endpush
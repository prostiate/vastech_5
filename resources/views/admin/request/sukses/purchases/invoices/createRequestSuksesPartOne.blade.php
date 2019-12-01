@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3>Create Purchase Invoice</h3>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="post" id="formCreate" class="form-horizontal">
                    <div id="demo-form2" class="form-horizontal form-label-left">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Contact*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select class="form-control select_contact contact_id" id="vendor_name">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Warehouse*
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select class="form-control selectwarehouse" id="warehouse">
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
                            <a href="{{ url('/purchases_invoice') }}" class="btn btn-primary">Cancel</a>
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
<script src="{{asset('js/purchases/invoices/addmoreitem.js')}}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js')}}" charset="utf-8"></script>
<script>
    function next() {
        var vendor_name = document.getElementById('vendor_name');
        var warehouse = document.getElementById('warehouse');
        window.location.href = "/purchases_invoice/newRS/" + vendor_name.value + "_" + warehouse.value;
    }
</script>
@endpush
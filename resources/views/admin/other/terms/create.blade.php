@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Create New Term</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="post" id="formCreate" class="form-horizontal">
                    <div id="demo-form2" class="form-horizontal form-label-left">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Name
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="name" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Length
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="number" name="length" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <a href="{{ url('/other/terms') }}" class="btn btn-primary">Cancel</a>
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
<script src="{{asset('js/otherlists/terms/createForm.js?v=5-27012020') }}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js?v=5-27012020') }}" charset="utf-8"></script>
<script src="{{asset('js/other/zebradatepicker.js?v=5-27012020') }}" charset="utf-8"></script>
@endpush
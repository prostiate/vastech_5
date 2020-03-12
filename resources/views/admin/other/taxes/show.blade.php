@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>{{$tax->name}}</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="post" id="formCreate" class="form-horizontal">
                    <div id="demo-form2" class="form-horizontal form-label-left">
                        <!--<div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tax
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="tax" class="form-control col-md-7 col-xs-12 selecttax">
                                    <option value="SINGLE">Single</option>
                                    <option value="GROUP">Group</option>
                                </select>
                            </div>
                        </div>-->
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Name
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input value="{{$tax->name}}" disabled type="text" name="name" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Effective Rate
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input value="{{$tax->rate}}" disabled type="number" name="effective_rate" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <!--<div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Witholding
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" class="flat" name="iCheck" name="witholding" value="1">
                                    </label>
                                </div>
                            </div>
                        </div>-->
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Sell Tax Account
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <h5>{{$tax->coa_sell->name}}</h5>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Buy Tax Account
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <h5>{{$tax->coa_buy->name}}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 center-margin">
                        <div class="form-group">
                            <a href="{{ url('/other/taxes') }}" class="btn btn-dark">Cancel</a>
                            <div class="btn-group">
                                <button class="btn btn-success" type="button" onclick="window.location.href = '/other/taxes/edit/' + {{$tax->id}};">Edit
                                </button>
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
<script src="{{asset('js/other/select2.js?v=5-20200312-1327') }}" charset="utf-8"></script>
<script src="{{asset('js/other/zebradatepicker.js?v=5-20200312-1327') }}" charset="utf-8"></script>
@endpush
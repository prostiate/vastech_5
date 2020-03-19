@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Create New Tax</h2>
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
                                <input value="{{$tax->name}}" type="text" name="name" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Effective Rate
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input value="{{$tax->rate}}" type="number" name="effective_rate" class="form-control col-md-7 col-xs-12">
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
                                <select name="sell_tax_account" class="form-control col-md-7 col-xs-12 selecttax">
                                    @foreach($coa as $c)
                                    <option value="{{$c->id}}" @if($c->id == $tax->sell_tax_account) selected @endif>({{$c->code}}) - {{$c->name}} ({{$c->coa_category->name}})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Buy Tax Account
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="buy_tax_account" class="form-control col-md-7 col-xs-12 selecttax">
                                    @foreach($coa2 as $c)
                                    <option value="{{$c->id}}" @if($c->id == $tax->buy_tax_account) selected @endif>({{$c->code}}) - {{$c->name}} ({{$c->coa_category->name}})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="col-md-12 text-center">
                        <div class="form-group">
                            <button class="btn btn-dark" type="button" onclick="window.location.href = '/other/taxes/' + {{$tax->id}};">Cancel
                            </button>
                            <div class="btn-group">
                                <button id="click" class="btn btn-success" type="button">Edit Tax
                                </button>
                                <input value="{{$tax->id}}" type="hidden" name="hidden_id" id="hidden_id" />
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
<script src="{{asset('js/otherlists/taxes/updateForm.js?v=5-20200319-0916') }}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js?v=5-20200319-0916') }}" charset="utf-8"></script>
<script src="{{asset('js/other/zebradatepicker.js?v=5-20200319-0916') }}" charset="utf-8"></script>
@endpush
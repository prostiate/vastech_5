@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <form method="post" id="formCreate" class="form-horizontal">
                <input type="hidden" value="{{$asset->id}}" name="hidden_id">                
                <div class="x_title">
                    <h2>Asset Detail</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">Asset
                                    Name*</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input type="text" class="form-control" name="asset_name" value="{{$asset->name}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12"
                                    style="text-align: left">Acquisition Date</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input type="text" class="form-control" id="datepicker1" name="asset_date"
                                        value="{{$asset->date}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">Asset
                                    Number*</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input type="text" class="form-control" name="asset_number"
                                        value="{{$asset->number}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12"
                                    style="text-align: left">Acquisition Cost</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input type="text" class="form-control form-control-sm" name="asset_cost"
                                        value="{{$asset->cost}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">Fixed
                                    Asset Number*</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="select2 form-control selectaccount" name="asset_account">
                                        @foreach ($fixed_accounts as $acc)
                                        <option value="{{$acc->id}}" @if($asset->asset_account == $acc->id) selected =
                                            'selected' @endif>({{$acc->code}}) -
                                            {{$acc->name}}
                                            ({{$acc->coa_category->name}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12"
                                    style="text-align: left">Account Credited</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="select2 form-control selectaccount" name="asset_account_credited">
                                        @foreach ($accounts as $acc)
                                        <option value="{{$acc->id}}" @if($asset->credited_account == $acc->id) selected =
                                            'selected' @endif>({{$acc->code}}) - {{$acc->name}}
                                            ({{$acc->coa_category->name}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12"
                                    style="text-align: left">Descrption</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <textarea class="form-control" id="descForm" rows="4" name="asset_desc"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="x_title">
                    <h2>Depreciation</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12"
                                    style="text-align: left">Non-depreciable Asset</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <label>
                                        <input type="checkbox" class="js-switch" 
                                        value="1" id="check_depreciable"
                                        name="is_depreciable" @if($asset->is_depreciable == 0) checked @endif />
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12"
                                    style="text-align: left">Method</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="select2 form-control selectaccount" name="depreciate_method"
                                        disabled>
                                        <option value="straight" @if($detail) @if($detail->method == 1) selected @endif
                                            @endif>Straight line</option>
                                        <option value="reduce" @if($detail) @if($detail->method == 2) selected @endif
                                            @endif>Reducing Balanse</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12"
                                    style="text-align: left">Depreciation Account</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="select2 form-control selectaccount"
                                        name="depreciate_account" disabled>
                                        @foreach ($depreciation_accumulated_accounts as $acc)
                                        <option value="{{$acc->id}}" @if($detail) @if($detail->
                                            accumulated_depreciate_account == $acc->id) selected = 'selected' @endif
                                            @endif>({{$acc->code}}) - {{$acc->name}}
                                            ({{$acc->coa_category->name}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">Useful
                                    Life</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input type="text" class="form-control" name="depreciate_life" @if($detail)
                                        value="{{$detail->life}}" @else value="4" @endif disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12"
                                    style="text-align: left">Depreciation Accumulated Account</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="select2 form-control selectaccount"
                                        name="depreciate_accumulated_account" disabled>
                                        @foreach ($depreciation_accounts as $acc)
                                        <option value="{{$acc->id}}" @if($detail) @if($detail->accumulated_depreciate ==
                                            $acc->id) selected = 'selected' @endif @endif>({{$acc->code}}) -
                                            {{$acc->name}}
                                            ({{$acc->coa_category->name}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">Rate /
                                    Year</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input type="text" class="form-control" name="depreciate_rate" @if($detail)
                                        value="{{$detail->rate}}" @else value="25" @endif disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12"
                                    style="text-align: left">Accumulated Depreciation</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input type="text" class="form-control" name="depreciate_accumulated" @if($detail)
                                        value="{{$detail->accumulated_depreciate}}" @else value="0" @endif disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">As at
                                Date</label>
                            <div class="col-md-7 col-sm-7 col-xs-12">
                                <input type="text" class="form-control" id="datepicker1" name="depreciate_date"
                                    @if($detail) value="{{$detail->date}}" @else value="{{$today}}" @endif disabled>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="col-md-3 center-margin">
                    <div class="form-group">
                        <a href="{{ url('/asset_managements/show') }}" class="btn btn-danger">Cancel</a>
                        <div class="btn-group">
                            <button id="click" type="button" class="btn btn-success">Update</button>
                        </div>
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
<script src="{{asset('js/asset_management/updateForm.js?v=5-26012020') }}" charset="utf-8"></script>
<script src="{{asset('js/other/sum.js?v=5-26012020') }}" charset="utf-8"></script>
<script src="{{asset('js/other/add_field.js?v=5-26012020') }}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js?v=5-26012020') }}" charset="utf-8"></script>
<script src="{{asset('js/other/is_depreciable.js?v=5-26012020') }}" charset="utf-8"></script>
<script src="{{asset('js/other/zebradatepicker.js?v=5-26012020') }}" charset="utf-8"></script>
@endpush
@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <form method="post" id="formCreate" class="form-horizontal">
                <div class="x_title">
                    <h2>Asset Detail</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">*
                                    Asset Name</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input type="text" class="form-control" name="asset_name" value="{{$asset->name}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">Acquisition Date</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$asset->date}}" type="text" class="form-control" id="datepicker1" name="asset_date" @if($asset->is_depreciated == 0) disabled @endif>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">*
                                    Asset Number</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input type="text" class="form-control" name="asset_number" value="{{$asset->number}}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">Acquisition Cost</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input type="text" class="form-control form-control-sm asset_cost_display" name="asset_cost_display" value="{{$asset->cost}}" onClick="this.select();" @if($asset->is_depreciated == 0) disabled @endif>
                                    <input type="text" class="form-control form-control-sm asset_cost" name="asset_cost" value="{{$asset->cost}}" hidden>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">*
                                    Fixed Asset Number</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="select2 form-control selectaccount" name="asset_account" @if($asset->is_depreciated == 0) disabled @endif>
                                        @foreach ($fixed_accounts as $acc)
                                        <option value="{{$acc->id}}" @if($asset->asset_account == $acc->id) selected @endif>({{$acc->code}}) - {{$acc->name}}
                                            ({{$acc->coa_category->name}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">Account Credited</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="select2 form-control selectaccount" name="asset_account_credited" @if($asset->is_depreciated == 0) disabled @endif>
                                        @foreach ($accounts as $acc)
                                        <option value="{{$acc->id}}" @if($asset->credited_account == $acc->id) selected @endif>({{$acc->code}}) - {{$acc->name}}
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
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">Descrption</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <textarea class="form-control" id="descForm" rows="4" name="asset_desc">{{$asset->description}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if($asset->is_depreciable == 1)
                <div class="x_title">
                    <h2>Depreciation</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">Method</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="select2 form-control selectaccount" name="depreciate_method" @if($asset->is_depreciated == 0) disabled @endif>
                                        <option value="straight">Straight Line</option>
                                        <option value="reduce">Reducing Balanse</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">Depreciation Account</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="select2 form-control selectaccount" name="depreciate_account" @if($asset->is_depreciated == 0) disabled @endif>
                                        @foreach ($depreciation_accumulated_accounts as $acc)
                                        <option value="{{$acc->id}}">({{$acc->code}}) - {{$acc->name}}
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
                                    <input type="text" class="form-control depreciate_life" name="depreciate_life" value="4" onClick="this.select();" @if($asset->is_depreciated == 0) disabled @endif>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">Depreciation Accumulated Account</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="select2 form-control selectaccount" name="depreciate_accumulated_account" @if($asset->is_depreciated == 0) disabled @endif>
                                        @foreach ($depreciation_accounts as $acc)
                                        <option value="{{$acc->id}}">({{$acc->code}}) - {{$acc->name}}
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
                                    <input type="text" class="form-control depreciate_rate" name="depreciate_rate" value="25" onClick="this.select();" @if($asset->is_depreciated == 0) disabled @endif>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">Accumulated Depreciation</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input type="text" class="form-control depreciate_accumulated_display" name="depreciate_accumulated_display" value="0" onClick="this.select();" @if($asset->is_depreciated == 0) disabled @endif>
                                    <input type="text" class="form-control depreciate_accumulated" name="depreciate_accumulated" value="0" hidden @if($asset->is_depreciated == 0) disabled @endif>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">As at
                                Date</label>
                            <div class="col-md-7 col-sm-7 col-xs-12">
                                <input value="{{$today}}" type="text" class="form-control" id="datepicker2" name="depreciate_date">
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <div class="col-md-12 text-center">
                    <div class="form-group">
                        <a href="{{ url('/asset_managements') }}" class="btn btn-danger">Cancel</a>
                        <div class="btn-group">
                            <input type="text" value="{{$asset->id}}" name="hidden_id" hidden>
                            @if($asset->is_depreciable == 1)
                            <button id="click" type="button" class="btn btn-success">Update</button>
                            @else
                            <button id="click2" type="button" class="btn btn-success">Update</button>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{asset('js/asset_management/updateForm.js?v=5-20200315-0243') }}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js?v=5-20200315-0243') }}" charset="utf-8"></script>
<script src="{{asset('js/other/is_depreciable.js?v=5-20200315-0243') }}" charset="utf-8"></script>
<script src="{{asset('js/other/zebradatepicker.js?v=5-20200315-0243') }}" charset="utf-8"></script>
@endpush
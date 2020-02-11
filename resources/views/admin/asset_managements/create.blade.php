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
                                    <input type="text" class="form-control" name="asset_name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">Acquisition Date</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$today}}" type="text" class="form-control" id="datepicker1" name="asset_date">
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
                                    <input type="text" class="form-control" name="asset_number" value="{{$trans_no}}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">Acquisition Cost</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input type="text" class="form-control form-control-sm asset_cost_display" name="asset_cost_display" value="0" onClick="this.select();">
                                    <input type="text" class="form-control form-control-sm asset_cost" name="asset_cost" value="0" hidden>
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
                                    <select class="select2 form-control selectaccount" name="asset_account">
                                        @foreach ($fixed_accounts as $acc)
                                        <option value="{{$acc->id}}">({{$acc->code}}) - {{$acc->name}}
                                            ({{$acc->coa_category->name}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">Account Credited</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="select2 form-control selectaccount" name="asset_account_credited">
                                        @foreach ($accounts as $acc)
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
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">Descrption</label>
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
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">Non-depreciable Asset</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <label>
                                        <input type="checkbox" class="js-switch" value="1" id="check_depreciable" name="is_depreciable" checked />
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">Method</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="select2 form-control selectaccount" name="depreciate_method" disabled>
                                        <option value="straight">Straight Line</option>
                                        <option value="reduce">Reducing Balanse</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">Depreciation Account</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="select2 form-control selectaccount" name="depreciate_account" disabled>
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
                                    <input type="text" class="form-control depreciate_life" name="depreciate_life" value="4" onClick="this.select();" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">Depreciation Accumulated Account</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="select2 form-control selectaccount" name="depreciate_accumulated_account" disabled>
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
                                    <input type="text" class="form-control depreciate_rate" name="depreciate_rate" value="25" onClick="this.select();" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">Accumulated Depreciation</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input type="text" class="form-control depreciate_accumulated_display" name="depreciate_accumulated_display" value="0" onClick="this.select();" disabled>
                                    <input type="text" class="form-control depreciate_accumulated" name="depreciate_accumulated" value="0" hidden disabled>
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
                <div class="form-group row">
                    <div class="offset-lg-9 col-lg-3 center-margin">
                        <a href="{{ url('/asset_managements') }}" class="btn btn-danger">Cancel</a>
                        <div class="btn-group">
                            <button id="click" type="button" class="btn btn-success">Create </button>
                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a id="clicknew">Create & New </a>
                                </li>
                                <li><a id="click">Create </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{asset('js/asset_management/createForm.js?v=5-20200211-1624') }}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js?v=5-20200211-1624') }}" charset="utf-8"></script>
<script src="{{asset('js/other/is_depreciable.js?v=5-20200211-1624') }}" charset="utf-8"></script>
<script src="{{asset('js/other/zebradatepicker.js?v=5-20200211-1624') }}" charset="utf-8"></script>
@endpush
<!-- {{-- @extends('layouts.admin')
@section('content')

<div class="dashboard-wrapper">
    <div class="row page-header">
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
            <div id="top">
                <h1> Asset Details </h1>
            </div>
        </div>
    </div>
    <div class="container-fluid dashboard-content">
        <form method="post" action="{{ route('asset.store') }}">
            <div class="card">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="row my-1">
                                <div class="col-sm-4">
                                    Asset Name
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control form-control-sm" id="" name="asset_name">
                                </div>
                            </div>
                            <div class="row my-1">
                                <div class="col-sm-4">
                                    Asset Number
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control form-control-sm" name="asset_number" value="{{$trans_no}}">
                                </div>
                            </div>
                            <div class="row my-1">
                                <div class="col-sm-4">
                                    Fixed Asset Account
                                </div>
                                <div class="col-sm-6">
                                    <select class="select2 form-control form-control-sm" name="asset_account">
                                        @foreach ($fixed_accounts as $acc)
                                        <option value="{{$acc->id}}">({{$acc->code}}) - {{$acc->name}}
                                            ({{$acc->coa_category->name}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row my-1">
                                <div class="col-sm-4">
                                    Description
                                </div>
                                <div class="col-sm-6">
                                    <textarea class="form-control" id="descForm" rows="2" name="asset_desc"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row my-1">
                                <div class="col-sm-4">
                                    Acquisition Date
                                </div>
                                <div class="col-sm-6">
                                    <input type="date" class="form-control form-control-sm" name="asset_date">
                                </div>
                            </div>
                            <div class="row my-1">
                                <div class="col-sm-4">
                                    Acquisition Cost
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control form-control-sm" name="asset_cost" value="0">
                                </div>
                            </div>
                            <div class="row my-1">
                                <div class="col-sm-4">
                                    Account Credited
                                </div>
                                <div class="col-sm-6">
                                    <select class="select2 form-control form-control-sm" name="asset_account_credited">
                                        @foreach ($accounts as $acc)
                                        <option value="{{$acc->id}}">({{$acc->code}}) - {{$acc->name}}
                                            ({{$acc->coa_category->name}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h3> Depreciation </h3>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="row my-2">
                                <div class="col-sm-4">
                                    Non-depreciable Asset
                                </div>
                                <div class="col-sm-6">
                                    <input type="checkbox" id="check_depreciable" name="is_depreciable" checked>
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col-sm-4">
                                    Method
                                </div>
                                <div class="col-sm-6">
                                    <select class="select2 form-control form-control-sm" name="depreciate_method" disabled>
                                        <option value="straight">Straight line</option>
                                        <option value="reduce">Reducing Balanse</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col-sm-4">
                                    Useful Life
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control form-control-sm" name="depreciate_life" value="4" disabled>
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col-sm-4">
                                    Rate/Year
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control form-control-sm" name="depreciate_rate" value="25" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row my-2">
                                <div class="col-sm-4">
                                    Depreciation Account
                                </div>
                                <div class="col-sm-6">
                                    <select class="select2 form-control form-control-sm" name="depreciate_account" disabled>
                                        @foreach ($expense_accounts as $acc)
                                        <option value="{{$acc->id}}">({{$acc->code}}) - {{$acc->name}}
                                            ({{$acc->coa_category->name}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col-sm-4">
                                    Accumulated Depreciation Account
                                </div>
                                <div class="col-sm-6">
                                    <select class="select2 form-control form-control-sm" name="depreciate_accumulated_account" disabled>
                                        @foreach ($depreciation_accounts as $acc)
                                        <option value="{{$acc->id}}">({{$acc->code}}) - {{$acc->name}}
                                            ({{$acc->coa_category->name}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col-sm-4">
                                    Accumulated Depreciation
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control form-control-sm" name="depreciate_accumulated" disabled>
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col-sm-4">
                                    As at Date
                                </div>
                                <div class="col-sm-6">
                                    <input type="date" class="form-control form-control-sm" id="numberForm" name="depreciate_date" disabled>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <div class="float-right">
                                    <a href="{{ url()->previous() }}" class="btn btn-danger">Cancel</a>
                                    <div class="btn-group dropup">
                                        <button type="submit" class="btn btn-success">Create Asset</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection --}} -->

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
                                <label class="control-label col-md-4 col-sm-3 col-xs-12"
                                    style="text-align: left">Acquisition Date</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$today}}" type="text" class="form-control" id="datepicker1"
                                        name="asset_date">
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
                                    <input type="text" class="form-control" name="asset_number" value="{{$trans_no}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12"
                                    style="text-align: left">Acquisition Cost</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input type="text" class="form-control form-control-sm" name="asset_cost" value="0">
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
                                <label class="control-label col-md-4 col-sm-3 col-xs-12"
                                    style="text-align: left">Account Credited</label>
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
                                        <input type="checkbox" class="js-switch" value="1" id="check_depreciable"
                                            name="is_depreciable" checked />
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
                                        <option value="straight">Straight line</option>
                                        <option value="reduce">Reducing Balanse</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12"
                                    style="text-align: left">Depreciation Account</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="select2 form-control selectaccount" name="depreciate_account"
                                        disabled>
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
                                    <input type="text" class="form-control" name="depreciate_life" value="4" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12"
                                    style="text-align: left">Depreciation Accumulated Account</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="select2 form-control selectaccount"
                                        name="depreciate_accumulated_account" disabled>
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
                                    <input type="text" class="form-control" name="depreciate_rate" value="25" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12"
                                    style="text-align: left">Accumulated Depreciation</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input type="text" class="form-control" name="depreciate_accumulated" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <label class="control-label col-md-4 col-sm-3 col-xs-12" style="text-align: left">As at
                                Date</label>
                            <div class="col-md-7 col-sm-7 col-xs-12">
                                <input value="{{$today}}" type="text" class="form-control" id="datepicker1"
                                    name="depreciate_date">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="offset-lg-9 col-lg-3">
                        <a href="{{ url()->previous() }}" class="btn btn-danger">Cancel</a>
                        <div class="btn-group dropup">
                            <button type="button" class="btn btn-success" id="click"> Create </button>
                            <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#">Create & New</a>
                                <a class="dropdown-item" href="#">Create </a>
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
<script src="{{asset('js/other/sum.js')}}" charset="utf-8"></script>
<script src="{{asset('js/other/sum.js')}}" charset="utf-8"></script>
<script src="{{asset('js/asset_management/createForm.js')}}" charset="utf-8"></script>
<script src="{{asset('js/other/add_field.js')}}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js')}}" charset="utf-8"></script>
<script src="{{asset('js/other/is_depreciable.js')}}" charset="utf-8"></script>
<script src="{{asset('js/other/zebradatepicker.js') }}" charset="utf-8"></script>
@endpush
@extends('admin.settings.index')

@section('contentheader')
<div class="page-title">
    <div class="title_left">
        <h3>Products</h3>
    </div>
    {{-- notifikasi form validasi --}}
    @if ($errors->has('file'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('file') }}</strong>
    </span>
    @endif
    {{-- notifikasi form error --}}
    @if ($error = Session::get('error'))
    <div class="alert alert-error alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $error }}</strong>
    </div>
    @endif
    {{-- notifikasi sukses --}}
    @if ($sukses = Session::get('sukses'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $sukses }}</strong>
    </div>
    @endif
    <!--<div class="title_right">
        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search for...">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button">Go!</button>
                </span>
            </div>
        </div>
    </div>-->
</div>
@endsection

@section('contentTab')

<div class="row">
    <form method="POST" action="{{ route('company.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="col-md-6 form-group">
            <div class="col-md-12 form-group">
                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">
                    <h2><strong>Company Setting</strong></h2>
                </label>
                <br>
                <br>
                <br>
            </div>
            <div class="col-md-12 form-group">
                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Logo</label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                    @if($logo)
                    <img src="{{ asset('file_logo/'.$logo->filename) }}" height="75px">
                    @else
                    <img src="{{ asset('file_logo/defaultlogo.jpg') }}" height="75px">
                    @endif
                    <br>
                    <br>
                    <input type="file" name="logo">
                </div>
            </div>

            <div class="col-md-12 form-group">
                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Show Logo in Report</label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                    <input type="checkbox" class="flat form-control" value="1" name="is_logo" @if($cs) @if($cs->is_logo === 1) checked @endif @endif>
                </div>
            </div>
            <div class="col-md-12 form-group">
                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Company Name</label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                    <input type="text" class="form-control" name="name" @if($cs) value="{{$cs->name}}" @endif>
                </div>
            </div>
            <div class="col-md-12 form-group">
                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Address</label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                    <textarea rows="3" class="form-control" name="address">@if($cs){{$cs->address}}@endif</textarea>
                </div>
            </div>
            <div class="col-md-12 form-group">
                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Shipping Address</label>
                <div class="col-md-7 col -sm-7 col-xs-12">
                    <textarea rows="3" class="form-control" name="shipping_address">@if($cs){{$cs->shipping_address}}@endif</textarea>
                </div>
            </div>
            <div class="col-md-12 form-group">
                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Phone</label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                    <input type="text" class="form-control" name="phone" @if($cs) value="{{$cs->phone}}" @endif>
                </div>
            </div>
            <div class="col-md-12 form-group">
                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Fax</label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                    <input type="text" class="form-control" name="fax" @if($cs) value="{{$cs->fax}}" @endif>
                </div>
            </div>
            <div class="col-md-12 form-group">
                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Company Tax Number</label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                    <input type="text" class="form-control" name="tax_number" @if($cs) value="{{$cs->tax_number}}" @endif>
                </div>
            </div>
            <div class="col-md-12 form-group">
                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Website</label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                    <input type="text" class="form-control" name="website" @if($cs) value="{{$cs->website}}" @endif>
                </div>
            </div>
            <div class="col-md-12 form-group">
                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Email</label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                    <input type="text" class="form-control" name="email" @if($cs) value="{{$cs->email}}" @endif>
                </div>
            </div>
        </div>
        <div class="col-md-6 form-group">
            {{--
            <div class="col-md-12 form-group">
                <label class="control-label col-md-12 col-sm-12 col-xs-12" style="text-align: left;">
                    <h2><strong>Bank Account Detail</strong></h2>
                </label>
                <br>
                <br>
                <br>
            </div>
            <div class="col-md-12 form-group">
                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Bank Name</label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                    <input type="text" class="form-control" name="bank_name">
                </div>
            </div>
            <div class="col-md-12 form-group">
                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Bank Branch</label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                    <input type="text" class="form-control" name="bank_branch">
                </div>
            </div>
            <div class="col-md-12 form-group">
                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Bank Address</label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                    <input type="text" class="form-control" name="bank_address">
                </div>
            </div>
            <div class="col-md-12 form-group">
                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Bank Account Number</label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                    <input type="text" class="form-control" name="bank_acc_number">
                </div>
            </div>
            <div class="col-md-12 form-group">
                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Bank Account Name</label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                    <input type="text" class="form-control" name="bank_acc_name">
                </div>
            </div>
            <div class="col-md-12 form-group">
                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Swift Code</label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                    <input type="text" class="form-control" name="swift_code">
                </div>
            </div>
            <div class="col-md-12 form-group">
                <br>
                <label class="control-label col-md-12 col-sm-12 col-xs-12" style="text-align: left;">
                    <h2><strong>Additional Feature Settings</strong></h2>
                </label>
                <br>
                <br>
                <br>
            </div>
            <div class="col-md-12 form-group">
                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Show Getting Started</label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                    <input type="checkbox" class="flat form-control" value="1" name="show_get_started">
                </div>
            </div>
            <div class="col-md-12 form-group">
                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Receive Monthly Company Performance Email</label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                    <input type="checkbox" class="flat form-control" value="1" name="receive_performance">
                </div>
            </div>
            <div class="col-md-12 form-group">
                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Tax Inclusive</label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                    <input type="checkbox" class="flat form-control" value="1" name="tax_inclusive">
                </div>
            </div>
            <div class="col-md-12 form-group">
                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Transaction Tag</label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                    <input type="checkbox" class="flat form-control" value="1" name="trans_tag">
                </div>
            </div>
            <div class="col-md-12 form-group">
                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Multi Currency</label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                    <input type="checkbox" class="flat form-control" value="1" name="multi_curr">
                </div>
            </div>
            <div class="col-md-12 form-group">
                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Currency</label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                    <select class="form-control selectterm" name="currency">
                        <option value="idr">IDR Indonesia</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12 form-group">
                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Currency Format</label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                    <select class="form-control selectaccount" name="currency_format">
                        <option value="1">Once with Dec</option>
                    </select>
                </div>
            </div>
            --}}
        </div>
</div>
<div class="row">
    <div class="col-md-2 center-margin">
        <div class="form-group">
            <a href="{{ url('/dashboard') }}" class="btn btn-danger">Cancel</a>
            <div class="btn-group">
                <button id="click" type="submit" class="btn btn-success">Update</button>
                </ul>
            </div>
        </div>
    </div>
    </form>
</div>

@endsection

{{--@push('scripts')
<script src="{{ asset('js/settings/user/dataTable.js?v=5-03022020') }}" charset="utf-8"></script>
@endpush--}}
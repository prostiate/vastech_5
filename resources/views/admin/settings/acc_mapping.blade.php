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
    <form method="post" id="formCreate" class="form-horizontal">
        <div class="accordion testing" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="panel">
                <a class="panel-heading" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <h4 class="panel-title">Sales</h4>
                </a>
                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne" aria-expanded="true" style="">
                    <div class="panel-body">
                        <div class="col-md-6 form-group">
                            <div class="col-md-12 form-group">
                                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Sales Revenue</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control selectaccount" name="sales_revenue">
                                        @foreach($all_coa as $ac)
                                        <option value="{{$ac->id}}" @if($sales_revenue->account_id == $ac->id) selected @endif>{{$ac->code}} - {{$ac->name}} ({{$ac->coa_category->name}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 form-group">
                                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Sales Discount</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control selectaccount" name="sales_discount">
                                        @foreach($all_coa as $ac)
                                        <option value="{{$ac->id}}" @if($sales_discount->account_id == $ac->id) selected @endif>{{$ac->code}} - {{$ac->name}} ({{$ac->coa_category->name}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 form-group">
                                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Sales Return</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control selectaccount" name="sales_return">
                                        @foreach($all_coa as $ac)
                                        <option value="{{$ac->id}}" @if($sales_return->account_id == $ac->id) selected @endif>{{$ac->code}} - {{$ac->name}} ({{$ac->coa_category->name}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 form-group">
                                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Sales Shipping</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control selectaccount" name="sales_shipping">
                                        @foreach($all_coa as $ac)
                                        <option value="{{$ac->id}}" @if($sales_shipping->account_id == $ac->id) selected @endif>{{$ac->code}} - {{$ac->name}} ({{$ac->coa_category->name}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <div class="col-md-12 form-group">
                                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Unearned Revenue</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control selectaccount" name="unearned_revenue">
                                        @foreach($all_coa as $ac)
                                        <option value="{{$ac->id}}" @if($unearned_revenue->account_id == $ac->id) selected @endif>{{$ac->code}} - {{$ac->name}} ({{$ac->coa_category->name}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 form-group">
                                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Unbilled Sales</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control selectaccount" name="unbilled_sales">
                                        @foreach($all_coa as $ac)
                                        <option value="{{$ac->id}}" @if($unbilled_sales->account_id == $ac->id) selected @endif>{{$ac->code}} - {{$ac->name}} ({{$ac->coa_category->name}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 form-group">
                                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Unbilled Receivable</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control selectaccount" name="unbilled_receivable">
                                        @foreach($all_coa as $ac)
                                        <option value="{{$ac->id}}" @if($unbilled_receivable->account_id == $ac->id) selected @endif>{{$ac->code}} - {{$ac->name}} ({{$ac->coa_category->name}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 form-group">
                                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Sales Tax Receivable</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control selectaccount" name="sales_tax_receiveable">
                                        @foreach($all_coa as $ac)
                                        <option value="{{$ac->id}}" @if($sales_tax_receiveable->account_id == $ac->id) selected @endif>{{$ac->code}} - {{$ac->name}} ({{$ac->coa_category->name}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel">
                <a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    <h4 class="panel-title">Purchase</h4>
                </a>
                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="false" style="height: 0px;">
                    <div class="panel-body">
                        <div class="col-md-6 form-group">
                            <div class="col-md-12 form-group">
                                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Purchase (COGS)</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control selectaccount" name="purchase">
                                        @foreach($all_coa as $ac)
                                        <option value="{{$ac->id}}" @if($purchase->account_id == $ac->id) selected @endif>{{$ac->code}} - {{$ac->name}} ({{$ac->coa_category->name}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 form-group">
                                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Purchase Shipping</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control selectaccount" name="purchase_shipping">
                                        @foreach($all_coa as $ac)
                                        <option value="{{$ac->id}}" @if($purchase_shipping->account_id == $ac->id) selected @endif>{{$ac->code}} - {{$ac->name}} ({{$ac->coa_category->name}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 form-group">
                                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Prepayment</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control selectaccount" name="prepayment">
                                        @foreach($all_coa as $ac)
                                        <option value="{{$ac->id}}" @if($prepayment->account_id == $ac->id) selected @endif>{{$ac->code}} - {{$ac->name}} ({{$ac->coa_category->name}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <div class="col-md-12 form-group">
                                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Unbilled Payable</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control selectaccount" name="unbilled_payable">
                                        @foreach($all_coa as $ac)
                                        <option value="{{$ac->id}}" @if($unbilled_payable->account_id == $ac->id) selected @endif>{{$ac->code}} - {{$ac->name}} ({{$ac->coa_category->name}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 form-group">
                                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Purchase Tax
                                    Receivable</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control selectaccount" name="purchase_tax_receivable">
                                        @foreach($all_coa as $ac)
                                        <option value="{{$ac->id}}" @if($purchase_tax_receivable->account_id == $ac->id) selected @endif>{{$ac->code}} - {{$ac->name}} ({{$ac->coa_category->name}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel">
                <a class="panel-heading collapsed" role="tab" id="headingThree" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    <h4 class="panel-title">AR / AP</h4>
                </a>
                <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree" aria-expanded="false" style="height: 0px;">
                    <div class="panel-body">
                        <div class="col-md-6 form-group">
                            <div class="col-md-12 form-group">
                                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Account Receivable</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control selectaccount" name="account_receivable">
                                        @foreach($all_coa as $ac)
                                        <option value="{{$ac->id}}" @if($account_receivable->account_id == $ac->id) selected @endif>{{$ac->code}} - {{$ac->name}} ({{$ac->coa_category->name}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <div class="col-md-12 form-group">
                                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Account Payable</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control selectaccount" name="account_payable">
                                        @foreach($all_coa as $ac)
                                        <option value="{{$ac->id}}" @if($account_payable->account_id == $ac->id) selected @endif>{{$ac->code}} - {{$ac->name}} ({{$ac->coa_category->name}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel">
                <a class="panel-heading collapsed" role="tab" id="headingFour" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                    <h4 class="panel-title">Inventory</h4>
                </a>
                <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour" aria-expanded="false" style="height: 0px;">
                    <div class="panel-body">
                        <div class="col-md-6 form-group">
                            <div class="col-md-12 form-group">
                                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Inventory</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control selectaccount" name="inventory">
                                        @foreach($all_coa as $ac)
                                        <option value="{{$ac->id}}" @if($inventory->account_id == $ac->id) selected @endif>{{$ac->code}} - {{$ac->name}} ({{$ac->coa_category->name}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 form-group">
                                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Inventory General</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control selectaccount" name="inventory_general">
                                        @foreach($all_coa as $ac)
                                        <option value="{{$ac->id}}" @if($inventory_general->account_id == $ac->id) selected @endif>{{$ac->code}} - {{$ac->name}} ({{$ac->coa_category->name}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <div class="col-md-12 form-group">
                                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Inventory Waste</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control selectaccount" name="inventory_waste">
                                        @foreach($all_coa as $ac)
                                        <option value="{{$ac->id}}" @if($inventory_waste->account_id == $ac->id) selected @endif>{{$ac->code}} - {{$ac->name}} ({{$ac->coa_category->name}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 form-group">
                                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Inventory Production</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control selectaccount" name="inventory_production">
                                        @foreach($all_coa as $ac)
                                        <option value="{{$ac->id}}" @if($inventory_production->account_id == $ac->id) selected @endif>{{$ac->code}} - {{$ac->name}} ({{$ac->coa_category->name}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel">
                <a class="panel-heading collapsed" role="tab" id="headingFive" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                    <h4 class="panel-title">Others</h4>
                </a>
                <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive" aria-expanded="false" style="height: 0px;">
                    <div class="panel-body">
                        <div class="col-md-6 form-group">
                            <div class="col-md-12 form-group">
                                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Opening Balance Equity</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control selectaccount" name="opening_balance_equity">
                                        @foreach($all_coa as $ac)
                                        <option value="{{$ac->id}}" @if($opening_balance_equity->account_id == $ac->id) selected @endif>{{$ac->code}} - {{$ac->name}} ({{$ac->coa_category->name}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <div class="col-md-12 form-group">
                                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Fixed Asset</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control selectaccount" name="fixed_asset">
                                        @foreach($all_coa as $ac)
                                        <option value="{{$ac->id}}" @if($fixed_asset->account_id == $ac->id) selected @endif>{{$ac->code}} - {{$ac->name}} ({{$ac->coa_category->name}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="row">
    <br>
    <div class="col-md-2 center-margin">
        <div class="form-group">
            <a href="{{ url('/dashboard') }}" class="btn btn-danger">Cancel</a>
            <div class="btn-group">
                <button id="click" type="submit" class="btn btn-success">Update</button>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/setting/updateForm_account.js?v=5-20200206-1313') }}" charset="utf-8"></script>
@endpush
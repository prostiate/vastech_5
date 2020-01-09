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
    <form method="POST" action="{{ route('acc_map.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="accordion testing" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="panel">
                <a class="panel-heading" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <h4 class="panel-title">Sales</h4>
                </a>
                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne" aria-expanded="true" style="">
                    <div class="panel-body">
                        <div class="col-md-6 form-group">
                            @foreach($def_acc as $da)
                            @if($da->id < 5)
                            <div class="col-md-12 form-group">
                                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">
                                    @if($da->id==1)Sales Revenue
                                    @elseif($da->id==2)Sales Discount
                                    @elseif($da->id==3)Sales Return
                                    @elseif($da->id==4)Sales Shipping
                                    @endif
                                </label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control select_account" name="sales[]">
                                        <option>
                                            {{$da->coa->code}}
                                            -
                                            {{$da->coa->name}}
                                        </option>
                                    </select>
                                    <input value="{{$da->account_id}}" class="selected_sales[]">
                                    <input class="tampungan_sales[]">
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </div>
                        <div class="col-md-6 form-group">
                            @foreach($def_acc as $da)
                            @if($da->id > 4 & $da->id < 9)
                            <div class="col-md-12 form-group">
                                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">
                                    @if($da->id==5)Unearned Revenue
                                    @elseif($da->id==6)Unbilled Sales
                                    @elseif($da->id==7)Unbilled Receivable
                                    @elseif($da->id==8)Sales Tax Receivable
                                    @endif
                                </label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control select_account" name="sales[]">
                                        <option>
                                            {{$da->coa->code}}
                                            -
                                            {{$da->coa->name}}
                                        </option>
                                    </select>
                                    <input value="{{$da->account_id}}" class="selected_sales[]">
                                    <input class="tampungan_sales[]">
                                </div>
                            </div>
                            @endif
                            @endforeach
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
                                    <select class="form-control select_account" name="purchase">
                                        <option>
                                            {{$def_acc->where('name','default_purchase')->first()->coa->code}}
                                            -
                                            {{$def_acc->where('name','default_purchase')->first()->coa->name}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 form-group">
                                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Purchase Shipping</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control select_account" name="purchase_shipping">
                                        <option>
                                            {{$def_acc->where('name','default_purchase_shipping')->first()->coa->code}}
                                            -
                                            {{$def_acc->where('name','default_purchase_shipping')->first()->coa->name}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 form-group">
                                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Prepayment</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control select_account" name="prepayment">
                                        <option>
                                            {{$def_acc->where('name','default_prepayment')->first()->coa->code}}
                                            -
                                            {{$def_acc->where('name','default_prepayment')->first()->coa->name}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <div class="col-md-12 form-group">
                                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Unbilled Payable</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control select_account" name="unbilled_payable">
                                        <option>
                                            {{$def_acc->where('name','default_unbilled_payable')->first()->coa->code}}
                                            -
                                            {{$def_acc->where('name','default_unbilled_payable')->first()->coa->name}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 form-group">
                                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Purchase Tax
                                    Receivable</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control select_account" name="purchase_tax_receivable">
                                        <option>
                                            {{$def_acc->where('name','default_purchase_tax_receivable')->first()->coa->code}}
                                            -
                                            {{$def_acc->where('name','default_purchase_tax_receivable')->first()->coa->name}}
                                        </option>
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
                                    <select class="form-control select_account" name="account_receivable">
                                        <option>
                                            {{$def_acc->where('name','default_account_receivable')->first()->coa->code}}
                                            -
                                            {{$def_acc->where('name','default_account_receivable')->first()->coa->name}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <div class="col-md-12 form-group">
                                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Account Payable</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control select_account" name="account_payable">
                                        <option>
                                            {{$def_acc->where('name','default_account_payable')->first()->coa->code}}
                                            -
                                            {{$def_acc->where('name','default_account_payable')->first()->coa->name}}
                                        </option>
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
                                    <select class="form-control select_account" name="inventory">
                                        <option>
                                            {{$def_acc->where('name','default_inventory')->first()->coa->code}}
                                            -
                                            {{$def_acc->where('name','default_inventory')->first()->coa->name}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 form-group">
                                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Inventory General</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control select_account" name="inventory_general">
                                        <option>
                                            {{$def_acc->where('name','default_inventory_general')->first()->coa->code}}
                                            -
                                            {{$def_acc->where('name','default_inventory_general')->first()->coa->name}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <div class="col-md-12 form-group">
                                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Inventory Waste</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control select_account" name="inventory_waste">
                                        <option>
                                            {{$def_acc->where('name','default_inventory_waste')->first()->coa->code}}
                                            -
                                            {{$def_acc->where('name','default_inventory_waste')->first()->coa->name}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 form-group">
                                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Inventory Production</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control select_account" name="inventory_production">
                                        <option>
                                            {{$def_acc->where('name','default_inventory_production')->first()->coa->code}}
                                            -
                                            {{$def_acc->where('name','default_inventory_production')->first()->coa->name}}
                                        </option>
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
                                    <select class="form-control select_account" name="opening_balance_equity">
                                        <option>
                                            {{$def_acc->where('name','default_opening_balance_equity')->first()->coa->code}}
                                            -
                                            {{$def_acc->where('name','default_opening_balance_equity')->first()->coa->name}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <div class="col-md-12 form-group">
                                <label class="control-label col-md-5 col-sm-5 col-xs-12" style="text-align: left;">Fixed Asset</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control select_account" name="fixed_asset">
                                        <option>
                                            {{$def_acc->where('name','default_fixed_asset')->first()->coa->code}}
                                            -
                                            {{$def_acc->where('name','default_fixed_asset')->first()->coa->name}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
    </form>
</div>

@endsection

@push('scripts')
<script src="{{ asset('js/setting/selectaccount.js') }}" charset="utf-8"></script>
@endpush
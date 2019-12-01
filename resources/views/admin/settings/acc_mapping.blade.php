@extends('admin.settings.index')

@section('contentTab')

<div class="row">
        <form method="post" id="formProduct" class="form-horizontal">
            <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel">
                    <a class="panel-heading" role="tab" id="headingOne" data-toggle="collapse"
                        data-parent="#accordion" href="#collapseOne" aria-expanded="true"
                        aria-controls="collapseOne">
                        <h4 class="panel-title">Sales</h4>
                    </a>
                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel"
                        aria-labelledby="headingOne" aria-expanded="true" style="">
                        <div class="panel-body">
                            <div class="col-md-6 form-group">
                                <div class="col-md-12 form-group">
                                    <label class="control-label col-md-5 col-sm-5 col-xs-12"
                                        style="text-align: left;">Sales Revenue</label>
                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                        <select class="form-control selectaccount"
                                            name="currency_format">
                                            <option value="1">Once with Dec</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 form-group">
                                    <label class="control-label col-md-5 col-sm-5 col-xs-12"
                                        style="text-align: left;">Sales Discount</label>
                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                        <select class="form-control selectaccount"
                                            name="currency_format">
                                            <option value="1">Once with Dec</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 form-group">
                                    <label class="control-label col-md-5 col-sm-5 col-xs-12"
                                        style="text-align: left;">Sales Return</label>
                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                        <select class="form-control selectaccount"
                                            name="currency_format">
                                            <option value="1">Once with Dec</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 form-group">
                                    <label class="control-label col-md-5 col-sm-5 col-xs-12"
                                        style="text-align: left;">Sales Shipping</label>
                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                        <select class="form-control selectaccount"
                                            name="currency_format">
                                            <option value="1">Once with Dec</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <div class="col-md-12 form-group">
                                    <label class="control-label col-md-5 col-sm-5 col-xs-12"
                                        style="text-align: left;">Unearned Revenue</label>
                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                        <select class="form-control selectaccount"
                                            name="currency_format">
                                            <option value="1">Once with Dec</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 form-group">
                                    <label class="control-label col-md-5 col-sm-5 col-xs-12"
                                        style="text-align: left;">Unbilled Sales</label>
                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                        <select class="form-control selectaccount"
                                            name="currency_format">
                                            <option value="1">Once with Dec</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 form-group">
                                    <label class="control-label col-md-5 col-sm-5 col-xs-12"
                                        style="text-align: left;">Unbilled Receivable</label>
                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                        <select class="form-control selectaccount"
                                            name="currency_format">
                                            <option value="1">Once with Dec</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 form-group">
                                    <label class="control-label col-md-5 col-sm-5 col-xs-12"
                                        style="text-align: left;">Sales Tax Receivable</label>
                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                        <select class="form-control selectaccount"
                                            name="currency_format">
                                            <option value="1">Once with Dec</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel">
                    <a class="panel-heading collapsed" role="tab" id="headingTwo"
                        data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"
                        aria-expanded="false" aria-controls="collapseTwo">
                        <h4 class="panel-title">Purchase</h4>
                    </a>
                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel"
                        aria-labelledby="headingTwo" aria-expanded="false" style="height: 0px;">
                        <div class="panel-body">
                            <div class="col-md-6 form-group">
                                <div class="col-md-12 form-group">
                                    <label class="control-label col-md-5 col-sm-5 col-xs-12"
                                        style="text-align: left;">Purchase (COGS)</label>
                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                        <select class="form-control selectaccount"
                                            name="currency_format">
                                            <option value="1">Once with Dec</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 form-group">
                                    <label class="control-label col-md-5 col-sm-5 col-xs-12"
                                        style="text-align: left;">Purchase Shipping</label>
                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                        <select class="form-control selectaccount"
                                            name="currency_format">
                                            <option value="1">Once with Dec</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 form-group">
                                    <label class="control-label col-md-5 col-sm-5 col-xs-12"
                                        style="text-align: left;">Prepayment</label>
                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                        <select class="form-control selectaccount"
                                            name="currency_format">
                                            <option value="1">Once with Dec</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <div class="col-md-12 form-group">
                                    <label class="control-label col-md-5 col-sm-5 col-xs-12"
                                        style="text-align: left;">Unbilled Payable</label>
                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                        <select class="form-control selectaccount"
                                            name="currency_format">
                                            <option value="1">Once with Dec</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 form-group">
                                    <label class="control-label col-md-5 col-sm-5 col-xs-12"
                                        style="text-align: left;">Purchase Tax
                                        Receivable</label>
                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                        <select class="form-control selectaccount"
                                            name="currency_format">
                                            <option value="1">Once with Dec</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel">
                    <a class="panel-heading collapsed" role="tab" id="headingThree"
                        data-toggle="collapse" data-parent="#accordion" href="#collapseThree"
                        aria-expanded="false" aria-controls="collapseThree">
                        <h4 class="panel-title">AR / AP</h4>
                    </a>
                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel"
                        aria-labelledby="headingThree" aria-expanded="false"
                        style="height: 0px;">
                        <div class="panel-body">
                            <div class="col-md-6 form-group">
                                <div class="col-md-12 form-group">
                                    <label class="control-label col-md-5 col-sm-5 col-xs-12"
                                        style="text-align: left;">Account Receivable</label>
                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                        <select class="form-control selectaccount"
                                            name="currency_format">
                                            <option value="1">Once with Dec</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <div class="col-md-12 form-group">
                                    <label class="control-label col-md-5 col-sm-5 col-xs-12"
                                        style="text-align: left;">Account Payable</label>
                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                        <select class="form-control selectaccount"
                                            name="currency_format">
                                            <option value="1">Once with Dec</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel">
                    <a class="panel-heading collapsed" role="tab" id="headingFour"
                        data-toggle="collapse" data-parent="#accordion" href="#collapseFour"
                        aria-expanded="false" aria-controls="collapseFour">
                        <h4 class="panel-title">Inventory</h4>
                    </a>
                    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel"
                        aria-labelledby="headingFour" aria-expanded="false"
                        style="height: 0px;">
                        <div class="panel-body">
                            <div class="col-md-6 form-group">
                                <div class="col-md-12 form-group">
                                    <label class="control-label col-md-5 col-sm-5 col-xs-12"
                                        style="text-align: left;">Inventory</label>
                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                        <select class="form-control selectaccount"
                                            name="currency_format">
                                            <option value="1">Once with Dec</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 form-group">
                                    <label class="control-label col-md-5 col-sm-5 col-xs-12"
                                        style="text-align: left;">Inventory General</label>
                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                        <select class="form-control selectaccount"
                                            name="currency_format">
                                            <option value="1">Once with Dec</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <div class="col-md-12 form-group">
                                    <label class="control-label col-md-5 col-sm-5 col-xs-12"
                                        style="text-align: left;">Inventory Waste</label>
                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                        <select class="form-control selectaccount"
                                            name="currency_format">
                                            <option value="1">Once with Dec</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 form-group">
                                    <label class="control-label col-md-5 col-sm-5 col-xs-12"
                                        style="text-align: left;">Inventory Production</label>
                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                        <select class="form-control selectaccount"
                                            name="currency_format">
                                            <option value="1">Once with Dec</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel">
                    <a class="panel-heading collapsed" role="tab" id="headingFive"
                        data-toggle="collapse" data-parent="#accordion" href="#collapseFive"
                        aria-expanded="false" aria-controls="collapseFive">
                        <h4 class="panel-title">Others</h4>
                    </a>
                    <div id="collapseFive" class="panel-collapse collapse" role="tabpanel"
                        aria-labelledby="headingFive" aria-expanded="false"
                        style="height: 0px;">
                        <div class="panel-body">
                            <div class="col-md-6 form-group">
                                <div class="col-md-12 form-group">
                                    <label class="control-label col-md-5 col-sm-5 col-xs-12"
                                        style="text-align: left;">Opening Balance Equity</label>
                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                        <select class="form-control selectaccount"
                                            name="currency_format">
                                            <option value="1">Once with Dec</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <div class="col-md-12 form-group">
                                    <label class="control-label col-md-5 col-sm-5 col-xs-12"
                                        style="text-align: left;">Fixed Asset</label>
                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                        <select class="form-control selectaccount"
                                            name="currency_format">
                                            <option value="1">Once with Dec</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 center-margin">
                <a href="{{ url('/dashboard') }}" class="btn btn-danger">Cancel</a>
                <div class="btn-group">
                    <button id="click" type="button" class="btn btn-success">Update</button>
                    </ul>
                </div>
            </div>
        </form>
    </div>

@endsection
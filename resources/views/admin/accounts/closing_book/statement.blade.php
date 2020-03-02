@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Closing Book</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>From <strong>{{$cb->start_period}}</strong> To <strong>{{$cb->end_period}}</strong></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form id="formCreate" data-parsley-validate="" class="form-horizontal form-label-left">
                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_content1" role="tab" id="invoice-tab" data-toggle="tab" aria-expanded="true">Trial Balance</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content2" role="tab" id="delivery-tab" data-toggle="tab" aria-expanded="false">Income Statement</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content3" role="tab" id="warehouses-tab" data-toggle="tab" aria-expanded="false">Balance Sheet</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content4" role="tab" id="warehouses-tab" data-toggle="tab" aria-expanded="false">Cash Flow</a>
                        </li>
                    </ul>
                    <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="invoice-tab">
                            <div class="x_panel">
                                <div class="x_content">
                                    <div class="media-body">
                                        <iframe src="/closing_book/trial_balance/start_date={{$cb->start_period}}&end_date={{$cb->end_period}}" width="100%" height="500" frameborder="1" allowfullscreen></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="delivery-tab">
                            <div class="x_panel">
                                <div class="x_content">
                                    <div class="media-body">
                                        <iframe src="/closing_book/profit_loss/start_date={{$cb->start_period}}&end_date={{$cb->end_period}}" width="100%" height="500" frameborder="0" style="border:0" allowfullscreen></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="delivery-tab">
                            <div class="x_panel">
                                <div class="x_content">
                                    <div class="media-body">
                                        <iframe src="/closing_book/balance_sheet/start_date={{$cb->start_period}}&end_date={{$cb->end_period}}" width="100%" height="500" frameborder="0" style="border:0" allowfullscreen></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="delivery-tab">
                            <div class="x_panel">
                                <div class="x_content">
                                    <div class="media-body">
                                        <iframe src="/closing_book/cash_flow/start_date={{$cb->start_period}}&end_date={{$cb->end_period}}" width="100%" height="500" frameborder="0" style="border:0" allowfullscreen></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="col-md-3 center-margin">
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="button" onclick="window.location.href = '/chart_of_accounts';">Cancel</button>
                            <button id="click" type="submit" class="btn btn-success">Confirm Close Book</button>
                            <input hidden name="hidden_id" value="{{$cb->id}}">
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
<script src="{{ asset('js/accounts/closing_book/createForm_statement.js?v=5-20200302-1755') }}" charset="utf-8"></script>
@endpush


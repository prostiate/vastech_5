@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Tutup Buku</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>Dari start_period sampai end_period</li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_content1" role="tab" id="invoice-tab"
                                data-toggle="tab" aria-expanded="true">Trial Balance</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content2" role="tab" id="delivery-tab"
                                data-toggle="tab" aria-expanded="false">Income Statement</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content6" role="tab" id="warehouses-tab"
                                data-toggle="tab" aria-expanded="false">Balance Sheet</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content6" role="tab" id="warehouses-tab"
                                data-toggle="tab" aria-expanded="false">Cash Flow</a>
                        </li>
                    </ul>
                    <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1"
                            aria-labelledby="invoice-tab">
                            <blockquote>
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>View new report</h2>
                                        <ul class="nav navbar-right panel_toolbox">
                                            <li>
                                                <button class="btn btn-dark dropdown-toggle" type="button"
                                                    onclick="window.location.href = '/other/transactions';">Transactions
                                                    List
                                                </button>
                                            </li>
                                        </ul>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">
                                        <div class="table-responsive">
                                            <h3>Nanti abis selesain view ini, buat controller untuk coa detail + journal entry. Karena apa yang diinput dicontroller 
                                                tergantung apa yang ditampilin disini
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </blockquote>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="delivery-tab">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>View new report</h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li>
                                            <button class="btn btn-dark dropdown-toggle" type="button"
                                                onclick="window.location.href = '/other/transactions';">Transactions
                                                List
                                            </button>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div class="table-responsive">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="col-md-3 center-margin">
                    <div class="form-group">
                        <div class="col-md-8 col-sm-6 col-xs-12 col-md-offset-4">
                            <button class="btn btn-primary" type="button"
                                onclick="window.location.href = '/chart_of_accounts';">Cancel</button>
                            <button id="click" type="submit" class="btn btn-success">Confirm Close Book</button>
                            <input hidden name="hidden_id" value="{closing_book->id}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="asset('js/products/products/deleteForm.js?v=5-20200211-1624') " charset="utf-8"></script>
@endpush
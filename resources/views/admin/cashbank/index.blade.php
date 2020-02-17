@extends('layouts.admin')

@section('contentheader')
<div class="page-title">
    <div class="title_left">
        <h3>Cash & Bank</h3>
    </div>
</div>
@endsection

@section('content')
@hasrole('Owner|Ultimate')
<div class="row">
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Summary In Chart</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <input hidden type="text" value="{{$open_po}}" id="open_po">
                <input hidden type="text" value="{{$payment_last}}" id="payment_last">
                <input hidden type="text" value="{{$overdue}}" id="overdue">
                <div id="hehehehe" style="height: 350px;"></div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Total Balance</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <button data-toggle="dropdown" class="btn btn-dark dropdown-toggle" type="button" aria-expanded="false">New Transaction <span class="caret"></span>
                        </button>
                        <ul role="menu" class="dropdown-menu">
                            <li><a href="/cashbank/bank_transfer/new">Transfer Funds</a>
                            </li>
                            <li><a href="/cashbank/bank_deposit/new">Receive Money</a>
                            </li>
                            <li><a href="/cashbank/bank_withdrawal/account/new">Pay Money</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row tile_count">
                    <div class="col-md-12 col-sm-6 col-xs-6 tile_stats_count">
                        <span class="count_top">Open Expenses</span>
                        <div class="count">Rp @number($open_po_total)</div>
                    </div>
                    <div class="col-md-12 col-sm-6 col-xs-6 tile_stats_count">
                        <span class="count_top">Paid Expenses Last 30 Days</span>
                        <div class="count">Rp @number($payment_last_total)</div>
                    </div>
                    <div class="col-md-12 col-sm-6 col-xs-6 tile_stats_count">
                        <span class="count_top">Expenses This Month</span>
                        <div class="count">Rp @number($overdue_total)</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endrole
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_content">
                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_content1" role="tab" id="invoice-tab" data-toggle="tab" aria-expanded="true">List of Accounts</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content2" role="tab" id="delivery-tab" data-toggle="tab" aria-expanded="false">List of Transactions</a>
                        </li>
                    </ul>
                    <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="invoice-tab">
                            <div class="x_panel">
                                @role('Owner|Ultimate|Cash & Bank')
                                @can('Create')
                                <div class="x_title">
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li>
                                            <button data-toggle="dropdown" class="btn btn-dark dropdown-toggle" type="button" aria-expanded="false">New Transaction <span class="caret"></span>
                                            </button>
                                            <ul role="menu" class="dropdown-menu">
                                                <li><a href="/cashbank/bank_transfer/new">Transfer Funds</a>
                                                </li>
                                                <li><a href="/cashbank/bank_deposit/new">Receive Money</a>
                                                </li>
                                                <li><a href="/cashbank/bank_withdrawal/account/new">Pay Money</a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                @endcan
                                @endrole
                                <div class="x_content">
                                    <div class="table-responsive">
                                        <table class="table table-striped jambo_table bulk_action" id="dataTable" style="width:100%">
                                            <thead>
                                                <tr class="headings">
                                                    <th class="column-title">Account Code</th>
                                                    <th class="column-title">Account Name </th>
                                                    <!--<th class="column-title">Statement Balance </th>-->
                                                    <th class="column-title">Balance </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $total = 0 ?>
                                                <?php $debit = 0 ?>
                                                <?php $credit = 0 ?>
                                                @foreach ($coa as $a)
                                                @foreach($coa_detail as $cd)
                                                @if($cd->coa_id == $a->id)
                                                <?php $debit += $cd->debit ?>
                                                <?php $credit += $cd->credit ?>
                                                @endif
                                                @endforeach
                                                <tr>
                                                    <td>
                                                        <a>{{$a->code}}</a>
                                                    </td>
                                                    <td>
                                                        <a href="/chart_of_accounts/{{$a->id}}">{{$a->name}}</a>
                                                    </td>
                                                    <td style="text-align: right">
                                                        @if($a->coa_category_id == 8 or $a->coa_category_id == 10 or $a->coa_category_id == 11 or $a->coa_category_id == 12 or $a->coa_category_id == 13 or $a->coa_category_id == 14)
                                                        <?php $total = $credit - $debit ?>
                                                        @else
                                                        <?php $total = $debit - $credit ?>
                                                        @endif
                                                        @if($total < 0) <a>Rp (@number(abs($total)))</a>
                                                            @else
                                                            <a>Rp @number($total)</a>
                                                            @endif
                                                    </td>
                                                </tr>
                                                <?php $total = 0 ?>
                                                <?php $debit = 0 ?>
                                                <?php $credit = 0 ?>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="delivery-tab">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>View Transaction Report</h2>
                                    @role('Cash & Bank')
                                    @can('Create')
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li>
                                            <button data-toggle="dropdown" class="btn btn-dark dropdown-toggle" type="button" aria-expanded="false">New Transaction <span class="caret"></span>
                                            </button>
                                            <ul role="menu" class="dropdown-menu">
                                                <li><a href="/cashbank/bank_transfer/new">Transfer Funds</a>
                                                </li>
                                                <li><a href="/cashbank/bank_deposit/new">Receive Money</a>
                                                </li>
                                                <li><a href="/cashbank/bank_withdrawal/account/new">Pay Money</a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                    @endcan
                                    @endrole
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li>
                                            <button class="btn btn-dark dropdown-toggle" type="button" onclick="window.location.href = '/other/transactions';">Transactions List
                                            </button>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div class="table-responsive">
                                        <table class="table table-striped jambo_table bulk_action" id="dataTable2" style="width:100%">
                                            <thead>
                                                <tr class="headings">
                                                    <th class="column-title">Transaction Date</th>
                                                    <th class="column-title">Transaction Number</th>
                                                    <th class="column-title">Contact</th>
                                                    <th class="column-title">Memo</th>
                                                    <th class="column-title">Total</th>
                                                    <th class="column-title">Status</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/cashbank/chartdiindex.js?v=5-20200217-1409') }}" charset="utf-8"></script>
<script src="{{ asset('js/cashbank/dataTable.js?v=5-20200217-1409') }}" charset="utf-8"></script>
@endpush
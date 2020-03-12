@extends('layouts.admin')

@section('contentheader')
<div class="page-title">
    <div class="title_left">
        <h3>Purchases Return</h3>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            @hasrole('Owner|Ultimate')
            <div class="x_title">
                <h2>List of Transactions</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <button data-toggle="dropdown" class="btn btn-dark dropdown-toggle" type="button" aria-expanded="false">New Purchase <span class="caret"></span>
                        </button>
                        <ul role="menu" class="dropdown-menu">
                            @if($user->company_id == 5)
                            <li><a href="/purchases_invoice/new">Purchase Invoice</a>
                            </li>
                            <li><a href="/purchases_order/new">Purchase Order</a>
                            </li>
                            <li><a href="/purchases_quote/new">Purchase Quote</a>
                            </li>
                            @elseif($user->company_id == 2)
                            <li><a href="/purchases_invoice/new">Purchase Invoice</a>
                            </li>
                            <li><a href="/purchases_invoice/newRS">Purchase Invoice Bundling</a>
                            </li>
                            <li><a href="/purchases_order/new">Purchase Order</a>
                            </li>
                            <li><a href="/purchases_order/newRS">Purchase Order Bundling</a>
                            </li>
                            <li><a href="/purchases_quote/new">Purchase Quote</a>
                            </li>
                            @else
                            <li><a href="/purchases_invoice/new">Purchase Invoice</a>
                            </li>
                            <li><a href="/purchases_order/new">Purchase Order</a>
                            </li>
                            <li><a href="/purchases_quote/new">Purchase Quote</a>
                            </li>
                            @endif
                        </ul>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            @endrole>
            @role('Purchase Return')
            @can('Create')
            <div class="x_title">
                <h2>List of Transactions</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <button data-toggle="dropdown" class="btn btn-dark dropdown-toggle" type="button" aria-expanded="false">New Purchase <span class="caret"></span>
                        </button>
                        <ul role="menu" class="dropdown-menu">
                            @if($user->company_id == 5)
                            <li><a href="/purchases_invoice/new">Purchase Invoice</a>
                            </li>
                            <li><a href="/purchases_order/new">Purchase Order</a>
                            </li>
                            <li><a href="/purchases_quote/new">Purchase Quote</a>
                            </li>
                            @elseif($user->company_id == 2)
                            <li><a href="/purchases_invoice/new">Purchase Invoice</a>
                            </li>
                            <li><a href="/purchases_invoice/newRS">Purchase Invoice Bundling</a>
                            </li>
                            <li><a href="/purchases_order/new">Purchase Order</a>
                            </li>
                            <li><a href="/purchases_order/newRS">Purchase Order Bundling</a>
                            </li>
                            <li><a href="/purchases_quote/new">Purchase Quote</a>
                            </li>
                            @else
                            <li><a href="/purchases_invoice/new">Purchase Invoice</a>
                            </li>
                            <li><a href="/purchases_order/new">Purchase Order</a>
                            </li>
                            <li><a href="/purchases_quote/new">Purchase Quote</a>
                            </li>
                            @endif
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
                                <th class="column-title">Returned Date</th>
                                <th class="column-title">Transaction Number</th>
                                <th class="column-title">Purchase Invoice No</th>
                                <th class="column-title">Transaction Date</th>
                                <th class="column-title">Due Date</th>
                                <th class="column-title">Total</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/purchases/return/dataTable.js?v=5-20200312-1327') }}" charset="utf-8"></script>
@endpush
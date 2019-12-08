@extends('layouts.admin')

@section('contentheader')
<div class="page-title">
    <div class="title_left">
        <h3>Sales Return</h3>
    </div>
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

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>List of Transactions</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <button data-toggle="dropdown" class="btn btn-dark dropdown-toggle" type="button" aria-expanded="false">New Sales <span class="caret"></span>
                        </button>
                        <ul role="menu" class="dropdown-menu">
                            @if($user->company_id == 5)
                            <li><a href="/sales_invoice/newRS">Sales Invoice</a>
                            </li>
                            <li><a href="/sales_order/newRS">Sales Order</a>
                            </li>
                            <li><a href="/sales_quote/new">Sales Quote</a>
                            </li>
                            @else
                            <li><a href="/sales_invoice/new">Sales Invoice</a>
                            </li>
                            <li><a href="/sales_order/new">Sales Order</a>
                            </li>
                            <li><a href="/sales_quote/new">Sales Quote</a>
                            </li>
                            @endif
                        </ul>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-striped jambo_table bulk_action" id="dataTable" style="width:100%">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">Returned Date</th>
                                <th class="column-title">Transaction Number</th>
                                <th class="column-title">Sales Invoice No</th>
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
<script src="{{ asset('js/sales/return/dataTable.js') }}" charset="utf-8"></script>
@endpush
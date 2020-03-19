@extends('layouts.admin')

@section('contentheader')
<div class="page-title">
    <div class="title_left">
        <h3>Product Detail</h3>
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
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <button class="btn btn-dark dropdown-toggle" type="button" onclick="window.location.href = '/products/edit/{{$products->id}}';">Edit Profile
                        </button>
                    </li>
                    <li>
                        <button data-toggle="dropdown" class="btn btn-dark dropdown-toggle" type="button" aria-expanded="false"><span class="glyphicon glyphicon-wrench"></span>
                        </button>
                        <ul role="menu" class="dropdown-menu">
                            <li><a href="#">Archive</a>
                            <li><a href="#" id="click">Delete</a>
                                <input type="text" value="{{$products->id}}" id="form_id" hidden>
                            </li>
                        </ul>
                    </li>
                </ul>
                <h2><b>{{$products->name}}</b></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_content1" role="tab" id="invoice-tab" data-toggle="tab" aria-expanded="true">Info Product / Service</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content2" role="tab" id="delivery-tab" data-toggle="tab" aria-expanded="false">List Transactions</a>
                        </li>
                        @if($products->is_bundle == 1)
                        <li role="presentation" class=""><a href="#tab_content3" role="tab" id="hehe-tab" data-toggle="tab" aria-expanded="false">Product Bundle</a>
                        </li>
                        @endif
                    </ul>
                    <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="invoice-tab">
                            <blockquote>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="col-md-12">
                                            <h2><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Product / Service Details</h2>
                                        </div>
                                        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                            <!--<h5>Product Image</h5>-->
                                            <h5>Product Name</h5>
                                            <h5><b>{{$products->name}}</b></h5>
                                            <br>
                                            <h5>Average Price</h5>
                                            <h5><b>Rp @number($products->avg_price)</b></h5>
                                            <br>
                                            <h5>Current Stock</h5>
                                            <h5><b>{{$products->qty}} {{$products->other_unit->name}}</b></h5>
                                            <br>
                                            <h5>Product Code / SKU</h5>
                                            @if($products->code == null)
                                            <h5><b>-</b></h5>
                                            @else
                                            <h5><b>{{$products->code}}</b></h5>
                                            @endif
                                            <br>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-12">
                                            <h2><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span></h2>
                                        </div>
                                        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                            <h5>Product Unit</h5>
                                            @if($products->other_unit_id == null)
                                            <h5><b>-</b></h5>
                                            @else
                                            <h5><b>{{$products->other_unit->name}}</b></h5>
                                            @endif
                                            <br>
                                            <h5>Product Description</h5>
                                            @if($products->desc == null)
                                            <h5><b>-</b></h5>
                                            @else
                                            <h5><b>{{$products->desc}}</b></h5>
                                            @endif
                                            <br>
                                            <h5>Product Type</h5>
                                            <h5><b>-</b></h5>
                                            <br>
                                            <h5>Product Category</h5>
                                            @if($products->other_product_category_id == null)
                                            <h5><b>-</b></h5>
                                            @else
                                            <h5><b>{{$products->other_product_category->name}}</b></h5>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </blockquote>
                            <blockquote>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h2><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Buy</h2>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                        <h5>Buy Unit Price</h5>
                                        <h5><b>Rp @number($products->buy_price)</b></h5>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                        <h5>Purchases Account</h5>
                                        <h5><b>{{$products->coaBuyAccount->name}}</b></h5>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                        <h5>Default Buy Tax</h5>
                                        @if($products->buy_tax == 0)
                                        <h5><b>-</b></h5>
                                        @else
                                        <h5><b>{{$products->taxBuy->name}}</b></h5>
                                        @endif
                                    </div>
                                </div>
                            </blockquote>
                            <blockquote>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h2><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Sell</h2>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                        <h5>Sell Unit Price</h5>
                                        <h5><b>Rp @number($products->sell_price)</b></h5>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                        <h5>Sales Account</h5>
                                        <h5><b>{{$products->coaSellAccount->name}}</b></h5>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                        <h5>Default Sell Tax</h5>
                                        @if($products->sell_tax == 0)
                                        <h5><b>-</b></h5>
                                        @else
                                        <h5><b>{{$products->taxSell->name}}</b></h5>
                                        @endif
                                    </div>
                                </div>
                            </blockquote>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="delivery-tab">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>View Transaction Report</h2>
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
                                        <table class="table table-striped jambo_table bulk_action">
                                            <thead>
                                                <tr class="headings">
                                                    <th class="column-title">Transaction Number </th>
                                                    <th class="column-title">Transaction Date </th>
                                                    <th class="column-title">Qty ({{$products->other_unit->name}})</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($pq as $pq)
                                                <tr>
                                                    <td>
                                                        <a href="/purchases_quote/{{$pq->purchase_quote->id}}">Purchase Quote #{{$pq->purchase_quote->number}}</a>
                                                    </td>
                                                    <td>
                                                        {{$pq->purchase_quote->transaction_date}}
                                                    </td>
                                                    <td>
                                                        {{$pq->qty}}
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @foreach($po as $po)
                                                <tr>
                                                    <td>
                                                        <a href="/purchases_order/{{$po->purchase_order->id}}">Purchase Order #{{$po->purchase_order->number}}</a>
                                                    </td>
                                                    <td>
                                                        {{$po->purchase_order->transaction_date}}
                                                    </td>
                                                    <td>
                                                        {{$po->qty}}
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @foreach($pd as $pd)
                                                <tr>
                                                    <td>
                                                        <a href="/purchases_delivery/{{$pd->purchase_delivery->id}}">Purchase Delivery #{{$pd->purchase_delivery->number}}</a>
                                                    </td>
                                                    <td>
                                                        {{$pd->purchase_delivery->transaction_date}}
                                                    </td>
                                                    <td>
                                                        {{$pd->qty}}
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @foreach($pi as $pi)
                                                <tr>
                                                    <td>
                                                        <a href="/purchases_invoice/{{$pi->purchase_invoice->id}}">Purchase Invoice #{{$pi->purchase_invoice->number}}</a>
                                                    </td>
                                                    <td>
                                                        {{$pi->purchase_invoice->transaction_date}}
                                                    </td>
                                                    <td>
                                                        {{$pi->qty}}
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @foreach($sq as $sq)
                                                <tr>
                                                    <td>
                                                        <a href="/sales_quote/{{$sq->sale_quote->id}}">Sales Quote #{{$sq->sale_quote->number}}</a>
                                                    </td>
                                                    <td>
                                                        {{$sq->sale_quote->transaction_date}}
                                                    </td>
                                                    <td>
                                                        {{$sq->qty}}
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @foreach($so as $so)
                                                <tr>
                                                    <td>
                                                        <a href="/sales_order/{{$so->sale_order->id}}">Sales Order #{{$so->sale_order->number}}</a>
                                                    </td>
                                                    <td>
                                                        {{$so->sale_order->transaction_date}}
                                                    </td>
                                                    <td>
                                                        {{$so->qty}}
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @foreach($sd as $sd)
                                                <tr>
                                                    <td>
                                                        <a href="/sales_delivery/{{$sd->sale_delivery->id}}">Sales Delivery #{{$sd->sale_delivery->number}}</a>
                                                    </td>
                                                    <td>
                                                        {{$sd->sale_delivery->transaction_date}}
                                                    </td>
                                                    <td>
                                                        {{$sd->qty}}
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @foreach($si as $si)
                                                <tr>
                                                    <td>
                                                        <a href="/sales_invoice/{{$si->sale_invoice->id}}">Sales Invoice #{{$si->sale_invoice->number}}</a>
                                                    </td>
                                                    <td>
                                                        {{$si->sale_invoice->transaction_date}}
                                                    </td>
                                                    <td>
                                                        {{$si->qty}}
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @foreach($sa as $sa)
                                                <tr>
                                                    <td>
                                                        <a href="/stock_adjustment/{{$sa->stock_adjustment->id}}">Stock Adjustment #{{$sa->stock_adjustment->number}}</a>
                                                    </td>
                                                    <td>
                                                        {{$sa->stock_adjustment->date}}
                                                    </td>
                                                    <td>
                                                        {{$sa->actual}}
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if($products->is_bundle == 1)
                        <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="hehe-tab">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Bundled Product</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div class="table-responsive">
                                        <table class="table table-striped jambo_table bulk_action">
                                            <thead>
                                                <tr class="headings">
                                                    <th class="column-title" style="width: 350px">Product Name</th>
                                                    <th class="column-title">Quantity</th>
                                                    <th class="column-title" style="width: 350px">Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($bundle_item as $bi)
                                                <tr>
                                                    <td>
                                                        <a href="/products/{{$bi->bundle_product_id}}">{{$bi->bundle_product->name}}</a>
                                                    </td>
                                                    <td>
                                                        <a>{{$bi->qty}}</a>
                                                    </td>
                                                    <td>
                                                        <?php $price = $bi->bundle_product->avg_price ?>
                                                        <?php $total = $bi->qty * $price ?>
                                                        <a>Rp @number($total)</a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div><br>
                                    <div class="table-responsive">
                                        <table class="table table-striped jambo_table bulk_action">
                                            <thead>
                                                <tr class="headings">
                                                    <th class="column-title" style="width: 350px">Cost</th>
                                                    <th class="column-title"></th>
                                                    <th class="column-title" style="width: 350px">Amount </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($bundle_cost as $bc)
                                                <tr>
                                                    <td>
                                                        <a href="/chart_of_accounts/{{$bc->coa_id}}">({{$bc->coa->code}}) - {{$bc->coa->name}} ({{$bc->coa->coa_category->name}})</a>
                                                    </td>
                                                    <td>
                                                    </td>
                                                    <td>
                                                        <a>Rp @number($bc->amount)</a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/products/products/deleteForm.js?v=5-20200319-0916') }}" charset="utf-8"></script>
@endpush
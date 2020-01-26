@extends('layouts.admin')

@section('contentheader')
<div class="page-title">
    <div class="title_left">
        <h3>Werehouse Information</h3>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                @hasrole('Owner|Ultimate|Warehouses')
                @can('Edit')
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <button class="btn btn-dark dropdown-toggle" type="button" onclick="window.location.href = '/warehouses/edit/{{$warehouses->id}}';">Edit Warehouse
                        </button>
                    </li>
                </ul>
                @endcan
                @endrole
                @if($warehouses->is_first_created != 1)
                @hasrole('Owner|Ultimate|Warehouses')
                @can('Delete')
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <button class="btn btn-dark dropdown-toggle" type="button" id="click">Delete Warehouse
                        </button>
                        <input type="text" value="{{$warehouses->id}}" id="form_id" hidden>
                    </li>
                </ul>
                @endcan
                @endrole
                @endif
                <h2><b>{{$warehouses->name}}</b></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_content1" role="tab" id="invoice-tab" data-toggle="tab" aria-expanded="true">Info Warehouse</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content3" role="tab" id="product-tab" data-toggle="tab" aria-expanded="false">Products List</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content2" role="tab" id="transaction-tab" data-toggle="tab" aria-expanded="false">Transactions List</a>
                        </li>
                    </ul>
                    <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="invoice-tab">
                            <blockquote>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="col-md-12">
                                            <h2><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Warehouse Details</h2>
                                        </div>
                                        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                            <h5>Warehouse Code</h5>
                                            @if($warehouses->code == null)
                                            <h5><b>-</b></h5>
                                            @else
                                            <h5><b>{{$warehouses->code}}</b></h5>
                                            @endif
                                            <br>
                                            <h5>Address</h5>
                                            @if($warehouses->address == null)
                                            <h5><b>-</b></h5>
                                            @else
                                            <h5><b>{{$warehouses->address}}</b></h5>
                                            @endif
                                            <br>
                                            <h5>Description</h5>
                                            @if($warehouses->desc == null)
                                            <h5><b>-</b></h5>
                                            @else
                                            <h5><b>{{$warehouses->desc}}</b></h5>
                                            @endif
                                            <br>
                                        </div>
                                    </div>
                                </div>
                            </blockquote>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="product-tab">
                            <div class="x_panel">
                                <div class="x_content">
                                    <div class="table-responsive">
                                        <table class="table table-striped jambo_table bulk_action">
                                            <thead>
                                                <tr class="headings">
                                                    <th class="column-title">Product Name </th>
                                                    <th class="column-title">Product Code </th>
                                                    <th class="column-title">Quantity</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($product_list as $a)
                                                @if($a->qty_total > 0 or $a->qty_total < 0) <tr>
                                                    <td>
                                                        <a href="/products/{{$a->product->id}}">{{$a->product->name}}</a>
                                                    </td>
                                                    <td>
                                                        <a>{{$a->product->code}}</a>
                                                    </td>
                                                    <td>
                                                        <a>{{$a->qty_total}}</a>
                                                    </td>
                                                    </tr>
                                                    @endif
                                                    @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="transaction-tab">
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
                                                    <th class="column-title">Number of Products</th>
                                                    <th class="column-title">Created Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $value = 0 ?>
                                                @foreach($po as $po)
                                                <tr>
                                                    <td>
                                                        <a href="/purchases_order/{{$po->id}}">Purchase Order #{{$po->number}}</a>
                                                    </td>
                                                    <td>
                                                        <a>{{$po->transaction_date}}</a>
                                                    </td>
                                                    <td>
                                                        @foreach($po->purchase_order_item as $poi)
                                                        <?php $value += 1 ?>
                                                        @endforeach
                                                        <a>{{$value}}</a>
                                                    </td>
                                                    <td>
                                                        {{$po->updated_at}}
                                                    </td>
                                                </tr>
                                                @endforeach
                                                <?php $value = 0 ?>
                                                @foreach($pd as $pd)
                                                <tr>
                                                    <td>
                                                        <a href="/purchases_delivery/{{$pd->id}}">Purchase Delivery #{{$pd->number}}</a>
                                                    </td>
                                                    <td>
                                                        <a>{{$pd->transaction_date}}</a>
                                                    </td>
                                                    <td>
                                                        @foreach($pd->purchase_delivery_item as $pdi)
                                                        <?php $value += 1 ?>
                                                        @endforeach
                                                        <a>{{$value}}</a>
                                                    </td>
                                                    <td>
                                                        {{$pd->updated_at}}
                                                    </td>
                                                </tr>
                                                @endforeach
                                                <?php $value = 0 ?>
                                                @foreach($pi as $pi)
                                                <tr>
                                                    <td>
                                                        <a href="/purchases_invoice/{{$pi->id}}">Purchase Invoice #{{$pi->number}}</a>
                                                    </td>
                                                    <td>
                                                        <a>{{$pi->transaction_date}}</a>
                                                    </td>
                                                    <td>
                                                        @foreach($pi->purchase_invoice_item as $pii)
                                                        <?php $value += 1 ?>
                                                        @endforeach
                                                        <a>{{$value}}</a>
                                                    </td>
                                                    <td>
                                                        {{$pi->updated_at}}
                                                    </td>
                                                </tr>
                                                @endforeach
                                                <?php $value = 0 ?>
                                                @foreach($so as $so)
                                                <tr>
                                                    <td>
                                                        <a href="/sales_order/{{$so->id}}">Sales Order #{{$so->number}}</a>
                                                    </td>
                                                    <td>
                                                        <a>{{$so->transaction_date}}</a>
                                                    </td>
                                                    <td>
                                                        @foreach($so->sale_order_item as $soi)
                                                        <?php $value += 1 ?>
                                                        @endforeach
                                                        <a>{{$value}}</a>
                                                    </td>
                                                    <td>
                                                        {{$so->updated_at}}
                                                    </td>
                                                </tr>
                                                @endforeach
                                                <?php $value = 0 ?>
                                                @foreach($sd as $sd)
                                                <tr>
                                                    <td>
                                                        <a href="/sales_delivery/{{$sd->id}}">Sales Delivery #{{$sd->number}}</a>
                                                    </td>
                                                    <td>
                                                        <a>{{$sd->transaction_date}}</a>
                                                    </td>
                                                    <td>
                                                        @foreach($sd->sale_delivery_item as $sdi)
                                                        <?php $value += 1 ?>
                                                        @endforeach
                                                        <a>{{$value}}</a>
                                                    </td>
                                                    <td>
                                                        {{$sd->updated_at}}
                                                    </td>
                                                </tr>
                                                @endforeach
                                                <?php $value = 0 ?>
                                                @foreach($si as $si)
                                                <tr>
                                                    <td>
                                                        <a href="/sales_invoice/{{$si->id}}">Sales Invoice #{{$si->number}}</a>
                                                    </td>
                                                    <td>
                                                        <a>{{$si->transaction_date}}</a>
                                                    </td>
                                                    <td>
                                                        @foreach($si->sale_invoice_item as $sii)
                                                        <?php $value += 1 ?>
                                                        @endforeach
                                                        <a>{{$value}}</a>
                                                    </td>
                                                    <td>
                                                        {{$si->updated_at}}
                                                    </td>
                                                </tr>
                                                @endforeach
                                                <?php $value = 0 ?>
                                                @foreach($sa as $sa)
                                                <tr>
                                                    <td>
                                                        <a href="/stock_adjustment/{{$sa->id}}">Stock Adjustment #{{$sa->number}}</a>
                                                    </td>
                                                    <td>
                                                        <a>{{$sa->transaction_date}}</a>
                                                    </td>
                                                    <td>
                                                        @foreach($sa->stock_adjustment_item as $sai)
                                                        <?php $value += 1 ?>
                                                        @endforeach
                                                        <a>{{$value}}</a>
                                                    </td>
                                                    <td>
                                                        {{$sa->updated_at}}
                                                    </td>
                                                </tr>
                                                @endforeach
                                                <?php $value = 0 ?>
                                                @foreach($wip as $wip)
                                                <tr>
                                                    <td>
                                                        <a href="/wip/{{$wip->id}}">Work In Progress #{{$wip->number}}</a>
                                                    </td>
                                                    <td>
                                                        <a>{{$wip->transaction_date}}</a>
                                                    </td>
                                                    <td>
                                                        @foreach($wip->wip_item as $wipi)
                                                        <?php $value += 1 ?>
                                                        @endforeach
                                                        <a>{{$value}}</a>
                                                    </td>
                                                    <td>
                                                        {{$wip->updated_at}}
                                                    </td>
                                                </tr>
                                                @endforeach
                                                <?php $value = 0 ?>
                                                @foreach($fwt as $fwt)
                                                <tr>
                                                    <td>
                                                        <a href="/warehouses_transfer/{{$fwt->id}}">Warehouse Transfer #{{$fwt->number}}</a>
                                                    </td>
                                                    <td>
                                                        <a>{{$fwt->transaction_date}}</a>
                                                    </td>
                                                    <td>
                                                        @foreach($fwt->warehouse_transfer_item as $fwti)
                                                        <?php $value += 1 ?>
                                                        @endforeach
                                                        <a>{{$value}}</a>
                                                    </td>
                                                    <td>
                                                        {{$fwt->updated_at}}
                                                    </td>
                                                </tr>
                                                @endforeach
                                                <?php $value = 0 ?>
                                                @foreach($twt as $twt)
                                                <tr>
                                                    <td>
                                                        <a href="/warehouses_transfer/{{$twt->id}}">Warehouse Transfer #{{$twt->number}}</a>
                                                    </td>
                                                    <td>
                                                        <a>{{$twt->transaction_date}}</a>
                                                    </td>
                                                    <td>
                                                        @foreach($twt->warehouse_transfer_item as $twti)
                                                        <?php $value += 1 ?>
                                                        @endforeach
                                                        <a>{{$value}}</a>
                                                    </td>
                                                    <td>
                                                        {{$twt->updated_at}}
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
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
<script src="{{ asset('js/products/warehouses/deleteForm.js?v=5-26012020') }}" charset="utf-8"></script>
@endpush
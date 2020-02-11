@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <button class="btn btn-dark dropdown-toggle" type="button" onclick="window.location.href = '#';" data-toggle="modal" data-target=".bs-example-modal-lg">Purchase History
                        </button>
                        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                        </button>
                                        <h5 class="modal-title" id="myModalLabel">Purchase History</h5>
                                        <h3 class="modal-title" id="myModalLabel"><strong>Purchase Invoice #{{$pi->number}}</strong></h3>
                                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                            <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Purchase Payment History</a>
                                            </li>
                                            @if($pi->selected_pq_id == null)
                                            <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Purchase Delivery History</a>
                                            </li>
                                            @else
                                            @endif
                                        </ul>
                                    </div>
                                    <div class="modal-body">
                                        <!---->
                                        <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                            <div id="myTabContent" class="tab-content">
                                                <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                                                    <div class="table-responsive my-5">
                                                        <table id="example" class="table table-striped jambo_table bulk_action">
                                                            <thead>
                                                                <tr class="headings">
                                                                    <th class="column-title" style="width:250px">Number</th>
                                                                    <th class="column-title" style="width:200px">Transaction Date</th>
                                                                    <th class="column-title" style="width:150px">Pay From</th>
                                                                    <th class="column-title" style="width:150px">Payment Method</th>
                                                                    <th class="column-title" style="width:150px">Payment Status</th>
                                                                    <th class="column-title" style="width:150px">Amount</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="neworderbody">
                                                                @foreach ($pi_history as $po)
                                                                <tr>
                                                                    <td>
                                                                        <div class="form-group">
                                                                            <a href="{{ url('/purchases_payment/'.$po->id) }}">Purchase Payment #{{$po->number}}</a>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="form-group">
                                                                            <a>{{$po->transaction_date}}</a>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="form-group">
                                                                            <a>{{$po->coa->name}}</a>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="form-group">
                                                                            <a>{{$po->payment_method->name}}</a>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="form-group">
                                                                            @if($po->status == 1)
                                                                            <a>Open</a>
                                                                            @elseif($po->status == 2)
                                                                            <a>Closed</a>
                                                                            @elseif($po->status == 3)
                                                                            <a>Paid</a>
                                                                            @elseif($po->status == 4)
                                                                            <a>Partial</a>
                                                                            @else
                                                                            <a>Overdue</a>
                                                                            @endif
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="form-group">
                                                                            <a>Rp @number($po->grandtotal)</a>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                                                    <div class="table-responsive my-5">
                                                        <table id="example" class="table table-striped jambo_table bulk_action">
                                                            <thead>
                                                                <tr class="headings">
                                                                    <th class="column-title" style="width:200px">Number</th>
                                                                    <th class="column-title" style="width:250px">Shipping Date</th>
                                                                    <th class="column-title" style="width:150px">Status</th>
                                                                </tr>
                                                            </thead>
                                                            @if($pi->selected_pd_id == null)
                                                            @else
                                                            <tbody class="neworderbody">
                                                                @foreach ($pd_history as $po)
                                                                <tr>
                                                                    <td>
                                                                        <div class="form-group">
                                                                            <a href="{{ url('/purchases_delivery/'.$po->selected_pd_id) }}">Purchase Delivery #{{$po->purchase_delivery->number}}</a>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="form-group">
                                                                            <a>{{$po->transaction_date}}</a>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="form-group">
                                                                            @if($po->status == 1)
                                                                            <a>Open</a>
                                                                            @elseif($po->status == 2)
                                                                            <a>Closed</a>
                                                                            @elseif($po->status == 3)
                                                                            <a>Paid</a>
                                                                            @elseif($po->status == 4)
                                                                            <a>Partial</a>
                                                                            @else
                                                                            <a>Overdue</a>
                                                                            @endif
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                            @endif
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <button class="btn btn-dark dropdown-toggle" type="button" onclick="window.location.href = '#';" data-toggle="modal" data-target=".bs-example-modal-lg-2">View Journal Entry
                        </button>
                        <div class="modal fade bs-example-modal-lg-2" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                        </button>
                                        <h5 class="modal-title" id="myModalLabel">Journal Report</h5>
                                        <h3 class="modal-title" id="myModalLabel"><strong>Purchase Invoice #{{$pi->number}}</strong></h3>
                                    </div>
                                    <div class="modal-body">
                                        <div class="table-responsive my-5">
                                            <table id="example" class="table table-striped jambo_table bulk_action">
                                                <thead>
                                                    <tr class="headings">
                                                        <th class="column-title" style="width:200px">Account Number</th>
                                                        <th class="column-title" style="width:250px">Account</th>
                                                        <th class="column-title" style="width:150px">Debit</th>
                                                        <th class="column-title" style="width:150px">Credit</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="neworderbody">
                                                    @foreach ($get_all_detail as $po)
                                                    <tr>
                                                        <td>
                                                            <div class="form-group">
                                                                <a href="{{ url('/purchases_invoice/'.$po->coa_id) }}">{{$po->coa->code}}</a>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <a href="{{ url('/purchases_invoice/'.$po->coa_id) }}">{{$po->coa->name}}</a>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                @if($po->debit == 0)
                                                                @else
                                                                <a>Rp @number($po->debit)</a>
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                @if($po->credit == 0)
                                                                @else
                                                                <a>Rp @number($po->credit)</a>
                                                                @endif
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    <tr class="headings">
                                                        <td>
                                                            <div class="form-group">
                                                                <strong><b>Total</b></strong>
                                                            </div>
                                                        </td>
                                                        <td>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <strong><b>Rp @number($total_debit)</b></strong>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <strong><b>Rp @number($total_credit)</b></strong>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <input type="button" class="btn btn-dark add" value="+ Add More Item" hidden>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <button data-toggle="dropdown" class="btn btn-dark dropdown-toggle" type="button" aria-expanded="false">Actions
                        </button>
                        <ul role="menu" class="dropdown-menu">
                            <li><a href="#">Clone Transaction</a></li>
                            <li><a href="/purchases_payment/new/from/{{$pi->id}}">Send Payment</a></li>
                            <li><a href="/purchase_return/new/{{$pi->id}}">Purchase Return</a></li>
                            <li><a href="#">Set as Recurring</a></li>
                            <li class="divider"></li>
                            <li><a target="_blank" href="/purchases_invoice/print/PDF/{{$pi->id}}">Print & Preview</a></li>
                        </ul>
                    </li>
                </ul>
                <h3><b>Purchase Invoice #{{$pi->number}}</b></h3>
                <a>Status: </a>
                @if($pi->status == 1)
                <span class="label label-warning" style="color:white;">Open</span>
                @elseif($pi->status == 2)
                <span class="label label-success" style="color:white;">Closed</span>
                @elseif($pi->status == 3)
                <span class="label label-success" style="color:white;">Paid</span>
                @elseif($pi->status == 4)
                <span class="label label-warning" style="color:white;">Partial</span>
                @elseif($pi->status == 5)
                <span class="label label-danger" style="color:white;">Overdue</span>
                @elseif($pi->status == 6)
                <span class="label label-success" style="color:white;">Sent</span>
                @elseif($pi->status == 7)
                <span class="label label-success" style="color:white;">Active</span>
                @elseif($pi->status == 8)
                <span class="label label-success" style="color:white;">Sold</span>
                @elseif($pi->status == 9)
                <span class="label label-success" style="color:white;">Disposed</span>
                @endif
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="post" id="formCreate" class="form-horizontal">
                    <br>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Transaction No</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$pi->number}}</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Vendor</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <a href="{{ url('/contacts/'.$pi->contact_id) }}">
                                        <h5>{{$pi->contact->display_name}}</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Vendor Ref No</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$pi->vnedor_ref_no}}</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Term</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$pi->term->name}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Transaction Date</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$pi->transaction_date}}</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Warehouse</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    @if($pi->warehouse_id == 0)
                                    <h5>{{$pi->warehouse->name}}</h5>
                                    @else
                                    <a href="{{ url('/warehouses/'.$pi->warehouse_id) }}">
                                        <h5>{{$pi->warehouse->name}}</h5>
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Due Date</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$pi->due_date}}</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Email</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$pi->email}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Vendor Address</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$pi->address}}</h5>
                                </div>
                            </div>
                            @if(!$pi->selected_po_id == null)
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Purchase No</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <a href="{{ url('/purchases_order/'.$pi->selected_po_id) }}">
                                        <h5> Purchase Order #{{$pi->transaction_no_po}}</h5>
                                    </a>
                                </div>
                            </div>
                            @elseif(!$pi->selected_pq_id == null)
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Purchase No</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <a href="{{ url('/purchases_quote/'.$pi->selected_pq_id) }}">
                                        <h5> Purchase Quote #{{$pi->transaction_no_pq}}</h5>
                                    </a>
                                </div>
                            </div>
                            @else
                            @endif
                        </div>
                    </div>
                    <br>
                    <div class="form-group tiles"></div>
                    <br>
                    <div class="table-responsive my-5">
                        <table id="example" class="table table-striped jambo_table bulk_action">
                            <thead>
                                <tr class="headings">
                                    <th class="column-title" style="width:300px">Product</th>
                                    <th class="column-title">Description</th>
                                    <th class="column-title" style="width:90px">Qty</th>
                                    <th class="column-title" style="width:90px">Units</th>
                                    <th class="column-title">Unit Price</th>
                                    <th class="column-title" style="width:90px">Tax</th>
                                    <th class="column-title">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="neworderbody">
                                @foreach ($products as $product)
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <a href="{{ url('/products/'.$product->product_id) }}">
                                                <h5>{{$product->product->name}}</h5>
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <h5>{{$product->desc}}</h5>
                                    </td>
                                    <td>
                                        <h5>{{$product->qty}}</h5>
                                    </td>
                                    <td>
                                        <h5>{{$product->unit->name}}</h5>
                                    </td>
                                    <td>
                                        <h5>Rp @number($product->unit_price)</h5>
                                    </td>
                                    <td>
                                        <h5>{{$product->tax->name}}</h5>
                                    </td>
                                    <td>
                                        <h5>Rp @number($product->amount)</h5>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="messageForm" style="text-align: left;">Message</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$pi->message}}</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4">
                                    </div>
                                    <div class="col-md-4">
                                        <h5> Sub Total </h5>
                                        <br>
                                        @if($pi->amount_paid > 0)
                                        <h3><b> Payment Paid </b></h3>
                                        <br>
                                        @endif
                                        <h3><b> Balance Due </b></h3>
                                    </div>
                                    <div class="col-md-4 float-right">
                                        <h5 class="subtotal text-right"> Rp @number($pi->grandtotal) </h5>
                                        <input type="text" class="subtotal_input" name="subtotal" hidden>
                                        <br>
                                        @if($pi->amount_paid > 0)
                                        <h3 class="currency balance text-right"><b> Rp @number($pi->amount_paid) </b></h3>
                                        <input type="text" class="currency balance_input" name="balance" hidden>
                                        <br>
                                        @endif
                                        <h3 class="currency balance text-right"><b> Rp @number($pi->balance_due) </b></h3>
                                        <input type="text" class="currency balance_input" name="balance" hidden>
                                        <div class="form-group tile"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="memoForm" style="text-align: left;">Memo</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$pi->memo}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="col-md-3 center-margin">
                        <div class="form-group">
                            <a href="{{ url('/purchases_invoice') }}" class="btn btn-dark">Cancel</a>
                            <button type="button" class="btn btn-danger" id="click">Delete</button>
                            <div class="btn-group">
                                <button class="btn btn-success" type="button" onclick="window.location.href = '/purchases_invoice/edit/' + {{$pi->id}};">Edit
                                </button>
                            </div>
                            <input type="text" value="{{$pi->id}}" id="form_id" hidden>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/purchases/invoices/deleteForm.js?v=5-20200211-1624') }}" charset="utf-8"></script>
@endpush
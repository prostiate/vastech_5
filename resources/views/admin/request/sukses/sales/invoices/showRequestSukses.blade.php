@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <button class="btn btn-dark dropdown-toggle" type="button" onclick="window.location.href = '#';" data-toggle="modal" data-target=".bs-example-modal-lg">Sales History
                        </button>
                        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                        </button>
                                        <h5 class="modal-title" id="myModalLabel">Sales History</h5>
                                        <h3 class="modal-title" id="myModalLabel"><strong>Sales Invoice #{{$pi->number}}</strong></h3>
                                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                            @if($check_pi_history != null)
                                            <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Sales Payment History</a>
                                            </li>
                                            @endif
                                            @if($pi->selected_pd_id != null)
                                            <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Sales Delivery History</a>
                                            </li>
                                            @endif
                                            @if($check_pr_history != null)
                                            <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Sales Return History</a>
                                            </li>
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
                                                                        <a href="{{ url('/sales_payment/'.$po->sale_payment->id) }}">Sales Payment #{{$po->sale_payment->number}}</a>
                                                                    </td>
                                                                    <td>
                                                                        <a>{{$po->sale_payment->transaction_date}}</a>
                                                                    </td>
                                                                    <td>
                                                                        <a>{{$po->sale_payment->coa->name}}</a>
                                                                    </td>
                                                                    <td>
                                                                        <a>{{$po->sale_payment->payment_method->name}}</a>
                                                                    </td>
                                                                    <td>
                                                                        @if($po->sale_payment->status == 1)
                                                                        <a>Open</a>
                                                                        @elseif($po->sale_payment->status == 2)
                                                                        <a>Closed</a>
                                                                        @elseif($po->sale_payment->status == 3)
                                                                        <a>Paid</a>
                                                                        @elseif($po->sale_payment->status == 4)
                                                                        <a>Partial</a>
                                                                        @elseif($po->sale_payment->status = 5)
                                                                        <a>Overdue</a>
                                                                        @else
                                                                        <a>Sent</a>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <a>Rp @number($po->payment_amount)</a>
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
                                                            @if($pi->selected_sd_id != null)
                                                            <tbody class="neworderbody">
                                                                @foreach ($pd_history as $po)
                                                                <tr>
                                                                    <td>
                                                                        <a href="{{ url('/sales_delivery/'.$po->selected_sd_id) }}">Sales Delivery #{{$po->sale_delivery->number}}</a>
                                                                    </td>
                                                                    <td>
                                                                        <a>{{$po->transaction_date}}</a>
                                                                    </td>
                                                                    <td>
                                                                        @if($po->status == 1)
                                                                        <a>Open</a>
                                                                        @elseif($po->status == 2)
                                                                        <a>Closed</a>
                                                                        @elseif($po->status == 3)
                                                                        <a>Paid</a>
                                                                        @elseif($po->status == 4)
                                                                        <a>Partial</a>
                                                                        @elseif($po->status = 5)
                                                                        <a>Overdue</a>
                                                                        @else
                                                                        <a>Sent</a>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                            @endif
                                                        </table>
                                                    </div>
                                                </div>
                                                <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
                                                    <div class="table-responsive my-5">
                                                        <table id="example" class="table table-striped jambo_table bulk_action">
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
                                                            <tbody>
                                                                @foreach ($pr_history as $po)
                                                                <tr>
                                                                    <td>
                                                                        <a>{{$po->transaction_date}}</a>
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{ url('/sales_return/'.$po->id) }}">Sales Return #{{$po->number}}</a>
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{ url('/sales_invoice/'.$po->selected_pi_id) }}">Sales Invoice #{{$po->transaction_no_si}}</a>
                                                                    </td>
                                                                    <td>
                                                                        <a>{{$po->transaction_date}}</a>
                                                                    </td>
                                                                    <td>
                                                                        <a>{{$po->due_date}}</a>
                                                                    </td>
                                                                    <td>
                                                                        <a>Rp @number($po->grandtotal)</a>
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
                                        <h3 class="modal-title" id="myModalLabel"><strong>Sales Invoice #{{$pi->number}}</strong></h3>
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
                                                            <a href="{{ url('/chart_of_accounts/'.$po->coa_id) }}">{{$po->coa->code}}</a>
                                                        </td>
                                                        <td>
                                                            <a href="{{ url('/chart_of_accounts/'.$po->coa_id) }}">{{$po->coa->name}}</a>
                                                        </td>
                                                        <td>
                                                            @if($po->debit == 0)
                                                            @else
                                                            <a>Rp @number($po->debit)</a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($po->credit == 0)
                                                            @else
                                                            <a>Rp @number($po->credit)</a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    <tr class="headings">
                                                        <td>
                                                            <strong><b>Total</b></strong>
                                                        </td>
                                                        <td>
                                                        </td>
                                                        <td>
                                                            <strong><b>Rp @number($total_debit)</b></strong>
                                                        </td>
                                                        <td>
                                                            <strong><b>Rp @number($total_credit)</b></strong>
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
                            @hasrole('Owner|Ultimate|Sales Invoice')
                            @can('Create')
                            @if($pi->status == 1 or $pi->status == 4 or $pi->status == 5)
                            <li><a href="#">Clone Transaction</a></li>
                            @hasrole('Owner|Ultimate|Sales Payment')
                            <li><a href="/sales_payment/new/from/{{$pi->id}}">Receive Payment</a></li>
                            @endrole
                            @hasrole('Owner|Ultimate|Sales Return')
                            <li><a href="/sales_return/new/{{$pi->id}}">Sales Return</a></li>
                            @endrole
                            <li><a href="#">Set as Recurring</a></li>
                            <li class="divider"></li>
                            @elseif($pi->status == 3 && $pi->total_return != $pi->grandtotal or $pi->total_return == null)
                            <li><a href="#">Clone Transaction</a></li>
                            @hasrole('Owner|Ultimate|Sales Return')
                            <li><a href="/sales_return/new/{{$pi->id}}">Sales Return</a></li>
                            @endrole
                            <li><a href="#">Set as Recurring</a></li>
                            <li class="divider"></li>
                            @else
                            <li><a href="#">Clone Transaction</a></li>
                            <li><a href="#">Set as Recurring</a></li>
                            <li class="divider"></li>
                            @endif
                            @endcan
                            @endrole
                            <li><a data-toggle="modal" data-target=".print_preview">Print & Preview</a></li>
                        </ul>
                        <div class="modal fade print_preview" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                        </button>
                                        <h5 class="modal-title" id="myModalLabel">Print & Preview</h5>
                                        <h3 class="modal-title" id="myModalLabel"><strong>Select Template</strong></h3>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="form-horizontal form-label-left">
                                                    <div class="col-md-12">
                                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" style="text-align: left;">Template Type</label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select id="template_type" class="form-control">
                                                                <option value="1">Template 1</option>
                                                                <option value="2">Template 2</option>
                                                                @if($pi->user->company_id == 5)
                                                                <option value="51" selected>Template Sukses Surabaya (Invoice)</option>
                                                                <option value="52" selected>Template Sukses Surabaya (Surat Jalan)</option>
                                                                @elseif($pi->user->company_id == 2)
                                                                <option value="21">Template Sukses</option>
                                                                <option value="211" selected>Template Sukses (Surat Jalan)</option>
                                                                @if($pi->jasa_only == 1)
                                                                <option value="222" selected>Template Gelora</option>
                                                                @else
                                                                <option value="22" selected>Template Gelora</option>
                                                                @endif
                                                                <option value="221" selected>Template Gelora (Surat Jalan)</option>
                                                                @if($pi->jasa_only == 1)
                                                                <option value="233">Template Workshop FAS</option>
                                                                @else
                                                                <option value="23">Template Workshop FAS</option>
                                                                @endif
                                                                <option value="231" selected>Template Workshop FAS (Surat Jalan)</option>
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" id="click_print">Print</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
                <h3><b>Sales Invoice #{{$pi->number}}</b></h3>
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Customer</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <a href="/contacts/{{$pi->contact_id}}">
                                        <h5>{{$pi->contact->display_name}}</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Customer Ref No</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$pi->vendor_ref_no}}</h5>
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
                                    <h5>{{$pi->warehouse->name}}</h5>
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
                            @if(!$pi->selected_so_id == null)
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Sales No</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <a href="{{ url('/sales_order/'.$pi->selected_so_id) }}">
                                        <h5> Sales Order #{{$pi->transaction_no_so}}</h5>
                                    </a>
                                </div>
                            </div>
                            @elseif(!$pi->selected_sq_id == null)
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Sales No</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <a href="{{ url('/sales_quote/'.$pi->selected_sq_id) }}">
                                        <h5> Sales Quote #{{$pi->transaction_no_sq}}</h5>
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
                                        <a href="/products/{{$product->product_id}}">
                                            {{$product->product->name}}
                                        </a>
                                    </td>
                                    <td>
                                        <a>{{$product->desc}}</a>
                                    </td>
                                    <td>
                                        <a>{{$product->qty}}</a>
                                    </td>
                                    <td>
                                        <a>{{$product->unit->name}}</a>
                                    </td>
                                    <td>
                                        <a>Rp @number($product->unit_price)</a>
                                    </td>
                                    <td>
                                        <a>{{$product->tax->name}}</a>
                                    </td>
                                    <td>
                                        <a>Rp @number($product->amount)</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($pi->selected_spk_id)
                    <br>
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
                    @endif
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
                                        <h5>Sub Total</h5>
                                        <h5>Tax Total </h5>
                                        <br>
                                        @if($pi->total_return > 0)
                                        <h4><b>Total Return</b></h4>
                                        <br>
                                        @endif
                                        @if($pi->amount_paid > 0)
                                        <h4><b>Payment Received</b></h4>
                                        <br>
                                        @endif
                                        <h3><b>Balance Due</b></h3>
                                        @if($pi->credit_memo > 0)
                                        <br>
                                        <h4><b>Total Credit Memo</b></h4>
                                        @endif
                                    </div>
                                    <div class="col-md-4 float-right">
                                        <h5 class="subtotal text-right"> Rp @number($pi->subtotal) </h5>
                                        <h5 class="total text-right"> Rp @number($pi->taxtotal) </h5>
                                        <br>
                                        @if($pi->total_return > 0)
                                        <h4 class="currency balance text-right"><b>Rp @number($pi->total_return)</b></h4>
                                        <br>
                                        @endif
                                        @if($pi->amount_paid > 0)
                                        <h4 class="currency balance text-right"><b> Rp @number($pi->amount_paid) </b></h4>
                                        <br>
                                        @endif
                                        <h3 class="currency balance text-right"><b> Rp @number($pi->balance_due) </b></h3>
                                        <div class="form-group tile"></div>
                                        @if($pi->credit_memo > 0)
                                        <br>
                                        <h4 class="currency balance text-right"><b> Rp @number($pi->credit_memo) </b></h4>
                                        @endif
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
                            <a href="{{ url('/sales_invoice') }}" class="btn btn-dark">Cancel</a>
                            @hasrole('Owner|Ultimate|Sales Invoice')
                                @if($pi->status == 1 or $pi->status == 5 && $check_pi_history == null && $check_pr_history == null)
                                    @can('Delete')
                                        @if(Auth::user()->company_id == 5)
                                        @if(Auth::user()->id == 999999)
                                        <button type="button" class="btn btn-danger" id="click">Delete</button>
                                        @endif
                                        @endif
                                    @endcan
                                    @can('Edit')
                                        <div class="btn-group">
                                            <button class="btn btn-success" type="button" onclick="window.location.href = '/sales_invoice/edit/{{$pi->id}}';">Edit
                                            </button>
                                        </div>
                                    @endcan
                                @endif
                            @endrole
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
<script src="{{ asset('js/sales/invoices/deleteForm.js?v=5-20200319-0916') }}" charset="utf-8"></script>
<script>
    $('#click_print').click(function() {
        var get_type = $('#template_type').find(":selected").val();
        var get_id = document.getElementById("form_id").value;
        if (get_type == '1') {
            window.open('/sales_invoice/print/PDF/1/' + get_id, '_blank');
        } else if (get_type == '2') {
            window.open('/sales_invoice/print/PDF/2/' + get_id, '_blank');
        } else if (get_type == '3') {
            window.open('/sales_invoice/print/PDF/3/' + get_id, '_blank');
        } else if (get_type == '51') {
            window.open('/sales_invoice/print/PDF/sukses_surabaya/' + get_id, '_blank');
        } else if (get_type == '52') {
            window.open('/sales_invoice/print/PDF/sukses_surabaya_sj/' + get_id, '_blank');
        } else if (get_type == '21') {
            window.open('/sales_invoice/print/PDF/sukses/' + get_id, '_blank');
        } else if (get_type == '211') {
            window.open('/sales_invoice/print/PDF/sukses_sj/' + get_id, '_blank');
        } else if (get_type == '22') {
            window.open('/sales_invoice/print/PDF/gelora/' + get_id, '_blank');
        } else if (get_type == '221') {
            window.open('/sales_invoice/print/PDF/gelora_sj/' + get_id, '_blank');
        } else if (get_type == '23') {
            window.open('/sales_invoice/print/PDF/fas/' + get_id, '_blank');
        } else if (get_type == '231') {
            window.open('/sales_invoice/print/PDF/fas_sj/' + get_id, '_blank');
        }
    });
</script>
@endpush
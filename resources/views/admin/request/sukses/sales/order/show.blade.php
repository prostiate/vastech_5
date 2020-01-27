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
                                        <h3 class="modal-title" id="myModalLabel"><strong>Sales Order #{{$pi->number}}</strong></h3>
                                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                            <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Sales Invoice History</a>
                                            </li>
                                            <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Sales Delivery History</a>
                                            </li>
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
                                                                    <th class="column-title" style="width:150px">Due Date</th>
                                                                    <th class="column-title" style="width:150px">Amount</th>
                                                                    <th class="column-title" style="width:150px">Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="neworderbody">
                                                                @foreach ($pi_history as $po)
                                                                <tr>
                                                                    <td>
                                                                        <a href="{{ url('/sales_invoice/'.$po->id) }}">Sales Invoice #{{$po->number}}</a>
                                                                    </td>
                                                                    <td>
                                                                        <a>{{$po->transaction_date}}</a>
                                                                    </td>
                                                                    <td>
                                                                        <a>{{$po->due_date}}</a>
                                                                    </td>
                                                                    <td>
                                                                        <a>@number($po->balance_due)</a>
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
                                                                        @elseif($po->status == 5)
                                                                        <a>Overdue</a>
                                                                        @else
                                                                        <a>Sent</a>
                                                                        @endif
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
                                                            <tbody class="neworderbody">
                                                                @foreach ($pd_history as $po)
                                                                <tr>
                                                                    <td>
                                                                        <a href="{{ url('/sales_delivery/'.$po->id) }}">Sales Delivery #{{$po->number}}</a>
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
                                                                        @elseif($po->status == 5)
                                                                        <a>Overdue</a>
                                                                        @else
                                                                        <a>Sent</a>
                                                                        @endif
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
                        <button data-toggle="dropdown" class="btn btn-dark dropdown-toggle" type="button" aria-expanded="false">Actions
                        </button>
                        <ul role="menu" class="dropdown-menu">
                            @hasrole('Owner|Ultimate|Sales Order')
                            @can('Create')
                            @if($pi->status == 1)
                            <li><a href="#">Clone Transaction</a></li>
                            @hasrole('Owner|Ultimate|Sales Delivery')
                            <li><a href="/sales_delivery/new/from/{{$pi->id}}">Create Delivery</a></li>
                            @endrole
                            @hasrole('Owner|Ultimate|Sales Invoice')
                            <li><a href="/sales_invoice/new/fromOrder/{{$pi->id}}">Create Invoice</a></li>
                            @endrole
                            <li><a href="#">Add Deposit</a></li>
                            <li><a href="#">Set as Recurring</a></li>
                            <li class="divider"></li>
                            @elseif($pi->status == 2)
                            <li><a href="#">Clone Transaction</a></li>
                            <li><a href="#">Add Deposit</a></li>
                            <li class="divider"></li>
                            @else
                            <li><a href="#">Clone Transaction</a></li>
                            @hasrole('Owner|Ultimate|Sales Delivery')
                            <li><a href="/sales_delivery/new/from/{{$pi->id}}">Create Delivery</a></li>
                            @endrole
                            @hasrole('Owner|Ultimate|Sales Invoice')
                            <li><a href="/sales_invoice/new/fromOrder/{{$pi->id}}">Create Invoice</a></li>
                            @endrole
                            <li><a href="#">Set as Recurring</a></li>
                            <li class="divider"></li>
                            @endif
                            @endcan
                            @endrole
                            <li><a data-toggle="modal" data-target=".print_preview">Print & Preview</a></li>
                            @hasrole('Owner|Ultimate|Sales Order')
                            <li><a href="#" id="clickClose">Close Order</a></li>
                            @endrole
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
                                                                <option value="3">Template 3</option>
                                                                @if($pi->user->company_id == 5)
                                                                <option value="51" selected>Template Sukses Surabaya</option>
                                                                @elseif($pi->user->company_id == 2)
                                                                <option value="21">Template Sukses</option>
                                                                <option value="22" selected>Template Gelora</option>
                                                                <option value="23">Template Workshop FAS</option>
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
                <h3><b>Sales Order #{{$pi->number}}</b></h3>
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Billing Address</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$pi->address}}</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Marketting</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    @if($pi->marketting != null)
                                    <a href="{{ url('/contacts/'.$pi->marketting) }}">
                                        <h5>{{$pi->contact_marketting->display_name}}</h5>
                                    </a>
                                    @else
                                    <a>
                                        <h5></h5>
                                    </a>
                                    @endif
                                </div>
                            </div>
                            @if($pi->selected_sq_id)
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Sales Quote No</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>
                                        <a href="{{ url('/sales_quote/'.$pi->selected_sq_id) }}">
                                            Sales Quote #{{$pi->sale_quote->number}}
                                        </a>
                                    </h5>
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
                                    <th class="column-title">Harga Nota</th>
                                    <th class="column-title">Harga Beda</th>
                                    <th class="column-title" style="width:90px">Tax</th>
                                    <th class="column-title">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="neworderbody">
                                @foreach ($products as $a)
                                <tr>
                                    <td>
                                        <a href="{{ url('/products/'.$a->product_id) }}">
                                            {{$a->product->name}}
                                        </a>
                                    </td>
                                    <td>
                                        <a>{{$a->desc}}</a>
                                    </td>
                                    <td>
                                        <a>{{$a->qty}}</a>
                                    </td>
                                    <td>
                                        <a>{{$a->unit->name}}</a>
                                    </td>
                                    <td>
                                        <a>Rp @number($a->harga_nota)</a>
                                    </td>
                                    <td>
                                        <a>Rp @number($a->unit_price)</a>
                                    </td>
                                    <td>
                                        <a>{{$a->tax->name}}</a>
                                    </td>
                                    <td>
                                        <a>Rp @number($a->amount)</a>
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
                                        <h5>Sub Total</h5>
                                        <h5>Tax Total</h5>
                                        <br>
                                        @if($pi->balance_due != $pi->grandtotal)
                                        <h3><b>Balance Due</b></h3>
                                        <br>
                                        @endif
                                        <h4><b>Grand Total</b></h4>
                                    </div>
                                    <div class="col-md-4 float-right">
                                        <h5 class="subtotal text-right">Rp @number($pi->grandtotal)</h5>
                                        <h5 class="taxtotal text-right">Rp @number($pi->taxtotal)</h5>
                                        <br>
                                        @if($pi->balance_due != $pi->grandtotal)
                                        <h3 class="currency balance text-right"><b>Rp @number($pi->balance_due)</b></h3>
                                        <br>
                                        @endif
                                        <h4 class="currency balance text-right"><b>Rp @number($pi->grandtotal)</b></h4>
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
                            <a href="{{ url('/sales_order') }}" class="btn btn-dark">Cancel</a>
                            @hasrole('Owner|Ultimate|Sales Order')
                            @if($pi->status == 1)
                            @can('Delete')
                            <button type="button" class="btn btn-danger" id="click">Delete</button>
                            @endcan
                            @can('Edit')
                            <div class="btn-group">
                                <button class="btn btn-success" type="button" onclick="window.location.href = '/sales_order/edit/' + {{$pi->id}};">Edit
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
<script src="{{ asset('js/sales/order/deleteForm.js?v=5-27012020') }}" charset="utf-8"></script>
<script src="{{ asset('js/sales/order/closeOrderForm.js?v=5-27012020') }}" charset="utf-8"></script>
<script>
    $('#click_print').click(function() {
        var get_type = $('#template_type').find(":selected").val();
        var get_id = document.getElementById("form_id").value;
        if (get_type == '1') {
            window.open('/sales_order/print/PDF/1/' + get_id, '_blank');
        } else if (get_type == '2') {
            window.open('/sales_order/print/PDF/2/' + get_id, '_blank');
        } else if (get_type == '3') {
            window.open('/sales_order/print/PDF/3/' + get_id, '_blank');
        } else if (get_type == '51') {
            window.open('/sales_order/print/PDF/sukses_surabaya/' + get_id, '_blank');
        } else if (get_type == '21') {
            window.open('/sales_order/print/PDF/sukses/' + get_id, '_blank');
        } else if (get_type == '22') {
            window.open('/sales_order/print/PDF/gelora/' + get_id, '_blank');
        } else if (get_type == '23') {
            window.open('/sales_order/print/PDF/fas/' + get_id, '_blank');
        }
    });
</script>
@endpush
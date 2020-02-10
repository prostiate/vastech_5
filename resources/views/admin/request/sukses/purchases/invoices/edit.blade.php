@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3>Edit Purchase Invoice</h3>
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
                                    <input value="{{$pi->number}}" type="text" class="form-control" name="trans_no" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Vendor*</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <a href="{{ url('/contacts/'.$pi->contact_id) }}">
                                        <h5>{{$pi->contact->display_name}}</h5>
                                    </a>
                                    <input type="text" name="vendor_name" value="{{$pi->contact_id}}" hidden>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Vendor Ref No</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input type="text" class="form-control" name="vendor_no" value="{{$pi->vendor_ref_no}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Term</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control selectterm term" name="term">
                                        @foreach($terms as $a)
                                        <option value="{{$a->id}}" length="{{$a->length}}" @if($a->id == $pi->term_id) selected @endif>
                                            {{$a->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Transaction Date</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$pi->transaction_date}}" type="text" class="form-control trans_date" name="trans_date" id="datepicker1">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Warehouse</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <a href="{{ url('/warehouses/'.$pi->warehouse_id) }}">
                                        <h5>{{$pi->warehouse->name}}</h5>
                                    </a>
                                    <input type="text" name="warehouse" value="{{$pi->warehouse_id}}" hidden>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Due Date</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$pi->due_date}}" type="text" class="form-control due_date" name="due_date" id="datepicker2">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Email</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input type="email" class="form-control email_text" name="email" value="{{$pi->email}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Vendor Address</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <textarea rows="4" class="form-control" name="vendor_address">{{$pi->address}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="form-group tiles"></div>
                    <br>
                    <div class="table-responsive my-5">
                        <table id="example" class="table jambo_table bulk_action">
                            <!--<thead>
                                <tr class="headings">
                                    <th class="column-title">Purchase Order No</th>
                                    <th class="column-title"></th>
                                    <th class="column-title">Purchase Order Ref No</th>
                                    <th class="column-title">Balance Due</th>
                                    <th class="column-title">Amount</th>
                                </tr>
                            </thead>-->
                            <tbody>
                                @foreach ($pipo as $pip)
                                <tr>
                                    <thead>
                                        <tr>
                                            <td>
                                                <a href="{{ url('/purchases_order/'.$pip->purchase_order_id) }}" style="color:white;">
                                                    <b>Purchase Order #{{$pip->purchase_order->number}}@if($pip->purchase_order->jasa_only == 1) <small style="color:white;"> - Fabrication Services Only</small> @endif</b>
                                                </a>
                                                <input type="text" name="po_id[]" value="{{$pip->id}}" >
                                                <input type="text" name="po_number[]" value="{{$pip->number}}" >
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                <tr class="headings">
                                    <th class="column-title" style="width: 250px">Product</th>
                                    <th class="column-title" style="width: 100px">Qty Order</th>
                                    <th class="column-title" style="width: 100px">Qty Remaining</th>
                                    <th class="column-title" style="width: 100px">Qty Dateng</th>
                                    <th class="column-title" style="width: 200px">Unit Price</th>
                                    <th class="column-title" style="width: 200px">Amount</th>
                                </tr>
                                @foreach($pipoi as $pii)
                                @if($pii->purchase_order_id == $pip->purchase_order_id)
                                <tr class="neworderbody">
                                    <td>
                                        <a href="/products/{{$pii->product_id}}">
                                            <h5>{{$pii->product->name}}</h5>
                                        </a>
                                        <input type="text" value="{{$pii->product_id}}" name="po_item_product_id[]" >
                                        <input type="text" value="{{$pii->id}}" name="po_item_id[]" >
                                    </td>
                                    <td>
                                        <h5>{{$pii->qty}}</h5>
                                    </td>
                                    <td>
                                        <h5>{{$pii->qty_remaining}}</h5>
                                        <input type="text" value="{{$pii->qty_remaining}}" name="po_qty_remaining[]" >
                                    </td>
                                    <td>
                                        <input onClick="this.select();" value="{{$pii->qty}}" type="text" class="qtydateng_display form-control" name="po_qty_dateng[]">
                                    </td>
                                    <td>
                                        <h5>Rp @number($pii->unit_price)</h5>
                                        <input type="text" class="unit_price" value="{{$pii->unit_price}}" name="po_unit_price[]" >
                                    </td>
                                    <td>
                                        <input type="text" class="order_amount_display form-control" readonly>
                                        <input type="text" class="order_amount" name="po_amount[]" >
                                    </td>
                                </tr>
                                @endif
                                @endforeach
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
                                    <textarea class="form-control" name="message" rows="4"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4">
                                    </div>
                                    <div class="col-md-4">
                                        <h3><b> Total Amount </b></h3>
                                        <!--<h3><b> Total Amount Order </b></h3>-->
                                    </div>
                                    <div class="col-md-4 float-right">
                                        <input class="balance form-control" readonly>
                                        <input type="text" class="balance_input" name="balance" hidden>
                                        <!--<input class="balance2 form-control" readonly>
                                        <input type="text" class="balance_input2" name="balance2" hidden>-->
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
                                    <textarea class="form-control" name="memo" rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="col-md-3 center-margin">
                        <div class="form-group">
                            <a href="{{ url('/purchases_invoice/newRS') }}" class="btn btn-danger">Back</a>
                            <div class="btn-group">
                                <button id="click" type="button" class="btn btn-success">Create </button>
                                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a id="clicknew">Create & New </a>
                                    </li>
                                    <li><a id="click">Create </a>
                                    </li>
                                </ul>
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
<script src="{{asset('js/request/sukses/purchases/invoices/createForm.js?v=5-20200206-1313') }}" charset="utf-8"></script>
<script src="{{asset('js/request/sukses/purchases/invoices/addmoreitem3.js?v=5-20200206-1313') }}" charset="utf-8"></script>
<script src="{{asset('js/other/zebradatepicker.js?v=5-20200206-1313') }}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js?v=5-20200206-1313') }}" charset="utf-8"></script>
<script src="{{asset('js/other/duedate_format.js?v=5-20200206-1313') }}" charset="utf-8"></script>
@endpush
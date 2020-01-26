@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3>Create Purchase Invoice</h3>
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
                                    <input value="{{$trans_no}}" type="text" class="form-control" name="trans_no" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Vendor*</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <a href="{{ url('/contacts/'.$vendors->id) }}">
                                        <h5>{{$vendors->display_name}}</h5>
                                    </a>
                                    <input type="text" name="vendor_name" value="{{$vendors->id}}" hidden>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Vendor Ref No</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input type="text" class="form-control" name="vendor_no">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Term</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control selectterm term" name="term">
                                        @foreach($terms as $a)
                                        <option value="{{$a->id}}" length="{{$a->length}}" @if($a->id == $vendors->term_id) selected @endif>
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
                                    <input value="{{$today}}" type="text" class="form-control trans_date" name="trans_date" id="datepicker1">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Warehouse</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <a href="{{ url('/warehouses/'.$warehouses->id) }}">
                                        <h5>{{$warehouses->name}}</h5>
                                    </a>
                                    <input type="text" name="warehouse" value="{{$warehouses->id}}" hidden>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Due Date</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input type="text" class="form-control due_date" name="due_date" id="datepicker2">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Email</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input type="email" class="form-control email_text" name="email" value="{{$vendors->email}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Vendor Address</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <textarea rows="4" class="form-control" name="vendor_address"></textarea>
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
                                @foreach($all_po as $ap)
                                    @if($ap->status == 4 or $ap->status == 1)
                                        @if($ap->balance_due > 0)
                                            <tr>
                                                <thead>
                                                    <tr>
                                                        <td>
                                                            <a href="/purchases_order/{{$ap->id}}" style="color:white;">
                                                                <h5><b>Purchase Order #{{$ap->number}}@if($ap->jasa_only == 1) <small style="color:white;"> - Fabrication Services Only</small> @endif</b></h5>
                                                            </a>
                                                            <input type="text" name="po_id[]" value="{{$ap->id}}" hidden>
                                                            <input type="text" name="po_number[]" value="{{$ap->number}}" hidden>
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
                                            @foreach($all_po_item as $api)
                                                @if($api->purchase_order_id == $ap->id)
                                                    @if($api->qty_remaining == 0)
                                                    <tr class="neworderbody" hidden>
                                                        <td>
                                                            <a href="/products/{{$api->product_id}}">
                                                                <h5>{{$api->product->name}}</h5>
                                                            </a>
                                                            <input type="text" value="{{$api->product_id}}" name="po_item_product_id[]" hidden>
                                                            <input type="text" value="{{$api->id}}" name="po_item_id[]" hidden>
                                                        </td>
                                                        <td>
                                                            <h5>{{$api->qty}}</h5>
                                                        </td>
                                                        <td>
                                                            <h5>{{$api->qty_remaining}}</h5>
                                                            <input type="text" value="{{$api->qty_remaining}}" name="po_qty_remaining[]" hidden>
                                                        </td>
                                                        <td>
                                                            <input onClick="this.select();" type="text" class="qtydateng_display form-control" name="po_qty_dateng[]">
                                                        </td>
                                                        <td>
                                                            <h5>Rp @number($api->unit_price)</h5>
                                                            <input type="text" class="unit_price" value="{{$api->unit_price}}" name="po_unit_price[]" hidden>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="order_amount_display form-control" readonly>
                                                            <input type="text" class="order_amount" name="po_amount[]" hidden>
                                                        </td>
                                                    </tr>
                                                    @else
                                                    <tr class="neworderbody">
                                                        <td>
                                                            <a href="/products/{{$api->product_id}}">
                                                                <h5>{{$api->product->name}}</h5>
                                                            </a>
                                                            <input type="text" value="{{$api->product_id}}" name="po_item_product_id[]" hidden>
                                                            <input type="text" value="{{$api->id}}" name="po_item_id[]" hidden>
                                                        </td>
                                                        <td>
                                                            <h5>{{$api->qty}}</h5>
                                                        </td>
                                                        <td>
                                                            <h5>{{$api->qty_remaining}}</h5>
                                                            <input type="text" value="{{$api->qty_remaining}}" name="po_qty_remaining[]" hidden>
                                                        </td>
                                                        <td>
                                                            <input onClick="this.select();" type="text" class="qtydateng_display form-control" name="po_qty_dateng[]">
                                                        </td>
                                                        <td>
                                                            <h5>Rp @number($api->unit_price)</h5>
                                                            <input type="text" class="unit_price" value="{{$api->unit_price}}" name="po_unit_price[]" hidden>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="order_amount_display form-control" readonly>
                                                            <input type="text" class="order_amount" name="po_amount[]" hidden>
                                                        </td>
                                                    </tr>
                                                    @endif
                                                @endif
                                            @endforeach
                                            </tr>
                                        @endif
                                    @endif
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
<script src="{{asset('js/request/sukses/purchases/invoices/createForm.js?v=5-26012020') }}" charset="utf-8"></script>
<script src="{{asset('js/request/sukses/purchases/invoices/addmoreitem3.js?v=5-26012020') }}" charset="utf-8"></script>
<script src="{{asset('js/other/zebradatepicker.js?v=5-26012020') }}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js?v=5-26012020') }}" charset="utf-8"></script>
<script src="{{asset('js/other/duedate_format.js?v=5-26012020') }}" charset="utf-8"></script>
@endpush
@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3>Update Sales Order</h3>
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
                                    <input value="{{$po->number}}" type="text" class="form-control" placeholder="AUTO" name="trans_no" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Customer*</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control select_contact contact_id" name="vendor_name">
                                        <option>{{$po->contact->display_name}}</option>
                                    </select>
                                    <input class="selected_contact_id" hidden>
                                    <input class="selected_contact_term" hidden>
                                    <input class="selected_email" hidden>
                                    <input class="selected_shipping_address" hidden>
                                    <input class="tampungan_contact_id" name="vendor_name2" value="{{$po->contact_id}}" hidden>
                                    <input class="tampungan_contact_term" value="{{$po->term_id}}" hidden>
                                    <input class="tampungan_email" value="{{$po->email}}" hidden>
                                    <input class="hidden_contact_id" value="{{$po->contact_id}}" hidden>
                                    <input class="hidden_shipping_address" value="{{$po->address}}" hidden>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Customer Ref No</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$po->vendor_ref_no}}" type="text" class="form-control" placeholder="Ref. Number Customer" name="vendor_no">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Term</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control selectterm term" name="term_date">
                                        @foreach($terms as $a)
                                        <option value="{{$a->id}}" @if($po->term_id == $a->id) selected = "selected" @endif length="{{$a->length}}">
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
                                    <input value="{{$po->transaction_date}}" type="text" class="form-control trans_date" name="trans_date" id="datepicker1">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Warehouse</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control selectwarehouse" name="warehouse">
                                        @foreach($warehouses as $a)
                                        <option value="{{$a->id}}" @if($po->warehouse_id == $a->id) selected = "selected" @endif>
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Due Date</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$po->due_date}}" type="text" class="form-control due_date" name="due_date" id="datepicker2">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Email</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$po->email}}" type="email" class="form-control email_text" name="email">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Billing Address</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <textarea rows="4" class="form-control address" name="vendor_address">{{$po->address}}</textarea>
                                </div>
                            </div>
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
                                    <th class="column-title"></th>
                                </tr>
                            </thead>
                            <tbody class="neworderbody">
                                @foreach ($po_item as $poitem)
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <select class="select_product form-control product_id" name="products[]">
                                                <option>{{$poitem->product->name}}</option>
                                            </select>
                                            <input class="selected_product_id" hidden>
                                            <input class="selected_product_desc" hidden>
                                            <input class="selected_product_unit" hidden>
                                            <input class="selected_product_price" hidden>
                                            <input class="selected_product_tax" hidden>
                                            <input class="selected_product_is_lock_sales" hidden>
                                            <input class="selected_product_qty" hidden>
                                            <input class="tampungan_product_id" name="products2[]" value="{{$poitem->product_id}}" hidden>
                                            <input class="tampungan_product_desc" value="{{$poitem->desc}}" hidden>
                                            <input class="tampungan_product_unit" value="{{$poitem->unit_id}}" hidden>
                                            <input class="tampungan_product_price" value="{{$poitem->unit_price}}" hidden>
                                            <input class="tampungan_product_tax" value="{{$poitem->tax_id}}" hidden>
                                            <input class="tampungan_product_is_lock_sales" hidden>
                                            <input class="tampungan_product_qty" value="{{$poitem->qty}}" hidden>
                                        </div>
                                    </td>
                                    <td>
                                        <textarea value='{{$poitem->desc}}' class="form-control desc" name="desc[]" rows="1">{{$poitem->desc}}</textarea>
                                    </td>
                                    <td>
                                        <input onClick="this.select();" value='{{$poitem->qty}}' type="text" class="qty form-control" value='1' name='qty[]'>
                                        <span class="red span_alert_qty" hidden><strong>Stock is not enough!</strong></span>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <select class="selectunit form-control units" name="units[]">
                                                @foreach ($units as $a)
                                                <option value="{{$a->id}}" @if($poitem->unit_id == $a->id) selected = 'selected' @endif>
                                                    {{$a->name}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <input onClick="this.select();" value='{{$poitem->unit_price}}' type="text" class="unit_price_display form-control" name="unit_price_display[]" required @if($poitem->product->is_lock_sales == 1) readonly @endif>
                                        <input value='{{$poitem->unit_price}}' type="text" class="unit_price form-control form-control-sm" name="unit_price[]" hidden>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <select class="taxes form-control selecttax" name="tax[]">
                                                @foreach ($taxes as $tax)
                                                <option value="{{$tax->id}}" rate="{{$tax->rate}}" @if($poitem->tax_id == $tax->id) selected = 'selected' @endif>{{$tax->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <input value="{{$poitem->amount}}" type="text" class="amount_display form-control" name="total_price_display[]" style="text-align: right;" readonly>
                                        <input value="{{$poitem->amount}}" type="text" class="amount form-control form-control-sm " name="total_price[]" hidden>
                                        <input value="{{$poitem->amounttax}}" type="text" class="amounttax" name="total_price_tax[]" hidden>
                                        <input value="{{$poitem->amountsub}}" type="text" class="amountsub" name="total_price_sub[]" hidden>
                                        <input value="{{$poitem->amountgrand}}" type="text" class="amountgrand" name="total_price_grand[]" hidden>
                                    </td>
                                    <td>
                                        <input type="button" class="btn btn-danger delete" value="x">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <input type="button" class="btn btn-dark add" value="+ Add More Item">
                    </div>
                    <br>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="messageForm" style="text-align: left;">Message</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <textarea value='{{$po->message}}' class="form-control" name="message" rows="4">{{$po->message}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4">
                                    </div>
                                    <div class="col-md-4">
                                        <h4> Sub Total </h4>
                                        <h4> Tax Total </h4>
                                        <br>
                                        <h3><b> Total Amount </b></h3>
                                    </div>
                                    <div class="col-md-4 float-right">
                                        <input class="subtotal form-control" readonly>
                                        <input type="text" class="subtotal_input" name="subtotal" hidden>
                                        <input class="total form-control" readonly>
                                        <input type="text" class="total_input" name="taxtotal" hidden>
                                        <br>
                                        <input class="balance form-control" readonly>
                                        <input type="text" class="balance_input" name="balance" hidden>
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
                                    <textarea value='{{$po->memo}}' class="form-control" name="memo" rows="4">{{$po->memo}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="col-md-3 center-margin">
                        <div class="form-group">
                            <a href="{{ url('/sales_order/'.$po->id) }}" class="btn btn-danger">Cancel</a>
                            <div class="btn-group">
                                <button id="click" type="button" class="btn btn-success">Update</button>
                                <input type="hidden" value="{{$po->id}}" name="hidden_id">
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
<script src="{{asset('js/sales/order/updateForm.js?v=5-20200206-1313') }}" charset="utf-8"></script>
<script src="{{asset('js/sales/order/addmoreitem.js?v=5-20200206-1313') }}" charset="utf-8"></script>
<script src="{{asset('js/other/zebradatepicker.js?v=5-20200206-1313') }}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js?v=5-20200206-1313') }}" charset="utf-8"></script>
<script src="{{asset('js/other/duedate_format.js?v=5-20200206-1313') }}" charset="utf-8"></script>
@endpush
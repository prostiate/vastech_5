@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3>Update Sales Invoice</h3>
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Customer*</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <a href="{{ url('/contacts/'.$pi->contact_id) }}">
                                        <h5>{{$pi->contact->display_name}}</h5>
                                    </a>
                                    <input type="hidden" name="vendor_name" value="{{$pi->contact_id}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Customer Ref No</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$pi->vendor_ref_no}}" type="text" class="form-control" name="vendor_no">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Term</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control selectterm term" name="term">
                                        @foreach($terms as $a)
                                        <option value="{{$a->id}}" length="{{$a->length}}" @if($pi->term_id == $a->id ) selected @endif>
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
                                    <select class="form-control selectwarehouse" name="warehouse">
                                        @foreach($warehouses as $a)
                                        <option value="{{$a->id}}" @if($pi->warehouse_id == $a->id ) selected @endif>
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Billing Address</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <textarea rows="4" class="form-control" name="vendor_address">{{$pi->address}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Sales No</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <a href="{{ url('/sales_quote/'.$pi->selected_sq_id) }}">
                                        <h5> Sales Quote #{{$pi->transaction_no_sq}}</h5>
                                    </a>
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
                                @foreach($pi_item as $item)
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <select class="select_product form-control product_id" name="products[]">
                                                <option>{{$item->product->name}}</option>
                                            </select>
                                            <input class="selected_product_id" hidden>
                                            <input class="selected_product_desc" hidden>
                                            <input class="selected_product_unit" hidden>
                                            <input class="selected_product_price" hidden>
                                            <input class="selected_product_tax" hidden>
                                            <input class="selected_product_is_lock_sales" hidden>
                                            <input class="tampungan_product_id" name="products2[]" value="{{$item->product_id}}" hidden>
                                            <input class="tampungan_product_desc" value="{{$item->desc}}" hidden>
                                            <input class="tampungan_product_unit" value="{{$item->unit_id}}" hidden>
                                            <input class="tampungan_product_price" value="{{$item->unit_price}}" hidden>
                                            <input class="tampungan_product_tax" value="{{$item->tax_id}}" hidden>
                                            <input class="tampungan_product_is_lock_sales" hidden>
                                        </div>
                                    </td>
                                    <td>
                                        <textarea class="form-control desc" name="desc[]" rows="1">{{$item->desc}}</textarea>
                                    </td>
                                    <td>
                                        <input onClick="this.select();" type="text" class="qty form-control" value='{{$item->qty}}' name='qty[]'>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <select class="selectunit form-control units" name="units[]">
                                                @foreach($units as $a)
                                                <option value="{{$a->id}}" @if($item->unit_id == $a->id) selected @endif>
                                                    {{$a->name}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <input onClick="this.select();" value="{{$item->unit_price}}" type="text" class="unit_price_display form-control" name="unit_price_display[]" required required @if($item->product->is_lock_sales == 1) readonly @endif>
                                        <input value="{{$item->unit_price}}" type="text" class="unit_price form-control form-control-sm" name="unit_price[]" hidden>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <select class="taxes form-control selecttax" name="tax[]">
                                                @foreach($taxes as $a)
                                                <option value="{{$a->id}}" rate="{{$a->rate}}" @if($item->tax_id == $a->id) selected @endif>
                                                    {{$a->name}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <input value="{{$item->amount}}" type="text" class="amount_display form-control" name="total_price_display[]" style="text-align: right;" readonly>
                                        <input value="{{$item->amount}}" type="text" class="amount form-control form-control-sm " name="total_price[]" hidden>
                                        <input value="{{$item->amounttax}}" type="text" class="amounttax" name="total_price_tax[]" hidden>
                                        <input value="{{$item->amountsub}}" type="text" class="amountsub" name="total_price_sub[]" hidden>
                                        <input value="{{$item->amountgrand}}" type="text" class="amountgrand" name="total_price_grand[]" hidden>
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
                                    <textarea class="form-control" name="message" rows="4">{{$pi->message}}</textarea>
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
                                    <textarea class="form-control" name="memo" rows="4">{{$pi->memo}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="col-md-3 center-margin">
                        <div class="form-group">
                            <a href="{{ url('/sales_invoice/'.$pi->id) }}" class="btn btn-danger">Cancel</a>
                            <div class="btn-group">
                                <button id="click" type="button" class="btn btn-success">Update</button>
                            </div>
                            <input value="{{$pi->id}}" type="hidden" name="hidden_id">
                            <input value="{{$pi->selected_sq_id}}" type="hidden" name="hidden_id_sq">
                            <input value="{{$pi->transaction_no_sq}}" type="hidden" name="hidden_number_sq">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{asset('js/sales/invoices/updateFormFromQuote.js?v=5-26012020') }}" charset="utf-8"></script>
<script src="{{asset('js/sales/invoices/addmoreitem.js?v=5-26012020') }}" charset="utf-8"></script>
<script src="{{asset('js/other/zebradatepicker.js?v=5-26012020') }}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js?v=5-26012020') }}" charset="utf-8"></script>
<script src="{{asset('js/other/duedate_format.js?v=5-26012020') }}" charset="utf-8"></script>
@endpush
@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3>Create Sales Invoice</h3>
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Customer*</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <a href="{{ url('/contacts/'.$po->contact_id) }}">
                                        <h5>{{$po->contact->display_name}}</h5>
                                    </a>
                                    <input type="hidden" name="vendor_name" value="{{$po->contact->id}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Customer Ref No</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$po->vendor_ref_no}}" type="text" class="form-control" name="vendor_no">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Term</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control selectterm term" name="term">
                                        @foreach($terms as $a)
                                        <option value="{{$a->id}}" length="{{$a->length}}" @if($po->term_id == $a->id) selected = "selected" @endif>
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
                                <div class="col-md-7 xdisplay_inputx form-group has-feedback">
                                    <input value="{{$today}}" type="text" class="form-control trans_date" name="trans_date" id="datepicker1">
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
                                <div class="col-md-7 xdisplay_inputx form-group has-feedback">
                                    <input type="text" class="form-control due_date" name="due_date" id="datepicker2">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Email</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input type="email" class="form-control" name="email" value="{{$po->email}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Billing Address</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <textarea rows="4" class="form-control" name="vendor_address">{{$po->address}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Sales No</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <a href="{{ url('/sales_order/'.$po->id) }}">
                                        <h5> Sales Order #{{$po->number}}</h5>
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
                                </tr>
                            </thead>
                            <tbody class="neworderbody">
                                @foreach ($po_item as $product)
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <select disabled class="selectproduct form-control product_id">
                                                <option>
                                                    {{$product->product->name}}
                                                </option>
                                            </select>
                                            <input type="hidden" name="products[]" value="{{$product->product_id}}">
                                            <input type="hidden" name="so_id[]" value="{{$product->id}}">
                                        </div>
                                    </td>
                                    <td>
                                        <textarea value="{{$product->desc}}" class="form-control desc" name="desc[]" rows="1">{{$product->desc}}</textarea>
                                    </td>
                                    <td>
                                        <input onClick="this.select();" r_val="{{$product->qty_remaining}}" value="0" type="number" class="qty form-control" name='qty[]'>
                                        <small>Remaining : <span class="remaining rqty">{{$product->qty_remaining}}</span></small>
                                        <input type="hidden" class="r_qty" name="r_qty[]">
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <select disabled class="selectunit form-control units">
                                                <option>
                                                    {{$product->unit->name}}
                                                </option>
                                            </select>
                                            <input type="hidden" name="units[]" value="{{$product->unit_id}}">
                                        </div>
                                    </td>
                                    <td>
                                        <input readonly onClick="this.select();" value="{{$product->unit_price}}" type="text" class="unit_price_display form-control" name="unit_price_display[]" required>
                                        <input value="{{$product->unit_price}}" type="text" class="unit_price form-control form-control-sm" name="unit_price[]" hidden>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <select disabled class="taxes form-control selecttax">
                                                <option value="{{$product->tax_id}}" rate="{{$product->tax->rate}}" selected>{{$product->tax->name}}</option>
                                            </select>
                                            <input type="hidden" name="tax[]" value="{{$product->tax_id}}">
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text" class="amount_display form-control" name="total_price_display[]" style="text-align: right;" readonly>
                                        <input type="text" class="amount form-control form-control-sm " name="total_price[]" hidden>
                                        <input type="text" class="amounttax" name="total_price_tax[]" hidden>
                                        <input type="text" class="amountsub" name="total_price_sub[]" hidden>
                                        <input type="text" class="amountgrand" name="total_price_grand[]" hidden>
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
                                    <textarea class="form-control" name="message" rows="4">{{$po->message}}</textarea>
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
                                        <h4><b> Payment Paid </b></h4>
                                        <br>
                                        <h3><b> Balance Due </b></h3>

                                    </div>
                                    <div class="col-md-4 float-right">
                                        <input class="subtotal form-control" readonly>
                                        <input type="text" class="subtotal_input" name="subtotal" hidden>
                                        <input class="total form-control" readonly>
                                        <input type="text" class="total_input" name="taxtotal" hidden>
                                        <br>
                                        <input class="form-control" value="{{$po->amount_paid}}" readonly>
                                        <input type="text" class="currency balance_input" name="amount_paid" hidden>
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
                                    <textarea class="form-control" name="memo" rows="4">{{$po->memo}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="col-md-12 text-center">
                        <div class="form-group">
                            <a href="{{ url('/sales_order/'.$po->id) }}" class="btn btn-danger">Cancel</a>
                            <div class="btn-group">
                                <button id="click" type="button" class="btn btn-success">Create </button>
                            </div>
                            <input value="{{$po->id}}" type="hidden" name="hidden_id">
                            <input value="{{$po->number}}" type="hidden" name="hidden_id_number">
                            <input value="{{$po->marketting}}" type="hidden" name="hidden_marketting">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{asset('js/request/sukses/sales/invoices/createFormFromOrder.js?v=5-20200319-0916') }}" charset="utf-8"></script>
<script src="{{asset('js/request/sukses/sales/invoices/addmoreitemFromOrder.js?v=5-20200319-0916') }}" charset="utf-8"></script>
<script src="{{asset('js/other/zebradatepicker.js?v=5-20200319-0916') }}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js?v=5-20200319-0916') }}" charset="utf-8"></script>
<script src="{{asset('js/other/duedate_format.js?v=5-20200319-0916') }}" charset="utf-8"></script>
<script src="{{ asset('js/other/qty_remaining.js?v=5-20200319-0916') }}" charset="utf-8"></script>
@endpush
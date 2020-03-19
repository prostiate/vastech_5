@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3><b>Create Purchase Delivery</b></h3>
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Vendor</label>
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Vendor Ref No</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$po->vendor_ref_no}}" type="text" class="form-control" name="vendor_no">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Purchase No</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <a href="{{ url('/purchases_order/'.$po->id) }}">
                                        <h5>Purchase Order #{{$po->number}}</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Shipping Date</label>
                                <div class="col-md-7 xdisplay_inputx form-group has-feedback">
                                    <input value="{{$today}}" type="text" class="form-control" name="shipping_date" id="datepicker1">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Warehouse</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select disabled class="form-control selectwarehouse">
                                        <option>
                                            {{$po->warehouse->name}}
                                        </option>
                                    </select>
                                    <input type="hidden" name="warehouse" value="{{$po->warehouse_id}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Email</label>
                                <div class="col-md-7 xdisplay_inputx form-group has-feedback">
                                    <input value="{{$po->email}}" type="email" class="form-control" name="email">
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
                                    <th class="column-title" style="width:200px">Description</th>
                                    <th class="column-title" style="width:150px">Qty</th>
                                    <th class="column-title" style="width:150px">Units</th>
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
                                            <input type="hidden" name="poi_id[]" value="{{$product->id}}">
                                        </div>
                                    </td>
                                    <td>
                                        <textarea value="{{$product->desc}}" class="form-control desc" name="desc[]" rows="1">{{$product->desc}}</textarea>
                                    </td>
                                    <td>
                                        <input onClick="this.select();" r_val="{{$product->qty_remaining}}" value="{{$product->qty_remaining}}" type="text" class="qty form-control" name='qty[]'>
                                        <small>Remaining : <span class="remaining rqty">0</span></small>
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
                                    <td hidden>
                                        <input readonly onClick="this.select();" value="{{$product->unit_price}}" type="text" class="unit_price_display form-control" name="unit_price_display[]" required>
                                        <input value="{{$product->unit_price}}" type="text" class="unit_price form-control form-control-sm" name="unit_price[]" hidden>
                                    </td>
                                    <td hidden>
                                        <div class="form-group">
                                            <select class="taxes form-control selecttax" name="tax[]">
                                                <option value="{{$product->tax_id}}" rate="{{$product->tax->rate}}" selected>{{$product->tax->name}}</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td hidden>
                                        <input value="{{$product->amount}}" type="text" class="amount_display form-control" name="total_price_display[]" style="text-align: right;" readonly>
                                        <input value="{{$product->amount}}" type="text" class="amount form-control form-control-sm " name="total_price[]" hidden>
                                        <input value="{{$product->amounttax}}" type="hidden" class="amounttax" name="total_price_tax[]">
                                        <input value="{{$product->amountsub}}" type="hidden" class="amountsub" name="total_price_sub[]">
                                        <input value="{{$product->amountgrand}}" type="hidden" class="amountgrand" name="total_price_grand[]">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!--<input type="button" class="btn btn-dark add" value="+ Add More Item" hidden>-->
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
                            <div class="col-md-6" hidden>
                                <div class="row">
                                    <div class="col-md-4">
                                    </div>
                                    <div class="col-md-4">
                                        <h5> Sub Total </h5>
                                        <h5> Tax Total </h5>
                                        <br>
                                        <h3><b> Total Amount </b></h3>
                                    </div>
                                    <div class="col-md-4 float-right">
                                        <h5 class="subtotal text-right"> Rp 0,00 </h5>
                                        <input type="text" class="subtotal_input" name="subtotal" hidden>
                                        <h5 class="total text-right"> Rp 0,00 </h5>
                                        <input type="text" class="total_input" name="taxtotal" hidden>
                                        <br>
                                        <h3 class="currency subtotal text-right"><b> Rp 0,00 </b></h3>
                                        <input type="text" class="currency subtotal_input" name="balance" hidden>
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
                    <div class="col-md-12 text-center">
                        <div class="form-group">
                            <a href="{{ url('/purchases_order/'.$po->id) }}" class="btn btn-dark">Cancel</a>
                            <div class="btn-group">
                                <button id="click" type="button" class="btn btn-success">Create Delivery</button>
                                <input value="{{$po->id}}" type="hidden" name="hidden_id">
                                <input value="{{$po->number}}" type="hidden" name="hidden_id_number">
                                <input value="{{$po->address}}" type="hidden" name="address">
                                <input value="{{$po->term_id}}" type="hidden" name="term">
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
<script src="{{ asset('js/purchases/delivery/createForm.js?v=5-20200319-0916') }}" charset="utf-8"></script>
<script src="{{ asset('js/other/addmoreitem.js?v=5-20200319-0916') }}" charset="utf-8"></script>
<script src="{{ asset('js/other/zebradatepicker.js?v=5-20200319-0916') }}" charset="utf-8"></script>
<script src="{{ asset('js/other/qty_remaining.js?v=5-20200319-0916') }}" charset="utf-8"></script>
@endpush
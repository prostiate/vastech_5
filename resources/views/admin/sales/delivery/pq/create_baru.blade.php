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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Transaction No</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$trans_no}}" type="text" class="form-control" placeholder="AUTO" name="invoice_no" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">*Vendor</label>
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer Ref No</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input type="text" class="form-control" placeholder="Ref. Number Customer" name="vendor_no">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Purchase No</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <a href="{{ url('/purchases_order/'.$po->id) }}">
                                        <h5>Purchase Order #{{$po->number}}</h5>
                                    </a>
                                    <input type="hidden" name="trans_ref" value="{{$po->number}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Shipping Date</label>
                                <div class="col-md-7 xdisplay_inputx form-group has-feedback">
                                    <input value="{{$today}}" type="text" class="form-control" name="shipping_date" id="datepicker1">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Warehouse</label>
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
                                        </div>
                                    </td>
                                    <td>
                                        <textarea class="form-control desc" name="desc[]" rows="1"></textarea>
                                    </td>
                                    <td>
                                        <input r_val="{{$product->qty}}" value="{{$product->qty}}" type="text" class="qty form-control" name='qty[]'>
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
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Message</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <textarea class="form-control" name="message" rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Memo</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <textarea class="form-control" name="memo" rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="col-md-3 center-margin">
                        <div class="form-group">
                            <a href="{{ url('/purchases_order/'.$po->id) }}" class="btn btn-dark">Cancel</a>
                            <div class="btn-group">
                                <button id="click" type="button" class="btn btn-success">Create Delivery</button>
                                <input value="{{$po->id}}" type="hidden" name="hidden_id">
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
<script src="{{ asset('js/purchases/delivery/createForm.js?v=5-27012020') }}" charset="utf-8"></script>
<script src="{{ asset('js/other/zebradatepicker.js?v=5-27012020') }}" charset="utf-8"></script>
<script src="{{ asset('js/other/qty_remaining.js?v=5-27012020') }}" charset="utf-8"></script>
@endpush
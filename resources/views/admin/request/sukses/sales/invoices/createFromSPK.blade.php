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
                                    <input {{--value="{{$po->vendor_ref_no}}"--}} type="text" class="form-control" name="vendor_no">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Term</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control selectterm term" name="term">
                                        @foreach($terms as $a)
                                        <option value="{{$a->id}}" length="{{$a->length}}">
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
                                    <a href="{{ url('/warehouses/'.$po->warehouse_id) }}">
                                        <h5>{{$po->warehouse->name}}</h5>
                                    </a>
                                    <input type="hidden" name="warehouse" value="{{$po->warehouse_id}}">
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
                                    <input type="email" class="form-control" name="email">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Billing Address</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <textarea rows="4" class="form-control" name="vendor_address"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">SPK No</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <a href="{{ url('/spk/'.$po->id) }}">
                                        <h5>Surat Perintah Kerja #{{$po->number}}</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="form-group tiles"></div>
                    <br>
                    <div class="">
                        <label>
                            <input type="checkbox" class="js-switch" value="1" name="jasa_only" /> Fabrication Services Only
                        </label>
                    </div>
                    <div class="table-responsive my-5">
                        <table id="example" class="table table-striped jambo_table bulk_action">
                            <thead>
                                <tr class="headings">
                                    <th class="column-title" style="width:300px">Product</th>
                                    <th class="column-title" style="width:100px">Description</th>
                                    <th class="column-title" style="width:110px">Qty Remaining</th>
                                    <th class="column-title" style="width:90px">Qty</th>
                                    <th class="column-title" style="width:90px">Units</th>
                                    <th class="column-title">Unit Price / Cost Unit Price</th>
                                    <th class="column-title" style="width:90px">Tax</th>
                                    <th class="column-title">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="neworderbody">
                                @foreach ($po_item as $a)
                                @if($a->qty_remaining_sent != 0)
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <a href="{{ url('/products/'.$a->product_id) }}">
                                                <h5>{{$a->product->name}}</h5>
                                            </a>
                                            <input type="text" name="products[]" value="{{$a->product_id}}" hidden>
                                        </div>
                                    </td>
                                    <td>
                                        <textarea class="form-control desc" name="desc[]" rows="1"></textarea>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <h5>{{$a->qty_remaining_sent}}</h5>
                                            <input type="text" name="qty_remaining[]" value="{{$a->qty_remaining_sent}}" hidden>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input onClick="this.select();" type="number" class="form-control qty" name="qty[]">
                                        </div>
                                        <!--{{--<input readonly r_val="0" value="{{$a->qty}}" type="number" class="qty form-control" name='qty[]'>
                                        <small>Remaining : <span class="remaining rqty">0</span></small>
                                        <input type="text" class="r_qty" name="r_qty[]">--}}-->
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <a>
                                                <h5>{{$a->product->other_unit->name}}</h5>
                                            </a>
                                            <input type="text" name="units[]" value="{{$a->product->other_unit_id}}" hidden>
                                        </div>
                                    </td>
                                    <td>
                                        <input readonly onClick="this.select();" value="{{$a->product->avg_price}}" type="text" class="unit_price_display form-control" name="unit_price_display[]" required>
                                        <input value="{{$a->product->avg_price}}" type="text" class="unit_price" name="unit_price[]" hidden>
                                        <br>
                                        <input onClick="this.select();" type="text" class="cost_unit_price_display form-control" name="cost_unit_price_display[]" required>
                                        <input type="text" class="cost_unit_price" name="cost_unit_price[]" hidden>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <a>
                                                <h5>{{$a->product->taxSell->name}}</h5>
                                            </a>
                                            <input type="text" name="tax[]" value="{{$a->product->sell_tax}}" hidden>
                                        </div>
                                    </td>
                                    <td>
                                        <!--{{--<?php $total_amount_display = $a->product->avg_price * $a->qty ?>
                                        <?php $total_amount = $a->product->avg_price * $a->qty ?>
                                        <?php $total_amount_tax = (($a->product->avg_price * $a->qty * $a->product->taxSell->rate) / 100) ?>
                                        <?php $total_amount_sub = $a->product->avg_price * $a->qty ?>
                                        <?php $total_amount_grand = $total_amount_sub + $total_amount_tax ?>
                                        <input value="{{$total_amount_display}}" type="text" class="amount_display form-control" name="total_price_display[]" readonly>
                                        <input value="{{$total_amount}}" type="text" class="amount" name="total_price[]" hidden>--}}-->
                                        <input type="text" class="amount_display form-control" name="total_price_display[]" readonly>
                                        <input type="text" class="amount" name="total_price[]" hidden>
                                        <!--{{--<input value="{{$total_amount_tax}}" type="text" class="amounttax" name="total_price_tax[]" >
                                        <input value="{{$total_amount_sub}}" type="text" class="amountsub" name="total_price_sub[]" >
                                        <input value="{{$total_amount_grand}}" type="text" class="amountgrand" name="total_price_grand[]" >--}}-->
                                        <!-- INI BUAT AMOUNT YANG COST -->
                                        <br>
                                        <input type="text" class="cost_amount_display form-control" name="cost_total_price_display[]" readonly>
                                        <input type="text" class="cost_amount" name="cost_total_price[]" hidden>
                                        <!--{{--<input type="text" class="cost_amounttax" name="cost_total_price_tax[]" >
                                        <input type="text" class="cost_amountsub" name="cost_total_price_sub[]" >
                                        <input type="text" class="cost_amountgrand" name="cost_total_price_grand[]" >--}}-->
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <!--<div class="table-responsive my-5">
                        <table id="example" class="table table-striped jambo_table bulk_action">
                            <thead>
                                <tr class="headings">
                                    <th class="column-title" style="width: 350px">Cost</th>
                                    <th class="column-title"></th>
                                    <th class="column-title" style="width: 350px">Amount </th>
                                    <th class="column-title" style="width: 50px"></th>
                                </tr>
                            </thead>
                            <tbody class="neworderbody2">
                            @if($check_cost_from_bundle != null)
                                @foreach($cost_from_bundle as $cfb))
                                    @foreach($po_item as $pi)
                                        @if($cfb->product_id == $pi->product_id)
                                        <tr>
                                            <td colspan="2">
                                                <div class="form-group">
                                                    <select class="form-control selectaccount cost_id" name="cost_acc[]">
                                                        <option></option>
                                                        @foreach ($costs as $a)
                                                        <option value="{{$a->id}}" @if($cfb->coa_id == $a->id) selected @endif>
                                                            ({{$a->code}}) - {{$a->name}} ({{$a->coa_category->name}})
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <input value="{{$cfb->amount}}" onClick="this.select();" type="text" class="form-control cost_amount_display" value="0">
                                                <input value="{{$cfb->amount}}" type="text" class="hidden_cost_amount" name="cost_amount[]" value="0" hidden>
                                            </td>
                                            <td>
                                                <input type="button" class="btn btn-danger delete1" value="x">
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                @endforeach
                            @else
                            <tr>
                                <td colspan="2">
                                    <div class="form-group">
                                        <select class="form-control selectaccount cost_id" name="cost_acc[]">
                                            <option></option>
                                            @foreach ($costs as $a)
                                            <option value="{{$a->id}}">
                                                ({{$a->code}}) - {{$a->name}} ({{$a->coa_category->name}})
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <input onClick="this.select();" type="text" class="form-control cost_amount_display" value="0">
                                    <input type="text" class="hidden_cost_amount" name="cost_amount[]" value="0" hidden>
                                </td>
                                <td>
                                    <input type="button" class="btn btn-danger delete2" value="x">
                                </td>
                            </tr>
                            @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" class="text-right">
                                        <h5><strong>Total</strong></h5>
                                        </h5>
                                    <td colspan="2">
                                        <input type="text" class="form-control total_cost_display" readonly>
                                        <input type="text" class="form-control total_cost_hidden" name="total_cost" hidden>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        <input type="button" class="btn btn-dark add-cost" value="+ Add More Cost">
                    </div>-->
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
                                        <!--<h4> Sub Total </h4>
                                        <h4> Tax Total </h4>-->
                                        <h4> Cost Total </h4>
                                        <br>
                                        <h3><b> Grand Total </b></h3>

                                    </div>
                                    <div class="col-md-4 float-right">
                                        <!--<input class="subtotal form-control" readonly>
                                        <input type="text" class="subtotal_input" name="subtotal" hidden>
                                        <input class="total form-control" readonly>
                                        <input type="text" class="total_input" name="taxtotal" hidden>-->
                                        <input class="costtotal form-control" readonly>
                                        <input type="text" class="costtotal_input" name="costtotal" hidden>
                                        <br>
                                        <input class="balance form-control" readonly>
                                        <input type="text" class="currency balance_input" name="balance" hidden>
                                        <input type="text" class="currency balance_input balance_input2" name="balance" hidden>
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
                    <div class="col-md-12 text-center">
                        <div class="form-group">
                            <a href="{{ url('/spk/'.$po->id) }}" class="btn btn-danger">Cancel</a>
                            <div class="btn-group">
                                <button id="click" type="button" class="btn btn-success">Create </button>
                            </div>
                            <input value="{{$po->id}}" type="text" name="spk_id" hidden>
                            <input value="{{$po->number}}" type="text" name="spk_number" hidden>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{asset('js/request/sukses/sales/invoices/addmoreitem.js?v=5-20200312-1327') }}" charset="utf-8"></script>
<script src="{{asset('js/request/sukses/sales/invoices/createFormFromSPK.js?v=5-20200312-1327') }}" charset="utf-8"></script>
<script src="{{asset('js/other/zebradatepicker.js?v=5-20200312-1327') }}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js?v=5-20200312-1327') }}" charset="utf-8"></script>
<script src="{{asset('js/other/duedate_format.js?v=5-20200312-1327') }}" charset="utf-8"></script>
@endpush
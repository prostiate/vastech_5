@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Edit Work In Progress</h2>
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
                                    <input value="{{$wip->number}}" type="text" class="form-control" readonly name="trans_no">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Transaction Date</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$wip->transaction_date}}" type="date" class="form-control" id="datepicker1" name="trans_date">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">SPK</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5><a href="/spk/{{$wip->selected_spk_id}}">Surat Perintah Kerja #{{$spk->number}}</a></h5>
                                    <input value="{{$spk->number}}" name="spk_no" hidden>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Contact</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5><a href="/contacts/{{$spk->contact_id}}">{{$spk->contact->display_name}}</a></h5>
                                    <input value="{{$spk->contact_id}}" name="contact" hidden>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">SPK Ref No</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$wip->vendor_ref_no}}</h5>
                                    <input value="{{$wip->vendor_ref_no}}" name="vendor_ref_no" hidden>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Warehouse</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5><a href="/warehouses/{{$spk->warehouse_id}}">{{$spk->warehouse->name}}</a></h5>
                                    <input value="{{$spk->warehouse_id}}" name="warehouse" hidden>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="memoForm" style="text-align: left;">Product Name</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5><a href="/products/{{$spk_item->product_id}}">{{$spk_item->product->name}}</a></h5>
                                    <input value="{{$spk_item->product_id}}" name="product_name" hidden>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Product Qty</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$wip->result_qty}}" onClick="this.select();" type="text" class="form-control product_qty" name="product_qty">
                                    <input value="{{$spk_item->qty}}" type="text" name="product_qty_to_make" hidden>
                                    <input value="{{$wip->result_product}}" type="text" name="product_id_to_make" hidden>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="memoForm" style="text-align: left;">Note</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <textarea class="form-control" name="desc" rows="4">{{$wip->desc}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="memoForm" style="text-align: left;">Production Method</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select name="production_method" class="form-control selectcategory production_method">
                                        <option value="0" selected>Material Per Product Qty</option>
                                        <option value="1">Material For All Product Qty</option>
                                    </select>
                                    <input class="wip_production_method" value="{{$wip->production_method}}" name="wip_production_method" hidden>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="memoForm" style="text-align: left;">Force Submit</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="1" name="force_submit" type="checkbox">
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="form-group tiles"></div>
                    <br>
                    <div id="material_per_product">
                        <div>
                            <a>Note* : Below product material will be used to make <strong><span>1</span></strong> per <strong>{{$spk_item->product->name}}</strong></a>
                        </div>
                        <br>
                        <div class="table-responsive my-5">
                            <table id="example" class="table table-striped jambo_table bulk_action">
                                <thead>
                                    <tr class="headings">
                                        <th class="column-title" style="width: 350px">Product Name</th>
                                        <th class="column-title" style="width: 250px">Quantity</th>
                                        <th class="column-title" style="width: 50px">Unit</th>
                                        <th class="column-title" style="width: 300px">Price</th>
                                        <th class="column-title" style="width: 300px">Total Price</th>
                                        <th class="column-title" style="width: 50px"></th>
                                    </tr>
                                </thead>
                                <tbody class="neworderbody_per">
                                    @if($wip->production_method != 1)
                                    @foreach($wip_item as $wi)
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <select class="form-control selectproduct_normal product_id_per" name="wip_product_id_per[]">
                                                    @foreach($wd as $qis)
                                                    <option @if($wi->product_id == $qis->product_id) selected @endif
                                                        value="{{$qis->product_id}}" unitprice="{{$qis->product->avg_price}}" unit="{{$qis->product->other_unit->name}}" qty="{{$qis->product->qty}}">{{$qis->product->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <input onClick="this.select();" type="number" class="wip_req_qty_display_per form-control qty" name="wip_product_req_qty_per[]" value="{{$wi->qty_require}}">
                                            <span class="red span_alert_qty_per" hidden><strong>Stock is not enough!</strong></span>
                                            <input class="force_submit_per" name="force_submit_item_per[]" type="number" value="1" disabled hidden>
                                        </td>
                                        <td>
                                            <input class="product_unit_per form-control" type="text" value="{{$wi->product->other_unit->name}}" readonly>
                                        </td>
                                        <td>
                                            <input onClick="this.select();" type="text" class="wip_product_price_display_per form-control" value="{{$wi->price}}">
                                            <input type="text" class="wip_product_price_per" name="wip_product_price_per[]" value="{{$wi->price}}" hidden>
                                        </td>
                                        <td>
                                            <input onClick="this.select();" type="text" class="wip_product_total_price_display_per form-control" value="{{$wi->total_price}}" readonly>
                                            <input type="text" class="wip_product_total_price_per" name="wip_product_total_price_per[]" value="{{$wi->total_price}}" hidden>
                                        </td>
                                        <td>
                                            <input type="button" class="btn btn-danger delete_per" value="x">
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <select class="form-control selectproduct_normal product_id_per" name="wip_product_id_per[]">
                                                    <option></option>
                                                    @foreach($wd as $qis)
                                                    <option value="{{$qis->product_id}}" unitprice="{{$qis->product->avg_price}}" unit="{{$qis->product->other_unit->name}}" qty="{{$qis->product->qty}}">{{$qis->product->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <input onClick="this.select();" type="number" class="wip_req_qty_display_per form-control qty" name="wip_product_req_qty_per[]" value="0">
                                            <span class="red span_alert_qty_per" hidden><strong>Stock is not enough!</strong></span>
                                            <input class="force_submit_per" name="force_submit_item_per[]" type="number" value="1" disabled hidden>
                                        </td>
                                        <td>
                                            <input class="product_unit_per form-control" type="text" readonly>
                                        </td>
                                        <td>
                                            <input onClick="this.select();" type="text" class="wip_product_price_display_per form-control" value="0">
                                            <input type="text" class="wip_product_price_per" name="wip_product_price_per[]" value="0" hidden>
                                        </td>
                                        <td>
                                            <input onClick="this.select();" type="text" class="wip_product_total_price_display_per form-control" value="0" readonly>
                                            <input type="text" class="wip_product_total_price_per" name="wip_product_total_price_per[]" value="0" hidden>
                                        </td>
                                        <td>
                                            <input type="button" class="btn btn-danger delete_per" value="x">
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                                <tfoot class="neworderfoot_per">
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right">
                                            <h5><strong>Margin </strong>
                                                <select class="form-control selectmargin" id="margin_per" style="width: 50px" name="margin_type_per">
                                                    <option value="rp" @if($wip->margin_type == 'rp') selected @endif>Rp</option>
                                                    <option value="per" @if($wip->margin_type == 'per') selected @endif>%</option>
                                                </select>
                                            </h5>
                                        </td>
                                        <td colspan="2">
                                            <input onClick="this.select();" type="text" class="form-control wip_margin_display_per" @if($wip->margin_type == 'rp') value="{{$wip->margin_total}}" @else value="{{$wip->margin_value}}" @endif>
                                            <input type="text" class="wip_margin_hidden_per_per" name="margin_value_per" value="{{$wip->margin_value}}" hidden>
                                            <input type="text" class="wip_margin_hidden_total_per" name="margin_total_per" value="{{$wip->margin_total}}" hidden>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-right">
                                            <h5><strong>Cost of Goods Sold</strong></h5>
                                        </td>
                                        <td colspan="2">
                                            <input type="text" class="form-control wip_total_price_display_per" readonly>
                                            <input type="text" class="wip_total_price_hidden_pure_per" hidden>
                                            <input type="text" class="wip_total_price_hidden_pure_input_per" name="grandtotal_with_qty_per" hidden>
                                            <input type="text" class="wip_total_price_hidden_grand_per" name="grandtotal_without_qty_per" hidden>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <input type="button" class="btn btn-dark add_per" value="+ Add More Item">
                        </div>
                        <br>
                        <div class="col-md-3 center-margin">
                            <div class="form-group">
                                <a href="{{ url('/wip/'.$wip->id) }}" class="btn btn-danger">Cancel</a>
                                <div class="btn-group">
                                    <button id="click_per" type="button" class="btn btn-success">Update</button>
                                    <input value="{{$wip->id}}" name="hidden_wip_id" hidden>
                                    <input value="{{$wip->selected_spk_id}}" name="spk_id" hidden>
                                    <input value="0" name="production_bundle" hidden>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="material_all_product" hidden>
                        <div>
                            <a>Note* : Below product material will be used to make <strong><span class="text_product_qty">{{$wip->result_qty}}</span></strong> of <strong>{{$spk_item->product->name}}</strong></a>
                        </div>
                        <br>
                        <div class="table-responsive my-5">
                            <table id="example" class="table table-striped jambo_table bulk_action">
                                <thead>
                                    <tr class="headings">
                                        <th class="column-title" style="width: 350px">Product Name</th>
                                        <th class="column-title" style="width: 250px">Quantity</th>
                                        <th class="column-title" style="width: 50px">Unit</th>
                                        <th class="column-title" style="width: 300px">Price</th>
                                        <th class="column-title" style="width: 300px">Total Price</th>
                                        <th class="column-title" style="width: 50px"></th>
                                    </tr>
                                </thead>
                                <tbody class="neworderbody_all">
                                    @if($wip->production_method == 1)
                                    @foreach($wip_item as $wi)
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <select class="form-control selectproduct_normal product_id_all" name="wip_product_id_all[]">
                                                    <option></option>
                                                    @foreach($wd as $qis)
                                                    <option @if($wi->product_id == $qis->product_id) selected @endif
                                                        value="{{$qis->product_id}}" unitprice="{{$qis->product->avg_price}}" unit="{{$qis->product->other_unit->name}}" qty="{{$qis->product->qty}}">{{$qis->product->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <input onClick="this.select();" type="number" class="wip_req_qty_display_all form-control qty" name="wip_product_req_qty_all[]" value="{{$wi->qty_total}}">
                                            <span class="red span_alert_qty_all" hidden><strong>Stock is not enough!</strong></span>
                                            <input class="force_submit_all" name="force_submit_item_all[]" type="number" value="1" disabled hidden>
                                        </td>
                                        <td>
                                            <input class="product_unit_all form-control" type="text" value="{{$wi->product->other_unit->name}}" readonly>
                                        </td>
                                        <td>
                                            <input onClick="this.select();" type="text" class="wip_product_price_display_all form-control" value="{{$wi->price}}">
                                            <input type="text" class="wip_product_price_all" name="wip_product_price_all[]" value="{{$wi->price}}" hidden>
                                        </td>
                                        <td>
                                            <input onClick="this.select();" type="text" class="wip_product_total_price_display_all form-control" value="{{$wi->total_price}}" readonly>
                                            <input type="text" class="wip_product_total_price_all" name="wip_product_total_price_all[]" value="{{$wi->total_price}}" hidden>
                                        </td>
                                        <td>
                                            <input type="button" class="btn btn-danger delete_all" value="x">
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <select class="form-control selectproduct_normal product_id_all" name="wip_product_id_all[]">
                                                    <option></option>
                                                    @foreach($wd as $qis)
                                                    <option value="{{$qis->product_id}}" unitprice="{{$qis->product->avg_price}}" unit="{{$qis->product->other_unit->name}}" qty="{{$qis->product->qty}}">{{$qis->product->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <input onClick="this.select();" type="number" class="wip_req_qty_display_all form-control qty" name="wip_product_req_qty_all[]" value="0">
                                            <span class="red span_alert_qty_all" hidden><strong>Stock is not enough!</strong></span>
                                            <input class="force_submit_all" name="force_submit_item_all[]" type="number" value="1" disabled hidden>
                                        </td>
                                        <td>
                                            <input class="product_unit_all form-control" type="text" readonly>
                                        </td>
                                        <td>
                                            <input onClick="this.select();" type="text" class="wip_product_price_display_all form-control" value="0">
                                            <input type="text" class="wip_product_price_all" name="wip_product_price_all[]" value="0" hidden>
                                        </td>
                                        <td>
                                            <input onClick="this.select();" type="text" class="wip_product_total_price_display_all form-control" value="0" readonly>
                                            <input type="text" class="wip_product_total_price_all" name="wip_product_total_price_all[]" value="0" hidden>
                                        </td>
                                        <td>
                                            <input type="button" class="btn btn-danger delete_all" value="x">
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                                <tfoot class="neworderfoot_all">
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right">
                                            <h5><strong>Margin </strong>
                                                <select class="form-control selectmargin" id="margin_all" style="width: 50px" name="margin_type_all">
                                                    <option value="rp" selected>Rp</option>
                                                    <option value="per">%</option>
                                                    <input class="wip_margin_type_all" value="{{$wip->margin_type}}" hidden>
                                                </select>
                                            </h5>
                                        </td>
                                        <td colspan="2">
                                            <input onClick="this.select();" type="text" class="form-control wip_margin_display_all" @if($wip->margin_type == 'rp') value="{{$wip->margin_total}}" @else value="{{$wip->margin_value}}" @endif>
                                            <input type="text" class="wip_margin_hidden_per_all" name="margin_value_all" value="{{$wip->margin_value}}" hidden>
                                            <input type="text" class="wip_margin_hidden_total_all" name="margin_total_all" value="{{$wip->margin_total}}" hidden>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-right">
                                            <h5><strong>Cost of Goods Sold</strong></h5>
                                        </td>
                                        <td colspan="2">
                                            <input type="text" class="form-control wip_total_price_display_all" readonly>
                                            <input type="text" class="wip_total_price_hidden_pure_all" hidden>
                                            <input type="text" class="wip_total_price_hidden_pure_input_all" name="grandtotal_with_qty_all" hidden>
                                            <input type="text" class="wip_total_price_hidden_grand_all" name="grandtotal_without_qty_all" hidden>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <input type="button" class="btn btn-dark add_all" value="+ Add More Item">
                        </div>
                        <br>
                        <div class="col-md-3 center-margin">
                            <div class="form-group">
                                <a href="{{ url('/wip/'.$wip->id) }}" class="btn btn-danger">Cancel</a>
                                <div class="btn-group">
                                    <button id="click_all" type="button" class="btn btn-success">Update</button>
                                    <input value="{{$wip->id}}" name="hidden_wip_id" hidden>
                                    <input value="{{$wip->selected_spk_id}}" name="spk_id" hidden>
                                    <input value="0" name="production_bundle" hidden>
                                </div>
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
<script src="{{ asset('js/request/sukses/wip/material_per_product.js?v=5-20200211-1624') }}" charset="utf-8"></script>
<script src="{{ asset('js/request/sukses/wip/material_all_product.js?v=5-20200211-1624') }}" charset="utf-8"></script>
<script src="{{ asset('js/request/sukses/wip/updateForm_per.js?v=5-20200211-1624') }}" charset="utf-8"></script>
<script src="{{ asset('js/request/sukses/wip/updateForm_all.js?v=5-20200211-1624') }}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js?v=5-20200211-1624') }}" charset="utf-8"></script>
<script src="{{asset('js/other/zebradatepicker.js?v=5-20200211-1624') }}" charset="utf-8"></script>
<script>
    $(document).ready(function() {
        $('.production_method').change(function() {
            if ($(this).val() == '0') {
                document.getElementById("material_per_product").removeAttribute("hidden");
                document.getElementById("material_all_product").setAttribute("hidden", "hidden");
            } else if ($(this).val() == '1') {
                document.getElementById("material_per_product").setAttribute("hidden", "hidden");
                document.getElementById("material_all_product").removeAttribute("hidden");
            }
        });
        var production_method = $('.wip_production_method').val();
        if (production_method == '0') {
            $('.production_method').val('0').trigger('change');
        } else {
            $('.production_method').val('1').trigger('change');
        }
        var margin_type = $('.wip_margin_type_all').val();
        if (margin_type == 'rp') {
            $('#margin_all').val('rp').trigger('change');
        } else {
            $('#margin_all').val('per').trigger('change');
        }
    });
</script>
@endpush
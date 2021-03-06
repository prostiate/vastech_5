@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>@lang("wip.create.title")</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="post" id="formCreate" class="form-horizontal">
                    <br>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang("wip.create.trans_no")</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$trans_no}}" type="text" class="form-control" readonly name="trans_no">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang("wip.create.trans_date")</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$today}}" type="date" class="form-control" id="datepicker1" name="trans_date">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang("wip.create.spk")</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5><a href="/spk/{{$spk->id}}">Surat Perintah Kerja #{{$spk->number}}</a></h5>
                                    <input value="{{$spk->number}}" name="spk_no" hidden>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang("wip.create.contact")</label>
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang("wip.create.ref_no")</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5><a href="/spk/{{$spk->id}}">{{$spk->vendor_ref_no}}</a></h5>
                                    <input value="{{$spk->vendor_ref_no}}" name="vendor_ref_no" hidden>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang("wip.create.warehouse")</label>
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="memoForm" style="text-align: left;">@lang("wip.create.product_name")</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5><a href="/products/{{$spk_item->product_id}}">{{$spk_item->product->name}}</a></h5>
                                    <input value="{{$spk_item->product_id}}" name="product_name" hidden>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang("wip.create.product_qty")</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$spk_item->qty_remaining}}" onClick="this.select();" type="text" class="form-control product_qty" name="product_qty">
                                    <input value="{{$spk_item->qty_remaining}}" type="text" name="product_qty_to_make" hidden>
                                    <input value="{{$spk_item->product_id}}" type="text" name="product_id_to_make" hidden>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="memoForm" style="text-align: left;">@lang("wip.create.note")</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <textarea class="form-control" name="desc" rows="4"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="memoForm" style="text-align: left;">@lang("wip.create.method")</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select name="production_method" class="form-control selectcategory production_method">
                                        <option value="0" selected>@lang("wip.create.product_method.method_1")</option>
                                        <option value="1">@lang("wip.create.product_method.method_2")</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="memoForm" style="text-align: left;">@lang("wip.create.force")</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input type="checkbox" id="force_submit" name="force_submit" value="1">
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="form-group tiles"></div>
                    <br>
                    <div id="material_per_product">
                        <div>
                            <a>@lang("wip.create.footnote.note_1")<strong><span>1</span></strong> @lang("wip.create.footnote.note_2") <strong>{{$spk_item->product->name}}</strong></a>
                        </div>
                        <br>
                        <div class="table-responsive my-5">
                            <table id="example" class="table table-striped jambo_table bulk_action">
                                <thead>
                                    <tr class="headings">
                                        <th class="column-title" style="width: 350px">@lang("wip.create.table.col_1")</th>
                                        <th class="column-title" style="width: 250px">@lang("wip.create.table.col_2")</th>
                                        <th class="column-title" style="width: 150px">@lang("wip.create.table.col_3")</th>
                                        <th class="column-title" style="width: 300px">@lang("wip.create.table.col_4")</th>
                                        <th class="column-title" style="width: 300px">@lang("wip.create.table.col_5")</th>
                                        <th class="column-title" style="width: 50px"></th>
                                    </tr>
                                </thead>
                                <tbody class="neworderbody_per">
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <!--<select class="form-control select_product product_id" name="wip_product_id[]">
                                                    <option></option>
                                                </select>
                                                <input class="selected_product_id" hidden>
                                                <input class="selected_product_price" hidden>
                                                <input class="tampungan_product_id" name="wip_product_id2[]" hidden>
                                                <input class="tampungan_product_price" hidden>-->
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
                                            <span class="red span_alert_qty_per" hidden><strong>@lang("wip.create.stock")</strong></span>
                                            <input class="force_submit_per" name="force_submit_item_per[]" type="text" value="1" disabled hidden>
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
                                </tbody>
                                <tfoot class="neworderfoot_per">
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right">
                                            <h5><strong>@lang("wip.create.margin")</strong>
                                                <select class="form-control selectmargin" id="margin_per" style="width: 50px" name="margin_type_per">
                                                    <option value="rp" selected>Rp</option>
                                                    <option value="per">%</option>
                                                </select>
                                            </h5>
                                        </td>
                                        <td colspan="2">
                                            <input onClick="this.select();" type="text" class="form-control wip_margin_display_per" value="0">
                                            <input type="text" class="wip_margin_hidden_per_per" name="margin_value_per" value="0" hidden>
                                            <input type="text" class="wip_margin_hidden_total_per" name="margin_total_per" value="0" hidden>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-right">
                                            <h5><strong>@lang("wip.create.cogs")</strong></h5>
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
                            <input type="button" class="btn btn-dark add_per" value="@lang('wip.create.more')">
                        </div>
                        <br>
                        <div class="col-md-12 text-center">
                            <div class="form-group">
                                <a href="{{ url('/spk/'.$spk->id) }}" class="btn btn-danger">@lang("wip.create.cancel")</a>
                                <div class="btn-group">
                                    <button id="click_per" type="button" class="btn btn-success">@lang("wip.create.create")</button>
                                    <input value="{{$spk->id}}" name="spk_id" hidden>
                                    <input value="0" name="production_bundle" hidden>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="material_all_product" hidden>
                        <div>
                            <a>@lang("wip.create.footnote.note_1")<strong><span class="text_product_qty">{{$spk_item->qty_remaining}}</span></strong> @lang("wip.create.footnote.note_3") <strong>{{$spk_item->product->name}}</strong></a>
                        </div>
                        <br>
                        <div class="table-responsive my-5">
                            <table id="example" class="table table-striped jambo_table bulk_action">
                                <thead>
                                    <tr class="headings">
                                        <th class="column-title" style="width: 350px">@lang("wip.create.table.col_1")</th>
                                        <th class="column-title" style="width: 250px">@lang("wip.create.table.col_2")</th>
                                        <th class="column-title" style="width: 150px">@lang("wip.create.table.col_3")</th>
                                        <th class="column-title" style="width: 300px">@lang("wip.create.table.col_4")</th>
                                        <th class="column-title" style="width: 300px">@lang("wip.create.table.col_5")</th>
                                        <th class="column-title" style="width: 50px"></th>
                                    </tr>
                                </thead>
                                <tbody class="neworderbody_all">
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <!--<select class="form-control select_product product_id" name="wip_product_id[]">
                                                    <option></option>
                                                </select>
                                                <input class="selected_product_id" hidden>
                                                <input class="selected_product_price" hidden>
                                                <input class="tampungan_product_id" name="wip_product_id2[]" hidden>
                                                <input class="tampungan_product_price" hidden>-->
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
                                            <span class="red span_alert_qty_all" hidden><strong>@lang("wip.create.stock")</strong></span>
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
                                </tbody>
                                <tfoot class="neworderfoot_all">
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right">
                                            <h5><strong>@lang("wip.create.margin")</strong>
                                                <select class="form-control selectmargin" id="margin_all" style="width: 50px" name="margin_type_all">
                                                    <option value="rp" selected>Rp</option>
                                                    <option value="per">%</option>
                                                </select>
                                            </h5>
                                        </td>
                                        <td colspan="2">
                                            <input onClick="this.select();" type="text" class="form-control wip_margin_display_all" value="0">
                                            <input type="text" class="wip_margin_hidden_per_all" name="margin_value_all" value="0" hidden>
                                            <input type="text" class="wip_margin_hidden_total_all" name="margin_total_all" value="0" hidden>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-right">
                                            <h5><strong>@lang("wip.create.cogs")</strong></h5>
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
                            <input type="button" class="btn btn-dark add_all" value="@lang('wip.create.more')">
                        </div>
                        <br>
                        <div class="col-md-12 text-center">
                            <div class="form-group">
                                <a href="{{ url('/spk/'.$spk->id) }}" class="btn btn-danger">@lang("wip.create.cancel")</a>
                                <div class="btn-group">
                                    <button id="click_all" type="button" class="btn btn-success">@lang("wip.create.create")</button>
                                    <input value="{{$spk->id}}" name="spk_id" hidden>
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
<script src="{{ asset('js/request/sukses/wip/material_per_product.js?v=5-20200319-0916') }}" charset="utf-8"></script>
<script src="{{ asset('js/request/sukses/wip/material_all_product.js?v=5-20200319-0916') }}" charset="utf-8"></script>
<script src="{{ asset('js/request/sukses/wip/createForm_per.js?v=5-20200319-0916') }}" charset="utf-8"></script>
<script src="{{ asset('js/request/sukses/wip/createForm_all.js?v=5-20200319-0916') }}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js?v=5-20200319-0916') }}" charset="utf-8"></script>
<script src="{{asset('js/other/zebradatepicker.js?v=5-20200319-0916') }}" charset="utf-8"></script>
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
        $('input[type="checkbox"]').click(function() {
            if ($(this).prop("checked") == true) {
                Swal.fire({
                    type: "warning",
                    title: "Are you sure?",
                    html: 'You are about to enabling force submit.<br>Please double check your input.',
                });
            }
        });
    });
</script>
@endpush
@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Create Work In Progress</h2>
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
                                    <input value="{{$trans_no}}" type="text" class="form-control" readonly name="trans_no">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Transaction Date</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$today}}" type="date" class="form-control" id="datepicker1" name="trans_date">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">SPK</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5><a href="/spk/{{$spk->id}}">Surat Perintah Kerja #{{$spk->number}}</a></h5>
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
                                    <h5><a href="/spk/{{$spk->id}}">{{$spk->vendor_ref_no}}</a></h5>
                                    <input value="{{$spk->vendor_ref_no}}" name="vendor_ref_no" hidden>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Proyek</label>
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="memoForm" style="text-align: left;">Note</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <textarea class="form-control" name="desc" rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="form-group tiles"></div>
                    <br>
                    <div>
                        <a>Note* : Quantity dan price untuk per satu barang {{$spk_item->product->name}}</a>
                    </div>
                    <br>
                    <div class="table-responsive my-5">
                        <table id="example" class="table table-striped jambo_table bulk_action">
                            <thead>
                                <tr class="headings">
                                    <th class="column-title" style="width: 350px">Product Name</th>
                                    <th class="column-title" style="width: 250px">Quantity<!-- per {{$spk_item->product->other_unit->name}}--></th>
                                    <th class="column-title" style="width: 300px">Price</th>
                                    <th class="column-title" style="width: 300px">Total Price<!-- per {{$spk_item->product->other_unit->name}}--></th>
                                    <th class="column-title" style="width: 50px"></th>
                                </tr>
                            </thead>
                            <tbody class="neworderbody">
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
                                            <select class="form-control selectproduct_normal product_id" name="wip_product_id[]">
                                                <option></option>
                                                @foreach($wd as $qis)
                                                @foreach($products as $pro)
                                                @if($pro->id == $qis->product_id)
                                                <option value="{{$pro->id}}" unitprice="{{$pro->avg_price}}">{{$pro->name}}</option>
                                                @endif
                                                @endforeach
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <input onClick="this.select();" type="number" class="wip_req_qty_display form-control qty" name="wip_product_req_qty[]" value="0">
                                    </td>
                                    <td>
                                        <input onClick="this.select();" type="text" class="wip_product_price_display form-control" value="0">
                                        <input type="text" class="wip_product_price" name="wip_product_price[]" value="0" hidden>
                                    </td>
                                    <td>
                                        <input onClick="this.select();" type="text" class="wip_product_total_price_display form-control" value="0" readonly>
                                        <input type="text" class="wip_product_total_price" name="wip_product_total_price[]" value="0" hidden>
                                    </td>
                                    <td>
                                        <input type="button" class="btn btn-danger delete" value="x">
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot class="neworderfoot">
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td class="text-right">
                                        <h5><strong>Margin </strong>
                                            <select class="form-control selectmargin" id="margin" style="width: 50px" name="margin_type">
                                                <option value="rp" selected>Rp</option>
                                                <option value="per">%</option>
                                            </select>
                                        </h5>
                                    </td>
                                    <td colspan="2">
                                        <input onClick="this.select();" type="text" class="form-control wip_margin_display" value="0">
                                        <input type="text" class="wip_margin_hidden_per" name="margin_value" value="0" hidden>
                                        <input type="text" class="wip_margin_hidden_total" name="margin_total" value="0" hidden>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-right">
                                        <h5><strong>HPP</strong></h5>
                                    </td>
                                    <td colspan="2">
                                        <input type="text" class="form-control wip_total_price_display" readonly>
                                        <input type="text" class="wip_total_price_hidden_pure" hidden>
                                        <input type="text" class="wip_total_price_hidden_pure_input" name="grandtotal_with_qty" hidden>
                                        <input type="text" class="wip_total_price_hidden_grand" name="grandtotal_without_qty" hidden>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        <input type="button" class="btn btn-dark add" value="+ Add More Item">
                    </div>
                    <br>
                    <div class="col-md-3 center-margin">
                        <div class="form-group">
                            <a href="{{ url('/spk/'.$spk->id) }}" class="btn btn-danger">Cancel</a>
                            <div class="btn-group">
                                <button id="click" type="button" class="btn btn-success">Create</button>
                                <input value="{{$spk->id}}" name="spk_id" hidden>
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
<script src="{{ asset('js/request/sukses/wip/counting.js') }}" charset="utf-8"></script>
<script src="{{ asset('js/request/sukses/wip/createForm.js') }}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js')}}" charset="utf-8"></script>
<script src="{{asset('js/other/zebradatepicker.js') }}" charset="utf-8"></script>
@endpush
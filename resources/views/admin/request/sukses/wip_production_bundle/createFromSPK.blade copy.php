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
                                    <input value="{{$spk_item->qty_remaining}}" onClick="this.select();" type="text" class="form-control product_qty" name="product_qty">
                                    <input value="{{$spk_item->qty}}" type="text" name="product_qty_to_make" hidden>
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
                    <div class="table-responsive my-5">
                        <table id="example" class="table table-striped jambo_table bulk_action">
                            <thead>
                                <tr class="headings">
                                    <th class="column-title" style="width: 350px">Product Name</th>
                                    <th class="column-title" style="width: 250px">Quantity In Stock</th>
                                    <th class="column-title" style="width: 250px">Quantity per {{$spk_item->product->other_unit->name}}</th>
                                    <th class="column-title" style="width: 300px">Price</th>
                                    <th class="column-title" style="width: 300px">Total Price</th>
                                </tr>
                            </thead>
                            <tbody class="neworderbody">
                                <?php $total_price = 0 ?>
                                <?php $total_price_con = 0 ?>
                                <?php $qty = 0 ?>
                                @foreach($current_product_bundle_item as $cpbi)
                                <tr>
                                    <td>
                                        <a href="/products/{{$cpbi->bundle_product_id}}">{{$cpbi->bundle_product->name}}</a>
                                        <input value="{{$cpbi->bundle_product_id}}" type="text" name="wip_product_id[]" hidden>
                                    </td>
                                    <td>
                                        @foreach($quantity_in_stock as $qis)
                                        @if($qis->product_id == $cpbi->bundle_product_id)
                                        <?php $qty += $qis->qty ?>
                                        @endif
                                        @endforeach
                                        <a>{{$qty}}</a>
                                        <input type="text" class="wip_qty_in_stock" name="wip_product_qty_in_stock[]" value="{{$qty}}" hidden>
                                    </td>
                                    <td>
                                        <a>{{$cpbi->qty}}</a>
                                        <input type="text" class="wip_req_qty" name="wip_product_req_qty[]" value="{{$cpbi->qty}}" hidden>
                                    </td>
                                    <td>
                                        <?php $price = $cpbi->bundle_product->avg_price ?>
                                        <a>Rp @number($price)</a>
                                        <input type="text" class="wip_product_price" name="wip_product_price[]" value="{{$price}}" hidden>
                                    </td>
                                    <td>
                                        <?php $total_price = $cpbi->bundle_product->avg_price * $cpbi->qty ?>
                                        <?php $total_price_con += $total_price ?>
                                        <a>Rp @number($total_price)</a>
                                        <input type="text" class="wip_product_total_price" name="wip_product_total_price[]" value="{{$total_price}}" hidden>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="neworderfoot">
                                <tr>
                                    <td></td>
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
                                    <td>
                                        <input onClick="this.select();" type="text" class="form-control wip_margin_display" value="0">
                                        <input type="text" class="wip_margin_hidden_per" name="margin_value" value="0" hidden>
                                        <input type="text" class="wip_margin_hidden_total" name="margin_total" value="0" hidden>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-right">
                                        <h5><strong>Grand Total</strong></h5>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control wip_total_price_display" readonly>
                                        <input type="text" class="wip_total_price_hidden_pure" name="grandtotal_without_margin" hidden>
                                        <!--{{--<input type="text" class="wip_total_price_hidden_qty">qty--}}-->
                                        <input type="text" class="wip_total_price_hidden_grand" name="grandtotal_with_margin" hidden>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
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
<script src="{{ asset('js/request/sukses/wip/counting.js?v=5-20200211-1624') }}" charset="utf-8"></script>
<script src="{{ asset('js/request/sukses/wip/createForm.js?v=5-20200211-1624') }}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js?v=5-20200211-1624') }}" charset="utf-8"></script>
<script src="{{asset('js/other/zebradatepicker.js?v=5-20200211-1624') }}" charset="utf-8"></script>
@endpush
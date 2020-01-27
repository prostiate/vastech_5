@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Edit Product / Service</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="post" id="formCreate" class="form-horizontal">
                    <br>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Product Name *</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$products->name}}" class="form-control" type="text" id="name_product" name="name_product">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Category</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select id="category_product" name="category_product" class="form-control selectcategory">
                                        @foreach($categories as $a)
                                        <option value="{{$a->id}}" @if($a->id == $products->other_product_category_id) selected @endif>
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Code / SKU</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$products->code}}" class="form-control" type="text" id="code_product" name="code_product">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Unit</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select id="unit_product" name="unit_product" class="form-control selectunit">
                                        @foreach($units as $a)
                                        <option value="{{$a->id}}" @if($a->id == $products->other_unit_id) selected @endif>
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
                            <!--<div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Bundle</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <div class="">
                                        <label>
                                            <input type="checkbox" class="js-switch is_bundle" value="1" name="is_bundle" />
                                        </label>
                                    </div>
                                </div>
                            </div>-->
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Production Bundle</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <div class="">
                                        <label>
                                            <input @if($products->is_production_bundle == 1) checked @endif type="checkbox" class="js-switch is_production_bundle" value="1" name="is_production_bundle" />
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Description</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$products->desc}}" class="form-control" type="text" id="desc_product" name="desc_product">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Discount</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <div class="">
                                        <label>
                                            <input @if($products->is_discount == 1) checked @endif type="checkbox" class="js-switch is_discount" value="1" name="is_discount" id="is_discount"/>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Price Lock</label>
                                <div class="col-sm-2">
                                    <div class="checkbox">
                                        <label>
                                            <input @if($products->is_lock_sales == 1) checked @endif type="checkbox" class="is_lock_sales" name="is_lock_sales" id="is_lock_sales"> Sales
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="checkbox">
                                        <label>
                                            <input @if($products->is_lock_purchase == 1) checked @endif type="checkbox" class="" name="is_lock_purchase"> Purchase
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="checkbox">
                                        <label>
                                            <input @if($products->is_lock_production == 1) checked @endif type="checkbox" class="" name="is_lock_production"> Production
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($products->sales_type == 'GT' or $products->sales_type == 'MT' or $products->sales_type == 'WS')
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Sales Type</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select id="sales_type" name="sales_type" class="form-control selectunit">
                                        <option value="GT" @if($products->sales_type == 'GT') selected @endif>General Trade</option>
                                        <option value="MT" @if($products->sales_type == 'MT') selected @endif>Modern Trade</option>
                                        <option value="WS" @if($products->sales_type == 'WS') selected @endif>Wholesaler</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <br>
                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#tab_content1" role="tab" id="invoice-tab" data-toggle="tab" aria-expanded="true">Price & Account Setting</a>
                            </li>
                            <li role="presentation" class=""><a href="#tab_content3" role="tab" id="discount-tab" @if($products->is_discount == 1) data-toggle="tab" @else data-toggle="" @endif aria-expanded="false">Discount Setting</a>
                            </li>
                            <li role="presentation" class=""><a href="#tab_content4" role="tab" id="production-tab" @if($products->is_production_bundle == 1) data-toggle="tab" @else data-toggle="" @endif aria-expanded="false">Production Bundle</a>
                            </li>
                        </ul>
                        <div id="myTabContent" class="tab-content">
                            <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="invoice-tab">
                                <div id="demo-form2" class="form-horizontal form-label-left">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="x_panel">
                                                    <div class="x_title">
                                                        <div class="">
                                                            <label>
                                                                <input type="checkbox" class="js-switch" value="1" name="is_buy" @if($products->is_buy == 1) checked @endif/> I Buy This Item
                                                            </label>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="x_content" data-parsley-validate>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="buy_account_product">Buy Account
                                                            </label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                <select id="buy_account_product" name="buy_account_product" class="form-control col-md-7 col-xs-12 selectbankname">
                                                                    @foreach($buy_accounts as $a)
                                                                    <option value="{{$a->id}}" @if($a->id == $products->buy_account) selected @endif>
                                                                        {{$a->name}}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="buy_tax">Default Buy Tax
                                                            </label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                <select id="buy_tax" name="buy_tax" class="form-control col-md-7 col-xs-12 selectbankname">
                                                                    @foreach($taxes as $a)
                                                                    <option value="{{$a->id}}" @if($a->id == $products->buy_tax) selected @endif>
                                                                        {{$a->name}}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="buy_price">Buy Unit Price
                                                            </label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                <input onClick="this.select();" value="{{$products->buy_price}}" type="text" class="form-control col-md-7 col-xs-12 buy_unit_price_display">
                                                                <input value="{{$products->buy_price}}" type="text" name="buy_price" class="hidden_buy_unit_price" hidden>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="x_panel">
                                                    <div class="x_title">
                                                        <div class="">
                                                            <label>
                                                                <input type="checkbox" class="js-switch" value="1" name="is_sell" @if($products->is_sell == 1) checked @endif/> I Sell This Item
                                                            </label>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="x_content" data-parsley-validate>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sell_account_product">Sell Account
                                                            </label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                <select d="sell_account_product" name="sell_account_product" class="form-control col-md-7 col-xs-12 selectbankname">
                                                                    @foreach($sell_accounts as $a)
                                                                    <option value="{{$a->id}}" @if($a->id == $products->sell_account) selected @endif>
                                                                        {{$a->name}}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sell_tax">Default Sell Tax
                                                            </label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                <select id="sell_tax" name="sell_tax" class="form-control col-md-7 col-xs-12 selectbankname">
                                                                    @foreach($taxes as $a)
                                                                    <option value="{{$a->id}}" @if($a->id == $products->sell_tax) selected @endif>
                                                                        {{$a->name}}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sell_price">Sell Unit Price
                                                            </label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                <input onClick="this.select();" value="{{$products->sell_price}}" type="text" class="form-control col-md-7 col-xs-12 sell_unit_price_display">
                                                                <input value="{{$products->sell_price}}" type="text" name="sell_price" class="hidden_sell_unit_price" hidden>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="x_panel">
                                                    <div class="x_title">
                                                        <div class="">
                                                            <label>
                                                                <input type="checkbox" class="js-switch" value="1" name="is_track" @if($products->is_track == 1) checked @endif/> I Track Stock for This Item
                                                            </label>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="x_content" data-parsley-validate>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sell_account_product">Default Inventory Account
                                                            </label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                <select id="default_inventory_account" name="default_inventory_account" class="form-control col-md-12 col-xs-12 selectproduct">
                                                                    @foreach($inventory_accounts as $a)
                                                                    <option value="{{$a->id}}" @if($a->id == $products->default_inventory_account) selected @endif>
                                                                        {{$a->name}}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sell_price">Minimum Stock Quantity
                                                            </label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                <input onClick="this.select();" value="{{$products->min_qty}}" placeholder="Minimum Stock Quantity" type="number" id="min_stock" name="min_stock" class="form-control col-md-7 col-xs-12">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="discount-tab">
                                <div class="x_panel">
                                    <div class="x_content">
                                        <div class="table-responsive">
                                            <table class="table table-striped jambo_table bulk_action">
                                                <thead>
                                                    <tr class="headings">
                                                        <th class="column-title">Discount Quantity</th>
                                                        <th class="column-title">Discount Price</th>
                                                    </tr>
                                                </thead>
                                                @if($products->is_discount == 1)
                                                <tbody class="neworderbody_discount">
                                                    <tr>
                                                        <td>
                                                            <div class="form-group">
                                                                <input value="{{$discount[0]->qty}}" onClick="this.select();" type="number" class="form-control discount_qty" name="discount_qty_a">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input value="{{$discount[0]->price}}" onClick="this.select();" type="text" class="form-control discount_price_display_a" hidden>
                                                            <input value="{{$discount[0]->price}}" type="text" class="discount_price_hidden_a" name="discount_price_a" hidden>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="form-group">
                                                                <input @if(count($discount)==2 or count($discount)==3 or count($discount)==4) value="{{$discount[1]->qty}}" @endif onClick="this.select();" type="number" class="form-control discount_qty" name="discount_qty_b">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input @if(count($discount)==2 or count($discount)==3 or count($discount)==4) value="{{$discount[1]->price}}" @endif onClick="this.select();" type="text" class="form-control discount_price_display_b" hidden>
                                                            <input @if(count($discount)==2 or count($discount)==3 or count($discount)==4) value="{{$discount[1]->price}}" @endif type="text" class="discount_price_hidden_b" name="discount_price_b" hidden>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="form-group">
                                                                <input @if(count($discount)==3 or count($discount)==4) value="{{$discount[2]->qty}}" @endif onClick="this.select();" type="number" class="form-control discount_qty" name="discount_qty_c">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input @if(count($discount)==3 or count($discount)==4) value="{{$discount[2]->price}}" @endif onClick="this.select();" type="text" class="form-control discount_price_display_c" hidden>
                                                            <input @if(count($discount)==3 or count($discount)==4) value="{{$discount[2]->price}}" @endif type="text" class="discount_price_hidden_c" name="discount_price_c" hidden>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="form-group">
                                                                <input @if(count($discount)==4) value="{{$discount[3]->qty}}" @endif onClick="this.select();" type="number" class="form-control discount_qty" name="discount_qty_d">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input @if(count($discount)==4) value="{{$discount[3]->price}}" @endif onClick="this.select();" type="text" class="form-control discount_price_display_d" hidden>
                                                            <input @if(count($discount)==4) value="{{$discount[3]->price}}" @endif type="text" class="discount_price_hidden_d" name="discount_price_d" hidden>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                @else
                                                <tbody class="neworderbody_discount">
                                                    <tr>
                                                        <td>
                                                            <div class="form-group">
                                                                <input onClick="this.select();" type="number" class="form-control discount_qty" name="discount_qty_a">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input onClick="this.select();" type="text" class="form-control discount_price_display_a">
                                                            <input type="text" class="discount_price_hidden_a" name="discount_price_a" hidden>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="form-group">
                                                                <input onClick="this.select();" type="number" class="form-control discount_qty" name="discount_qty_b">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input onClick="this.select();" type="text" class="form-control discount_price_display_b">
                                                            <input type="text" class="discount_price_hidden_b" name="discount_price_b" hidden>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="form-group">
                                                                <input onClick="this.select();" type="number" class="form-control discount_qty" name="discount_qty_c">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input onClick="this.select();" type="text" class="form-control discount_price_display_c">
                                                            <input type="text" class="discount_price_hidden_c" name="discount_price_c" hidden>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="form-group">
                                                                <input onClick="this.select();" type="number" class="form-control discount_qty" name="discount_qty_d">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input onClick="this.select();" type="text" class="form-control discount_price_display_d">
                                                            <input type="text" class="discount_price_hidden_d" name="discount_price_d" hidden>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                @endif
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="production-tab">
                                <div class="x_panel">
                                    <div class="x_content">
                                        <div class="table-responsive">
                                            <table class="table table-striped jambo_table bulk_action">
                                                <thead>
                                                    <tr class="headings">
                                                        <th class="column-title" style="width: 350px">Product Name</th>
                                                        <th class="column-title">Quantity</th>
                                                        <th class="column-title" style="width: 350px">Price</th>
                                                        <th class="column-title" style="width: 50px"></th>
                                                    </tr>
                                                </thead>
                                                <tbody class="neworderbody_production">
                                                    @foreach($production as $pr)
                                                    <tr>
                                                        <td>
                                                            <div class="form-group">
                                                                <select class="form-control select_product_production product_id_production" name="product_id_production[]">
                                                                    <option>{{$pr->bundle_product->name}}</option>
                                                                </select>
                                                                <input class="selected_product_id_production" hidden>
                                                                <input value="{{$pr->bundle_product_id}}" class="tampungan_product_id_production" name="product_id_production2[]" hidden>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input value="{{$pr->qty}}" onClick="this.select();" type="number" class="form-control qty_production" name="product_qty_production[]" value="0">
                                                        </td>
                                                        <td>
                                                            <input value="{{$pr->price}}" onClick="this.select();" type="text" class="form-control product_price_display_production" value="0">
                                                            <input value="{{$pr->price}}" type="text" class="hidden_product_price_production" name="product_price_production[]" value="0" hidden>
                                                        </td>
                                                        <td>
                                                            <input type="button" class="btn btn-danger delete_production" value="x">
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <input type="button" class="btn btn-dark add-item_production" value="+ Add More Item">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">
                            <button class="btn btn-primary" type="button" onclick="window.location.href = '/products/{{$products->id}}';">Cancel</button>
                            <div class="btn-group">
                                <button id="click" type="button" class="btn btn-success">Update </button>
                                <input value="{{$products->id}}" type="hidden" name="hidden_id" id="hidden_id" />
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
<script src="{{asset('js/products/products/addmoreitem_product_bundle.js?v=5-27012020') }}" charset="utf-8"></script>
<script src="{{asset('js/products/products/addmoreitem_production_bundle.js?v=5-27012020') }}" charset="utf-8"></script>
<script src="{{asset('js/products/products/updateForm.js?v=5-27012020') }}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js?v=5-27012020') }}" charset="utf-8"></script>
<script>
    $(document).ready(function() {
        $('.is_bundle').click(function() {
            if ($(this).prop("checked") == true) {
                $('#product-tab').attr("data-toggle", "tab");
            } else if ($(this).prop("checked") == false) {
                $('#product-tab').removeAttr("data-toggle", "tab");
                $('#myTab a[href="#tab_content1"]').tab('show');
            }
        });
        $('.is_lock_sales').click(function(e) {
            var checkbox = $(this);
            if (checkbox.not(":checked")) {
                alert("If you turn on discount, you cannot turn off price lock for sales!")
                e.preventDefault();
                return false;
            }
        });
        $('.is_discount').click(function() {
            if ($(this).prop("checked") == true) {
                $('#discount-tab').attr("data-toggle", "tab");
                $('#is_lock_sales').prop("checked", true);
            } else if ($(this).prop("checked") == false) {
                $('#discount-tab').removeAttr("data-toggle", "tab");
                $('#myTab a[href="#tab_content1"]').tab('show');
                $('#is_lock_sales').prop("checked", false);
            }
        });
        $('.is_production_bundle').click(function() {
            if ($(this).prop("checked") == true) {
                $('#production-tab').attr("data-toggle", "tab");
            } else if ($(this).prop("checked") == false) {
                $('#production-tab').removeAttr("data-toggle", "tab");
                $('#myTab a[href="#tab_content1"]').tab('show');
            }
        });
        $(".neworderbody_discount").on("keyup change", ".discount_price_display_a", function() {
            var tr = $(this).closest("tr");
            var hidden_discount_price = tr.find(".discount_price_display_a").val();
            tr.find(".discount_price_hidden_a").val(hidden_discount_price);
        });
        $(".neworderbody_discount").on("keyup change", ".discount_price_display_b", function() {
            var tr = $(this).closest("tr");
            var hidden_discount_price = tr.find(".discount_price_display_b").val();
            tr.find(".discount_price_hidden_b").val(hidden_discount_price);
        });
        $(".neworderbody_discount").on("keyup change", ".discount_price_display_c", function() {
            var tr = $(this).closest("tr");
            var hidden_discount_price = tr.find(".discount_price_display_c").val();
            tr.find(".discount_price_hidden_c").val(hidden_discount_price);
        });
        $(".neworderbody_discount").on("keyup change", ".discount_price_display_d", function() {
            var tr = $(this).closest("tr");
            var hidden_discount_price = tr.find(".discount_price_display_d").val();
            tr.find(".discount_price_hidden_d").val(hidden_discount_price);
        });
    });
</script>
@endpush
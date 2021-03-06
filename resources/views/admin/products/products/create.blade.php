@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>@lang('product_1.create.title')</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="post" id="formCreate" class="form-horizontal">
                    <br>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang('product_1.create.name')</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input class="form-control" type="text" id="name_product" name="name_product">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang('product_1.create.category')</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select id="category_product" name="category_product" class="form-control selectcategory">
                                        @foreach($categories as $a)
                                        <option value="{{$a->id}}">
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang('product_1.create.code')</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input class="form-control" type="text" id="code_product" name="code_product">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang('product_1.create.unit')</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select id="unit_product" name="unit_product" class="form-control selectunit">
                                        @foreach($units as $a)
                                        <option value="{{$a->id}}">
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang('product_1.create.check_production')</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <div class="">
                                        <label>
                                            <input type="checkbox" class="js-switch is_production_bundle" value="1" name="is_production_bundle" />
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang('product_1.create.desc')</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input class="form-control" type="text" id="desc_product" name="desc_product">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang('product_1.create.check_discount')</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <div class="">
                                        <label>
                                            <input type="checkbox" class="js-switch is_discount" value="1" name="is_discount" id="is_discount" />
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang('product_1.create.price_lock.price_lock')</label>
                                <div class="col-sm-2">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="is_lock_sales" name="is_lock_sales" id="is_lock_sales">@lang('product_1.create.price_lock.sales')
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="" name="is_lock_purchase">@lang('product_1.create.price_lock.purchase')
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="" name="is_lock_production">@lang('product_1.create.price_lock.production')
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($user->roles->first()->name == 'GT' or $user->roles->first()->name == 'MT' or $user->roles->first()->name == 'WS')
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Sales Type</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select id="sales_type" name="sales_type" class="form-control selectunit">
                                        <option value="GT" @if($user->roles->first()->name == 'GT') selected @endif>General Trade</option>
                                        <option value="MT" @if($user->roles->first()->name == 'MT') selected @endif>Modern Trade</option>
                                        <option value="WS" @if($user->roles->first()->name == 'WS') selected @endif>Wholesaler</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <br>
                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#tab_content1" role="tab" id="invoice-tab" data-toggle="tab" aria-expanded="true">@lang('product_1.create.tab_1.name')</a>
                            </li>
                            <!--<li role="presentation" class=""><a href="#tab_content2" role="tab" id="product-tab" data-toggle="tab" aria-expanded="false">Product Bundle</a>
                            </li>-->
                            <li role="presentation" class=""><a href="#tab_content3" role="tab" id="discount-tab" data-toggle="tab" aria-expanded="false">@lang('product_1.create.tab_2.name')</a>
                            </li>
                            <li role="presentation" class=""><a href="#tab_content4" role="tab" id="production-tab" data-toggle="tab" aria-expanded="false">@lang('product_1.create.tab_3.name')</a>
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
                                                                <input type="checkbox" class="js-switch" value="1" name="is_buy" checked />@lang('product_1.create.tab_1.buy_1')
                                                            </label>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="x_content" data-parsley-validate>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="buy_account_product">@lang('product_1.create.tab_1.buy_2')
                                                            </label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                <select id="buy_account_product" name="buy_account_product" class="form-control col-md-7 col-xs-12 selectbankname">
                                                                    @foreach($buy_accounts as $a)
                                                                    <option value="{{$a->id}}" @if($a->id == $default_buy_account->account_id) selected="selected" @endif>
                                                                        {{$a->name}}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="buy_tax">@lang('product_1.create.tab_1.buy_3')
                                                            </label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                <select id="buy_tax" name="buy_tax" class="form-control col-md-7 col-xs-12 selectbankname">
                                                                    @foreach($taxes as $a)
                                                                    <option value="{{$a->id}}">
                                                                        {{$a->name}}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="buy_price">@lang('product_1.create.tab_1.buy_4')
                                                            </label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                <input onClick="this.select();" value="0" type="text" class="form-control col-md-7 col-xs-12 buy_unit_price_display">
                                                                <input value="0" type="text" name="buy_price" class="hidden_buy_unit_price" hidden>
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
                                                                <input type="checkbox" class="js-switch" value="1" name="is_sell" checked />@lang('product_1.create.tab_1.sell_1')
                                                            </label>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="x_content" data-parsley-validate>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sell_account_product">@lang('product_1.create.tab_1.sell_2')
                                                            </label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                <select d="sell_account_product" name="sell_account_product" class="form-control col-md-7 col-xs-12 selectbankname">
                                                                    @foreach($sell_accounts as $a)
                                                                    <option value="{{$a->id}}" @if($a->id == $default_sell_account->account_id) selected="selected" @endif>
                                                                        {{$a->name}}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sell_tax">@lang('product_1.create.tab_1.sell_3')
                                                            </label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                <select id="sell_tax" name="sell_tax" class="form-control col-md-7 col-xs-12 selectbankname">
                                                                    @foreach($taxes as $a)
                                                                    <option value="{{$a->id}}">
                                                                        {{$a->name}}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sell_price">@lang('product_1.create.tab_1.sell_4')
                                                            </label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                <input onClick="this.select();" value="0" type="text" class="form-control col-md-7 col-xs-12 sell_unit_price_display">
                                                                <input value="0" type="text" name="sell_price" class="hidden_sell_unit_price" hidden>
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
                                                                <input type="checkbox" class="js-switch" value="1" name="is_track" checked />@lang('product_1.create.tab_1.track_1')
                                                            </label>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="x_content" data-parsley-validate>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sell_account_product">@lang('product_1.create.tab_1.track_2')
                                                            </label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                <select id="default_inventory_account" name="default_inventory_account" class="form-control col-md-12 col-xs-12 selectproduct">
                                                                    @foreach($inventory_accounts as $a)
                                                                    <option value="{{$a->id}}">
                                                                        {{$a->name}}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sell_price">@lang('product_1.create.tab_1.track_3')
                                                            </label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                <input onClick="this.select();" value="0" placeholder="Minimum Stock Quantity" type="number" id="min_stock" name="min_stock" class="form-control col-md-7 col-xs-12">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--<div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="product-tab">
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
                                                <tbody class="neworderbody1">
                                                    <tr>
                                                        <td>
                                                            <div class="form-group">
                                                                <select id="mySelect2" class="form-control select_product product_id" name="product_id[]">
                                                                    <option></option>
                                                                </select>
                                                                <input class="selected_product_id" hidden>
                                                                <input class="selected_product_avg_price" hidden>
                                                                <input class="tampungan_product_id" hidden>
                                                                <input class="tampungan_product_avg_price" hidden>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input onClick="this.select();" type="number" class="form-control qty" name="product_qty[]" value="0">
                                                        </td>
                                                        <td>
                                                            <input onClick="this.select();" type="text" class="form-control product_price_display" value="0" readonly>
                                                            <input type="text" class="hidden_product_id" name="product_id2[]" hidden>
                                                            <input type="text" class="hidden_product_price" name="product_price[]" value="0" hidden>
                                                        </td>
                                                        <td>
                                                            <input type="button" class="btn btn-danger delete" value="x">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="2" class="text-right">
                                                            <h5><strong>Total</strong></h5>
                                                            </h5>
                                                        <td colspan="2">
                                                            <input type="text" class="form-control total_price_display" readonly>
                                                            <input type="text" class="form-control total_price_hidden" name="total_price" readonly hidden>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <input type="button" class="btn btn-dark add-item" value="+ Add More Item">
                                        </div><br>
                                        <div class="table-responsive my-5">
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
                                                            <input type="button" class="btn btn-danger delete" value="x">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="2" class="text-right">
                                                            <h5><strong>Total</strong></h5>
                                                            </h5>
                                                        <td colspan="2">
                                                            <input type="text" class="form-control total_cost_display" readonly>
                                                            <input type="text" class="form-control total_cost_hidden" name="total_cost" readonly hidden>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <input type="button" class="btn btn-dark add-cost" value="+ Add More Cost">
                                        </div>
                                        <div class="form-group">
                                            <div class="form-horizontal form-label-left">
                                                <div class="col-md-6">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="memoForm">Grand Total</label>
                                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                                        <input type="text" class="form-control total_grand_display" readonly>
                                                        <input type="text" class="form-control total_grand_hidden" name="total_grand" readonly hidden>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>-->
                            <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="discount-tab">
                                <div class="x_panel">
                                    <div class="x_content">
                                        <div class="table-responsive">
                                            <table class="table table-striped jambo_table bulk_action">
                                                <thead>
                                                    <tr class="headings">
                                                        <th class="column-title">@lang('product_1.create.tab_2.col_1')</th>
                                                        <th class="column-title">@lang('product_1.create.tab_2.col_2')</th>
                                                    </tr>
                                                </thead>
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
                                                        <th class="column-title" style="width: 350px">@lang('product_1.create.tab_3.col_1')</th>
                                                        <th class="column-title" style="width: 350px">@lang('product_1.create.tab_3.col_2')</th>
                                                        <th class="column-title" style="width: 350px">@lang('product_1.create.tab_3.col_3')</th>
                                                        <th class="column-title" style="width: 50px"></th>
                                                    </tr>
                                                </thead>
                                                <tbody class="neworderbody_production">
                                                    <tr>
                                                        <td>
                                                            <div class="form-group">
                                                                <select class="form-control select_product_production product_id_production" name="product_id_production[]">
                                                                    <option></option>
                                                                </select>
                                                                <input class="selected_product_id_production" hidden>
                                                                <input class="tampungan_product_id_production" name="product_id_production2[]" hidden>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input onClick="this.select();" type="number" class="form-control qty_production" name="product_qty_production[]" value="0">
                                                        </td>
                                                        <td>
                                                            <input onClick="this.select();" type="text" class="form-control product_price_display_production" value="0">
                                                            <input type="text" class="hidden_product_price_production" name="product_price_production[]" value="0" hidden>
                                                        </td>
                                                        <td>
                                                            <input type="button" class="btn btn-danger delete_production" value="x">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <input type="button" class="btn btn-dark add-item_production" value="@lang('product_1.create.tab_3.more')">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 text-center">
                        <div class="form-group">
                            <button class="btn btn-primary" type="button" onclick="window.location.href = '/products';">@lang('product_1.create.cancel')</button>
                            <div class="btn-group">
                                <button id="click" type="button" class="btn btn-success">@lang('product_1.create.create')</button>
                                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a id="clicknew">@lang('product_1.create.create_new')</a>
                                    </li>
                                    <li><a id="click">@lang('product_1.create.create')</a>
                                    </li>
                                </ul>
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
<script src="{{asset('js/products/products/addmoreitem_product_bundle.js?v=5-20200319-0916') }}" charset="utf-8"></script>
<script src="{{asset('js/products/products/addmoreitem_production_bundle.js?v=5-20200319-0916') }}" charset="utf-8"></script>
<script src="{{asset('js/products/products/createForm.js?v=5-20200319-0916') }}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js?v=5-20200319-0916') }}" charset="utf-8"></script>
<script>
    $(document).ready(function() {
        $('#product-tab').removeAttr("data-toggle", "tab");
        $('#discount-tab').removeAttr("data-toggle", "tab");
        $('#production-tab').removeAttr("data-toggle", "tab");
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
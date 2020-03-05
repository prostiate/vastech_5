@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Create Product / Service JOYDAY</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="post" id="formCreate">
                    <div id="demo-form2" class="form-horizontal form-label-left">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name_product">Product Name <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input placeholder="Product Name" type="text" id="name_product" name="name_product" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="code_product">Code / SKU
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input placeholder="Code / SKU" type="text" id="code_product" name="code_product" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category_product">Category
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select id="category_product" name="category_product" class="form-control col-md-12 col-xs-12 selectcategory">
                                    @foreach($categories as $a)
                                    <option value="{{$a->id}}">
                                        {{$a->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="unit_product">Unit
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select id="unit_product" name="unit_product" class="form-control col-md-12 col-xs-12 selectunit">
                                    @foreach($units as $a)
                                    <option value="{{$a->id}}">
                                        {{$a->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="desc_product">Description
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input placeholder="Description" type="text" id="desc_product" name="desc_product" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="desc_product">Market
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="market" class="form-control col-md-7 col-xs-12 selectidenfitytype">
                                    @hasrole('Owner|GT')
                                    <option value="GT">General Trade (GT)</option>
                                    @endrole
                                    @hasrole('Owner|MT')
                                    <option value="MT">Modern Trade (MT)</option>
                                    @endrole
                                    @hasrole('Owner|WS')
                                    <option value="WS">Wall Saler (WS)</option>
                                    @endrole
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="desc_product">Bundle
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="">
                                    <label>
                                        <input type="checkbox" class="js-switch" value="1" id="is_bundle" name="is_bundle" />
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#tab_content1" role="tab" id="invoice-tab" data-toggle="tab" aria-expanded="true">Price & Setting</a>
                            </li>
                            <li role="presentation"><a href="#tab_content2" role="tab" id="product-tab" aria-expanded="false">Product Bundle</a>
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
                                                                <input type="checkbox" class="js-switch" value="1" name="is_buy" checked /> I Buy This Item
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
                                                                    <option value="{{$a->id}}" @if($a->id == $default_buy_account->account_id) selected="selected" @endif>
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
                                                                    <option value="{{$a->id}}">
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
                                                                <input type="checkbox" class="js-switch" value="1" name="is_sell" checked /> I Sell This Item
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
                                                                    <option value="{{$a->id}}" @if($a->id == $default_sell_account->account_id) selected="selected" @endif>
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
                                                                    <option value="{{$a->id}}">
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
                                                                <input type="checkbox" class="js-switch" value="1" name="is_track" checked /> I Track Stock for This Item
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
                                                                    <option value="{{$a->id}}">
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
                            <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="product-tab">
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
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">
                            <button class="btn btn-primary" type="button" onclick="window.location.href = '/products';">Cancel</button>
                            <div class="btn-group">
                                <button id="click" type="button" class="btn btn-success">Create </button>
                                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a id="clicknew">Create & New </a>
                                    </li>
                                    <li><a id="click">Create </a>
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
<script src="{{asset('js/request/joyday/products/addmoreitem.js?v=5-20200305-1546') }}" charset="utf-8"></script>
<script src="{{asset('js/request/joyday/products/createForm.js?v=5-20200305-1546') }}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js?v=5-20200305-1546') }}" charset="utf-8"></script>
<script>
    $(document).ready(function() {
        $('input[type="checkbox"]').click(function() {
            if ($(this).prop("checked") == true) {
                $('#product-tab').attr("data-toggle", "tab");
            } else if ($(this).prop("checked") == false) {
                $('#product-tab').removeAttr("data-toggle", "tab");
                $('#myTab a[href="#tab_content1"]').tab('show');
            }
        });
    });
</script>
@endpush
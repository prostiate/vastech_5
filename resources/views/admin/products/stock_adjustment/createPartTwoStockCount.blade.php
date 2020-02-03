@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Create Stock Adjustment</h2>
                <!--<ul class="nav navbar-right panel_toolbox">
                    <li>
                        <button class="btn btn-dark dropdown-toggle" type="button" onclick="window.location.href = '#';">Preview Stock card PDF
                        </button>
                    </li>
                    <li>
                        <button class="btn btn-dark dropdown-toggle" type="button" onclick="window.location.href = '#';">Preview Stock Card Excel
                        </button>
                    </li>
                </ul>-->
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="post" id="formCreate" class="form-horizontal">
                    <br>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Adjustment Type</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>@if($adtype == 1) Stock Count @else Stock In / Out @endif</h5>
                                    <input hidden type="text" name="type" value="{{$adtype}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Adjustment Date</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$today}}" type="text" class="form-control" name="trans_date" id="datepicker1">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Category</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select id="adjustment_category" name="adjustment_category" class="form-control col-md-7 col-xs-12 selectadjustmentcategory">
                                        <option value="General" @if($adcat=='General' ) selected @endif>General</option>
                                        <option value="Waste" @if($adcat=='Waste' ) selected @endif>Waste</option>
                                        <option value="Production" @if($adcat=='Production' ) selected @endif>Production</option>
                                        <option value="Opening Quantity" @if($adcat=='Opening Quantity' ) selected @endif>Opening Quantity</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Warehouse</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5><a href="/warehouses/{{$warehouses->id}}">{{$warehouses->name}}</a></h5>
                                    <input type="text" name="warehouse" value="{{$warehouses->id}}" hidden>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Account</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control selectaccount" name="account">
                                        @foreach($accounts as $a)
                                        <option value="{{$a->id}}">
                                            ({{$a->code}}) - {{$a->name}} ({{$a->coa_category->name}})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Memo</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <textarea rows="4" class="form-control" name="memo"></textarea>
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
                                    <th class="column-title" style="width:500px">Product Name</th>
                                    <th class="column-title" style="width:200px">Product Code</th>
                                    <th class="column-title" style="width:200px">Recorded Quantity</th>
                                    <th class="column-title" style="width:200px">Actual Quantity</th>
                                    <th class="column-title" style="width:200px">Average Price</th>
                                    <th class="column-title" style="width:50px"></th>
                                </tr>
                            </thead>
                            <tbody class="neworderbody1">
                                <tr>
                                    <td>
                                        <select name="product[]" class="form-control selectproduct_normal product_id">
                                            <option></option>
                                            @foreach($warehouse_detail_from as $a)
                                            <option value="{{$a->product_id}}" code="{{$a->product->code}}" qty="{{$a->qty}}" avgprice="{{$a->product->avg_price}}">
                                                {{$a->product->code}} - {{$a->product->name}} - {{$a->product->avg_price}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <h5 class="product_code"></h5>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control recorded_qty" name="recorded_qty[]" readonly>
                                    </td>
                                    <td>
                                        <input onClick="this.select();" value="0" type="number" class="form-control" name="actual_qty[]">
                                    </td>
                                    <td>
                                        <input onClick="this.select();" type="text" class="form-control avg_price_display" readonly>
                                        <input type="text" class="form-control avg_price" name="avg_price[]" hidden>
                                    </td>
                                    <td>
                                        <input type="button" class="btn btn-danger delete" value="x">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <input type="button" class="btn btn-dark add-item" value="+ Add More Item">
                    </div>
                    <br>
                    <div class="col-md-2 center-margin">
                        <div class="form-group">
                            <a href="{{ url('/stock_adjustment/new') }}" class="btn btn-danger">Back</a>
                            <div class="btn-group">
                                <button id="click" type="button" class="btn btn-success">Create</button>
                            </div>
                        </div>
                    </div>
                    <!--hidden input for default account-->
                    <input type="text" class="di" value="{{$default_inventory1->account_id}}" name="default_inventory" hidden>
                    <input type="text" class="dig" value="{{$default_inventory2->account_id}}" name="default_inventory_general" hidden>
                    <input type="text" class="diw" value="{{$default_inventory3->account_id}}" name="default_inventory_waste" hidden>
                    <input type="text" class="dip" value="{{$default_inventory4->account_id}}" name="default_inventory_production" hidden>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{asset('js/other/select2.js?v=5-03022020') }}" charset="utf-8"></script>
<script src="{{asset('js/other/zebradatepicker.js?v=5-03022020') }}" charset="utf-8"></script>
<script src="{{asset('js/products/stock_adjustment/createFormStockCount.js?v=5-03022020') }}" charset="utf-8"></script>
<script src="{{asset('js/products/stock_adjustment/addmoreitemStockCount.js?v=5-03022020') }}" charset="utf-8"></script>
<script src="{{asset('js/products/stock_adjustment/category_to_account.js?v=5-03022020') }}" charset="utf-8"></script>
@endpush
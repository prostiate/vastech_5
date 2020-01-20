@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Update Stock Adjustment</h2>
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
                                    <h5>Stock Count</h5>
                                    <input hidden type="text" name="type" value="1">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Adjustment Date</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$header->date}}" type="text" class="form-control" name="trans_date" id="datepicker1">
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
                                        <option value="General" @if($header->adjustment_type =='General' ) selected @endif>General</option>
                                        <option value="Waste" @if($header->adjustment_type =='Waste' ) selected @endif>Waste</option>
                                        <option value="Production" @if($header->adjustment_type =='Production' ) selected @endif>Production</option>
                                        <option value="Opening Quantity" @if($header->adjustment_type =='Opening Quantity' ) selected @endif>Opening Quantity</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Warehouse</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5><a href="/warehouses/{{$header->warehouse_id}}">{{$header->warehouse->name}}</a></h5>
                                    <input type="text" name="warehouse" value="{{$header->warehouse_id}}" hidden>
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
                                        <option value="{{$a->id}}" @if($header->coa_id == $a->id) selected @endif>
                                            ({{$a->code}}) - {{$a->name}} ({{$a->coa_category->name}})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Memo</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <textarea rows="4" class="form-control" name="memo">{{$header->memo}}</textarea>
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
                                @foreach($details as $a)
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <h5><a href="/products/{{$a->product_id}}"> {{$a->product->name}} </a></h5>
                                            <input type="text" value="{{$a->product_id}}" class="product_id form-control" name="product_id[]" hidden>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <h5> {{$a->product->code}} </h5>
                                            <input type="text" value="{{$a->product->code}}" class="product_code form-control" name="product_code[]" hidden>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <h5> {{$a->recorded}} </h5>
                                            <input type="text" value="{{$a->recorded}}" class="recorded_qty form-control" name="recorded_qty[]" hidden>
                                        </div>
                                    </td>
                                    <td>
                                        <input value="{{$a->actual}}" type="text" class="actual_qty form-control" name="actual_qty[]">
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input onClick="this.select();" type="text" value="{{$a->avg_price}}" class="avg_price_display form-control">
                                            <input type="text" value="{{$a->avg_price}}" class="avg_price_hidden" name="avg_price[]">
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <input type="button" class="btn btn-dark add-item" value="+ Add More Item">
                    </div>
                    <br>
                    <div class="col-md-2 center-margin">
                        <div class="form-group">
                            <a href="{{ url('/stock_adjustment/'.$header->id) }}" class="btn btn-danger">Cancel</a>
                            <div class="btn-group">
                                <button id="click" type="button" class="btn btn-success">Update</button>
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
<script src="{{asset('js/other/select2.js')}}" charset="utf-8"></script>
<script src="{{asset('js/other/zebradatepicker.js') }}" charset="utf-8"></script>
<script src="{{asset('js/products/stock_adjustment/createFormStockCount.js')}}" charset="utf-8"></script>
<script src="{{asset('js/products/stock_adjustment/addmoreitemStockCount.js')}}" charset="utf-8"></script>
<script src="{{asset('js/products/stock_adjustment/category_to_account.js')}}" charset="utf-8"></script>
@endpush
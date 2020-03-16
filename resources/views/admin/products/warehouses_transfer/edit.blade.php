@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>@lang('product_4.edit.title')</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="post" id="formCreate" class="form-horizontal">
                    <br>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left text-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">@lang('product_4.edit.from')</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <a href="/warehouses/{{$wt->from_warehouse_id}}">
                                        <h5>{{$wt->from_warehouse->name}}</h5>
                                    </a>
                                    <input value="{{$wt->from_warehouse_id}}" type="text" name="from_warehouse" hidden>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">@lang('product_4.edit.trans_date')</label>
                                <div class="col-md-7 xdisplay_inputx form-group has-feedback">
                                    <input value="{{$wt->transaction_date}}" type="text" class="form-control" name="transfer_date" id="datepicker1">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">@lang('product_4.edit.to')</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <a href="/warehouses/{{$wt->to_warehouse_id}}">
                                        <h5>{{$wt->to_warehouse->name}}</h5>
                                    </a>
                                    <input value="{{$wt->to_warehouse_id}}" type="text" name="to_warehouse" hidden>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">@lang('product_4.edit.memo')</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <textarea rows="4" class="form-control" name="memo">{{$wt->memo}}</textarea>
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
                                    <th class="column-title" style="width:300px">@lang('product_4.edit.col_1')</th>
                                    <!--<th class="column-title" style="width:150px">Qty Before</th>
                                    <th class="column-title" style="width:150px">Qty After</th>-->
                                    <th class="column-title" style="width:200px">@lang('product_4.edit.col_2')</th>
                                    <th class="column-title" style="width:50px"></th>
                                </tr>
                            </thead>
                            <tbody class="neworderbody">
                                @foreach($wti as $wtii)
                                <tr>
                                    <td>
                                        <select name="product[]" class="form-control col-md-12 col-xs-12 selectproduct_normal product_id">
                                            <option></option>
                                            @foreach($warehouse_detail_from as $a)
                                            <option value="{{$a->product_id}}" @if($a->product_id == $wtii->product_id) selected @endif>
                                                {{$a->product->name}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <!--<td>
                                        <input type="text" class="qty_before form-control" name="qty_before" readonly>
                                    </td>
                                    <td>
                                        <input type="text" class="qty_after form-control" name="qty_after" readonly>
                                    </td>-->
                                    <td>
                                        <input value="{{$wtii->qty}}" type="text" class="qty_transfer form-control" name="qty[]">
                                    </td>
                                    <td>
                                        <input type="button" class="delete btn btn-danger" value="x">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <input type="button" class="btn btn-dark add-item" value="@lang('product_4.edit.more')">
                    </div>
                    <br>
                    <div class="col-md-12 text-center">
                        <div class="form-group">
                            <a href="/warehouses_transfer/{{$wt->id}}" class="btn btn-danger">@lang('product_4.edit.back')</a>
                            <div class="btn-group">
                                <button id="click" type="button" class="btn btn-success">@lang('product_4.edit.update')</button>
                                <input value="{{$wt->number}}" type="text" name="trans_no" hidden>
                                <input value="{{$wt->id}}" type="text" name="hidden_id" hidden>
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
<script src="{{asset('js/products/warehouse_transfer_list/addmoreitem.js?v=5-20200315-0243') }}" charset="utf-8"></script>
<script src="{{asset('js/products/warehouse_transfer_list/updateForm.js?v=5-20200315-0243') }}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js?v=5-20200315-0243') }}" charset="utf-8"></script>
<script src="{{asset('js/other/zebradatepicker.js?v=5-20200315-0243') }}" charset="utf-8"></script>
@endpush
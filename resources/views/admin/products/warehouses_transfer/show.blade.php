@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3><b>@lang('product_4.show.title'){{$wt->number}}</b></h3>
                <a>Status: </a>
                @if($wt->status == 1)
                <span class="label label-warning" style="color:white;">Open</span>
                @elseif($wt->status == 2)
                <span class="label label-success" style="color:white;">Closed</span>
                @elseif($wt->status == 3)
                <span class="label label-success" style="color:white;">Paid</span>
                @elseif($wt->status == 4)
                <span class="label label-warning" style="color:white;">Partial</span>
                @elseif($wt->status == 5)
                <span class="label label-danger" style="color:white;">Overdue</span>
                @elseif($wt->status == 6)
                <span class="label label-success" style="color:white;">Sent</span>
                @elseif($wt->status == 7)
                <span class="label label-success" style="color:white;">Active</span>
                @elseif($wt->status == 8)
                <span class="label label-success" style="color:white;">Sold</span>
                @elseif($wt->status == 9)
                <span class="label label-success" style="color:white;">Disposed</span>
                @endif
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="post" id="formCreate" class="form-horizontal">
                    <br>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left text-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">@lang('product_4.show.from')</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <a href="/warehouses/{{$wt->from_warehouse_id}}">
                                        <h5>{{$wt->from_warehouse->name}}</h5>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">@lang('product_4.show.trans_date')</label>
                                <div class="col-md-7 xdisplay_inputx form-group has-feedback">
                                    <a>
                                        <h5>{{$wt->transaction_date}}</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">@lang('product_4.show.to')</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <a href="/warehouses/{{$wt->to_warehouse_id}}">
                                        <h5>{{$wt->to_warehouse->name}}</h5>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">@lang('product_4.show.memo')</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <a>
                                        <h5>{{$wt->memo}}</h5>
                                    </a>
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
                                    <th class="column-title" style="width:300px">@lang('product_4.show.col_1')</th>
                                    <!--<th class="column-title" style="width:150px">Qty Before</th>
                                    <th class="column-title" style="width:150px">Qty After</th>-->
                                    <th class="column-title" style="width:200px">@lang('product_4.show.col_2')</th>
                                </tr>
                            </thead>
                            <tbody class="neworderbody">
                                @foreach($wti as $a)
                                <tr>
                                    <td>
                                        <a>{{$a->product->name}}</a>
                                    </td>
                                    <!--<td>
                                        <input type="text" class="qty_before form-control" name="qty_before" readonly>
                                    </td>
                                    <td>
                                        <input type="text" class="qty_after form-control" name="qty_after" readonly>
                                    </td>-->
                                    <td>
                                        <a>{{$a->qty}}</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <div class="col-md-3 center-margin">
                        <div class="form-group">
                            <a href="/warehouses_transfer" class="btn btn-dark">@lang('product_4.show.back')</a>
                            @hasrole('Owner|Ultimate|Warehouse Transfer')
                            @can('Delete')
                            <button type="button" class="btn btn-danger" id="click">@lang('product_4.show.delete')</button>
                            @endcan
                            @can('Edit')
                            <div class="btn-group">
                                <button class="btn btn-success" type="button" onclick="window.location.href = '/warehouses_transfer/edit/' + {{$wt->id}};">@lang('product_4.show.edit')
                                </button>
                            </div>
                            @endcan
                            @endrole
                            <input type="text" value="{{$wt->id}}" id="form_id" hidden>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/products/warehouse_transfer_list/deleteForm.js?v=5-20200305-1546') }}" charset="utf-8"></script>
@endpush
@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><b>{{$header->adjustment_type}} - @lang('product_2.show.title'){{$header->number}}</b></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <button class="btn btn-dark dropdown-toggle" type="button" onclick="window.location.href = '#';" data-toggle="modal" data-target=".bs-example-modal-lg-2">@lang('product_2.show.vje')
                        </button>
                        <div class="modal fade bs-example-modal-lg-2" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                        </button>
                                        <h5 class="modal-title" id="myModalLabel">@lang('product_2.show.jr')</h5>
                                        <h3 class="modal-title" id="myModalLabel"><strong>@lang('product_2.show.title'){{$header->number}}</strong></h3>
                                    </div>
                                    <div class="modal-body">
                                        <div class="table-responsive my-5">
                                            <table id="example" class="table table-striped jambo_table bulk_action">
                                                <thead>
                                                    <tr class="headings">
                                                        <th class="column-title" style="width:200px">@lang('product_2.show.table_2.col_1')</th>
                                                        <th class="column-title" style="width:250px">@lang('product_2.show.table_2.col_2')</th>
                                                        <th class="column-title" style="width:150px">@lang('product_2.show.table_2.col_3')</th>
                                                        <th class="column-title" style="width:150px">@lang('product_2.show.table_2.col_4')</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="neworderbody">
                                                    @foreach ($get_all_detail as $po)
                                                    <tr>
                                                        <td>
                                                            <a href="{{ url('/chart_of_accounts/'.$po->coa_id) }}">{{$po->coa->code}}</a>
                                                        </td>
                                                        <td>
                                                            <a href="{{ url('/chart_of_accounts/'.$po->coa_id) }}">{{$po->coa->name}}</a>
                                                        </td>
                                                        <td>
                                                            @if($po->debit == 0)
                                                            @else
                                                            <a>Rp @number($po->debit)</a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($po->credit == 0)
                                                            @else
                                                            <a>Rp @number($po->credit)</a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    <tr class="headings">
                                                        <td>
                                                            <strong><b>Total</b></strong>
                                                        </td>
                                                        <td>
                                                        </td>
                                                        <td>
                                                            <strong><b>Rp @number($total_debit)</b></strong>
                                                        </td>
                                                        <td>
                                                            <strong><b>Rp @number($total_credit)</b></strong>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <input type="button" class="btn btn-dark add" value="+ Add More Item" hidden>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-dark" data-dismiss="modal">@lang('product_2.show.close')</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="post" id="formCreate" class="form-horizontal">
                    <br>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang('product_2.show.type_1')</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$header->adjustment_type}}</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang('product_2.show.adjust_date')</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$header->date}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang('product_2.show.account')</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$header->coa->name}}</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang('product_2.show.warehouse')</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$header->warehouse->name}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang('product_2.show.memo')</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$header->memo}}</h5>
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
                                    <th class="column-title" style="width:200px">@lang('product_2.show.table.col_1')</th>
                                    <th class="column-title" style="width:150px">@lang('product_2.show.table.col_2')</th>
                                    <th class="column-title" style="width:150px">@lang('product_2.show.table.col_3')</th>
                                    <th class="column-title" style="width:150px">@lang('product_2.show.table.col_4')</th>
                                    <th class="column-title" style="width:150px">@lang('product_2.show.table.col_5')</th>
                                    <th class="column-title" style="width:150px">@lang('product_2.show.table.col_6')</th>
                                </tr>
                            </thead>
                            <tbody class="neworderbody">
                                @foreach($details as $a)
                                <tr>
                                    <td>
                                        <a href="/products/{{$a->product_id}}">{{$a->product->name}}</a>
                                    </td>
                                    <td>
                                        {{$a->product->code}}
                                    </td>
                                    <td>
                                        {{$a->recorded}}
                                    </td>
                                    <td>
                                        {{$a->actual}}
                                    </td>
                                    <td>
                                        {{$a->difference}}
                                    </td>
                                    <td>
                                        Rp @number($a->product->avg_price)
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <div class="col-md-12 text-center">
                        <div class="form-group">
                            <a href="{{ url('/stock_adjustment') }}" class="btn btn-dark">@lang('product_2.show.cancel')</a>
                            <button type="button" class="btn btn-danger" id="click">@lang('product_2.show.delete')</button>
                            <input type="text" value="{{$header->id}}" id="form_id" hidden>
                            <!--<div class="btn-group">
                                <a href="{{ url('/stock_adjustment/edit/stock_count/'.$header->id) }}" class="btn btn-success">Edit</a>
                            </div>-->
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/products/stock_adjustment/deleteForm.js?v=5-20200312-1327') }}" charset="utf-8"></script>
@endpush
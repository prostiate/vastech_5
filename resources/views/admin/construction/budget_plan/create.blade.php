@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>@lang('construction.create_bp.title')</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="post" id="formCreate" class="form-horizontal">
                    <br>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang('construction.create_bp.number')</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$header_area->budget_plan->number}}</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang('construction.create_bp.date')</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$header_area->budget_plan->date}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang('construction.create_bp.project_name')</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5><a href="/construction/budget_plan/area/{{$header_area->budget_plan->id}}">{{$header_area->budget_plan->project->name}}</a></h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang('construction.create_bp.address')</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$header_area->budget_plan->address}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang('construction.create_bp.area_name')</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control selectproject" onChange="window.location.href=this.value">
                                        @foreach($get_area as $a)
                                        <option value="/construction/budget_plan/new/area_id={{$a->id}}" @if($a->id == $header_area->id) selected @endif>{{$a->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="table-responsive">
                        <table class="table table-striped jambo_table bulk_action">
                            <tbody>
                                <thead>
                                    <tr class="headings">
                                        <th class="column-title" style="width: 350px">@lang('construction.create_bp.table.col_1')</th>
                                        <th class="column-title" style="width: 150px">@lang('construction.create_bp.table.col_2')</th>
                                        <th class="column-title" style="width: 150px">@lang('construction.create_bp.table.col_3')</th>
                                        <th class="column-title text-center" style="width: 350px">@lang('construction.create_bp.table.col_4')</th>
                                        <th class="column-title text-center" style="width: 350px">@lang('construction.create_bp.table.col_5')</th>
                                        <th class="column-title" style="width: 50px"></th>
                                    </tr>
                                </thead>
                            <tbody class="neworderbody">
                                <tr class="head" hidden>
                                    <td>
                                        <input type="text" name="budget_plan_detail_id[]" hidden>
                                        <input type="text" name="budget_plan_detail_duration[]" hidden>
                                        <input class="budget_plan_detail_price" type="text" name="budget_plan_detail_price[]" hidden>
                                    <td>
                                </tr>
                                    @if($header_detail->count() > 0)
                                        @foreach($header_detail as $item)
                                            @if($loop->first)
                                                <tr class="initialtr">
                                                    <td>
                                                        <div class="form-group">
                                                            <select class="select_product form-control product_id" name="product[]">
                                                                <option>{{$item->product->name}}</option>
                                                            </select>
                                                            <input class="selected_product_id" hidden>
                                                            <input class="selected_product_unit" hidden>
                                                            <input class="tampungan_product_id" name="product2[]" value="{{$item->product_id}}" hidden>
                                                            <input class="tampungan_product_unit" hidden>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <select class="selectunit form-control unit" name="unit[]">
                                                                @foreach($unit as $a)
                                                                <option value="{{$a->id}}" @if($a->id == $item->unit_id) selected @endif>
                                                                    {{$a->name}}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input value="{{$item->qty}}" onClick="this.select();" type="text" class="form-control qty" name="quantity[]" value="0">
                                                    </td>
                                                    <td>
                                                        <input value="{{$item->amount}}" onClick="this.select();" type="text" class="form-control price_display" name="price_display[]" value="0">
                                                        <input value="{{$item->amount}}" type="text" class="price_hidden" name="price[]" value="0" hidden>
                                                    </td>
                                                    <td>
                                                        <input value="{{$item->amounttotal}}" type="text" class="form-control total_price_display" value="0" readonly>
                                                        <input value="{{$item->amounttotal}}" type="text" class="total_price_hidden" name="total_price[]" value="0" hidden>
                                                    </td>
                                                    <td>
                                                        <input type="button" class="btn btn-dark add" value="+">
                                                    </td>
                                                </tr>
                                            @else
                                                <tr class="initialtr">
                                                    <td>
                                                        <div class="form-group">
                                                            <select class="select_product form-control product_id" name="product[]">
                                                                <option>{{$item->product->name}}</option>
                                                            </select>
                                                            <input class="selected_product_id" hidden>
                                                            <input class="selected_product_unit" hidden>
                                                            <input class="tampungan_product_id" name="product2[]" value="{{$item->product_id}}" hidden>
                                                            <input class="tampungan_product_unit" hidden>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <select class="selectunit form-control unit" name="unit[]">
                                                                @foreach($unit as $a)
                                                                <option value="{{$a->id}}" @if($a->id == $item->unit_id) selected @endif>
                                                                    {{$a->name}}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input value="{{$item->qty}}" onClick="this.select();" type="text" class="form-control qty" name="quantity[]" value="0">
                                                    </td>
                                                    <td>
                                                        <input value="{{$item->amount}}" onClick="this.select();" type="text" class="form-control price_display" name="price_display[]" value="0">
                                                        <input value="{{$item->amount}}" type="text" class="price_hidden" name="price[]" value="0" hidden>
                                                    </td>
                                                    <td>
                                                        <input value="{{$item->amounttotal}}" type="text" class="form-control total_price_display" value="0" readonly>
                                                        <input value="{{$item->amounttotal}}" type="text" class="total_price_hidden" name="total_price[]" value="0" hidden>
                                                    </td>
                                                    <td>
                                                        <input type="button" class="btn btn-danger delete" value="x">
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @else
                                        <tr class="initialtr">
                                            <td>
                                                <div class="form-group">
                                                    <select class="select_product form-control product_id" name="product[]">
                                                        <option></option>
                                                    </select>
                                                    <input class="selected_product_id" hidden>
                                                    <input class="selected_product_unit" hidden>
                                                    <input class="tampungan_product_id" name="product2[]" hidden>
                                                    <input class="tampungan_product_unit" hidden>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <select class="selectunit form-control unit" name="unit[]">
                                                        @foreach($unit as $a)
                                                        <option value="{{$a->id}}">
                                                            {{$a->name}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <input onClick="this.select();" type="text" class="form-control qty" name="quantity[]" value="0">
                                            </td>
                                            <td>
                                                <input onClick="this.select();" type="text" class="form-control price_display" name="price_display[]" value="0">
                                                <input type="text" class="price_hidden" name="price[]" value="0" hidden>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control total_price_display" value="0" readonly>
                                                <input type="text" class="total_price_hidden" name="total_price[]" value="0" hidden>
                                            </td>
                                            <td>
                                                <input type="button" class="btn btn-dark add" value="+">
                                            </td>
                                        </tr>
                                    @endif
                                <tr class="warning" hidden>
                                    <td colspan="6" style="text-align: right">
                                        <small><strong>@lang('construction.create_bp.sub_total_warn')</strong></small>
                                    </td>
                                </tr>
                                <tr class="outputbody">
                                    <td colspan="4" style="text-align: right">
                                        <h4><strong>@lang('construction.create_bp.grand_total')</strong></h4>
                                    </td>
                                    <td colspan="2">
                                        <input type="text" class="form-control sub_display" value="0" readonly>
                                        <input type="text" class="sub_hidden" name="subtotal" value="0" hidden>
                                    </td>
                                </tr>
                            </tbody>
                            </tbody>
                            <tfoot hidden>
                                <tr>
                                    <td colspan="4" style="text-align: right">
                                        <h4><strong>@lang('construction.create_bp.grand_total')</strong></h4>
                                    </td>
                                    <td colspan="2">
                                        <input type="text" class="form-control grandtotal_display" value="0" readonly>
                                        <input type="text" class="grandtotal_hidden" name="grandtotal" value="0" hidden>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="col-md-12 text-center">
                        <div class="form-group">
                            <button class="btn btn-primary" type="button" onclick="window.location.href = '/construction/budget_plan/area/{{$header_area->budget_plan->id}}';">@lang('construction.create_bp.cancel')</button>
                            <div class="btn-group">
                                <button id="click" type="button" class="btn btn-success">@lang('construction.create_bp.save')</button>
                                <input type="text" name="hidden_area_id" value="{{$header_area->id}}" hidden>
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
<script src="{{asset('js/construction/budget_plans/addmoreitem2.js?v=5-20200315-0243') }}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js?v=5-20200315-0243') }}" charset="utf-8"></script>
<script src="{{asset('js/construction/budget_plans/createForm.js?v=5-20200315-0243') }}" charset="utf-8"></script>
<script src="{{asset('js/other/zebradatepicker.js?v=5-20200315-0243') }}" charset="utf-8"></script>
@endpush
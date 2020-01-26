@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Station One</h2>
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Production Date</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$today}}" type="date" class="form-control" id="datepicker1" name="trans_date">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Result Product</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input onClick="this.select();" type="text" class="form-control" name="result_product">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Contact</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control selectcontact" name="contact">
                                        <option></option>
                                        @foreach ($contacts as $a)
                                        <option value="{{$a->id}}">
                                            {{$a->display_name}}
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Result Qty</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input onClick="this.select();" onchange="multiplier(this)" type="number" class="form-control result_qty" name="result_qty" value="0">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Warehouse</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control selectwarehouse" name="warehouse">
                                        <option></option>
                                        @foreach ($warehouses as $a)
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Result Unit</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control selectunit" name="result_unit">
                                        <option></option>
                                        @foreach ($units as $a)
                                        <option value="{{$a->id}}">
                                            {{$a->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="memoForm" style="text-align: left;">Description</label>
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
                                    <th class="column-title" style="width: 450px">Raw Material</th>
                                    <th class="column-title">Quantity</th>
                                    <th class="column-title" style="width: 350px">Amount</th>
                                    <th class="column-title" style="width: 50px"></th>
                                </tr>
                            </thead>
                            <tbody class="neworderbody1">
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <select class="form-control selectproduct product_id" name="raw_product[]">
                                                <option></option>
                                                @foreach ($products as $a)
                                                <option value="{{$a->id}}">
                                                    {{$a->name}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <input onClick="this.select();" type="number" class="form-control qty" name="raw_qty[]" value="0">
                                    </td>
                                    <td>
                                        <input onClick="this.select();" type="text" class="examount form-control" value="0">
                                        <input type="text" class="amount" name="raw_amount[]" value="0" hidden>
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
                                        <input type="text" class="form-control total_raw_display" readonly>
                                        <input type="text" class="form-control total_raw_hidden" name="total_raw" readonly hidden>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        <input type="button" class="btn btn-dark add-item" value="+ Add More Item">
                    </div>
                    <br>
                    <div class="table-responsive my-5">
                        <table id="example" class="table table-striped jambo_table bulk_action">
                            <thead>
                                <tr class="headings">
                                    <th class="column-title" style="width: 450px">Cost</th>
                                    <th class="column-title">Estimated Cost</th>
                                    <th class="column-title">Multiplier </th>
                                    <th class="column-title" style="width: 350px">Amount </th>
                                    <th class="column-title" style="width: 50px"></th>
                                </tr>
                            </thead>
                            <tbody class="neworderbody2">
                                <tr>
                                    <td>
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
                                        <input onClick="this.select();" type="text" class="form-control cost_est" value="0">
                                        <input type="text" class="hidden_cost_est" name="cost_est[]" value="0" hidden>
                                    </td>
                                    <td>
                                        <input id="cost_multi_display" onClick="this.select();" type="number" class="form-control cost_multi" value="0">
                                        <input id="cost_multi_hidden" type="text" class="hidden_cost_multi" name="cost_multi[]" value="0" hidden>
                                    </td>
                                    <td>
                                        <input onClick="this.select();" type="text" class="form-control cost_total">
                                        <input type="text" class="hidden_cost_total" name="cost_total[]" hidden>
                                    </td>
                                    <td>
                                        <input type="button" class="btn btn-danger delete" value="x">
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-right">
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
                    <br>
                    <div class="col-md-3 center-margin">
                        <div class="form-group">
                            <a href="{{ url('/production_one') }}" class="btn btn-danger">Cancel</a>
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
<script src="{{asset('js/products/production_one/station_one/createForm.js?v=5-26012020') }}" charset="utf-8"></script>
<script src="{{asset('js/products/production_one/station_one/addmoreitem.js?v=5-26012020') }}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js?v=5-26012020') }}" charset="utf-8"></script>
<script src="{{asset('js/other/zebradatepicker.js?v=5-26012020') }}" charset="utf-8"></script>
@endpush
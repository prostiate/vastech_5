@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Create New Bill of Quantities</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="post" id="formCreate" class="form-horizontal">
                    <br>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Number</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$trans_no}}" class="form-control" type="text" name="trans_no" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Date *</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$today}}" type="text" class="form-control" name="date" id="datepicker1">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Bill of Quantities Name *</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$header_bp->name}}" class="form-control" type="text" name="name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Address *</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$header_bp->address}}" class="form-control" type="text" name="address">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Budget Plan No</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5><a href="/construction/budget_plan/{{$header_bp->id}}">{{$header_bp->number}}</a></h5>
                                    <input value="{{$header_bp->id}}" type="text" name="budget_plan_id" id="budget_plan_id" hidden>
                                    <input value="{{$header_bp->offering_letter_id}}" type="text" name="offering_letter_id" id="offering_letter_id" hidden>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="table-responsive">
                        <table class="table table-striped jambo_table bulk_action">
                            <tbody>
                                @foreach($item_bp as $item)
                                <thead>
                                    <tr class="headings">
                                        <th colspan="2" class="column-title" style="width: 350px; text-align: center" data-toggle="tooltip" data-placement="top" data-original-title="Working Detail">{{$item->name}}</th>
                                        <th colspan="2" class="column-title" style="width: 350px; text-align: center" data-toggle="tooltip" data-placement="top" data-original-title="Duration">{{$item->duration}}</th>
                                        <th colspan="2" class="column-title" style="width: 350px; text-align: center" data-toggle="tooltip" data-placement="top" data-original-title="Budget Plan Total Price"><?php echo 'Rp ' . number_format($item->amount, 2, ',', '.') ?></th>
                                    </tr>
                                </thead>
                                <tr class="headings">
                                    <th class="column-title" style="width: 350px">Product</th>
                                    <th class="column-title" style="width: 150px">Unit</th>
                                    <th class="column-title" style="width: 150px">Quantity</th>
                                    <th class="column-title" style="width: 350px">Price</th>
                                    <th class="column-title" style="width: 350px">Total Price</th>
                                    <th class="column-title" style="width: 50px"></th>
                                </tr>
                            <tbody class="neworderbody">
                                <tr class="head" hidden>
                                    <td>
                                        <input value="{{$item->id}}" type="text" name="budget_plan_detail_id[]" hidden>
                                        <input value="{{$item->duration}}" type="text" name="budget_plan_detail_duration[]" hidden>
                                        <input class="budget_plan_detail_price" value="{{$item->amount}}" type="text" name="budget_plan_detail_price[]" hidden>
                                    <td>
                                </tr>
                                <tr class="initialtr">
                                    <td>
                                        <div class="form-group">
                                            <select class="select_product form-control product_id" name="product[]">
                                                <option></option>
                                            </select>
                                            <input class="selected_product_id" hidden>
                                            <input class="selected_product_unit" hidden>
                                            <input class="tampungan_product_id" hidden>
                                            <input class="tampungan_product_unit" hidden>
                                        </div>
                                        <input value="{{$item->id}}" type="text" name="item_budget_plan_id[]" class="item_budget_plan_id" hidden>
                                        <input value="{{$item->offering_letter_detail_id}}" type="text" name="item_offering_letter_id[]" class="item_offering_letter_id" hidden>
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
                                <tr class="warning" hidden>
                                    <td colspan="6" style="text-align: right">
                                        <small><strong>Sub total cannot be more than the price that already assigned.</strong></small>
                                    </td>
                                </tr>
                                <tr class="outputbody">
                                    <td colspan="4" style="text-align: right">
                                        <h4><strong>Sub Total</strong></h4>
                                    </td>
                                    <td colspan="2">
                                        <input type="text" class="form-control sub_display" value="0" readonly>
                                        <input type="text" class="sub_hidden" name="subtotal[]" value="0" hidden>
                                    </td>
                                </tr>
                            </tbody>
                            @endforeach
                            </tbody>
                            <tfoot hidden>
                                <tr>
                                    <td colspan="4" style="text-align: right">
                                        <h4><strong>Grand Total</strong></h4>
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
                            <button class="btn btn-primary" type="button" onclick="window.location.href = '/construction/budget_plan/{{$header_bp->id}}';">Cancel</button>
                            <div class="btn-group">
                                <button id="click" type="button" class="btn btn-success">Create</button>
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
<script src="{{asset('js/construction/bill_quantities/addmoreitem.js?v=5-20200305-1546') }}" charset="utf-8"></script>
<script src="{{asset('js/construction/bill_quantities/createForm.js?v=5-20200305-1546') }}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js?v=5-20200305-1546') }}" charset="utf-8"></script>
<script src="{{asset('js/other/zebradatepicker.js?v=5-20200305-1546') }}" charset="utf-8"></script>
@endpush
@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Create New Progress</h2>
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Progress Name *</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$header_fo->name}}" class="form-control" type="text" name="name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Address *</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$header_fo->name}}" class="form-control" type="text" name="address">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Form Order No</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5><a href="/construction/form_order/{{$header_fo->id}}">{{$header_fo->number}}</a></h5>
                                    <input value="{{$header_fo->id}}" type="text" name="form_order_id" id="form_order_id" hidden>
                                    <input value="{{$header_bq->id}}" type="text" name="bill_quantities_id" id="bill_quantities_id" hidden>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="table-responsive">
                        <table class="table table-striped jambo_table bulk_action">
                            <tbody>
                                @foreach($grouped as $item)
                                <thead>
                                    <tr class="headings">
                                        <th colspan="5" class="column-title" style="width: 350px; text-align: center" data-toggle="tooltip" data-placement="top" data-original-title="Working Description">{{$item[0]->offering_letter_detail->name}}</th>
                                    </tr>
                                </thead>
                                <tr class="headings">
                                    <th class="column-title" style="width: 350px">Working Detail</th>
                                    <th class="column-title" style="width: 150px">Duration (month)</th>
                                    <th class="column-title" style="width: 150px">Current Progress (month)</th>
                                    <th class="column-title" style="width: 150px">Progress Real (%)</th>
                                    <th class="column-title" style="width: 150px">Lateness (%)</th>
                                </tr>
                                <?php $subtotal = 0; ?>
                                @foreach($item as $item)
                                <?php $subtotal += $item->amount; ?>
                            <tbody class="neworderbody">
                                <tr>
                                    <td>
                                        {{$item->name}}
                                        <input value="{{$item->id}}" type="text" name="budget_plan_detail_id[]" hidden>
                                        <input value="{{$item->duration}}" type="text" name="budget_plan_detail_duration[]" hidden>
                                        <input value="{{$item->amount}}" type="text" name="budget_plan_detail_price[]" hidden>
                                    </td>
                                    <td>
                                        {{$item->duration}}
                                        <input value="{{$item->duration}}" class="form-control order_duration" name="duration[]" hidden>
                                    </td>
                                    <td>
                                        <input onClick="this.select();" type="number" min="0" class="form-control order_days" name="days[]" value="0" data-toggle="tooltip" data-placement="left" data-original-title="Progress : 0 %">
                                    </td>
                                    <td>
                                        <input onClick="this.select();" type="number" min="0" max="100" class="form-control order_progress" name="progress[]" value="0">
                                    </td>
                                    <td>
                                        <input onClick="this.select();" type="text" class="form-control order_late" name="late[]" value="0" readonly>
                                    </td>
                                </tr>
                            </tbody>
                            @endforeach
                            <tr>
                                <td colspan="3" style="text-align: right">

                                </td>
                                <td colspan="2">

                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                            <tfoot hidden>
                                <tr>
                                    <td colspan="3" style="text-align: right">
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
                            <button class="btn btn-primary" type="button" onclick="window.location.href = '/construction/form_order/{{$header_fo->id}}';">Cancel</button>
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
<script src="{{asset('js/construction/progress/addmoreitem.js?v=5-20200319-0916') }}" charset="utf-8"></script>
<script src="{{asset('js/construction/progress/createForm.js?v=5-20200319-0916') }}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js?v=5-20200319-0916') }}" charset="utf-8"></script>
<script src="{{asset('js/other/zebradatepicker.js?v=5-20200319-0916') }}" charset="utf-8"></script>
@endpush
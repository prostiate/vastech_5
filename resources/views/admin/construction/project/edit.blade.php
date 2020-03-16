@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Edit Form Order</h2>
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
                                    <input value="{{$header->number}}" class="form-control" type="text" name="trans_no" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Date *</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$header->date}}" type="text" class="form-control" name="date" id="datepicker1">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Form Order Name *</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$header->name}}" class="form-control" type="text" name="name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Address *</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$header->address}}" class="form-control" type="text" name="address">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Bill Quantities No</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5><a href="/construction/bill_quantities/{{$header->bill_quantities_id}}">{{$header->bill_quantities->number}}</a></h5>
                                    <input value="{{$header->bill_quantities_id}}" type="text" name="bill_quantities_id" id="bill_quantities_id" hidden>
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
                                        <th colspan="2" class="column-title" style="width: 350px; text-align: center" data-toggle="tooltip" data-placement="top" data-original-title="Working Description">{{$item[0]->budget_plan_detail->offering_letter_detail->name}}</th>
                                    </tr>
                                </thead>
                                <tr class="headings">
                                    <th class="column-title" style="width: 350px">Working Detail</th>
                                    <th class="column-title" style="width: 150px">Duration (month)</th>
                                </tr>
                                @foreach($item as $item)
                            <tbody class="neworderbody">
                                <tr>
                                    <td>
                                        {{$item->budget_plan_detail->name}}
                                        <input value="{{$item->id}}" type="text" name="budget_plan_detail_id[]" hidden>
                                    </td>
                                    <td>
                                        {{$item->budget_plan_detail->duration}}
                                    </td>
                                </tr>
                            </tbody>
                            @endforeach
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12 text-center">
                        <div class="form-group">
                            <input value="{{$header->id}}" type="text" name="hidden_id" hidden>
                            <button class="btn btn-primary" type="button" onclick="window.location.href = '/construction/form_order/{{$header->id}}';">Cancel</button>
                            <div class="btn-group">
                                <button id="click" type="button" class="btn btn-success">Update</button>
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
<script src="{{asset('js/construction/form_order/updateForm.js?v=5-20200315-0243') }}" charset="utf-8"></script>
<script src="{{asset('js/other/zebradatepicker.js?v=5-20200315-0243') }}" charset="utf-8"></script>
@endpush
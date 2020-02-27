@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Create New Budget Plan</h2>
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Date
                                    *</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$today}}" type="text" class="form-control" name="date" id="datepicker1">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Budget Plan Name *</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input class="form-control" type="text" name="name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Address *</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$header_ol->address}}" class="form-control" type="text" name="address">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Offering Letter No</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5><a href="/construction/offering_letter/{{$header_ol->id}}">{{$header_ol->number}}</a>
                                    </h5>
                                    <input value="{{$header_ol->id}}" type="text" name="offering_letter_id" id="offering_letter_id" hidden>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="table-responsive">
                        <table class="table table-striped jambo_table bulk_action">
                            @foreach($item_ol as $k => $item)
                            <thead>
                                <tr class="headings">
                                    <th class="column-title" style="width: 350px; text-align: center" data-toggle="tooltip" data-placement="top" data-original-title="Working Description">
                                        {{$item->name}}</th>
                                    <th class="column-title" style="width: 350px; text-align: center" data-toggle="tooltip" data-placement="top" data-original-title="Specification">
                                        {{$item->specification}}</th>
                                    <th class="column-title" style="width: 350px; text-align: center" data-toggle="tooltip" data-placement="top" data-original-title="Offering Total Price">
                                        <?php echo 'Rp ' . number_format($item->amount, 2, ',', '.') ?></th>
                                    <th class="column-title" style="width: 50px"></th>
                                </tr>
                            </thead>
                            <tr class="headings">
                                <th class="column-title" style="width: 350px">Working Detail</th>
                                <th class="column-title" style="width: 150px">Duration (month)</th>
                                <th colspan="2" class="column-title" style="width: 350px">Price</th>
                            </tr>
                            <tbody class="neworderbody">
                                <tr class="initialtr">
                                    <td>
                                        <input class="offering_letter_amount" value="{{$item->amount}}" type="text" name="offering_letter_detail_price[]" hidden>
                                        <input value="{{$item->id}}" class="kon" name="offering_letter_detail_id[]" hidden>
                                        <input onClick="this.select();" type="text" class="form-control" name="working_detail[]">
                                    </td>
                                    <td>
                                        <input onClick="this.select();" type="number" class="form-control" name="duration[]" value="0">
                                    </td>
                                    <td>
                                        <input onClick="this.select();" type="text" class="form-control price_display" name="price_display[]" value="0">
                                        <input type="text" class="price_hidden" name="price[]" value="0" hidden>
                                    </td>
                                    <td>
                                        <input type="button" class="btn btn-dark add" value="+">
                                    </td>
                                </tr>
                                <tr class="warning" hidden>
                                    <td colspan="4" style="text-align: right">
                                        <small class="red"><strong>Sub total cannot be more than the price that already assigned.</strong></small>
                                    </td>
                                </tr>
                                <tr class="outputbody">
                                    <td colspan="2" style="text-align: right">
                                        <h4><strong>Sub Total</strong></h4>
                                    </td>
                                    <td colspan="2">
                                        <input type="text" class="form-control sub_display" value="0" readonly>
                                        <input type="text" class="sub_hidden" name="subtotal[]" value="0" hidden>
                                    </td>
                                </tr>
                            </tbody>
                            @endforeach
                            <tfoot hidden>
                                <tr>
                                    <td colspan="2" style="text-align: right">
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
                    <div class="form-group" style="text-align: center">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="button" onclick="window.location.href = '/construction/offering_letter/{{$header_ol->id}}';">Cancel</button>
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
<script src="{{asset('js/construction/budget_plans/addmoreitem.js?v=5-20200221-1431') }}" charset="utf-8"></script>
<script src="{{asset('js/construction/budget_plans/createForm.js?v=5-20200221-1431') }}" charset="utf-8"></script>
<script src="{{asset('js/other/zebradatepicker.js?v=5-20200221-1431') }}" charset="utf-8"></script>
@endpush
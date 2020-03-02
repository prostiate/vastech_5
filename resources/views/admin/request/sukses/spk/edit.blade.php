@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>@lang("spk.edit.title")</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="post" id="formCreate" class="form-horizontal">
                    <br>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang("spk.edit.trans_no")</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$spk->number}}" type="text" class="form-control" readonly name="trans_no">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang("spk.edit.trans_date")</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$spk->transaction_date}}" type="date" class="form-control" id="datepicker1" name="trans_date">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang("spk.edit.contact")</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control select_contact contact_id" name="contact">
                                        <option>{{$spk->contact->display_name}}</option>
                                    </select>
                                    <input class="selected_contact_id" hidden>
                                    <input class="tampungan_contact_id" name="contact2" value="{{$spk->contact_id}}" hidden>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang("spk.edit.warehouse")</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control selectwarehouse" name="warehouse">
                                        <option></option>
                                        @foreach ($warehouses as $a)
                                        <option value="{{$a->id}}" @if($a->id == $spk->warehouse_id) selected @endif>
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">@lang("spk.edit.warehouse")</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$spk->vendor_ref_no}}" type="text" class="form-control" name="vendor_ref_no">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="memoForm" style="text-align: left;">@lang("spk.edit.note")</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <textarea class="form-control" name="desc" rows="4">{{$spk->desc}}</textarea>
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
                                    <th class="column-title" style="width: 600px">@lang("spk.edit.table.col_1")</th>
                                    <th class="column-title">@lang("spk.edit.table.col_2")</th>
                                    <th class="column-title" style="width: 50px"></th>
                                </tr>
                            </thead>
                            <tbody class="neworderbody">
                                @foreach($spk_item as $si)
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <select class="form-control select_product product_id" name="product[]">
                                                <option>{{$si->product->name}}</option>
                                            </select>
                                            <input class="selected_product_id" hidden>
                                            <input class="tampungan_product_id" name="product2[]" value="{{$si->product_id}}" hidden>
                                        </div>
                                    </td>
                                    <td>
                                        <input value="{{$si->qty}}" onClick="this.select();" type="number" class="examount form-control qty" name="qty[]">
                                        <input value="{{$si->qty}}" type="text" class="amount" hidden>
                                    </td>
                                    <td>
                                        <input type="button" class="btn btn-danger delete" value="x">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <input type="button" class="btn btn-dark add" value="@lang('spk.edit.more')">
                    </div>
                    <br>
                    <div class="col-md-12 text-center">
                        <div class="form-group">
                            <a href="{{ url('/spk/'.$spk->id) }}" class="btn btn-danger">@lang("spk.edit.cancel")</a>
                            <div class="btn-group">
                                <button id="click" type="button" class="btn btn-success">@lang("spk.edit.update")</button>
                                <input value="{{$spk->id}}" name="hidden_id" hidden>
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
<script src="{{ asset('js/request/sukses/spk/updateForm.js?v=5-20200302-1755') }}" charset="utf-8"></script>
<script src="{{ asset('js/request/sukses/spk/addmoreitem.js?v=5-20200302-1755') }}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js?v=5-20200302-1755') }}" charset="utf-8"></script>
<script src="{{asset('js/other/zebradatepicker.js?v=5-20200302-1755') }}" charset="utf-8"></script>
@endpush
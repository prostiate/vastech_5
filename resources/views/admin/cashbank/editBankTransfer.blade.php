@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Bank Transfer</h2>
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
                                    <input value="{{$caba->number}}" type="text" class="form-control" readonly name="trans_no">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Transaction Date</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$caba->date}}" type="date" class="form-control" id="datepicker1" name="trans_date">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="memoForm" style="text-align: left;">Memo</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <textarea class="form-control" name="memo" rows="4">{{$caba->memo}}</textarea>
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
                                    <th class="column-title" style="width: 400px">Transfer From</th>
                                    <th class="column-title">Deposit To</th>
                                    <th class="column-title">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="neworderbody">
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <select class="form-control selectaccount" name="transfer_from">
                                                @foreach ($coa as $a)
                                                <option value="{{$a->id}}" @if($a->id == $caba->transfer_from) selected @endif>
                                                    ({{$a->code}}) - {{$a->name}} ({{$a->coa_category->name}})
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <select class="form-control selectaccount" name="deposit_to">
                                                @foreach ($coa as $a)
                                                <option value="{{$a->id}}" @if($a->id == $caba->deposit_to) selected @endif>
                                                    ({{$a->code}}) - {{$a->name}} ({{$a->coa_category->name}})
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <input onClick="this.select();" type="text" class="amount_display form-control" value="{{$caba->amount}}" >
                                        <input type="text" class="amount_hidden" name="amount" value="{{$caba->amount}}" hidden>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <div class="col-md-3 center-margin">
                        <div class="form-group">
                            <a href="{{ url('/cashbank/bank_transfer/'. $caba->id) }}" class="btn btn-danger">Cancel</a>
                            <div class="btn-group">
                                <button id="click" type="button" class="btn btn-success">Update </button>
                            </div>
                            <input type="text" value="{{$caba->id}}" name="hidden_id" id="form_id" hidden>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{asset('js/cashbank/addmoreitem_banktransfer.js?v=5-27012020') }}" charset="utf-8"></script>
<script src="{{asset('js/cashbank/updateFormBankTransfer.js?v=5-27012020') }}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js?v=5-27012020') }}" charset="utf-8"></script>
<script src="{{asset('js/other/zebradatepicker.js?v=5-27012020') }}" charset="utf-8"></script>
@endpush
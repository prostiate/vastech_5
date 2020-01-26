@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Bank Deposit</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <!-- {{-- <form method="post" action="/cashbank/updateBankDeposit" id="formCreate" class="form-horizontal"> --}} -->
                <form method="post" id="formCreate" class="form-horizontal">
                    <!-- {{--{{ csrf_field() }} --}} -->
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Deposit To*</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select type="select" class="form-control selectaccount" name="deposit_to">
                                        @foreach ($coa as $a)
                                        <option value="{{$a->id}}" @if($a->id == $caba->deposit_to) selected @endif>
                                            ({{$a->code}}) - {{$a->name}} ({{$a->coa_category->name}})
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Transaction Date</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$caba->date}}" type="date" class="form-control" id="datepicker1" name="trans_date">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Payer*</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select type="text" class="form-control selectcontact" name="vendor_name">
                                        <option></option>
                                        @foreach ($contact as $a)
                                        <option value="{{$a->id}}" @if($a->id == $caba->contact_id) selected @endif>
                                            {{$a->display_name}}
                                        </option>
                                        @endforeach
                                    </select>
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
                                    <th class="column-title" style="width: 400px">Receive From</th>
                                    <th class="column-title">Description</th>
                                    <th class="column-title">Tax</th>
                                    <th class="column-title">Amount</th>
                                    <th class="column-title" style="width: 50px"></th>
                                </tr>
                            </thead>
                            <tbody class="neworderbody">
                                @foreach($caba_details as $a)
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <select class="select2 form-control form-control-sm expense_id selectaccount" name="expense_acc[]" required>
                                                <option></option>
                                                @foreach ($expenses as $expense)
                                                <option value="{{$expense->id}}" @if($expense->id == $a->receive_from) selected @endif>
                                                    ({{$expense->code}}) - {{$expense->name}} ({{$expense->coa_category->name}})
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <textarea class="dec form-control" id="descTable" rows="1" name="desc_acc[]">{{$a->desc}}</textarea>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <select class="select2 form-control form-control-sm taxes selecttax" name="tax_acc[]">
                                                @foreach ($taxes as $tax)
                                                <option value="{{$tax->id}}" rate="{{$tax->rate}}" @if($tax->id == $a->tax_id) selected @endif>
                                                    {{$tax->name}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <input value="{{$a->amount}}" onClick="this.select();" type="text" class="examount form-control form-control-sm" id="numberForm">
                                        <input value="{{$a->amount}}" type="text" class="amount" name="amount_acc[]" hidden>
                                        <input value="{{$a->amounttax}}" type="text" class="amounttax" name="total_amount_tax[]" hidden>
                                        <input value="{{$a->amountsub}}" type="text" class="amountsub" name="total_amount_sub[]" hidden>
                                        <input value="{{$a->amountgrand}}" type="text" class="amountgrand" name="total_amount_grand[]" hidden>
                                    </td>
                                    <td>
                                        <input type="button" class="btn btn-danger delete" value="x">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <input type="button" class="btn btn-dark add" value="+ Add More Item">
                    </div>
                    <br>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="memoForm" style="text-align: left;">Memo</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <textarea class="form-control" name="memo" rows="4">{{$caba->memo}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4">
                                    </div>
                                    <div class="col-md-4">
                                        <h5> Sub Total </h5>
                                        <h5> Tax Total </h5>
                                        <br>
                                        <h3><b> Total Amount </b></h3>
                                    </div>
                                    <div class="col-md-4 float-right">
                                        <h5 class="subtotal text-right"> Rp 0.00 </h5>
                                        <input type="text" class="subtotal_input" name="subtotal" hidden>
                                        <h5 class="total text-right"> Rp 0,00 </h5>
                                        <input type="text" class="total_input" name="taxtotal" hidden>
                                        <br>
                                        <h3 class="balance text-right"><b> Rp 0.00 </b></h3>
                                        <input type="text" class="balance_input" name="balance" hidden>
                                        <div class="form-group tile"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="col-md-3 center-margin">
                        <div class="form-group">
                            <a href="{{ url('/cashbank/bank_deposit/'. $caba->id) }}" class="btn btn-danger">Cancel</a>
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
<script src="{{asset('js/cashbank/updateFormBankDeposit.js?v=5-26012020') }}" charset="utf-8"></script>
<script src="{{asset('js/other/addmoreitem_expenses.js?v=5-26012020') }}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js?v=5-26012020') }}" charset="utf-8"></script>
<script src="{{asset('js/other/zebradatepicker.js?v=5-26012020') }}" charset="utf-8"></script>
@endpush
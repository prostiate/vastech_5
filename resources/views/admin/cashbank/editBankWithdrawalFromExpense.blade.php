@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Bank Withdrawal</h2>
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Pay From*</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select type="select" class="form-control selectaccount" name="pay_from">
                                        @foreach ($coa as $a)
                                        <option value="{{$a->id}}" @if($a->id == $caba->pay_from) selected @endif>
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
                                    <th class="column-title" style="width: 300px">Payment For <a style="color: white;"><strong><u>Expense</u></strong></a></th>
                                    <th class="column-title">Description</th>
                                    <th class="column-title">Total</th>
                                    <th class="column-title">Balance Due</th>
                                    <th class="column-title">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="neworderbody">
                                @foreach($caba_details as $a)
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <a href="/expenses/{{$a->expense->id}}">Expense #{{$a->expense->number}}</a></a>
                                            <input hidden type="text" name="expense_acc" value="{{$a->expense->id}}">
                                            <input hidden type="text" name="expense_pay_from" value="{{$a->expense->pay_from_coa_id}}">
                                            <input hidden type="text" name="expense_account_coa_detail" value="{{$a->expense->expense_contact->account_payable_id}}">
                                        </div>
                                    </td>
                                    <td>
                                        <textarea class="dec form-control" id="descTable" rows="1" name="desc_acc">{{$a->desc}}</textarea>
                                    </td>
                                    <td>
                                        <a>Rp @number($a->expense->grandtotal)</a>
                                        <input hidden type="text" name="grandtotal" value="{{$a->expense->grandtotal}}">
                                    </td>
                                    <td>
                                        <a>Rp @number($a->expense->balance_due)</a>
                                        <input hidden type="text" name="balance_due" value="{{$a->expense->balance_due}}">
                                    </td>
                                    <td>
                                        <input type="text" class="viewajah form-control text1" id="warnOnDecimalsEntered2" value="{{$a->amount}}">
                                        <input hidden type="text" class="examount form-control text2" name="amount_acc" value="{{$a->amount}}">
                                        <input hidden type="text" class="totinput">
                                        <input hidden type="text" class="totview">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                                        <h3><b> Total Amount </b></h3>
                                    </div>
                                    <div class="col-md-4 float-right">
                                        <h3 class="balance text-right"><b> Rp @number($caba->amount) </b></h3>
                                        <input type="text" class="balance_input" name="balance" hidden value="{{$caba->amount}}">
                                        <div class="form-group tile"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="col-md-3 center-margin">
                        <div class="form-group">
                            <a href="{{ url('/cashbank/bank_withdrawal/'.$caba->id) }}" class="btn btn-danger">Cancel</a>
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
<script>
    $(document).on('keyup keydown change', '.text1, .text2', function() {
        $('.text1, .text2').not(this).val(this.value);
    })
</script>
<script src="{{asset('js/jquery.formatCurrency-1.4.0/jquery.formatCurrency-1.4.0.js?v=5-20200302-1755') }}" charset="utf-8"></script>
<script type="text/javascript">
    $(function() {
        $('#warnOnDecimalsEntered2').blur(function() {
                $('#warnOnDecimalsEnteredNotification2').html(null);
                $(this).formatCurrency({
                    roundToDecimalPlace: 2,
                    eventOnDecimalsEntered: true
                });
            })
            .bind('decimalsEntered', function(e, cents) {
                var errorMsg = 'Please do not enter any cents (0.' + cents + ')';
                $('#warnOnDecimalsEnteredNotification2').html(errorMsg);
                log('Event on decimals entered: ' + errorMsg);
            });
    });
</script>
<script>
    $(function() {
        $('.selected_expense').on("change", function() {
            var grtot = $('option:selected', this).attr('grandtotal');
            $('.view_selected_expense_grandtotal').html('Rp ' + grtot + ',00');
            $('.input_selected_expense_grandtotal').val(grtot);
            var bld = $('option:selected', this).attr('balance_due');
            $('.view_selected_expense_balancedue').html('Rp ' + bld + ',00');
            $('.input_selected_expense_balancedue').val(bld);
        });
    });
</script>

<script src="{{asset('js/cashbank/updateFormBankWithdrawalFromExpense.js?v=5-20200302-1755') }}" charset="utf-8"></script>
<script src="{{asset('js/other/addmoreitem_cashbankwithdrawalfromexpense.js?v=5-20200302-1755') }}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js?v=5-20200302-1755') }}" charset="utf-8"></script>
<script src="{{asset('js/other/zebradatepicker.js?v=5-20200302-1755') }}" charset="utf-8"></script>
@endpush
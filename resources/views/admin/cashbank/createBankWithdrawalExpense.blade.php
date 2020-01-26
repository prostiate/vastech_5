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
                                    <input value="{{$trans_no}}" type="text" class="form-control" readonly name="trans_no">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Pay From*</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select type="select" class="form-control selectaccount" name="pay_from">
                                        @foreach ($coa as $a)
                                        <option value="{{$a->id}}">
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
                                    <input value="{{$today}}" type="date" class="form-control" id="datepicker1" name="trans_date">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Payer*</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select type="text" class="form-control selectcontact" name="vendor_name">
                                        <option></option>
                                        @foreach ($contact as $a)
                                        <option value="{{$a->id}}">
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
                                    <th class="column-title" style="width: 300px">Payment For <a href="/cashbank/bank_withdrawal/account/new" style="color: white;">Account</a> | <a href="/cashbank/bank_withdrawal/expense/new" style="color: white;"><strong><u>Expense</u></strong></a></th>
                                    <th class="column-title">Description</th>
                                    <th class="column-title">Total</th>
                                    <th class="column-title">Balance Due</th>
                                    <th class="column-title">Amount</th>
                                    <th class="column-title" style="width: 50px"></th>
                                </tr>
                            </thead>
                            <tbody class="neworderbody">
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <select class="select2 form-control form-control-sm expense_id selectexpense selected_expense" name="expense_acc[]" required>
                                                <option></option>
                                                @foreach ($expenses as $a)
                                                <option value="{{$a->id}}" grandtotal="{{$a->grandtotal}}" balance_due="{{$a->balance_due}}">
                                                    Expense #{{$a->number}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <textarea class="dec form-control" id="descTable" rows="1" name="desc_acc[]"></textarea>
                                    </td>
                                    <td>
                                        <h5 class="view_selected_expense_grandtotal">Rp 0,00</h5>
                                        <input hidden class="input_selected_expense_grandtotal form-control" type="text" name="grandtotal[]">
                                    </td>
                                    <td>
                                        <h5 class="view_selected_expense_balancedue">Rp 0,00</h5>
                                        <input hidden class="input_selected_expense_balancedue form-control" type="text" name="balance_due[]">
                                    </td>
                                    <td>
                                        <input hidden type="text" class="form-control text1" id="warnOnDecimalsEntered2">
                                        <input type="text" class="examount form-control text2" name="amount_acc[]">
                                        <input type="hidden" class="amount">
                                        <input type="hidden" class="amountsub">
                                    </td>
                                    <td>
                                        <input type="button" class="btn btn-danger delete" value="x">
                                    </td>
                                </tr>
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
                                    <textarea class="form-control" name="memo" rows="4"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4">
                                    </div>
                                    <div class="col-md-4">
                                        <h5> Sub Total </h5>
                                        <br>
                                        <h3><b> Total Amount </b></h3>
                                    </div>
                                    <div class="col-md-4 float-right">
                                        <h5 class="subtotal text-right"> Rp 0,00 </h5>
                                        <input type="text" class="subtotal_input" name="subtotal" hidden>
                                        <br>
                                        <h3 class="balance text-right"><b> Rp 0,00 </b></h3>
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
                            <a href="{{ url('/cashbank') }}" class="btn btn-danger">Cancel</a>
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
<!--{{--<script>
    $(document).on('keyup keydown change', '.text1, .text2', function() {
        $('.text1, .text2').not(this).val(this.value);
    })
</script>
<script src="{{asset('js/jquery.formatCurrency-1.4.0/jquery.formatCurrency-1.4.0.js?v=5-26012020') }}" charset="utf-8"></script>
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
</script>--}}-->
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

<script src="{{asset('js/cashbank/createFormBankWithdrawalExpense.js?v=5-26012020') }}" charset="utf-8"></script>
<script src="{{asset('js/other/addmoreitem_cashbankwithdrawalexpense.js?v=5-26012020') }}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js?v=5-26012020') }}" charset="utf-8"></script>
<script src="{{asset('js/other/zebradatepicker.js?v=5-26012020') }}" charset="utf-8"></script>
@endpush
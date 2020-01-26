@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3><b>Update Payment</b></h3>
            </div>
            <div class="x_content">
                <form method="post" id="formCreate" class="form-horizontal">
                    <br>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Transaction No</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$po->number}}" type="text" class="form-control" name="trans_no" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Customer</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <a href="{{ url('/contacts/'.$po->contact_id) }}">
                                        <h5>{{$po->contact->display_name}}</h5>
                                    </a>
                                    <input type="hidden" name="vendor_name" value="{{$po->contact->id}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Payment Date</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$po->transaction_date}}" type="text" class="form-control" name="payment_date" id="datepicker1">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Deposit To*</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control selectaccount" name="pay_from">
                                        @foreach($coa as $a)
                                        <option value="{{$a->id}}" @if($po->account_id == $a->id) selected = "selected" @endif>
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Due Date</label>
                                <div class="col-md-7 xdisplay_inputx form-group has-feedback">
                                    <input value="{{$po->due_date}}" type="text" class="form-control" name="due_date" id="datepicker2">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Payment Method</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control selectaccount" name="payment_method">
                                        @foreach($payment_method as $a)
                                        <option value="{{$a->id}}" @if($po->other_payment_method_id == $a->id) selected = "selected" @endif>
                                            {{$a->name}}
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
                                    <th class="column-title" style="width:100px">Due Date</th>
                                    <th class="column-title" style="width:250px">Number</th>
                                    <th class="column-title" style="width:200px">Description</th>
                                    <th class="column-title" style="width:150px">Total</th>
                                    <th class="column-title" style="width:150px">Balance Due</th>
                                    <th class="column-title" style="width:150px">Payment Amount</th>
                                </tr>
                            </thead>
                            <tbody class="neworderbody">
                                @foreach($get_all_invoice as $gai)
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <a>{{$gai->sale_invoice->due_date}}</a>
                                            <input type="hidden" name="pidue_date[]" value="{{$gai->sale_invoice->due_date}}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <a href="{{ url('/sales_invoice/'.$gai->sale_invoice->id) }}">Sales Invoice #{{$gai->sale_invoice->number}}</a>
                                            <input type="hidden" name="pinumber[]" value="{{$gai->sale_invoice->id}}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <a>{{$gai->sale_invoice->memo}}</a>
                                            <input type="hidden" name="pidesc[]" value="{{$gai->sale_invoice->memo}}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <a>Rp @number($gai->sale_invoice->grandtotal)</a>
                                            <input type="hidden" name="pitotal[]" value="{{$gai->sale_invoice->grandtotal}}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <a>Rp @number($gai->sale_invoice->balance_due)</a>
                                            <input type="hidden" name="pibalancedue[]" value="{{$gai->sale_invoice->balance_due}}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input onClick="this.select();" type="text" name="pipayment_amount_display[]" class="payment_amount_display" value="{{$gai->payment_amount}}">
                                            <input type="text" name="pipayment_amount[]" class="payment_amount" hidden value="{{$gai->payment_amount}}">
                                            <input type="hidden" class="amount" value="{{$gai->payment_amount}}">
                                            <input type="hidden" class="amountsub">
                                        </div>
                                    </td>
                                </tr>
                                <input value="{{$gai->sale_invoice_id}}" type="hidden" name="hidden_id[]">
                                @endforeach
                            </tbody>
                        </table>
                        <input type="button" class="btn btn-dark add" value="+ Add More Item" hidden>
                    </div>
                    <br>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="memoForm" style="text-align: left;">Memo</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <textarea class="form-control" name="memo" rows="4">{{$po->memo}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4">
                                    </div>
                                    <div class="col-md-4">
                                        <!--<h5 hidden> Sub Total </h5>
                                        <h5 hidden> Tax Total </h5>
                                        <br>-->
                                        <h3><b> Total </b></h3>
                                    </div>
                                    <div class="col-md-4 float-right">
                                        <!--<h5 class="subtotal text-right" hidden> Rp 0,00 </h5>
                                        <input type="text" class="subtotal_input" name="subtotal" hidden>
                                        <h5 class="total text-right" hidden> Rp 0,00 </h5>
                                        <input type="text" class="total_input" name="taxtotal" hidden>
                                        <br>-->
                                        <input class="balance form-control" readonly>
                                        <input type="text" class="currency balance_input" name="balance" hidden>
                                        <div class="form-group tile"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="col-md-3 center-margin">
                        <div class="form-group">
                            <a href="{{ url('/sales_payment/'.$po->id) }}" class="btn btn-dark">Cancel</a>
                            <div class="btn-group">
                                <button id="click" type="button" class="btn btn-success">Update</button>
                                <input value="{{$po->id}}" type="text" name="hidden_id_payment" hidden>
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
<script src="{{ asset('js/sales/payment/updateForm.js?v=5-26012020') }}" charset="utf-8"></script>
<script src="{{ asset('js/other/zebradatepicker.js?v=5-26012020') }}" charset="utf-8"></script>
<script src="{{ asset('js/other/select2.js?v=5-26012020') }}" charset="utf-8"></script>
<script src="{{ asset('js/other/addmoreitem_payment.js?v=5-26012020') }}" charset="utf-8"></script>
@endpush
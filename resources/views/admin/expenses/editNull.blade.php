@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Update Expense</h2>
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
                                    <input value="{{$ex->number}}" type="text" class="form-control" readonly name="trans_no">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Pay From*</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select type="select" class="form-control selectaccount" name="pay_from">
                                        @foreach ($accounts as $account)
                                        <option value="{{$account->id}}" @if($ex->pay_from_coa_id == $account->id) selected = "selected" @endif>
                                            ({{$account->code}}) - {{$account->name}} ({{$account->coa_category->name}})
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Beneficiary</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select type="text" class="form-control selectaccount" name="vendor_name">
                                        @foreach ($vendors as $vendor)
                                        <option value="{{$vendor->id}}" @if($ex->contact_id == $vendor->id) selected = "selected" @endif>
                                            {{$vendor->display_name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Payment Method</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select type="text" class="form-control selectaccount" name="payment_method">
                                        @foreach ($payment_method as $a)
                                        <option value="{{$a->id}}" @if($ex->payment_method_id == $a->id) selected = "selected" @endif>
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Transaction Date</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input value="{{$ex->transaction_date}}" type="date" class="form-control" id="datepicker1" name="trans_date">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Billing Address</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <textarea rows="4" class="form-control" name="address">{{$ex->address}}</textarea>
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
                                    <th class="column-title" style="width: 400px">Expense Account</th>
                                    <th class="column-title">Description</th>
                                    <th class="column-title">Tax</th>
                                    <th class="column-title">Amount</th>
                                    <th class="column-title" style="width: 50px"></th>
                                </tr>
                            </thead>
                            <tbody class="neworderbody">
                                @foreach ($ex_item as $product)
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <select class="select2 form-control form-control-sm expense_id selectaccount" name="expense_acc[]" required>
                                                @foreach ($expenses as $expense)
                                                <option value="{{$expense->id}}"  @if($product->coa_id === $expense->id) selected='selected' @endif>
                                                    ({{$expense->code}}) - {{$expense->name}} ({{$expense->coa_category->name}})
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <textarea class="dec form-control" id="descTable" rows="1" name="desc_acc[]">{{$product->desc}}</textarea>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <select class="select2 form-control form-control-sm taxes selecttax" name="tax_acc[]">
                                                @foreach ($taxes as $tax)
                                                <option value="{{$tax->id}}" rate="{{$tax->rate}}" @if($product->tax_id === $tax->id) selected='selected' @endif>
                                                    {{$tax->name}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <input value="{{$product->amount}}" onClick="this.select();" type="text" class="examount form-control form-control-sm" id="numberForm">
                                        <input value="{{$product->amount}}" type="text" class="amount" name="amount_acc[]" hidden>
                                        <input value="{{$product->amounttax}}" type="text" class="amounttax" name="total_amount_tax[]" hidden>
                                        <input value="{{$product->amountsub}}" type="text" class="amountsub" name="total_amount_sub[]" hidden>
                                        <input value="{{$product->amountgrand}}" type="text" class="amountgrand" name="total_amount_grand[]" hidden>
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
                                    <textarea class="form-control" name="memo" rows="4">{{$ex->memo}}</textarea>
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
                                        <input class="subtotal form-control" readonly>
                                        <input type="text" class="subtotal_input" name="subtotal" hidden>
                                        <input class="total form-control" readonly>
                                        <input type="text" class="total_input" name="taxtotal" hidden>
                                        <br>
                                        <input class="balance form-control" readonly>
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
                            <a href="{{ url('/expenses/'.$ex->id) }}" class="btn btn-danger">Cancel</a>
                            <div class="btn-group">
                                <button id="click" type="button" class="btn btn-success">Update</button>
                                <input type="hidden" value="{{$ex->id}}" name="hidden_id">
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
<script src="{{asset('js/expenses/updateFormNull.js?v=5-03022020') }}" charset="utf-8"></script>
<script src="{{asset('js/other/addmoreitem_expenses.js?v=5-03022020') }}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js?v=5-03022020') }}" charset="utf-8"></script>
<script src="{{asset('js/other/zebradatepicker.js?v=5-03022020') }}" charset="utf-8"></script>
@endpush
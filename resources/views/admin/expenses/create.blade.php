@extends('layouts.admin')

@section('content')
<div class="row">
    <form method="post" id="formCreate" class="form-horizontal">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Create Expense</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Pay Later</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input type="checkbox" class="flat form-control" value="1" name="pay_later">
                                </div>
                            </div>
                        </div>
                    </div>
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
                                        @foreach ($accounts as $account)
                                        <option value="{{$account->id}}">
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
                                        <option value="{{$vendor->id}}">
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
                                        <option value="{{$a->id}}">
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
                                    <input value="{{$today}}" type="date" class="form-control trans_date" id="datepicker1" name="trans_date">
                                </div>
                            </div>
                            <div class="col-md-6" name="duedate_div">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Due Date</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input type="text" class="form-control due_date" name="due_date" id="datepicker2">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Billing Address</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <textarea rows="4" class="form-control" name="address"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6" name="term_div">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Term</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select class="form-control selectterm term" name="term">
                                        @foreach($terms as $a)
                                        <option value="{{$a->id}}" length="{{$a->length}}" @if($a->id == 1) selected @endif>
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
                                    <th class="column-title" style="width: 400px">Expense Account</th>
                                    <th class="column-title">Description</th>
                                    <th class="column-title">Tax</th>
                                    <th class="column-title">Amount</th>
                                    <th class="column-title" style="width: 50px"></th>
                                </tr>
                            </thead>
                            <tbody class="neworderbody">
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <select class="select2 form-control form-control-sm expense_id selectaccount" name="expense_acc[]" required>
                                                <option></option>
                                                @foreach ($expenses as $expense)
                                                <option value="{{$expense->id}}">
                                                    ({{$expense->code}}) - {{$expense->name}} ({{$expense->coa_category->name}})
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <textarea class="dec form-control" id="descTable" rows="1" name="desc_acc[]"></textarea>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <select class="select2 form-control form-control-sm taxes selecttax" name="tax_acc[]">
                                                @foreach ($taxes as $tax)
                                                <option value="{{$tax->id}}" rate="{{$tax->rate}}">
                                                    {{$tax->name}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <input onClick="this.select();" type="text" class="examount form-control form-control-sm" id="numberForm">
                                        <input type="text" class="amount" name="amount_acc[]" hidden>
                                        <input type="text" class="amounttax" name="total_amount_tax[]" hidden>
                                        <input type="text" class="amountsub" name="total_amount_sub[]" hidden>
                                        <input type="text" class="amountgrand" name="total_amount_grand[]" hidden>
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
                            <a href="{{ url('/expenses') }}" class="btn btn-danger">Cancel</a>
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
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="{{asset('js/expenses/createForm.js?v=5-20200221-1431') }}" charset="utf-8"></script>
<script src="{{asset('js/expenses/pay_later.js?v=5-20200221-1431') }}" charset="utf-8"></script>
<script src="{{asset('js/expenses/addmoreitem.js?v=5-20200221-1431') }}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js?v=5-20200221-1431') }}" charset="utf-8"></script>
<script src="{{asset('js/other/zebradatepicker.js?v=5-20200221-1431') }}" charset="utf-8"></script>
<script src="{{asset('js/other/duedate_format.js?v=5-20200221-1431') }}" charset="utf-8"></script>
@endpush
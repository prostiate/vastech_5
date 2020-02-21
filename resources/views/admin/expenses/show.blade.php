@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <button class="btn btn-dark dropdown-toggle" type="button" onclick="window.location.href = '/expenses/edit/' + {{$pi->id}};">Edit Profile
                        </button>
                    </li>
                    <li>
                        <button data-toggle="dropdown" class="btn btn-dark dropdown-toggle" type="button" aria-expanded="false">Actions
                        </button>
                        <ul role="menu" class="dropdown-menu">
                            <li><a href="#">Clone Transaction</a></li>
                            <li><a href="#">Set as Recurring</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Print & Preview</a></li>
                            <li><a href="#">View Journal Entry</a></li>
                        </ul>
                    </li>
                </ul>
                <h3><b>Expense #{{$pi->number}}</b></h3>
                <a>Status: </a>
                @if($pi->status == 1)
                <span class="label label-warning" style="color:white;">Open</span>
                @elseif($pi->status == 2)
                <span class="label label-success" style="color:white;">Closed</span>
                @elseif($pi->status == 3)
                <span class="label label-success" style="color:white;">Paid</span>
                @elseif($pi->status == 4)
                <span class="label label-warning" style="color:white;">Partial</span>
                @elseif($pi->status == 5)
                <span class="label label-danger" style="color:white;">Overdue</span>
                @elseif($pi->status == 6)
                <span class="label label-success" style="color:white;">Sent</span>
                @elseif($pi->status == 7)
                <span class="label label-success" style="color:white;">Active</span>
                @elseif($pi->status == 8)
                <span class="label label-success" style="color:white;">Sold</span>
                @elseif($pi->status == 9)
                <span class="label label-success" style="color:white;">Disposed</span>
                @endif
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="post" id="formCreate" class="form-horizontal">
                    <br>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Transaction No</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input disabled value="{{$pi->number}}" type="text" class="form-control" readonly name="trans_no">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">* Pay From</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select disabled type="select" class="form-control selectaccount" name="pay_from">
                                        <option>
                                            {{$pi->coa->name}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Beneficiary</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select disabled type="text" class="form-control selectaccount" name="vendor_name">
                                        <option>
                                            {{$pi->expense_contact->display_name}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Payment Method</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <select disabled type="text" class="form-control selectaccount" name="payment_method">
                                        <option>
                                            {{$pi->payment_method->name}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Transaction Date</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input disabled value="{{$pi->transaction_date}}" type="date" class="form-control" id="datepicker1" name="trans_date">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Billing Address</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <textarea disabled rows="4" class="form-control" name="address">{{$pi->address}}</textarea>
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
                                </tr>
                            </thead>
                            <tbody class="neworderbody">
                                @foreach ($products as $a)
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <select disabled class="select2 form-control form-control-sm expense_id selectaccount" name="expense_acc[]" required>
                                                <option>
                                                    {{$a->coa->name}}
                                                </option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <textarea disabled class="dec form-control" id="descTable" rows="1" name="desc_acc[]">{{$a->desc}}</textarea>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <select disabled class="select2 form-control form-control-sm taxes selecttax" name="tax_acc[]">
                                                <option>
                                                    {{$a->tax->name}}
                                                </option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <input disabled value="{{$a->amount}}" type="text" class="amount form-control form-control-sm" id="numberForm" name="amount_acc[]">
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="memoForm">Memo</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <textarea disabled value="{{$pi->memo}}" class="form-control" name="memo" rows="4">{{$pi->memo}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4">
                                    </div>
                                    <div class="col-md-4">
                                        <h5> Sub Total </h5>
                                        <h5> Total Paid </h5>
                                        <br>
                                        <h3><b> Balance Due </b></h3>
                                    </div>
                                    <div class="col-md-4 float-right">
                                        <h5 class="subtotal text-right"> Rp {{$pi->grandtotal}} </h5>
                                        <input type="text" class="subtotal_input" name="subtotal" hidden>
                                        <h5 class="subtotal text-right"> Rp {{$pi->grandtotal}} </h5>
                                        <input type="text" class="subtotal_input" name="subtotal" hidden>
                                        <br>
                                        <h3 class="currency balance text-right"><b> Rp {{$pi->amount_paid}} </b></h3>
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
                            <a href="{{ url('/expenses/'.$pi->id) }}" class="btn btn-dark">Cancel</a>
                            <a href="#" class="btn btn-danger">Delete</a>
                            <div class="btn-group">
                                <button class="btn btn-success" type="button" onclick="window.location.href = '/expenses/edit/' + {{$pi->id}};">Edit
                                </button>
                            </div>
                            @endif
                            <input type="text" value="{{$pi->id}}" id="form_id" hidden>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/expense/deleteForm.js?v=5-20200221-1431') }}" charset="utf-8"></script>
@endpush
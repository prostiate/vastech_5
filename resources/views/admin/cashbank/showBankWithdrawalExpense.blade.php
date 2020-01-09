@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <button class="btn btn-dark dropdown-toggle" type="button" onclick="window.location.href = '#';" data-toggle="modal" data-target=".bs-example-modal-lg-2">View Journal Entry
                        </button>
                        <div class="modal fade bs-example-modal-lg-2" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                        </button>
                                        <h5 class="modal-title" id="myModalLabel">Journal Report</h5>
                                        <h3 class="modal-title" id="myModalLabel"><strong>Bank Transfer #{{$caba->number}}</strong></h3>
                                    </div>
                                    <div class="modal-body">
                                        <div class="table-responsive my-5">
                                            <table id="example" class="table table-striped jambo_table bulk_action">
                                                <thead>
                                                    <tr class="headings">
                                                        <th class="column-title" style="width:200px">Account Number</th>
                                                        <th class="column-title" style="width:250px">Account</th>
                                                        <th class="column-title" style="width:150px">Debit</th>
                                                        <th class="column-title" style="width:150px">Credit</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="neworderbody">
                                                    @foreach ($get_all_detail as $po)
                                                    <tr>
                                                        <td>
                                                            <a href="{{ url('/chart_of_accounts/'.$po->coa_id) }}">{{$po->coa->code}}</a>
                                                        </td>
                                                        <td>
                                                            <a href="{{ url('/chart_of_accounts/'.$po->coa_id) }}">{{$po->coa->name}}</a>
                                                        </td>
                                                        <td>
                                                            @if($po->debit == 0)
                                                            @else
                                                            <a>Rp @number($po->debit)</a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($po->credit == 0)
                                                            @else
                                                            <a>Rp @number($po->credit)</a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    <tr class="headings">
                                                        <td>
                                                            <strong><b>Total</b></strong>
                                                        </td>
                                                        <td>
                                                        </td>
                                                        <td>
                                                            <strong><b>Rp @number($total_debit)</b></strong>
                                                        </td>
                                                        <td>
                                                            <strong><b>Rp @number($total_credit)</b></strong>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <input type="button" class="btn btn-dark add" value="+ Add More Item" hidden>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <button data-toggle="dropdown" class="btn btn-dark dropdown-toggle" type="button" aria-expanded="false">Actions
                        </button>
                        <ul role="menu" class="dropdown-menu">
                            @role('Owner|Ultimate|Cash & Bank')
                            @can('Create')
                            <li><a href="#">Clone Transaction</a></li>
                            <li><a href="#">Set as Recurring</a></li>
                            <li class="divider"></li>
                            @endcan
                            @endrole
                            <li><a target="_blank" href="/cashbank/bank_withdrawal/PDF/{{$caba->id}}">Print & Preview</a></li>
                        </ul>
                    </li>
                </ul>
                <h3>Bank Withdrawal #{{$caba->number}}</h3>
                <a>Status: </a>
                @if($caba->status == 1)
                <span class="label label-warning" style="color:white;">Open</span>
                @elseif($caba->status == 2)
                <span class="label label-success" style="color:white;">Closed</span>
                @elseif($caba->status == 3)
                <span class="label label-success" style="color:white;">Paid</span>
                @elseif($caba->status == 4)
                <span class="label label-warning" style="color:white;">Partial</span>
                @elseif($caba->status == 5)
                <span class="label label-danger" style="color:white;">Overdue</span>
                @else
                <span class="label label-success" style="color:white;">Sent</span>
                @endif
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
                                    <h5>{{$caba->number}}</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Pay From</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5><a href="/chart_of_accounts/{{$caba->pay_from}}">{{$caba->coa_pay_from->name}}</a></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Transaction Date</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$caba->date}}</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Payer</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5><a href="/contacts/{{$caba->contact_id}}">{{$caba->contact->display_name}}</a></h5>
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
                                    <th class="column-title" style="width: 400px">Payment For <a style="color: white;"><strong><u>Expense</u></strong></a></th>
                                    <th class="column-title">Description</th>
                                    <th class="column-title">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="neworderbody">
                                @foreach($caba_details as $a)
                                <tr>
                                    <td>
                                        <a href="/expenses/{{$a->expense_id}}">Expense #{{$a->expense->number}}</a>
                                    </td>
                                    <td>
                                        <a>{{$a->desc}}</a>
                                    </td>
                                    <td>
                                        <a>Rp @number($a->amount)</a>
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
                                    <h5>{{$caba->memo}}</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4">
                                    </div>
                                    <div class="col-md-4">
                                        <h5> Sub Total </h5>
                                        <br>
                                        <h3><b> Balance Due </b></h3>
                                    </div>
                                    <div class="col-md-4 float-right">
                                        <h5 class="subtotal text-right"> Rp @number($caba->amount) </h5>
                                        <input type="text" class="subtotal_input" name="subtotal" hidden>
                                        <br>
                                        <h3 class="balance text-right"><b> Rp @number($caba->amount) </b></h3>
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
                            <a href="{{ url('/cashbank') }}" class="btn btn-dark">Cancel</a>
                            Owner|Ultimate|Cash & Bank')
                            @can('Delete')
                            <button type="button" class="btn btn-danger" id="click">Delete</button>
                            @endcan
                            @can('Edit')
                            <div class="btn-group">
                                <button class="btn btn-success" type="button" onclick="window.location.href = '/cashbank/bank_withdrawal/expense/edit/' + {{$caba->id}};">Edit
                                </button>
                            </div>
                            @endcan
                            @endrole
                            <input type="text" value="{{$caba->id}}" name="hidden_id" id="form_id" hidden>
                            <input type="text" value="{{$caba->number}}" name="number" hidden>
                            <input type="text" value="{{$caba->transfer_from}}" name="transfer_from" hidden>
                            <input type="text" value="{{$caba->deposit_to}}" name="deposit_to" hidden>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{asset('js/cashbank/deleteFormBankWithdrawal.js')}}" charset="utf-8"></script>
@endpush
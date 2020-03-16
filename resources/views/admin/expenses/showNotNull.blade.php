@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <button class="btn btn-dark dropdown-toggle" type="button" onclick="window.location.href = '#';" data-toggle="modal" data-target=".bs-example-modal-lg">@lang("expense.show.pay_his")
                        </button>
                        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                        </button>
                                        <h5 class="modal-title" id="myModalLabel">@lang("expense.show.pay_his")</h5>
                                        <h3 class="modal-title" id="myModalLabel"><strong>@lang("expense.show.title"){{$pi->number}}</strong></h3>
                                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                            <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">@lang("expense.show.pay_his")</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="modal-body">
                                        <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                            <div id="myTabContent" class="tab-content">
                                                <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                                                    <div class="table-responsive my-5">
                                                        <table id="example" class="table table-striped jambo_table bulk_action">
                                                            <thead>
                                                                <tr class="headings">
                                                                    <th class="column-title" style="width:250px">@lang("expense.show.table_pay_his.col_1")</th>
                                                                    <th class="column-title" style="width:200px">@lang("expense.show.table_pay_his.col_2")</th>
                                                                    <th class="column-title" style="width:150px">@lang("expense.show.table_pay_his.col_3")</th>
                                                                    <th class="column-title" style="width:150px">@lang("expense.show.table_pay_his.col_4")</th>
                                                                    <th class="column-title" style="width:150px">@lang("expense.show.table_pay_his.col_5")</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="neworderbody">
                                                                @foreach ($bank_withdrawal as $a)
                                                                <tr>
                                                                    <td>
                                                                        <a href="{{ url('/cashbank/bank_withdrawal/'.$a->id) }}">@lang("expense.show.bw_no"){{$a->cashbank->number}}</a>
                                                                    </td>
                                                                    <td>
                                                                        <a>{{$a->cashbank->date}}</a>
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{ url('/chart_of_accounts/'.$a->cashbank->pay_from) }}">{{$a->cashbank->coa_pay_from->name}}</a>
                                                                    </td>
                                                                    <td>
                                                                        @if($a->cashbank->status == 1)
                                                                        <a>Open</a>
                                                                        @elseif($a->cashbank->status == 2)
                                                                        <a>Closed</a>
                                                                        @elseif($a->cashbank->status == 3)
                                                                        <a>Paid</a>
                                                                        @elseif($a->cashbank->status == 4)
                                                                        <a>Partial</a>
                                                                        @else
                                                                        <a>Overdue</a>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <a>Rp @number($a->cashbank->amount)</a>
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-dark" data-dismiss="modal">@lang("expense.show.close")</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <button class="btn btn-dark dropdown-toggle" type="button" onclick="window.location.href = '#';" data-toggle="modal" data-target=".bs-example-modal-lg-2">@lang("expense.show.vje")
                        </button>
                        <div class="modal fade bs-example-modal-lg-2" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                        </button>
                                        <h5 class="modal-title" id="myModalLabel">@lang("expense.show.jr")</h5>
                                        <h3 class="modal-title" id="myModalLabel"><strong>@lang("expense.show.vje"){{$pi->number}}</strong></h3>
                                    </div>
                                    <div class="modal-body">
                                        <div class="table-responsive my-5">
                                            <table id="example" class="table table-striped jambo_table bulk_action">
                                                <thead>
                                                    <tr class="headings">
                                                        <th class="column-title" style="width:200px">@lang("expense.show.table_vje.col_1")</th>
                                                        <th class="column-title" style="width:250px">@lang("expense.show.table_vje.col_2")</th>
                                                        <th class="column-title" style="width:150px">@lang("expense.show.table_vje.col_3")</th>
                                                        <th class="column-title" style="width:150px">@lang("expense.show.table_vje.col_4")</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="neworderbody">
                                                    @foreach ($get_all_detail as $a)
                                                    <tr>
                                                        <td>
                                                            <a href="{{ url('/chart_of_accounts/'.$a->coa_id) }}">{{$a->coa->code}}</a>
                                                        </td>
                                                        <td>
                                                            <a href="{{ url('/chart_of_accounts/'.$a->coa_id) }}">{{$a->coa->name}}</a>
                                                        </td>
                                                        <td>
                                                            @if($a->debit == 0)
                                                            @else
                                                            <a>Rp @number($a->debit)</a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($a->credit == 0)
                                                            @else
                                                            <a>Rp @number($a->credit)</a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    <tr class="headings">
                                                        <td>
                                                            <strong><b>@lang("expense.show.total")</b></strong>
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
                                        <button type="button" class="btn btn-dark" data-dismiss="modal">@lang("expense.show.close")</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <button data-toggle="dropdown" class="btn btn-dark dropdown-toggle" type="button" aria-expanded="false">@lang("expense.show.action.action_1")
                        </button>
                        <ul role="menu" class="dropdown-menu">
                            @hasrole('Owner|Ultimate|Expense')
                            @can('Delete')
                            @if($pi->status == 1 or $pi->status == 4)
                            @hasrole('Owner|Ultimate|Cash & Bank')
                            <li><a href="/cashbank/bank_withdrawal/expense/new/{{$pi->id}}">@lang("expense.show.action.action_2")</a></li>
                            @endrole
                            @endif
                            <li><a href="#">@lang("expense.show.action.action_3")</a></li>
                            <li><a href="#">@lang("expense.show.action.action_4")</a></li>
                            <li class="divider"></li>
                            @endcan
                            @endrole
                            <li><a target="_blank" href="/expenses/print/PDF1/{{$pi->id}}">@lang("expense.show.action.action_5")</a></li>
                        </ul>
                    </li>
                </ul>
                <h3><b>Expense #{{$pi->number}}</b></h3>
                <a>Status: </a>
                @if($pi->status == 1)
                <span class="label label-warning" style="color:white;">@lang("status.open")</span>
                @elseif($pi->status == 2)
                <span class="label label-success" style="color:white;">@lang("status.closed")</span>
                @elseif($pi->status == 3)
                <span class="label label-success" style="color:white;">@lang("status.paid")</span>
                @elseif($pi->status == 4)
                <span class="label label-warning" style="color:white;">@lang("status.part")</span>
                @elseif($pi->status == 5)
                <span class="label label-danger" style="color:white;">@lang("status.over")</span>
                @elseif($pi->status == 6)
                <span class="label label-success" style="color:white;">@lang("status.sent")</span>
                @elseif($pi->status == 7)
                <span class="label label-success" style="color:white;">@lang("status.act")</span>
                @elseif($pi->status == 8)
                <span class="label label-success" style="color:white;">@lang("status.sold")</span>
                @elseif($pi->status == 9)
                <span class="label label-success" style="color:white;">@lang("status.dis")</span>
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
                                    <h5>{{$pi->number}}</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Pay From</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5><a href="/chart_of_accounts/{{$pi->pay_from_coa_id}}">{{$pi->coa->name}}</a></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Beneficiary</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5><a href="/contacts/{{$pi->contact_id}}">{{$pi->expense_contact->display_name}}</a></h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Payment Method</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$pi->payment_method->name}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Transaction Date</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$pi->transaction_date}}</h5>
                                </div>
                            </div>
                            <!--<div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Due Date</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$pi->due_date}}</h5>
                                </div>
                            </div>-->
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Billing Address</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$pi->address}}</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Term</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$pi->term->name}}</h5>
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
                                        <a href="/chart_of_accounts/{{$a->coa_id}}">{{$a->coa->name}}</a>
                                    </td>
                                    <td>
                                        <a>{{$a->desc}}</a>
                                    </td>
                                    <td>
                                        <a>{{$a->tax->name}}</a>
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
                                    <h5>{{$pi->memo}}</h5>
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
                                        <h3><b> Expense Paid </b></h3>
                                        <br>
                                        <h3><b> Balance Due </b></h3>
                                    </div>
                                    <div class="col-md-4 float-right">
                                        <h5 class="subtotal text-right"> Rp @number($pi->subtotal) </h5>
                                        <input type="text" class="subtotal_input" name="subtotal" hidden>
                                        <h5 class="subtotal text-right"> Rp @number($pi->taxtotal) </h5>
                                        <input type="text" class="subtotal_input" name="subtotal" hidden>
                                        <br>
                                        <h3 class="currency balance text-right"><b> Rp @number($pi->amount_paid) </b></h3>
                                        <input type="text" class="currency balance_input" name="balance" hidden>
                                        <div class="form-group tile"></div>
                                        <br>
                                        <h3 class="currency balance text-right"><b> Rp @number($pi->balance_due) </b></h3>
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
                            <a href="{{ url('/expenses') }}" class="btn btn-dark">Cancel</a>
                            @hasrole('Owner|Ultimate|Expense')
                            @if(!$pi->amount_paid > 0)
                            @can('Delete')
                            <button type="button" class="btn btn-danger" id="click">Delete</button>
                            @endcan
                            @can('Edit')
                            <div class="btn-group">
                                <button class="btn btn-success" type="button" onclick="window.location.href = '/expenses/edit/' + {{$pi->id}};">Edit
                                </button>
                            </div>
                            @endcan
                            @endif
                            @endrole
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
<script src="{{ asset('js/expenses/deleteFormNotNull.js?v=5-20200315-0243') }}" charset="utf-8"></script>
@endpush
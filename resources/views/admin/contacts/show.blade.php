@extends('layouts.admin')

@section('contentheader')
<div class="page-title">
    <div class="title_left">
        <h3>Contact Information</h3>
    </div>
    <!--<div class="title_right">
        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search for...">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button">Go!</button>
                </span>
            </div>
        </div>
    </div>-->
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <div class="col-md-12">
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <button class="btn btn-dark dropdown-toggle" type="button" onclick="window.location.href = '/contacts/edit/{{$contact->id}}';">Edit Profile
                            </button>
                        </li>
                        <li>
                            <button data-toggle="dropdown" class="btn btn-dark dropdown-toggle" type="button" aria-expanded="false">Create Transaction <span class="caret"></span>
                            </button>
                            <ul role="menu" class="dropdown-menu">
                                @if($contact->type_customer == 1 && $contact->type_vendor == 1 && $contact->type_employee == 1 && $contact->type_other == 1)
                                <li><a href="/sales_invoice/new">Sales Invoice</a></li>
                                <li><a href="/purchases_invoice/new">Purchase Invoice</a></li>
                                <li><a href="/expenses/new">Expense</a></li>
                                <li><a href="#">Bank Deposit</a></li>
                                <li><a href="#">Bank Withdrawal</a></li>
                                <li><a href="#">Credit Memo</a></li>
                                <li><a href="#">Debit Memo</a></li>
                                @elseif($contact->type_customer == 1)
                                <li><a href="/sales_invoice/new">Sales Invoice</a></li>
                                <li><a href="#">Credit Memo</a></li>
                                @elseif($contact->type_vendor == 1)
                                <li><a href="/expenses/new">Expense</a></li>
                                <li><a href="#">Debit Memo</a></li>
                                @elseif($contact->type_employee == 1)
                                <li><a href="/expenses/new">Expense</a></li>
                                <li><a href="#">Bank Deposit</a></li>
                                <li><a href="#">Bank Withdrawal</a></li>
                                <li><a href="#">Debit Memo</a></li>
                                @elseif($contact->type_other == 1)
                                <li><a href="/expenses/new">Expense</a></li>
                                <li><a href="#">Bank Deposit</a></li>
                                <li><a href="#">Bank Withdrawal</a></li>
                                <li><a href="#">Debit Memo</a></li>
                                @endif
                            </ul>
                        </li>
                        <li>
                            <button data-toggle="dropdown" class="btn btn-dark dropdown-toggle" type="button" aria-expanded="false"><span class="glyphicon glyphicon-wrench"></span>
                            </button>
                            <ul role="menu" class="dropdown-menu">
                                <!--<li><a href="#">View Statement Report</a>
                                <li><a href="#">Merge Contacts</a>
                                <li><a href="#">Archive Contact</a>-->
                                <li><a href="#" id="click">Delete</a>
                                    <input type="text" value="{{$contact->id}}" id="form_id" hidden>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <h3><b>{{$contact->display_name}}</b></h3>
                    <a>Type: </a>
                    @if($contact->type_customer == 1)
                    <span class="label label-primary" style="color:white;">Customer</span>
                    @endif
                    @if($contact->type_vendor == 1)
                    <span class="label label-primary" style="color:white;">Vendor</span>
                    @endif
                    @if($contact->type_employee == 1)
                    <span class="label label-primary" style="color:white;">Employee</span>
                    @endif
                    @if($contact->type_other == 1)
                    <span class="label label-primary" style="color:white;">Other</span>
                    @endif
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_content1" role="tab" id="invoice-tab" data-toggle="tab" aria-expanded="true">Profile</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content2" role="tab" id="delivery-tab" data-toggle="tab" aria-expanded="false">List Transactions</a>
                        </li>
                    </ul>
                    <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="invoice-tab">
                            <blockquote>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="col-md-12">
                                            <h2><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> General Information</h2>
                                        </div>
                                        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                            <h5>Contact Name</h5>
                                            <h5><b>{{$contact->display_name}}</b></h5>
                                            <br>
                                            <h5>Company Name</h5>
                                            @if($contact->company_name == null)
                                            <h5><b>-</b></h5>
                                            @else
                                            <h5><b>{{$contact->company_name}}</b></h5>
                                            @endif
                                            <br>
                                            <h5>Email</h5>
                                            @if($contact->email == null)
                                            <h5><b>-</b></h5>
                                            @else
                                            <h5><b>{{$contact->email}}</b></h5>
                                            @endif
                                            <br>
                                            <h5>Handphone</h5>
                                            @if($contact->handphone == null)
                                            <h5><b>-</b></h5>
                                            @else
                                            <h5><b>{{$contact->handphone}}</b></h5>
                                            @endif
                                        </div>
                                        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                            <h5>Telephone</h5>
                                            @if($contact->telephone == null)
                                            <h5><b>-</b></h5>
                                            @else
                                            <h5><b>{{$contact->telephone}}</b></h5>
                                            @endif
                                            <br>
                                            <h5>Fax</h5>
                                            @if($contact->fax == null)
                                            <h5><b>-</b></h5>
                                            @else
                                            <h5><b>{{$contact->fax}}</b></h5>
                                            @endif
                                            <br>
                                            <h5>Billing Address</h5>
                                            @if($contact->billing_address == null)
                                            <h5><b>-</b></h5>
                                            @else
                                            <h5><b>{{$contact->billing_address}}</b></h5>
                                            @endif
                                            <br>
                                            <h5>Shipping Address</h5>
                                            @if($contact->shipping_address == null)
                                            <h5><b>-</b></h5>
                                            @else
                                            <h5><b>{{$contact->shipping_address}}</b></h5>
                                            @endif
                                        </div>
                                        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                            <h5>NPWP</h5>
                                            @if($contact->npwp == null)
                                            <h5><b>-</b></h5>
                                            @else
                                            <h5><b>{{$contact->npwp}}</b></h5>
                                            @endif
                                            <br>
                                            <h5>Identity</h5>
                                            @if($contact->identity_type == null)
                                            <h5><b>-</b></h5>
                                            @else
                                            <h5><b>{{$contact->identity_type}}</b></h5>
                                            @endif
                                            <br>
                                            <h5>Identity Number</h5>
                                            @if($contact->identity_id == null)
                                            <h5><b>-</b></h5>
                                            @else
                                            <h5><b>{{$contact->identity_id}}</b></h5>
                                            @endif
                                            <br>
                                            <h5>Another Info</h5>
                                            @if($contact->another_info == null)
                                            <h5><b>-</b></h5>
                                            @else
                                            <h5><b>{{$contact->another_info}}</b></h5>
                                            @endif
                                        </div>
                                    </div>
                                    <!--<div class="col-md-6">
                                        <div class="col-md-12">
                                            <h2><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Bank Account</h2>
                                        </div>
                                        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                            <h5>Bank Name</h5>
                                            <h5><b>-</b></h5>
                                            <br>
                                            <h5>Bank Branch</h5>
                                            <h5><b>-</b></h5>
                                            <br>
                                            <h5>Bank Holder Name</h5>
                                            <h5><b>-</b></h5>
                                            <br>
                                            <h5>Account Number</h5>
                                            <h5><b>-</b></h5>
                                        </div>
                                    </div>-->
                                </div>
                            </blockquote>
                            <blockquote>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h2><span class="glyphicon glyphicon-book" aria-hidden="true"></span> Chart of Account</h2>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                        <h5>Account Payable</h5>
                                        <a href="/chart_of_accounts/{{$contact->account_payable_id}}">
                                            <h5><b>({{$contact->coaPayable->code}}) - {{$contact->coaPayable->name}}</b></h5>
                                        </a>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                        <h5>Account Receivable</h5>
                                        <a href="/chart_of_accounts/{{$contact->account_receivable_id}}">
                                            <h5><b>({{$contact->coaReceivable->code}}) - {{$contact->coaReceivable->name}}</b></h5>
                                        </a>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                        <h5>Default Payment Terms</h5>
                                        <h5><b>{{$contact->term->name}}</b></h5>
                                    </div>
                                </div>
                            </blockquote>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="delivery-tab">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>View Transaction Report</h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li>
                                            <button class="btn btn-dark dropdown-toggle" type="button" onclick="window.location.href = '/other/transactions';">Transactions List
                                            </button>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div class="table-responsive">
                                        <table class="table table-striped jambo_table bulk_action">
                                            <thead>
                                                <tr class="headings">
                                                    <th class="column-title">Transaction Number </th>
                                                    <th class="column-title">Transaction Date </th>
                                                    <th class="column-title">Due Date </th>
                                                    <th class="column-title">Status </th>
                                                    <th class="column-title">Amount </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($pq as $pq)
                                                <tr>
                                                    <td><a href="/purchases_quote/{{$pq->id}}">Purchase Quote #{{$pq->number}}</a></td>
                                                    <td>{{$pq->transaction_date}}</td>
                                                    <td>{{$pq->due_date}}</td>
                                                    @if($pq->status == 1)
                                                    <td>Open</td>
                                                    @elseif($pq->status == 2)
                                                    <td>Closed</td>
                                                    @elseif($pq->status == 3)
                                                    <td>Paid</td>
                                                    @elseif($pq->status == 4)
                                                    <td>Partially Sent</td>
                                                    @else
                                                    <td>Overdue</td>
                                                    @endif
                                                    <td>Rp @number($pq->grandtotal)</td>
                                                </tr>
                                                @endforeach
                                                @foreach($po as $po)
                                                <tr>
                                                    <td><a href="/purchases_order/{{$po->id}}">Purchase Order #{{$po->number}}</a></td>
                                                    <td>{{$po->transaction_date}}</td>
                                                    <td>{{$po->due_date}}</td>
                                                    @if($po->status == 1)
                                                    <td>Open</td>
                                                    @elseif($po->status == 2)
                                                    <td>Closed</td>
                                                    @elseif($po->status == 3)
                                                    <td>Paid</td>
                                                    @elseif($po->status == 4)
                                                    <td>Partially Sent</td>
                                                    @else
                                                    <td>Overdue</td>
                                                    @endif
                                                    <td>Rp @number($po->grandtotal)</td>
                                                </tr>
                                                @endforeach
                                                @foreach($pd as $pd)
                                                <tr>
                                                    <td><a href="/purchases_delivery/{{$pd->id}}">Purchase Delivery #{{$pd->number}}</a></td>
                                                    <td>{{$pd->transaction_date}}</td>
                                                    <td>{{$pd->due_date}}</td>
                                                    @if($pd->status == 1)
                                                    <td>Open</td>
                                                    @elseif($pd->status == 2)
                                                    <td>Closed</td>
                                                    @elseif($pd->status == 3)
                                                    <td>Paid</td>
                                                    @elseif($pd->status == 4)
                                                    <td>Partially Sent</td>
                                                    @else
                                                    <td>Overdue</td>
                                                    @endif
                                                    <td>Rp @number($pd->grandtotal)</td>
                                                </tr>
                                                @endforeach
                                                @foreach($pi as $pi)
                                                <tr>
                                                    <td><a href="/purchases_invoice/{{$pi->id}}">Purchase Invoice #{{$pi->number}}</a></td>
                                                    <td>{{$pi->transaction_date}}</td>
                                                    <td>{{$pi->due_date}}</td>
                                                    @if($pi->status == 1)
                                                    <td>Open</td>
                                                    @elseif($pi->status == 2)
                                                    <td>Closed</td>
                                                    @elseif($pi->status == 3)
                                                    <td>Paid</td>
                                                    @elseif($pi->status == 4)
                                                    <td>Partially Sent</td>
                                                    @else
                                                    <td>Overdue</td>
                                                    @endif
                                                    <td>Rp @number($pi->grandtotal)</td>
                                                </tr>
                                                @endforeach
                                                @foreach($pp as $pp)
                                                <tr>
                                                    <td><a href="/purchases_payment/{{$pp->id}}">Purchase Payment #{{$pp->number}}</a></td>
                                                    <td>{{$pp->transaction_date}}</td>
                                                    <td>{{$pp->due_date}}</td>
                                                    @if($pp->status == 1)
                                                    <td>Open</td>
                                                    @elseif($pp->status == 2)
                                                    <td>Closed</td>
                                                    @elseif($pp->status == 3)
                                                    <td>Paid</td>
                                                    @elseif($pp->status == 4)
                                                    <td>Partially Sent</td>
                                                    @else
                                                    <td>Overdue</td>
                                                    @endif
                                                    <td>Rp @number($pp->grandtotal)</td>
                                                </tr>
                                                @endforeach
                                                @foreach($sq as $sq)
                                                <tr>
                                                    <td><a href="/sales_quote/{{$sq->id}}">Sales Quote #{{$sq->number}}</a></td>
                                                    <td>{{$sq->transaction_date}}</td>
                                                    <td>{{$sq->due_date}}</td>
                                                    @if($sq->status == 1)
                                                    <td>Open</td>
                                                    @elseif($sq->status == 2)
                                                    <td>Closed</td>
                                                    @elseif($sq->status == 3)
                                                    <td>Paid</td>
                                                    @elseif($sq->status == 4)
                                                    <td>Partially Sent</td>
                                                    @else
                                                    <td>Overdue</td>
                                                    @endif
                                                    <td>Rp @number($sq->grandtotal)</td>
                                                </tr>
                                                @endforeach
                                                @foreach($so as $so)
                                                <tr>
                                                    <td><a href="/sales_order/{{$so->id}}">Sales Order #{{$so->number}}</a></td>
                                                    <td>{{$so->transaction_date}}</td>
                                                    <td>{{$so->due_date}}</td>
                                                    @if($so->status == 1)
                                                    <td>Open</td>
                                                    @elseif($so->status == 2)
                                                    <td>Closed</td>
                                                    @elseif($so->status == 3)
                                                    <td>Paid</td>
                                                    @elseif($so->status == 4)
                                                    <td>Partially Sent</td>
                                                    @else
                                                    <td>Overdue</td>
                                                    @endif
                                                    <td>Rp @number($so->grandtotal)</td>
                                                </tr>
                                                @endforeach
                                                @foreach($sd as $sd)
                                                <tr>
                                                    <td><a href="/sales_delivery/{{$sd->id}}">Sales Delivery #{{$sd->number}}</a></td>
                                                    <td>{{$sd->transaction_date}}</td>
                                                    <td>{{$sd->due_date}}</td>
                                                    @if($sd->status == 1)
                                                    <td>Open</td>
                                                    @elseif($sd->status == 2)
                                                    <td>Closed</td>
                                                    @elseif($sd->status == 3)
                                                    <td>Paid</td>
                                                    @elseif($sd->status == 4)
                                                    <td>Partially Sent</td>
                                                    @else
                                                    <td>Overdue</td>
                                                    @endif
                                                    <td>Rp @number($sd->grandtotal)</td>
                                                </tr>
                                                @endforeach
                                                @foreach($si as $si)
                                                <tr>
                                                    <td><a href="/sales_invoice/{{$si->id}}">Sales Invoice #{{$si->number}}</a></td>
                                                    <td>{{$si->transaction_date}}</td>
                                                    <td>{{$si->due_date}}</td>
                                                    @if($si->status == 1)
                                                    <td>Open</td>
                                                    @elseif($si->status == 2)
                                                    <td>Closed</td>
                                                    @elseif($si->status == 3)
                                                    <td>Paid</td>
                                                    @elseif($si->status == 4)
                                                    <td>Partially Sent</td>
                                                    @else
                                                    <td>Overdue</td>
                                                    @endif
                                                    <td>Rp @number($si->grandtotal)</td>
                                                </tr>
                                                @endforeach
                                                @foreach($sp as $sp)
                                                <tr>
                                                    <td><a href="/sales_payment/{{$sp->id}}">Sales Payment #{{$sp->number}}</a></td>
                                                    <td>{{$sp->transaction_date}}</td>
                                                    <td>{{$sp->due_date}}</td>
                                                    @if($sp->status == 1)
                                                    <td>Open</td>
                                                    @elseif($sp->status == 2)
                                                    <td>Closed</td>
                                                    @elseif($sp->status == 3)
                                                    <td>Paid</td>
                                                    @elseif($sp->status == 4)
                                                    <td>Partially Sent</td>
                                                    @else
                                                    <td>Overdue</td>
                                                    @endif
                                                    <td>Rp @number($sp->grandtotal)</td>
                                                </tr>
                                                @endforeach
                                                @foreach($expense as $ex)
                                                <td>
                                                    <td><a href="/expenses/{{$ex->id}}">Expense #{{$ex->number}}</a></td>
                                                    <td>{{$ex->transaction_date}}</td>
                                                    <td>{{$ex->due_date}}</td>
                                                    @if($ex->status == 1)
                                                    <td>Open</td>
                                                    @elseif($ex->status == 2)
                                                    <td>Closed</td>
                                                    @elseif($ex->status == 3)
                                                    <td>Paid</td>
                                                    @elseif($ex->status == 4)
                                                    <td>Partially Sent</td>
                                                    @else
                                                    <td>Overdue</td>
                                                    @endif
                                                    <td>Rp @number($ex->grandtotal)</td>
                                                </td>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/contacts/deleteForm.js') }}" charset="utf-8"></script>
@endpush
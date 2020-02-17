@extends('layouts.admin')

@section('contentheader')
<div class="page-title">
    <div class="title_left">
        <h3>Contact Information</h3>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <div class="col-md-12">
                    <ul class="nav navbar-right panel_toolbox">
                        @hasrole('Owner|Ultimate|Contact')
                        @can('Edit')
                        <li>
                            <button class="btn btn-dark dropdown-toggle" type="button" onclick="window.location.href = '/contacts/edit/{{$contact->id}}';">Edit Profile
                            </button>
                        </li>
                        @endcan
                        @endrole
                        <!--<li>
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
                        </li>-->
                        @if($check_transaction == 1)
                        @hasrole('Owner|Ultimate|Contact')
                        @can('Edit')
                        <li>
                            <button class="btn btn-dark dropdown-toggle" type="button" onclick="window.location.href = '#';" data-toggle="modal" data-target=".bs-example-modal-lg-2">Adjust Limit Balance
                            </button>
                            <div class="modal fade bs-example-modal-lg-2" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <form method="post" id="formCreate">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                                </button>
                                                <h3 class="modal-title" id="myModalLabel"><strong>Adjust Limit Balance</strong></h3>
                                            </div>
                                            <div class="modal-body">
                                                <div class="col-md-6">
                                                    <div class="form-horizontal form-label-left">
                                                        <div class="form-group row">
                                                            <label>Type Adjustment</label>
                                                            <select name="type_limit_balance" class="form-control selectbankname">
                                                                <option value="add" selected>Add</option>
                                                                <option value="minus">Minus</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-horizontal form-label-left">
                                                        <div class="form-group row">
                                                            <label>Value</label>
                                                            <input onClick="this.select();" type="text" class="form-control to_limit_balance_display">
                                                            <input type="text" class="to_limit_balance_hidden" name="to_limit_balance" hidden>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="col-md-1 center-margin">
                                                    <div class="form-horizontal">
                                                        <div class="form-group row">
                                                            <button id="clickLimit" type="button" class="btn btn-success">Create</button>
                                                            <input value="{{$contact->id}}" type="text" name="hidden_id" id="hidden_id" hidden>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group tiles"></div>
                                                <br>
                                                <div class="table-responsive my-5">
                                                    <table id="example" class="table table-striped jambo_table bulk_action">
                                                        <thead>
                                                            <tr class="headings">
                                                                <th class="column-title" style="width:200px">By</th>
                                                                <th class="column-title" style="width:200px">Type Adjustment</th>
                                                                <th class="column-title" style="width:200px">From</th>
                                                                <th class="column-title" style="width:200px">To</th>
                                                                <th class="column-title" style="width:200px">Value</th>
                                                                <th class="column-title" style="width:200px">Created At</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($hlb as $hlb)
                                                            <tr>
                                                                <td>{{$hlb->user->name}}</td>
                                                                <td>@if($hlb->type_limit_balance == 'add') Add @else Minus @endif</td>
                                                                <td>@number($hlb->from_limit_balance)</td>
                                                                <td>@number($hlb->to_limit_balance)</td>
                                                                <td>@number($hlb->value)</td>
                                                                <td>{{$hlb->created_at}}</td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </li>
                        @endif
                        @endcan
                        @endrole
                        <li>
                            <button data-toggle="dropdown" class="btn btn-dark dropdown-toggle" type="button" aria-expanded="false"><span class="glyphicon glyphicon-wrench"></span>
                            </button>
                            <ul role="menu" class="dropdown-menu">
                                <!--<li><a href="#">View Statement Report</a>
                                <li><a href="#">Merge Contacts</a>-->
                                @hasrole('Owner|Ultimate|Contact')
                                @can('Delete')
                                <li><a href="#" id="click">Delete</a>
                                    <input type="text" value="{{$contact->id}}" id="form_id" hidden>
                                </li>
                                @endcan
                                @endrole
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
                                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                        <h5>Limit Balance</h5>
                                        <h5><b>Rp @number($contact->limit_balance)</b></h5>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                        <h5>Current Limit Balance</h5>
                                        <h5><b>Rp @number($contact->current_limit_balance)</b></h5>
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
                                                    <th class="column-title">Transaction Date </th>
                                                    <th class="column-title">Transaction Number </th>
                                                    <th class="column-title">Due Date </th>
                                                    <th class="column-title">Status </th>
                                                    <th class="column-title">Amount </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($other_transaction as $ot)
                                                <tr>
                                                    <td>{{$ot->transaction_date}}</td>
                                                    @if($ot->type == 'purchase quote')
                                                    <td><a href="/purchases_quote/{{$ot->ref_id}}">Purchase Quote #{{$ot->number}}</a></td>
                                                    @elseif($ot->type == 'purchase order')
                                                    <td><a href="/purchases_order/{{$ot->ref_id}}">Purchase Order #{{$ot->number}}</a></td>
                                                    @elseif($ot->type == 'purchase delivery')
                                                    <td><a href="/purchases_delivery/{{$ot->ref_id}}">Purchase Delivery #{{$ot->number}}</a></td>
                                                    @elseif($ot->type == 'purchase invoice')
                                                    <td><a href="/purchases_invoice/{{$ot->ref_id}}">Purchase Invoice #{{$ot->number}}</a></td>
                                                    @elseif($ot->type == 'purchase payment')
                                                    <td><a href="/purchases_payment/{{$ot->ref_id}}">Purchase Payment #{{$ot->number}}</a></td>
                                                    @elseif($ot->type == 'purchase return')
                                                    <td><a href="/purchases_return/{{$ot->ref_id}}">Purchase Return #{{$ot->number}}</a></td>
                                                    @elseif($ot->type == 'sales quote')
                                                    <td><a href="/sales_quote/{{$ot->ref_id}}">Sales Quote #{{$ot->number}}</a></td>
                                                    @elseif($ot->type == 'sales order')
                                                    <td><a href="/sales_order/{{$ot->ref_id}}">Sales Order #{{$ot->number}}</a></td>
                                                    @elseif($ot->type == 'sales delivery')
                                                    <td><a href="/sales_delivery/{{$ot->ref_id}}">Sales Delivery #{{$ot->number}}</a></td>
                                                    @elseif($ot->type == 'sales invoice')
                                                    <td><a href="/sales_invoice/{{$ot->ref_id}}">Sales Invoice #{{$ot->number}}</a></td>
                                                    @elseif($ot->type == 'sales payment')
                                                    <td><a href="/sales_payment/{{$ot->ref_id}}">Sales Payment #{{$ot->number}}</a></td>
                                                    @elseif($ot->type == 'sales return')
                                                    <td><a href="/sales_return/{{$ot->ref_id}}">Sales Return #{{$ot->number}}</a></td>
                                                    @elseif($ot->type == 'spk')
                                                    <td><a href="/spk/{{$ot->ref_id}}">SPK #{{$ot->number}}</a></td>
                                                    @elseif($ot->type == 'wip')
                                                    <td><a href="/wip/{{$ot->ref_id}}">WIP #{{$ot->number}}</a></td>
                                                    @elseif($ot->type == 'bankdeposit')
                                                    <td><a href="/cashbank/bank_deposit/{{$ot->ref_id}}">Bank Deposit #{{$ot->number}}</a></td>
                                                    @elseif($ot->type == 'bankwithdrawalaccount')
                                                    <td><a href="/cashbank/bank_withdrawal/{{$ot->ref_id}}">Bank Withdrawal #{{$ot->number}}</a></td>
                                                    @elseif($ot->type == 'bankwithdrawalfromexpense')
                                                    <td><a href="/cashbank/bank_withdrawal/{{$ot->ref_id}}">Bank Withdrawal #{{$ot->number}}</a></td>
                                                    @endif
                                                    <td>{{$ot->due_date}}</td>
                                                    @if($ot->status == 1)
                                                    <td>Open</td>
                                                    @elseif($ot->status == 2)
                                                    <td>Closed</td>
                                                    @elseif($ot->status == 3)
                                                    <td>Paid</td>
                                                    @elseif($ot->status == 4)
                                                    <td>Partial</td>
                                                    @elseif($ot->status == 5)
                                                    <td>Overdue</td>
                                                    @else
                                                    <td>Sent</td>
                                                    @endif
                                                    <td>Rp @number($ot->total)</td>
                                                </tr>
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
<script src="{{ asset('js/contacts/createLimitForm.js?v=5-20200217-1409') }}" charset="utf-8"></script>
<script src="{{ asset('js/contacts/deleteForm.js?v=5-20200217-1409') }}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js?v=5-20200217-1409') }}" charset="utf-8"></script>
<script>
    function inputMasking() {
        Inputmask.extendAliases({
            numeric: {
                prefix: "Rp",
                digits: 2,
                digitsOptional: false,
                decimalProtect: true,
                groupSeparator: ",",
                radixPoint: ".",
                radixFocus: true,
                autoGroup: true,
                autoUnmask: true,
                removeMaskOnSubmit: true
            }
        });
        Inputmask.extendAliases({
            IDR: {
                alias: "numeric",
                prefix: "Rp "
            }
        });
        $(".to_limit_balance_display").inputmask("IDR");
    }
    $(document).ready(function() {
        inputMasking();
        $(".to_limit_balance_display").on("keyup change", function() {
            if ($(this).val() < 0) {
                $(this).val('0');
            } else {
                var to_limit_balance_display = $(".to_limit_balance_display").val();
                $(".to_limit_balance_hidden").val(to_limit_balance_display);
            }
        });
    });
</script>
@endpush
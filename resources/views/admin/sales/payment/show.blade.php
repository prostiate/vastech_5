@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <ul class="nav navbar-right panel_toolbox">
                    <!--<li>
                        <a class="btn btn-dark" target="_blank" href='/sales_payment/print/PDF/{{$pp->id}}'>Print & Preview
                        </a>
                    </li>-->
                    <li>
                        <button class="btn btn-dark dropdown-toggle" type="button" target="_blank" onclick="window.open('/sales_payment/print/PDF/{{$pp->id}}')">Print & Preview
                        </button>
                    </li>
                    <li>
                        <button class="btn btn-dark dropdown-toggle" type="button" onclick="window.location.href = '#';" data-toggle="modal" data-target=".bs-example-modal-lg">View Journal Entry
                        </button>
                        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                        </button>
                                        <h5 class="modal-title" id="myModalLabel">Journal Report</h5>
                                        <h3 class="modal-title" id="myModalLabel"><strong>Receive Payment #{{$pp->number}}</strong></h3>
                                    </div>
                                    <div class="modal-body">
                                        <div class="table-responsive my-5">
                                            <table id="example" class="table table-striped jambo_table bulk_action">
                                                <thead>
                                                    <tr class="headings">
                                                        <th class="column-title" style="width:250px">Account Number</th>
                                                        <th class="column-title" style="width:200px">Account</th>
                                                        <th class="column-title" style="width:150px">Debit</th>
                                                        <th class="column-title" style="width:150px">Credit</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="neworderbody">
                                                    @foreach ($get_all_detail as $a)
                                                    <tr>
                                                        <td>
                                                            <a href="{{ url('/sales_invoice/'.$a->coa_id) }}">{{$a->coa->code}}</a>
                                                        </td>
                                                        <td>
                                                            <a href="{{ url('/sales_invoice/'.$a->coa_id) }}">{{$a->coa->name}}</a>
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
                </ul>
                <h3><b>Sales Payment #{{$pp->number}}</b></h3>
                <a>Status: </a>
                @if($pp->status == 1)
                <span class="label label-warning" style="color:white;">Open</span>
                @elseif($pp->status == 2)
                <span class="label label-success" style="color:white;">Closed</span>
                @elseif($pp->status == 3)
                <span class="label label-success" style="color:white;">Paid</span>
                @elseif($pp->status == 4)
                <span class="label label-warning" style="color:white;">Partial</span>
                @elseif($pp->status == 5)
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
                                    <h5>{{$pp->number}}</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Customer</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <a href="{{ url('/contacts/'.$pp->contact_id) }}">
                                        <h5>{{$pp->contact->display_name}}</h5>
                                    </a>
                                    <input disabled type="hidden" name="vendor_name" value="{{$pp->contact->id}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Payment Date</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$pp->transaction_date}}</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Deposit To</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <a href="{{ url('/chart_of_accounts/'.$pp->account_id) }}">
                                        <h5>{{$pp->coa->name}}</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-horizontal form-label-left">
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Due Date</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$pp->due_date}}</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Payment Method</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <h5>{{$pp->payment_method->name}}</h5>
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
                                    <th class="column-title" style="width:250px">Number</th>
                                    <th class="column-title" style="width:200px">Description</th>
                                    <th class="column-title" style="width:150px">Payment Amount</th>
                                </tr>
                            </thead>
                            <tbody class="neworderbody">
                                @foreach ($pp_item as $po)
                                <tr>
                                    <td>
                                        <a href="{{ url('/sales_invoice/'.$po->sale_invoice->id) }}">Sales Invoice #{{$po->sale_invoice->number}}</a>
                                    </td>
                                    <td>
                                        <a>{{$po->desc}}</a>
                                    </td>
                                    <td>
                                        <a>Rp @number($po->payment_amount)</a>
                                    </td>
                                </tr>
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
                                    <h5>{{$pp->memo}}</h5>
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
                                        <h3 class="currency balance text-right"><b> Rp @number($pp->grandtotal)</b></h3>
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
                            <a href="{{ url('/sales_payment') }}" class="btn btn-dark">Cancel</a>
                            <button type="button" class="btn btn-danger" id="click">Delete</button>
                            <div class="btn-group">
                                <button class="btn btn-success" type="button" onclick="window.location.href = '/sales_payment/edit/' + {{$pp->id}};">Edit
                                </button>
                            </div>
                            <input type="text" value="{{$pp->id}}" id="form_id" hidden>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/sales/payment/deleteForm.js') }}" charset="utf-8"></script>
@endpush
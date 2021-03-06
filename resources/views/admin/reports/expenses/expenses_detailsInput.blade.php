@extends('layouts/admin')

@section('contentheader')
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Expenses List</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link">Start Date </a></li>
                    <li><input value="{{$start}}" type="date" id="datepicker1" class="form-control"></li>
                    <li><a class="collapse-link">End Date </a></li>
                    <li><input value="{{$end}}" type="date" id="datepicker2" class="form-control"></li>
                    <li>
                        <button type="button" id="click" class="btn btn-dark" onclick="next()">Filter</button>
                    </li>
                    <li>
                        <button class="btn btn-dark dropdown-toggle" type="button" onclick="window.location.href = '#';" data-toggle="modal" data-target=".bs-example-modal-lg">More Filter
                        </button>
                        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-md">
                                <form method="post" id="formCreate">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                            </button>
                                            <h3 class="modal-title" id="myModalLabel"><strong>Reports Filter</strong></h3>
                                        </div>
                                        <div class="modal-body">
                                            <div class="col-md-12">
                                                <div class="form-horizontal form-label-left">
                                                    <div class="form-group row">
                                                        <label>Start Date</label>
                                                        <input value="{{$start}}" type="date" id="datepicker3" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-horizontal form-label-left">
                                                    <div class="form-group row">
                                                        <label>End Date</label>
                                                        <input value="{{$end}}" type="date" id="datepicker4" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-horizontal form-label-left">
                                                    <div class="form-group row">
                                                        <label>Filter by Contacts</label>
                                                        <select name="contact" id="contact" class="form-control selectaccount" multiple>
                                                            <option></option>
                                                            @foreach($contact as $a)
                                                            <option value="{{$a->id}}">{{$a->display_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="col-md-1 center-margin">
                                                <div class="form-horizontal">
                                                    <div class="form-group row">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                                            <button type="button" id="click" class="btn btn-dark" onclick="nextMoreFilter()">Filter</button>
                                            <input type="text" name="hidden_id" id="hidden_id" hidden>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </li>
                    <li>
                        <button data-toggle="dropdown" class="btn btn-dark mr-5 dropdown-toggle" type="button" aria-expanded="false">Export
                        </button>
                        <ul role="menu" class="dropdown-menu">
                            <li><a onclick="excel()">Excel</a>
                            </li>
                            <li><a onclick="csv()">CSV</a>
                            </li>
                            <li><a onclick="pdf()">PDF</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="col-12 table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr class="btn-dark">
                                                <th class="text-left">Date</th>
                                                <th class="text-left" style="width:200px;">Number</th>
                                                <th class="text-left">Beneficiary</th>
                                                <th class="text-left">Memo</th>
                                                <th class="text-right">Tax</th>
                                                <th class="text-right">Total</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-right">Balance Due</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($expense as $ot)
                                            <tr>
                                                <td>{{$ot->transaction_date}}</td>
                                                <td><a href="/expenses/{{$ot->id}}">Expense #{{$ot->number}}</a></td>
                                                <td><a href="/contacts/{{$ot->contact_id}}">{{$ot->expense_contact->display_name}}</a></td>
                                                <td>{{$ot->memo}}</td>
                                                <td class="text-right">@number($ot->taxtotal)</td>
                                                <td class="text-right">@number($ot->grandtotal)</td>
                                                <td class="text-center">{{$ot->expense_status->name}}</td>
                                                <td class="text-right">@number($ot->balance_due)</td>
                                            </tr>
                                            <thead>
                                                <tr>
                                                    <th style="width:100px;"></th>
                                                    <th class="text-left" style="width:300px;">Account Name</th>
                                                    <th class="text-left" style="width:200px;">Description</th>
                                                    <th class="text-right" style="width:200px;">Amount</th>
                                                    <th class="text-right" style="width:100px;">Tax</th>
                                                    <th class="text-right" style="width:200px;">Total Amount</th>
                                                    <th class="text-left" style="width:100px;"></th>
                                                    <th style="width:100px;"></th>
                                                </tr>
                                            </thead>
                                        <tbody>
                                            @foreach($ot->expense_item as $otsi)
                                            <tr>
                                                <td></td>
                                                <td> <a href="/chart_of_accounts/{{$otsi->coa_id}}">{{$otsi->coa->name}}</a></td>
                                                <td>{{$otsi->desc}}</td>
                                                <td class="text-right">@number($otsi->amount)</td>
                                                <td class="text-right">@number($otsi->amounttax)</td>
                                                <td class="text-right">@number($otsi->amountgrand)</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
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


@endsection

@push('scripts')
<script src="{{ asset('js/other/zebradatepicker.js?v=5-20200319-0916') }}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js?v=5-20200319-0916') }}" charset="utf-8"></script>
<script>
    function next() {
        var date1 = document.getElementById('datepicker1');
        var date2 = document.getElementById('datepicker2');
        var coas = $('#coa').val();
        var contacts = $('#contact').val();
        window.location.href = "/reports/expenses_details/start_date=" + date1.value + '&end_date=' + date2.value + '&contacts=' + contacts;
    }

    function nextMoreFilter() {
        var date3 = document.getElementById('datepicker3');
        var date4 = document.getElementById('datepicker4');
        var coas = $('#coa').val();
        var contacts = $('#contact').val();
        window.location.href = "/reports/expenses_details/start_date=" + date3.value + '&end_date=' + date4.value + '&contacts=' + contacts;
    }

    function excel() {
        var date1 = document.getElementById('datepicker1');
        var date2 = document.getElementById('datepicker2');
        var coas = $('#coa').val();
        var contacts = $('#contact').val();
        window.location.href = "/reports/expenses_details/excel/start_date=" + date1.value + '&end_date=' + date2.value + '&contacts=' + contacts;
    }

    function csv() {
        var date1 = document.getElementById('datepicker1');
        var date2 = document.getElementById('datepicker2');
        var coas = $('#coa').val();
        var contacts = $('#contact').val();
        window.location.href = "/reports/expenses_details/csv/start_date=" + date1.value + '&end_date=' + date2.value + '&contacts=' + contacts;
    }

    function pdf() {
        var date1 = document.getElementById('datepicker1');
        var date2 = document.getElementById('datepicker2');
        var coas = $('#coa').val();
        var contacts = $('#contact').val();
        window.location.href = "/reports/expenses_details/pdf/start_date=" + date1.value + '&end_date=' + date2.value + '&contacts=' + contacts;
    }
</script>
@endpush
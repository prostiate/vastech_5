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
                    <li><input value="{{$today}}" type="date" id="datepicker1" class="form-control"></li>
                    <li><a class="collapse-link">End Date </a></li>
                    <li><input value="{{$today}}" type="date" id="datepicker2" class="form-control"></li>
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
                                                        <input value="{{$today}}" type="date" id="datepicker3" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-horizontal form-label-left">
                                                    <div class="form-group row">
                                                        <label>End Date</label>
                                                        <input value="{{$today}}" type="date" id="datepicker4" class="form-control">
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
                                                <th class="text-left">Transaction</th>
                                                <th class="text-left">Number</th>
                                                <th class="text-left" style="width: 200px">Category</th>
                                                <th class="text-left" style="width: 300px">Description</th>
                                                <th class="text-left">Beneficiary</th>
                                                <th class="text-right">Amount</th>
                                                <th class="text-right">Tax</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-right">Balance Due</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $total_grandtotal = 0;
                                            $total_balance_due = 0;
                                            ?>
                                            @foreach($expense as $exx)
                                            <?php 
                                            $total_grandtotal += $exx->grandtotal;
                                            $total_balance_due += $exx->balance_due;
                                            ?>
                                            <tr>
                                                <td class="text-left"><a href="/expenses/{{$exx->id}}">{{$exx->transaction_date}}</td>
                                                <td class="text-left"><a href="/expenses/{{$exx->id}}">Expense</a></td>
                                                <td class="text-left"><a href="/expenses/{{$exx->id}}">{{$exx->number}}</a></td>
                                                <td class="text-left">
                                                @foreach($exx->expense_item as $exii)
                                                    <a href="/chart_of_accounts/{{$exii->coa_id}}">{{$exii->coa->name}};</a>
                                                @endforeach
                                                </td>
                                                <td class="text-left">
                                                @foreach($exx->expense_item as $exii)
                                                    {{$exii->desc}};
                                                @endforeach
                                                </td>
                                                <td class="text-left"><a href="/contacts/{{$exx->contact_id}}">{{$exx->expense_contact->display_name}}</a></td>
                                                <td class="text-right">@number($exx->grandtotal)</td>
                                                <td class="text-right">@number($exx->taxtotal)</td>
                                                <td class="text-center">{{$exx->expense_status->name}}</td>
                                                <td class="text-right">@number($exx->balance_due)</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5" class="text-center"></td>
                                                <td style="text-align: right;"><b>Grand Total</b></td>
                                                <td class="text-right"><b>@number($total_grandtotal)</b></td>
                                                <td></td>
                                                <td></td>
                                                <td class="text-right"><b>@number($total_balance_due)</b></td>
                                            </tr>
                                        </tfoot>
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
<script src="{{ asset('js/other/zebradatepicker.js?v=5-20200217-1409') }}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js?v=5-20200217-1409') }}" charset="utf-8"></script>
<script>
    function next() {
        var date1 = document.getElementById('datepicker1');
        var date2 = document.getElementById('datepicker2');
        var coas = $('#coa').val();
        var contacts = $('#contact').val();
        window.location.href = "/reports/expenses_list/start_date=" + date1.value + '&end_date=' + date2.value + '&contacts=' + contacts;
    }

    function nextMoreFilter() {
        var date3 = document.getElementById('datepicker3');
        var date4 = document.getElementById('datepicker4');
        var coas = $('#coa').val();
        var contacts = $('#contact').val();
        window.location.href = "/reports/expenses_list/start_date=" + date3.value + '&end_date=' + date4.value + '&contacts=' + contacts;
    }

    function excel() {
        var date1 = document.getElementById('datepicker1');
        var date2 = document.getElementById('datepicker2');
        var coas = $('#coa').val();
        var contacts = $('#contact').val();
        window.location.href = "/reports/expenses_list/excel/start_date=" + date1.value + '&end_date=' + date2.value + '&contacts=' + contacts;
    }

    function csv() {
        var date1 = document.getElementById('datepicker1');
        var date2 = document.getElementById('datepicker2');
        var coas = $('#coa').val();
        var contacts = $('#contact').val();
        window.location.href = "/reports/expenses_list/csv/start_date=" + date1.value + '&end_date=' + date2.value + '&contacts=' + contacts;
    }

    function pdf() {
        var date1 = document.getElementById('datepicker1');
        var date2 = document.getElementById('datepicker2');
        var coas = $('#coa').val();
        var contacts = $('#contact').val();
        window.location.href = "/reports/expenses_list/pdf/start_date=" + date1.value + '&end_date=' + date2.value + '&contacts=' + contacts;
    }
</script>
@endpush
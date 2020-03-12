@extends('layouts/admin')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Sales List</h2>
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
                            <div class="modal-dialog modal-sm">
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
                                                        <label>Filter by Sales Type</label>
                                                        <select name="filter_by_type" id="filter_by_type" class="form-control selecttype" multiple>
                                                            <option></option>
                                                            <option value="sales quote">Sales Quote</option>
                                                            <option value="sales order">Sales Order</option>
                                                            <option value="sales delivery">Sales Delivery</option>
                                                            <option value="sales invoice">Sales Invoice</option>
                                                            <option value="sales payment">Sales Payment</option>
                                                            <option value="sales return">Sales Return</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-horizontal form-label-left">
                                                    <div class="form-group row">
                                                        <label>Filter by Customer</label>
                                                        <select name="filter_by_con" id="filter_by_con" class="form-control selectcontact" multiple>
                                                            <option></option>
                                                            @foreach($contact as $a)
                                                            <option value="{{$a->id}}">{{$a->display_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-horizontal form-label-left">
                                                    <div class="form-group row">
                                                        <label>Filter by Status</label>
                                                        <select name="filter_by_stat" id="filter_by_stat" class="form-control selectstatus" multiple>
                                                            <option></option>
                                                            @foreach($status as $a)
                                                            <option value="{{$a->id}}">{{$a->name}}</option>
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
                            <input value="{{$today}}" type="date" id="start_date" hidden>
                            <input value="{{$today}}" type="date" id="end_date" hidden>
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
                                                <th style="width:100px;">Date</th>
                                                <th class="text-left">Transaction Type</th>
                                                <th class="text-left">Transaction Number</th>
                                                <th class="text-left">Customer</th>
                                                <th class="text-left">Status</th>
                                                <th class="text-left" style="width:200px;">Memo</th>
                                                <th class="text-right">Total</th>
                                                <th class="text-right">Balance Due</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $grand_total = 0 ?>
                                            <?php $grand_balance_due = 0 ?>
                                            @forelse($customer as $ot)
                                            <td colspan="8" class="strong"><b>{{$ot->first()->ot_contact->display_name}} </b></td>
                                            <?php $sub_total = 0 ?>
                                            <?php $sub_balance_due = 0 ?>
                                            @foreach($ot as $ot)
                                            <?php $sub_total += $ot->total ?>
                                            <?php $sub_balance_due += $ot->balance_due ?>
                                            <tr>
                                                <td>{{$ot->transaction_date}}</td>
                                                <td><a href="#"><?php echo ucwords($ot->type) ?></a></td>
                                                <td><a href="#">{{$ot->number}}</a></td>
                                                @if($ot->type == 'closing book')
                                                <td><a href="#">-</a></td>
                                                @else
                                                <td><a href="#">{{$ot->ot_contact->display_name}}</a></td>
                                                @endif
                                                <td><a href="#">{{$ot->ot_status->name}}</a></td>
                                                <td><a href="#">{{$ot->memo}}</a></td>
                                                <td class="text-right">@number($ot->total)</td>
                                                <td class="text-right">@number($ot->balance_due)</td>
                                            </tr>
                                            @endforeach
                                            <?php $grand_total += $sub_total ?>
                                            <?php $grand_balance_due +=  $sub_balance_due ?>
                                            <tr>
                                                <td colspan="5" class="text-center"></td>
                                                <td style="text-align: right;"><b>Sub Total</b></td>
                                                <td class="text-right"><b>@number($sub_total)</b></td>
                                                <td class="text-right"><b>@number($sub_balance_due)</b></td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="8" class="text-center">Data is not found</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                        @if(count($customer) >= 1)
                                        <tfoot>
                                            <tr>
                                                <td colspan="5" class="text-center"></td>
                                                <td style="text-align: right;"><b>Total</b></td>
                                                <td class="text-right"><b>@number($grand_total)</b></td>
                                                <td class="text-right"><b>@number($grand_balance_due)</b></td>
                                            </tr>
                                        </tfoot>
                                        @endif
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
<script src="{{asset('js/other/select2.js?v=5-20200312-1327') }}" charset="utf-8"></script>
<script src="{{ asset('js/other/zebradatepicker.js?v=5-20200312-1327') }}" charset="utf-8"></script>
<script>
    function next() {
        var start = document.getElementById('datepicker1');
        var end = document.getElementById('datepicker2');
        var contact = $('#filter_by_con').val();
        var status = $('#filter_by_stat').val();
        var type = $('#filter_by_type').val();
        window.location.href = "/reports/ss_surabaya/sales_list/start_date=" + start.value + '&end_date=' + end.value + '&type=' + type + '&customer=' + contact + '&status=' + status;
    }

    function nextMoreFilter() {
        var start = document.getElementById('datepicker3');
        var end = document.getElementById('datepicker4');
        var contact = $('#filter_by_con').val();
        var status = $('#filter_by_stat').val();
        var type = $('#filter_by_type').val();
        window.location.href = "/reports/ss_surabaya/sales_list/start_date=" + start.value + '&end_date=' + end.value + '&type=' + type + '&customer=' + contact + '&status=' + status;
    }

    function excel() {
        var start = document.getElementById('datepicker3');
        var end = document.getElementById('datepicker4');
        var contact = $('#filter_by_con').val();
        var status = $('#filter_by_stat').val();
        var type = $('#filter_by_type').val();
        window.location.href = "/reports/ss_surabaya/sales_list/excel/start_date=" + start.value + '&end_date=' + end.value + '&type=' + type + '&customer=' + contact + '&status=' + status;
    }

    function csv() {
        var start = document.getElementById('datepicker3');
        var end = document.getElementById('datepicker4');
        var contact = $('#filter_by_con').val();
        var status = $('#filter_by_stat').val();
        var type = $('#filter_by_type').val();
        window.location.href = "/reports/ss_surabaya/sales_list/csv/start_date=" + start.value + '&end_date=' + end.value + '&type=' + type + '&customer=' + contact + '&status=' + status;
    }

    function pdf() {
        var start = document.getElementById('datepicker3');
        var end = document.getElementById('datepicker4');
        var contact = $('#filter_by_con').val();
        var status = $('#filter_by_stat').val();
        var type = $('#filter_by_type').val();
        window.open("/reports/ss_surabaya/sales_list/pdf/start_date=" + start.value + '&end_date=' + end.value + '&type=' + type + '&customer=' + contact + '&status=' + status);
    }
</script>
@endpush

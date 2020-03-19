@extends('layouts/admin')

@section('contentheader')
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Sales by Customer</h2>
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
                                                <th style="width:150px;">Customer / Date</th>
                                                <th class="text-left">Product</th>
                                                <th class="text-right">Qty</th>
                                                <th class="text-left">Unit</th>
                                                <th class="text-right">Unit Price</th>
                                                <th class="text-right">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $grand_total = 0 ?>
                                            @forelse($customers as $customer)
                                            <tr>
                                                <td class="text-center" colspan="6"><b>{{$customer->first()->first()->contact->display_name}}</b></td>
                                            </tr>
                                            <?php $cust_total = 0 ?>
                                            @foreach($customer as $k => $invoice)
                                            <tr>
                                                <td class="text-center" colspan="6"><b>Sales Invoice #{{$invoice->first()->number}}</b></td>
                                            </tr>
                                            <?php $item_total = 0 ?>
                                            @foreach($invoice->first()->sale_invoice_item as $item)
                                            <tr>
                                                <td class="text-left">{{$customer->first()->first()->contact->display_name}}</td>
                                                <td class="text-left">{{$item->product->name}}</td>
                                                <td class="text-right">{{$item->qty}}</td>
                                                <td class="text-left">{{$item->unit->name}}</td>
                                                <td class="text-right">@number($item->unit_price)</td>
                                                <td class="text-right">@number($item->amount)</td>
                                                <?php $item_total += $item->amount ?>
                                            </tr>
                                            @endforeach
                                            <?php $cust_total += $item_total?>
                                            @endforeach
                                            <tr>
                                                <td colspan="4" class="text-center"></td>
                                                <td style="text-align: right;"><b>{{$customer->first()->first()->contact->display_name}} | Total Sales</b></td>
                                                <td style="text-align: right;"><b>@number($cust_total)</b></td>
                                            </tr>
                                            <?php $grand_total += $cust_total?>
                                            @empty
                                            <tr>
                                                <td colspan="6" class="text-center">Data is not found</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                        @if(count($si) >= 1)
                                        <tfoot>
                                            <tr>
                                                <td colspan="4" class="text-center"></td>
                                                <td style="text-align: right;"><b>Grand Total</b></td>
                                                <td style="text-align: right;"><b>@number($grand_total)</b></td>
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
<script src="{{asset('js/other/select2.js?v=5-20200319-0916') }}" charset="utf-8"></script>
<script src="{{ asset('js/other/zebradatepicker.js?v=5-20200319-0916') }}" charset="utf-8"></script>
<script>
    function next() {
        var start = document.getElementById('datepicker1');
        var end = document.getElementById('datepicker2');
        var contact = $('#filter_by_con').val();
        window.location.href = "/reports/ss_surabaya/sales_by_customer/start_date=" + start.value + '&end_date=' + end.value + '&customer=' + contact;
    }

    function nextMoreFilter() {
        var start = document.getElementById('datepicker3');
        var end = document.getElementById('datepicker4');
        var contact = $('#filter_by_con').val();
        window.location.href = "/reports/ss_surabaya/sales_by_customer/start_date=" + start.value + '&end_date=' + end.value + '&customer=' + contact;
    }

    function excel() {
        var start = document.getElementById('datepicker3');
        var end = document.getElementById('datepicker4');
        var contact = $('#filter_by_con').val();
        window.location.href = "/reports/ss_surabaya/sales_by_customer/excel/start_date=" + start.value + '&end_date=' + end.value + '&customer=' + contact;
    }

    function csv() {
        var start = document.getElementById('datepicker3');
        var end = document.getElementById('datepicker4');
        var contact = $('#filter_by_con').val();
        window.location.href = "/reports/ss_surabaya/sales_by_customer/csv/start_date=" + start.value + '&end_date=' + end.value + '&customer=' + contact;
    }

    function pdf() {
        var start = document.getElementById('datepicker3');
        var end = document.getElementById('datepicker4');
        var contact = $('#filter_by_con').val();
        window.open("/reports/ss_surabaya/sales_by_customer/pdf/start_date=" + start.value + '&end_date=' + end.value + '&customer=' + contact);
    }
</script>
@endpush
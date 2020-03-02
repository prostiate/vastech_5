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
                            <input value="{{$start}}" type="date" id="start_date" hidden>
                            <input value="{{$end}}" type="date" id="end_date" hidden>
                            <input value="{{$con}}" type="text" id="con" hidden>
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
                                                <th class="text-left">Transaction</th>
                                                <th class="text-left">No</th>
                                                <th class="text-left">Product</th>
                                                <th class="text-right">Qty</th>
                                                <th class="text-left">Unit</th>
                                                <th class="text-right">Unit Price</th>
                                                <th class="text-right">Amount</th>
                                                <th class="text-right">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $stop = 0 ?>
                                            <?php $total_amount = 0 ?>
                                            <?php $total_total = 0 ?>
                                            <?php $grandtotal_amount = 0 ?>
                                            <?php $grandtotal_total = 0 ?>
                                            @if(count($si) >= 1)
                                            @foreach($contact as $c)
                                            @foreach($si as $s)
                                            @if($s->contact_id == $c->id)
                                            <td colspan="9">
                                                <a href="/contacts/{{$c->id}}"><strong>{{$c->display_name}}</strong></a>
                                            </td>
                                            @foreach($sid as $sd)
                                            @if($sd->sale_invoice_id == $s->id)
                                            <tr>
                                                <td class="text-left">{{$s->transaction_date}}</td>
                                                <td class="text-left">Sales Invoice</td>
                                                <td class="text-left">{{$s->number}}</td>
                                                <td class="text-left">{{$sd->product->name}}</td>
                                                <td class="text-right">{{$sd->qty}}</td>
                                                <td class="text-left">{{$sd->unit->name}}</td>
                                                <td class="text-right">@number($sd->unit_price)</td>
                                                <td class="text-right">@number($sd->amount)</td>
                                                <?php $total_amount += $sd->amount ?>
                                                <?php $total_total += $total_amount ?>
                                                <?php $grandtotal_amount += $total_amount ?>
                                                <?php $grandtotal_total += $total_total ?>
                                                <td class="text-right">@number($total_amount)</td>
                                            </tr>
                                            @endif
                                            @endforeach
                                            @if($stop == 0)
                                            <?php $stop += 1 ?>
                                            <tr>
                                                <td colspan="6" class="text-center"></td>
                                                <td style="text-align: right;"><b>{{$c->display_name}} | Total Sales</b></td>
                                                <td class="text-right"><b>@number($total_amount)</b></td>
                                                <td class="text-right"><b>@number($total_total)</b></td>
                                            </tr>
                                            @endif
                                            <?php $total_amount = 0 ?>
                                            <?php $total_total = 0 ?>
                                            @endif
                                            <?php $stop = 0 ?>
                                            @endforeach
                                            @endforeach
                                            @else
                                            <tr>
                                                <td colspan="9" class="text-center">Data is not found</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                        @if(count($si) >= 1)
                                        <tfoot>
                                            <tr>
                                                <td colspan="7" class="text-center"></td>
                                                <td style="text-align: right;"><b>Grand Total</b></td>
                                                <td class="text-right"><b>@number($grandtotal_total)</b></td>
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
<script src="{{asset('js/other/select2.js?v=5-20200302-1755') }}" charset="utf-8"></script>
<script src="{{ asset('js/other/zebradatepicker.js?v=5-20200302-1755') }}" charset="utf-8"></script>
<script>
    function next() {
        var start = document.getElementById('datepicker1');
        var end = document.getElementById('datepicker2');
        var contact = $('#filter_by_con').val();
        window.location.href = "/reports/sales_by_customer/start_date=" + start.value + '&end_date=' + end.value + '&customer=' + contact;
    }

    function nextMoreFilter() {
        var start = document.getElementById('datepicker3');
        var end = document.getElementById('datepicker4');
        var contact = $('#filter_by_con').val();
        window.location.href = "/reports/sales_by_customer/start_date=" + start.value + '&end_date=' + end.value + '&customer=' + contact;
    }

    function excel() {
        var start = document.getElementById('datepicker3');
        var end = document.getElementById('datepicker4');
        var contact = $('#con').val();
        window.location.href = "/reports/sales_by_customer/excel/start_date=" + start.value + '&end_date=' + end.value + '&customer=' + contact;
    }

    function csv() {
        var start = document.getElementById('datepicker3');
        var end = document.getElementById('datepicker4');
        var contact = $('#con').val();
        window.location.href = "/reports/sales_by_customer/csv/start_date=" + start.value + '&end_date=' + end.value + '&customer=' + contact;
    }

    function pdf() {
        var start = document.getElementById('datepicker3');
        var end = document.getElementById('datepicker4');
        var contact = $('#con').val();
        window.open("/reports/sales_by_customer/pdf/start_date=" + start.value + '&end_date=' + end.value + '&customer=' + contact);
    }
</script>
@endpush
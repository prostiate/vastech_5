@extends('layouts/admin')

@section('contentheader')
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Inventory Summary</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link">As Of </a></li>
                    <li><input value="{{$today}}" type="date" id="datepicker1" class="form-control"></li>
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
                                                        <label>As Of</label>
                                                        <input value="{{$today}}" type="date" id="datepicker2" class="form-control">
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
                            <input value="{{$startyear_last_periode}}" type="date" id="startyear_last_periode" hidden>
                            <input value="{{$endyear_last_periode}}" type="date" id="endyear_last_periode" hidden>
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
                                    <table class="table table-striped table-condensed">
                                        <thead>
                                            <tr class="headings btn-dark">
                                                <th class="column-title text-left">Product Code</th>
                                                <th class="column-title text-left">Product Name</th>
                                                <th class="column-title text-left">Qty</th>
                                                <th class="column-title text-center">Buffer Qty</th>
                                                <th class="column-title text-left">Units</th>
                                                <th class="column-title text-right" style="width: 150px">Average Cost</th>
                                                <th class="column-title text-right" style="width: 150px">Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $total_val = 0 ?>
                                            <?php $grand_total_val = 0 ?>
                                            @foreach($products as $a)
                                            <tr>
                                                <td>
                                                    <a>{{$a->code}}</a>
                                                </td>
                                                <td>
                                                    <a href="/products/{{$a->id}}">{{$a->name}}</a>
                                                </td>
                                                <td>
                                                    <a>{{$a->qty}}</a>
                                                </td>
                                                <td class="text-center">
                                                    <a>-</a>
                                                </td>
                                                <td>
                                                    <a>{{$a->other_unit->name}}</a>
                                                </td>
                                                <td class="text-right">
                                                    <a>@number($a->avg_price)</a>
                                                </td>
                                                <td class="text-right">
                                                    <?php $total_val = $a->avg_price * $a->qty ?>
                                                    <a>@number($total_val)</a>
                                                </td>
                                            </tr>
                                            <?php $grand_total_val += $total_val ?>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="6" style="text-align: right"><strong>Total Value</strong></th>
                                                <th class="text-right"><strong>@number($grand_total_val)</strong></th>
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
<script src="{{ asset('js/other/zebradatepicker.js?v=5-20200221-1431') }}" charset="utf-8"></script>
<script>
    function next() {
        var date1 = document.getElementById('datepicker1');
        window.location.href = "/reports/inventory_summary/as_of=" + date1.value;
    }

    function nextMoreFilter() {
        var date2 = document.getElementById('datepicker2');
        window.location.href = "/reports/inventory_summary/as_of=" + date2.value;
    }

    function excel() {
        var date1 = document.getElementById('datepicker1');
        var startyear_last_periode = document.getElementById('startyear_last_periode');
        var endyear_last_periode = document.getElementById('endyear_last_periode');
        window.location.href = "/reports/inventory_summary/excel/as_of=" + date1.value + "/start_year=" + startyear_last_periode.value + "&end_year=" + endyear_last_periode.value;
    }

    function csv() {
        var date1 = document.getElementById('datepicker1');
        var startyear_last_periode = document.getElementById('startyear_last_periode');
        var endyear_last_periode = document.getElementById('endyear_last_periode');
        window.location.href = "/reports/inventory_summary/csv/as_of=" + date1.value + "/start_year=" + startyear_last_periode.value + "&end_year=" + endyear_last_periode.value;
    }

    function pdf() {
        var date1 = document.getElementById('datepicker1');
        var startyear_last_periode = document.getElementById('startyear_last_periode');
        var endyear_last_periode = document.getElementById('endyear_last_periode');
        window.open("/reports/inventory_summary/pdf/as_of=" + date1.value + "/start_year=" + startyear_last_periode.value + "&end_year=" + endyear_last_periode.value, '_blank');
    }
</script>
@endpush
@extends('layouts/admin')

@section('contentheader')
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Journal Report</h2>
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
                                            <!--{{--
                                            <div class="col-md-12">
                                                <div class="form-horizontal form-label-left">
                                                    <div class="form-group row">
                                                        <label>Filter by Period</label>
                                                        <select name="type_limit_balance" class="form-control selectbankname">
                                                            <option value="custom" selected>Custom</option>
                                                            <option value="today">Today</option>
                                                            <option value="this_week">This Week</option>
                                                            <option value="this_month">This Month</option>
                                                            <option value="this_year">This Year</option>
                                                            <option value="yesterday">Yesterday</option>
                                                            <option value="last_week">Last Week</option>
                                                            <option value="last_month">Last Month</option>
                                                            <option value="last_year">Last Year</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            --}}-->
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
                                                <th style="width:150px; text-align: center">Account Name / Date</th>
                                                <th class="text-left"></th>
                                                <th class="text-left"></th>
                                                <th class="text-right" style="width: 200px">Debit</th>
                                                <th class="text-right" style="width: 200px">Credit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $total_debit = 0 ?>
                                            <?php $total_credit = 0 ?>
                                            <?php $total_debit2 = 0 ?>
                                            <?php $total_credit2 = 0 ?>
                                            @foreach($coa_detail as $cdb => $cdb2)
                                                @if($cdb2->sum('debit') != 0 or $cdb2->sum('credit') != 0)
                                                <tr>
                                                    <td colspan="6"><b>{{$cdb}} | @foreach($cdb2 as $a) {{$a->date}} (created on {{$a->created_at}}) @break @endforeach</b></td>
                                                </tr>
                                                @foreach($cdb2 as $b)
                                                <tr>
                                                    <td></td>
                                                    <td><a href="#">({{$b->coa->code}}) - {{$b->coa->name}}</a></td>
                                                    <td></td>
                                                    <td class="text-right">@number($b->debit)</td>
                                                    <td class="text-right">@number($b->credit)</td>
                                                </tr>
                                                <?php $total_debit += $b->debit ?>
                                                <?php $total_credit += $b->credit ?>
                                                @endforeach
                                                <?php $total_debit2 += $total_debit ?>
                                                <?php $total_credit2 += $total_credit ?>
                                                <tr>
                                                    <td colspan="2" class="text-center"></td>
                                                    <td style="text-align: right;"><b>Total</b></td>
                                                    <td style="text-align: right;"><b>@number($total_debit)</b></td>
                                                    <td style="text-align: right;"><b>@number($total_credit)</b></td>
                                                </tr>
                                                <?php $total_debit = 0 ?>
                                                <?php $total_credit = 0 ?>
                                                @endif
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2" class="text-center" ></td>
                                                <td style="text-align: right;" ><b>Grand Total</b></td>
                                                <td style="text-align: right;" ><b>@number($total_debit2)</b></td>
                                                <td style="text-align: right;" ><b>@number($total_credit2)</b></td>
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
<script src="{{ asset('js/other/zebradatepicker.js') }}" charset="utf-8"></script>
<script>
    function next() {
        var date1   = document.getElementById('datepicker1');
        var date2     = document.getElementById('datepicker2');
        window.location.href = "/reports/journal_report/start_date=" + date1.value + '&end_date=' + date2.value;
    }
    function nextMoreFilter() {
        var date3   = document.getElementById('datepicker3');
        var date4   = document.getElementById('datepicker4');
        window.location.href = "/reports/journal_report/start_date=" + date3.value + '&end_date=' + date4.value;
    }
    function excel() {
        var date1   = document.getElementById('datepicker1');
        var date2   = document.getElementById('datepicker2');
        window.location.href = "/reports/journal_report/excel/start_date=" + date1.value + '&end_date=' + date2.value;
    }
    function csv() {
        var date1   = document.getElementById('datepicker1');
        var date2   = document.getElementById('datepicker2');
        window.location.href = "/reports/journal_report/csv/start_date=" + date1.value + '&end_date=' + date2.value;
    }
    function pdf() {
        var date1   = document.getElementById('datepicker1');
        var date2   = document.getElementById('datepicker2');
        window.open("/reports/journal_report/pdf/start_date=" + date1.value + '&end_date=' + date2.value, '_blank');
    }
</script>
@endpush
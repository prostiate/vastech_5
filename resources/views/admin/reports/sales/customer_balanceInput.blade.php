@extends('layouts/admin')

@section('contentheader')
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Customer Balance</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link">As Of </a></li>
                    <li><input value="{{$today2}}" type="date" id="datepicker1" class="form-control"></li>
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
                                                        <input value="{{$today2}}" type="date" id="datepicker2" class="form-control">
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
                                                <th class="text-left">Due Date</th>
                                                <th class="text-right">Amount</th>
                                                <th class="text-right">Balance Due</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $stop = 0 ?>
                                            <?php $total_grandtotal = 0 ?>
                                            <?php $total_balance_due = 0 ?>
                                            @if(count($si) >= 1)
                                            @foreach($contact as $c)
                                            @foreach($si as $s)
                                            @if($s->contact_id == $c->id)
                                            @if($stop == 0)
                                            <?php $stop += 1 ?>
                                            <tr>
                                                <td colspan="6">
                                                    <a href="/contacts/{{$c->id}}"><strong>{{$c->display_name}}</strong></a>
                                                </td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <td><a>{{$s->transaction_date}}</a></td>
                                                <td><a>Sales Invoice</a></td>
                                                <td><a>{{$s->number}}</a></td>
                                                <td><a>{{$s->due_date}}</a></td>
                                                <td class="text-right"><a>@number($s->grandtotal)</a></td>
                                                <td class="text-right"><a>@number($s->balance_due)</a></td>
                                            </tr>
                                            <?php $total_grandtotal += $s->grandtotal ?>
                                            <?php $total_balance_due += $s->balance_due ?>
                                            @endif
                                            @endforeach
                                            <?php $stop = 0 ?>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td colspan="8" class="text-center">Data is not found</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                        @if(count($si) >= 1)
                                        <tfoot>
                                            <tr>
                                                <td colspan="3" class="text-center"></td>
                                                <td style="text-align: right;"><b>Grand Total</b></td>
                                                <td class="text-right"><b>@number($total_grandtotal)</b></td>
                                                <td class="text-right"><b>@number($total_balance_due)</b></td>
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
        var contact = $('#filter_by_con').val();
        window.location.href = "/reports/customer_balance/as_of=" + start.value + '&customer=' + contact;
    }

    function nextMoreFilter() {
        var start = document.getElementById('datepicker2');
        var contact = $('#filter_by_con').val();
        window.location.href = "/reports/customer_balance/as_of=" + start.value + '&customer=' + contact;
    }

    function excel() {
        var start = document.getElementById('datepicker2');
        var contact = $('#con').val();
        window.location.href = "/reports/customer_balance/excel/as_of=" + start.value + '&customer=' + contact;
    }

    function csv() {
        var start = document.getElementById('datepicker2');
        var contact = $('#con').val();
        window.location.href = "/reports/customer_balance/csv/as_of=" + start.value + '&customer=' + contact;
    }

    function pdf() {
        var start = document.getElementById('datepicker2');
        var contact = $('#con').val();
        window.open("/reports/customer_balance/pdf/as_of=" + start.value + '&customer=' + contact);
    }
</script>
@endpush
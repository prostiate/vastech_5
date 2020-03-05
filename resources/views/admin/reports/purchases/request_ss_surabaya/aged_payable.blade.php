@extends('layouts/admin')

@section('contentheader')
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Aged Payable</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link">Start Date </a></li>
                    <li><input value="{{$today}}" type="date" id="datepicker1" class="form-control"></li>
                    <li><a class="collapse-link">End Date </a></li>
                    <li><input value="{{$today}}" type="date" id="datepicker2" class="form-control"></li>
                    <li>
                        <button type="button" id="click" class="btn btn-dark" onclick="next()">Filter</button>
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
                                                <th style="width:300px;">Customer</th>
                                                <th class="text-center">Total</th>
                                                <th class="text-center">1 - 30 Days</th>
                                                <th class="text-center">31 - 60 Days</th>
                                                <th class="text-center">61 - 90 Days</th>
                                                <th class="text-center">> 90 Days</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <?php $periode1 = 0 ?>
                                            <?php $periode2 = 0 ?>
                                            <?php $periode3 = 0 ?>
                                            <?php $periode4 = 0 ?>
                                            <?php $total = 0 ?>
                                            @foreach($si as $k => $c)
                                            <tr>
                                                <td>{{$c->contact->display_name}}</td>
                                                <td class="text-right">@number($c->balance_due)</td>
                                                <?php $total += $c->balance_due ?>
                                                <td class="text-right">
                                                    @if(isset($group1[$c->contact->display_name]))
                                                    @number($group1[$c->contact->display_name]->sum('balance_due'))
                                                    <?php $periode1 += $group1[$c->contact->display_name]->sum('balance_due') ?>
                                                    @else
                                                    0.00
                                                    @endif</td>
                                                <td class="text-right">
                                                    @if(isset($group2[$c->contact->display_name]))
                                                    @number($group2[$c->contact->display_name]->sum('balance_due'))
                                                    <?php $periode2 += $group2[$c->contact->display_name]->sum('balance_due') ?>
                                                    @else
                                                    0.00
                                                    @endif</td>
                                                <td class="text-right">
                                                    @if(isset($group3[$c->contact->display_name]))
                                                    @number($group3[$c->contact->display_name]->sum('balance_due'))
                                                    <?php $periode3 += $group3[$c->contact->display_name]->sum('balance_due') ?>
                                                    @else
                                                    0.00
                                                    @endif</td>
                                                <td class="text-right">
                                                    @if(isset($group4[$c->contact->display_name]))
                                                    @number($group4[$c->contact->display_name]->sum('balance_due'))
                                                    <?php $periode4 += $group4[$c->contact->display_name]->sum('balance_due') ?>
                                                    @else
                                                    0.00
                                                    @endif</td>
                                            </tr>
                                            @isset($group1[$c->contact->display_name] )
                                            <tr>
                                                <td class="text-center" colspan="6"> 1-30 </td>
                                            </tr>
                                            @foreach($group1[$c->contact->display_name] as $k)
                                            <tr>
                                                <td>
                                                    Purchse Invoice {{$k->number}}
                                                </td>
                                                <td class="text-right">
                                                    {{$k->transaction_date}}
                                                </td>
                                                <td class="text-right">
                                                    @number($k->balance_due)
                                                </td>
                                            </tr>
                                            @endforeach
                                            @endisset
                                            @isset($group2[$c->contact->display_name] )
                                            <tr>
                                                <td colspan="6"> 31-60 </td>
                                            </tr>
                                            @foreach($group2[$c->contact->display_name] as $k)
                                            <tr>
                                                <td>
                                                    Purchse Invoice {{$k->number}}
                                                </td>
                                                <td class="text-right">
                                                    {{$k->transaction_date}}
                                                </td>
                                                <td colspan="2" class="text-right">
                                                    @number($k->balance_due)
                                                </td>
                                            </tr>
                                            @endforeach
                                            @endisset
                                            @isset($group3[$c->contact->display_name] )
                                            <tr>
                                                <td colspan="6"> 61-90 </td>
                                            </tr>
                                            @foreach($group3[$c->contact->display_name] as $k)
                                            <tr>
                                                <td>
                                                    Purchase Invoice {{$k->number}}
                                                </td>
                                                <td class="text-right">
                                                    {{$k->transaction_date}}
                                                </td>
                                                <td colspan="3" class="text-right">
                                                    @number($k->balance_due)
                                                </td>
                                            </tr>
                                            @endforeach
                                            @endisset
                                            @isset($group4[$c->contact->display_name] )
                                            <tr>
                                                <td colspan="6"> >90 </td>
                                            </tr>
                                            @foreach($group4[$c->contact->display_name] as $k)
                                            <tr>
                                                <td>
                                                    Purchse Invoice {{$k->number}}
                                                </td>
                                                <td class="text-right">
                                                    {{$k->transaction_date}}
                                                </td>
                                                <td colspan="4" class="text-right">
                                                    @number($k->balance_due)
                                                </td>
                                            </tr>
                                            @endforeach
                                            @endisset
                                            @endforeach
                                            <tr>
                                                <td class="text-left"><b>Total Payable</b></td>
                                                <td class="text-right"><b>@number($total)</b></td>
                                                <td class="text-right"><b>@number($periode1)</b></td>
                                                <td class="text-right"><b>@number($periode2)</b></td>
                                                <td class="text-right"><b>@number($periode3)</b></td>
                                                <td class="text-right"><b>@number($periode4)</b></td>
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
<script src="{{ asset('js/other/zebradatepicker.js?v=5-20200305-1546') }}" charset="utf-8"></script>
<script>
    function next() {
        var start = document.getElementById('datepicker1');
        var end = document.getElementById('datepicker2');
        window.location.href = "/reports/ss_surabaya/aged_payable/start_date=" + start.value + "&end_date=" + end.value;
    }

    function excel() {
        var start = document.getElementById('datepicker1');
        var end = document.getElementById('datepicker2');
        window.location.href = "/reports/ss_surabaya/aged_payable/excel/start_date=" + start.value + "&end_date=" + end.value;
    }

    function csv() {
        var start = document.getElementById('datepicker1');
        var end = document.getElementById('datepicker2');
        window.location.href = "/reports/ss_surabaya/aged_payable/csv/start_date=" + start.value + "&end_date=" + end.value;
    }

    function pdf() {
        var start = document.getElementById('datepicker1');
        var end = document.getElementById('datepicker2');
        window.open("/reports/ss_surabaya/aged_payable/pdf/start_date=" + start.value + "&end_date=" + end.value);
    }
</script>
@endpush
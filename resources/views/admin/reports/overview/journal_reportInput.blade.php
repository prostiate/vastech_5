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
                                                <th class="text-right" style="width: 300px">Debit</th>
                                                <th class="text-right" style="width: 300px">Credit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $total_debit = 0 ?>
                                            <?php $total_credit = 0 ?>
                                            <?php $total_debit2 = 0 ?>
                                            <?php $total_credit2 = 0 ?>
                                            @foreach($coa_detail as $cdb => $cdb2)
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
        var start   = document.getElementById('datepicker1');
        var end     = document.getElementById('datepicker2');
        window.location.href = "/reports/journal_report/" + start.value + '&' + end.value;
    }
</script>
@endpush
@extends('layouts/admin')

@section('contentheader')
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Purchases List</h2>
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
                                                <th style="width:100px;">Date</th>
                                                <th class="text-left">Transaction Type</th>
                                                <th class="text-left">Transaction Number</th>
                                                <th class="text-left">Vendor</th>
                                                <th class="text-left">Status</th>
                                                <th class="text-left" style="width:200px;">Memo</th>
                                                <th class="text-right">Total</th>
                                                <th class="text-right">Balance Due</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $total_total = 0 ?>
                                            <?php $total_balance_due = 0 ?>
                                            @foreach($other_transaction as $ot)
                                            @if($ot->type == 'purchase invoice')
                                            <?php $total_total += $ot->total ?>
                                            <?php $total_balance_due += $ot->balance_due ?>
                                            <tr>
                                                <td>{{$ot->transaction_date}}</td>
                                                <td><a href="#">Purchase Invoice</a></td>
                                                <td><a href="#">{{$ot->number}}</a></td>
                                                <td><a href="#">{{$ot->ot_contact->display_name}}</a></td>
                                                <td><a href="#">{{$ot->ot_status->name}}</a></td>
                                                <td><a href="#">{{$ot->memo}}</a></td>
                                                <td class="text-right">@number($ot->total)</td>
                                                <td class="text-right">@number($ot->balance_due)</td>
                                            </tr>
                                            @endif
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5" class="text-center"></td>
                                                <td style="text-align: right;"><b>TOTAL</b></td>
                                                <td class="text-right"><b>@number($total_total)</b></td>
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
<script src="{{ asset('js/other/zebradatepicker.js?v=5-20200305-1546') }}" charset="utf-8"></script>
<script>
    function next() {
        var start   = document.getElementById('datepicker1');
        var end     = document.getElementById('datepicker2');
        window.location.href = "/reports/purchases_list/" + start.value + '&' + end.value;
    }
</script>
@endpush
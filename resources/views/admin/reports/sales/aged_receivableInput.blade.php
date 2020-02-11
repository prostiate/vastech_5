@extends('layouts/admin')

@section('contentheader')
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Aged Receivable</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link">As Of </a></li>
                    <li><input value="{{$today}}" type="date" id="datepicker1" class="form-control"></li>
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
                                                <th style="width:300px;">Customer</th>
                                                <th class="text-center">Total</th>
                                                <th class="text-center">1 - 30 Days</th>
                                                <th class="text-center">31 - 60 Days</th>
                                                <th class="text-center">61 - 90 Days</th>
                                                <th class="text-center">> 90 Days</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <?php $total = 0 ?>
                                            <?php $total_satutiga = 0 ?>
                                            @foreach($contact as $c)
                                                @foreach($si as $sii)
                                                    @if($c->id == $sii->contact_id)
                                                        <tr>
                                                            <td>{{$c->display_name}}</td>
                                                            <?php $total += $sii->balance_due ?>
                                                            <td class="text-center">@number($total)</td>
                                                            <?php $satutiga_awal = date('Y-m-01', strtotime($sii->transaction_date)) ?>
                                                            <?php $satutiga_akhir = date('Y-m-t', strtotime($sii->transaction_date)) ?>
                                                            @if($sii->transaction_date >= $satutiga_awal && $sii->transaction_date <= $satutiga_akhir)
                                                                <?php $total_satutiga += $sii->balance_due ?>
                                                                <td class="text-center">@number($total_satutiga)</td>
                                                            @endif
                                                            <td class="text-center">0.00</td>
                                                            <td class="text-center">0.00</td>
                                                            <td class="text-center">0.00</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            <?php $total_satutiga = 0 ?>
                                            <?php $total = 0 ?>
                                            @endforeach
                                            <tr>
                                                <td class="text-left" ><b>Total Receivable</b></td>
                                                <td class="text-center"><b></b></td>
                                                <td class="text-center"><b></b></td>
                                                <td class="text-center"><b>0.00</b></td>
                                                <td class="text-center"><b>0.00</b></td>
                                                <td class="text-center"><b>0.00</b></td>
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
<script src="{{ asset('js/other/zebradatepicker.js?v=5-20200211-1624') }}" charset="utf-8"></script>
<script>
    function next() {
        var start   = document.getElementById('datepicker1');
        window.location.href = "/reports/aged_receivable/" + start.value;
    }
</script>
@endpush
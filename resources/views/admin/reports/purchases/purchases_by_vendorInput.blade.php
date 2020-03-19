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
                                            @foreach($contact as $c)
                                                @foreach($si as $s)
                                                    @if($s->contact_id == $c->id)
                                                        <td colspan="9">
                                                            <a href="/contacts/{{$c->id}}"><strong>{{$c->display_name}}</strong></a>
                                                        </td>
                                                        @foreach($sid as $sd)
                                                            @if($sd->purchase_invoice_id == $s->id)
                                                                <tr>
                                                                    <td class="text-left">{{$s->transaction_date}}</td>
                                                                    <td class="text-left">Purchase Invoice</td>
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
                                                                <td style="text-align: right;"><b>{{$c->display_name}} | Total Purchase</b></td>
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
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="7" class="text-center"></td>
                                                <td style="text-align: right;"><b>Grand Total</b></td>
                                                <td class="text-right"><b>@number($grandtotal_total)</b></td>
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
<script src="{{ asset('js/other/zebradatepicker.js?v=5-20200319-0916') }}" charset="utf-8"></script>
<script>
    function next() {
        var start   = document.getElementById('datepicker1');
        var end     = document.getElementById('datepicker2');
        window.location.href = "/reports/purchases_by_vendor/" + start.value + '&' + end.value;
    }
</script>
@endpush
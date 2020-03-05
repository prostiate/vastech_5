@extends('layouts/admin')

@section('contentheader')
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Sales Order Completion</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link">Start Date </a></li>
                    <li><input value="{{$today}}" type="date" id="datepicker1" class="form-control"></li>
                    <li><a class="collapse-link">End Date </a></li>
                    <li><input value="{{$today}}" type="date" id="datepicker2" class="form-control"></li>
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
                                                <th class="text-left">Order Date</th>
                                                <th class="text-left">Order No.</th>
                                                <th class="text-right">Order Amount</th>
                                                <th class="text-center">Order Status</th>
                                                <th class="text-right">Delivery Amount</th>
                                                <th class="text-right">Invoice Amount</th>
                                                <th class="text-right">Payment Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $total_amount = 0 ?>
                                            <?php $grandtotal_sell_amount = 0 ?>
                                            <?php $grandtotal_return_amount = 0 ?>
                                            @foreach($so as $soo)
                                                <tr>
                                                    <td class="text-left">{{$soo->transaction_date}}</td>
                                                    <td class="text-left">{{$soo->number}}</td>
                                                    <td class="text-right">@number($soo->grandtotal)</td>
                                                    <td class="text-center">{{$soo->status_order->name}}</td>
                                                    @foreach($sd as $sdd)
                                                        @if($sdd->selected_so_id == $soo->id)
                                                            @if($sdd->grandtotal > 0)
                                                                <td class="text-right">sd @number($sdd->grandtotal)</td>
                                                            @else
                                                                <td class="text-right">sd @number(0)</td>
                                                                @endif
                                                        @else
                                                                <td class="text-right">sd @number(0)</td>
                                                        @endif
                                                    @endforeach
                                                    @foreach($si as $sii)
                                                        @if($sii->selected_so_id == $soo->id)
                                                            @if($sii->grandtotal > 0)
                                                                <td class="text-right">si @number($sii->grandtotal)</td>
                                                            @else
                                                                <td class="text-right">si @number(0)</td>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                    @foreach($spi as $spii)
                                                        @if($spii->sale_invoice->selected_so_id == $soo->id)
                                                            <td class="text-right">sp @number($spii->payment_amount)</td>
                                                        @endif
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4" class="text-center"></td>
                                                <td style="text-align: right;"><b>Total</b></td>
                                                <td class="text-right"><b>@number($grandtotal_sell_amount)</b></td>
                                                <?php $neg3 = $grandtotal_return_amount - ($grandtotal_return_amount * 2) ?>
                                                <td class="text-right"><b>@number($neg3)</b></td>
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
        window.location.href = "/reports/sales_by_product/" + start.value + '&' + end.value;
    }
</script>
@endpush
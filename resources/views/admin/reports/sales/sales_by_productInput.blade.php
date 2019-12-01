@extends('layouts/admin')

@section('contentheader')
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Sales By Product</h2>
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
                                                <th class="text-left">Product Code</th>
                                                <th class="text-left">Product</th>
                                                <th class="text-right">Sell Qty</th>
                                                <th class="text-right">Returned Qty</th>
                                                <th class="text-left">Unit</th>
                                                <th class="text-right">Total Value Sold</th>
                                                <th class="text-right">Total Value Returned</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $total_amount = 0 ?>
                                            <?php $grandtotal_sell_amount = 0 ?>
                                            <?php $grandtotal_return_amount = 0 ?>
                                            @foreach($si as $is)
                                                @foreach($sid as $sdi)
                                                    @if($is->id == $sdi->sale_invoice_id)
                                                    <tr>
                                                        <td class="text-left">{{$sdi->product->code}}</td>
                                                        <td class="text-left">{{$sdi->product->name}}</td>
                                                        <td class="text-right">{{$sdi->qty}}</td>
                                                        @if($sir != 0)
                                                            @foreach($sir as $sri)
                                                                @if($sri->sale_invoice_item_id == $sdi->id)
                                                                <?php $neg1 = gmp_neg($sri->qty) ?>
                                                                <td class="text-right">{{$neg1}}</td>
                                                                @else
                                                                <td class="text-right">0</td>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            <td class="text-right">0</td>
                                                        @endif
                                                        <td class="text-left">{{$sdi->unit->name}}</td>
                                                        <td class="text-right">@number($sdi->amount)</td>
                                                        @if($sir != 0)
                                                            @foreach($sir as $sri)
                                                                @if($sri->sale_invoice_item_id == $sdi->id)
                                                                <?php $neg2 = $sri->amount - ($sri->amount * 2) ?>
                                                                <td class="text-right">@number($neg2)</td>
                                                                <?php $grandtotal_return_amount += $sri->amount ?>
                                                                @else
                                                                <td class="text-right">@number(0)</td>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            <td class="text-right">@number(0)</td>
                                                        @endif
                                                        <?php $grandtotal_sell_amount += $sdi->amount ?>
                                                    </tr>
                                                    @endif
                                                @endforeach
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
<script src="{{ asset('js/other/zebradatepicker.js') }}" charset="utf-8"></script>
<script>
    function next() {
        var start   = document.getElementById('datepicker1');
        var end     = document.getElementById('datepicker2');
        window.location.href = "/reports/sales_by_product/" + start.value + '&' + end.value;
    }
</script>
@endpush
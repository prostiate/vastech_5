@extends('layouts/admin')

@section('contentheader')
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Sales Delivery</h2>
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
                                                <th class="text-left">Product</th>
                                                <th class="text-left">Unit</th>
                                                <th class="text-right">Qty</th>
                                                <th class="text-right">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $stop = 0 ?>
                                            <?php $total_amount = 0 ?>
                                            <?php $grandtotal_amount = 0 ?>
                                            @foreach($contact as $c)
                                                @foreach($sd as $ds)
                                                    @if($c->id == $ds->contact_id)
                                                        <td colspan="9">
                                                            <a><strong>{{$c->display_name}}</strong></a>
                                                        </td>
                                                        @foreach($sditem as $sdi)
                                                            @if($sdi->sale_delivery_id == $ds->id)
                                                                <tr>
                                                                    <td colspan="1"></td>
                                                                    <td class="text-left">{{$sdi->product_id}}</td>
                                                                    <td class="text-left">{{$sdi->unit->name}}</td>
                                                                    <td class="text-right">{{$sdi->qty}}</td>
                                                                    <td class="text-right">@number($sdi->amount)</td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                        <?php $total_amount += $sdi->amount ?>
                                                        @if($stop == 0)
                                                        <?php $stop += 1 ?>
                                                        <tr>
                                                            <td colspan="4" class="text-right"><strong>Total</strong></td>
                                                            <td style="text-align: right;"><b>@number($total_amount)</b></td>
                                                        </tr>
                                                        @endif
                                                    @endif
                                                <?php $grandtotal_amount += $total_amount ?>
                                                <?php $stop = 0 ?>
                                                @endforeach
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3" class="text-center"></td>
                                                <td style="text-align: right;"><b>Grand Total</b></td>
                                                <td class="text-right"><b>@number($grandtotal_amount)</b></td>
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
<script src="{{ asset('js/other/zebradatepicker.js?v=5-20200206-1313') }}" charset="utf-8"></script>
<script>
    function next() {
        var start   = document.getElementById('datepicker1');
        var end     = document.getElementById('datepicker2');
        window.location.href = "/reports/sales_delivery/" + start.value + '&' + end.value;
    }
</script>
@endpush
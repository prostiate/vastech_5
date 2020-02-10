@extends('layouts/admin')

@section('contentheader')
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Inventory Valuation</h2>
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
                                    <table class="table table-striped table-condensed">
                                        <thead>
                                            <tr class="headings btn-dark">
                                                <th class="column-title" style="width:200px">Date</th>
                                                <th class="column-title" style="width:150px">Transaction</th>
                                                <th class="column-title" style="width:150px;">No</th>
                                                <th class="column-title" style="width:150px;">Description</th>
                                                <th class="column-title text-center" style="width:150px;">Mutation</th>
                                                <th class="column-title text-center" style="width:100px;">Stocked Qty</th>
                                                <th class="column-title text-right" style="width:150px;">Avg Cost</th>
                                                <th class="column-title text-right" style="width:150px;">Buy/Sell Price</th>
                                                <th class="column-title text-right" style="width:150px;">Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $current_val_pi = 0 ?>
                                            <?php $current_val_si = 0 ?>
                                            <?php $total_current_val_pi = 0 ?>
                                            <?php $total_current_val_si = 0 ?>
                                            <?php $total_current_qty_pi = 0 ?>
                                            <?php $total_current_qty_si = 0 ?>
                                            <?php $grandtotal = 0 ?>
                                            @foreach($products as $a)
                                                <tr>
                                                    <td colspan="9">
                                                        <a><strong>{{$a->name}}</strong></a>
                                                    </td>
                                                </tr>
                                                @foreach($pi as $ppi)
                                                    @foreach($pip as $pii)
                                                        @if($pii->purchase_invoice_id == $ppi->id)
                                                            @if($a->id == $pii->product_id)
                                                                <?php $current_val_pi += $a->avg_price * $pii->qty ?>
                                                                <?php $total_current_val_pi += $current_val_pi ?>
                                                                <?php $total_current_qty_pi += $pii->qty ?>
                                                                <tr>
                                                                    <td>
                                                                        <a>{{$pii->purchase_invoice->transaction_date}}</a>
                                                                    </td>
                                                                    <td>
                                                                        <a>Purchase Invoice</a>
                                                                    </td>
                                                                    <td>
                                                                        <a>{{$pii->purchase_invoice->number}}</a>
                                                                    </td>
                                                                    <td>
                                                                        <a>{{$pii->purchase_invoice->memo}}</a>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <a></a>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <a>{{$pii->qty}}</a>
                                                                    </td>
                                                                    <td class="text-right">
                                                                        <a>@number($a->avg_price)</a>
                                                                    </td>
                                                                    <td class="text-right">
                                                                        <a>@number($pii->unit_price)</a>
                                                                    </td>
                                                                    <td class="text-right">
                                                                        <a>@number($current_val_pi)</a>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endif
                                                    <?php $current_val_pi = 0 ?>
                                                    @endforeach
                                                @endforeach
                                                @foreach($si as $ssi)
                                                    @foreach($sis as $sii)
                                                        @if($sii->sale_invoice_id == $ssi->id)
                                                            @if($a->id == $sii->product_id)
                                                                <?php $current_val_si += $a->avg_price * $sii->qty ?>
                                                                <?php $total_current_val_si += $current_val_si ?>
                                                                <?php $total_current_qty_si += $sii->qty ?>
                                                                <tr>
                                                                    <td>
                                                                        <a>{{$sii->sale_invoice->transaction_date}}</a>
                                                                    </td>
                                                                    <td>
                                                                        <a>Sales Invoice</a>
                                                                    </td>
                                                                    <td>
                                                                        <a>{{$sii->sale_invoice->number}}</a>
                                                                    </td>
                                                                    <td>
                                                                        <a>{{$sii->sale_invoice->memo}}</a>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <a></a>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <a>{{$sii->qty}}</a>
                                                                    </td>
                                                                    <td class="text-right">
                                                                        <a>@number($a->avg_price)</a>
                                                                    </td>
                                                                    <td class="text-right">
                                                                        <a>@number($sii->unit_price)</a>
                                                                    </td>
                                                                    <td class="text-right">
                                                                        <a>@number($current_val_si)</a>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                    <?php $current_val_si = 0 ?>
                                                @endforeach
                                                <tr>
                                                    <td colspan="5" class="text-right">
                                                        <a>Current Stock :</a>
                                                    </td>
                                                    <td class="text-center">
                                                        <a>{{$total_current_qty_pi - $total_current_qty_si}}</a>
                                                    </td>
                                                    <td>
                                                        <a></a>
                                                    </td>
                                                    <td>
                                                        <a>Current Value :</a>
                                                    </td>
                                                    <td class="text-right">
                                                        <?php $grandtotal += $total_current_val_si + $total_current_val_pi ?>
                                                        <a>@number($total_current_val_si + $total_current_val_pi)</a>
                                                    </td>
                                                </tr>
                                            <?php $total_current_val_pi = 0 ?>
                                            <?php $total_current_val_si = 0 ?>
                                            <?php $total_current_qty_pi = 0 ?>
                                            <?php $total_current_qty_si = 0 ?>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="8" style="text-align: right"><strong>Grand Total</strong></th>
                                                <th class="text-right"><strong>@number($grandtotal)</strong></th>
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
        window.location.href = "/reports/inventory_valuation/" + start.value + '&' + end.value;
    }
</script>
@endpush
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
                    <li><a class="collapse-link">As Of </a></li>
                    <li><input value="{{$today2}}" type="date" id="datepicker1" class="form-control"></li>
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
                                                <th class="column-title" style="width:150px">Product Code</th>
                                                <th class="column-title" style="width:200px">Product Name</th>
                                                <th class="column-title" style="width:150px;">Qty</th>
                                                <th class="column-title" style="width:150px;">Buffer</th>
                                                <th class="column-title" style="width:100px;">Products Units</th>
                                                <th class="column-title text-right" style="width:150px;">Average Cost</th>
                                                <th class="column-title text-right" style="width:150px;">Inventory Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $total_val = 0 ?>
                                            <?php $grand_total_val = 0 ?>
                                            @foreach($warehouse as $w)
                                                <tr>
                                                    <td colspan="9">
                                                        <a><strong>{{$w->name}}</strong></a>
                                                    </td>
                                                </tr>
                                                @foreach($warehouse_detail as $wd)
                                                    @foreach($wd as $wdd)
                                                        <tr>
                                                            <td>
                                                                <a>{{$wdd->product->code}}</a>
                                                            </td>
                                                            <td>
                                                                <a>{{$wdd->product->name}}</a>
                                                            </td>
                                                            <td>
                                                                <a>{{$wdd->totalqty}}</a>
                                                            </td>
                                                            <td>
                                                                <a>-</a>
                                                            </td>
                                                            <td>
                                                                <a>{{$wdd->product->other_unit->name}}</a>
                                                            </td>
                                                            <td class="text-right">
                                                                <a>@number($wdd->product->avg_price)</a>
                                                            </td>
                                                            <td class="text-right">
                                                                <?php $total_val = $wdd->product->avg_price * $wdd->totalqty ?>
                                                                <a>@number($total_val)</a>
                                                            </td>
                                                        </tr>
                                                        <?php $grand_total_val += $total_val ?>
                                                    @endforeach
                                                @endforeach
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="6" style="text-align: right"><strong>Total</strong></th>
                                                <th class="text-right"><strong>@number($grand_total_val)</strong></th>
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
        window.location.href = "/reports/warehouse_items_valuation/" + start.value;
    }
</script>
@endpush
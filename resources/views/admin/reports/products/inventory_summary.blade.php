@extends('layouts/admin')

@section('contentheader')
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Inventory Summary</h2>
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
                                    <table class="table table-striped table-condensed">
                                        <thead>
                                            <tr class="headings btn-dark">
                                                <th class="column-title text-left">Product Code</th>
                                                <th class="column-title text-left">Product Name</th>
                                                <th class="column-title text-left">Qty</th>
                                                <th class="column-title text-center">Buffer Qty</th>
                                                <th class="column-title text-left">Units</th>
                                                <th class="column-title text-right" style="width: 150px">Average Cost</th>
                                                <th class="column-title text-right" style="width: 150px">Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $total_val = 0 ?>
                                            <?php $grand_total_val = 0 ?>
                                            @foreach($products as $a)
                                            <tr>
                                                <td>
                                                    <a>{{$a->code}}</a>
                                                </td>
                                                <td>
                                                    <a href="/products/{{$a->id}}">{{$a->name}}</a>
                                                </td>
                                                <td>
                                                    <a>{{$a->qty}}</a>
                                                </td>
                                                <td class="text-center">
                                                    <a>-</a>
                                                </td>
                                                <td>
                                                    <a>{{$a->other_unit->name}}</a>
                                                </td>
                                                <td class="text-right">
                                                    <a>@number($a->avg_price)</a>
                                                </td>
                                                <td class="text-right">
                                                    <?php $total_val = $a->avg_price * $a->qty ?>
                                                    <a>@number($total_val)</a>
                                                </td>
                                            </tr>
                                            <?php $grand_total_val += $total_val ?>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="6" style="text-align: right"><strong>Total Value</strong></th>
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
<script src="{{ asset('js/other/zebradatepicker.js') }}" charset="utf-8"></script>
<script>
    function next() {
        var start   = document.getElementById('datepicker1');
        window.location.href = "/reports/inventory_summary/" + start.value;
    }
</script>
@endpush
@extends('layouts/admin')

@section('contentheader')
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Warehouse Stock Quantity</h2>
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
                                                <th class="column-title" style="width:150px">Product Code</th>
                                                <th class="column-title" style="width:300px">Product Name</th>
                                                <th class="column-title text-center">Product Units</th>
                                                @foreach($warehouse as $w)
                                                <th class="column-title">{{$w->name}}</th>
                                                @endforeach
                                                <th class="column-title">Total Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $total_qty = 0 ?>
                                            @foreach($warehouse_detail as $wd)
                                                @foreach($wd as $wdd)
                                                    <tr>
                                                        <td>
                                                            <a>{{$wdd->product->code}}</a>
                                                        </td>
                                                        <td>
                                                            <a>{{$wdd->product->name}}</a>
                                                        </td>
                                                        <td class="text-center">
                                                            <a>{{$wdd->product->other_unit->name}}</a>
                                                        </td>
                                                        @foreach($warehouse as $ware)
                                                            @if($ware->id == $wdd->warehouse_id)
                                                                <?php $total_qty += $wdd->totalqty ?>
                                                                <td>
                                                                    <a>{{$wdd->totalqty}}</a>
                                                                </td>
                                                            @endif
                                                        @endforeach
                                                        <td>
                                                            <a>{{$total_qty}}</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            <?php $total_qty = 0 ?>
                                            @endforeach
                                        </tbody>
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
        window.location.href = "/reports/warehouse_stock_quantity/" + start.value;
    }
</script>
@endpush
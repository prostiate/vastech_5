@extends('layouts/admin')

@section('contentheader')
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Inventory Details</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link">As Of </a></li>
                    <li><input type="date" name="datepicker" id="datepicker" class="form-control"></li>
                    <li>
                        <button data-toggle="dropdown" class="btn btn-dark dropdown-toggle" type="button" aria-expanded="false">More Filter <span class="caret"></span>
                        </button>
                        <ul role="menu" class="dropdown-menu">
                            <li><a href="/expenses/new">Expenses</a>
                            </li>
                        </ul>
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
                                                <th class="column-title" style="width:150px; text-align: center;">No</th>
                                                <th class="column-title" style="width:150px; text-align: center;">Description</th>
                                                <th class="column-title" style="width:150px; text-align: center;">Mutation</th>
                                                <th class="column-title" style="width:100px; text-align: right;">Stock Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $total_val = 0 ?>
                                            <?php $grand_total_val = 0 ?>
                                            @foreach($products as $a)
                                            <tr>
                                                <td colspan="6">
                                                    <a><strong>() {{$a->name}}</strong></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a></a>
                                                </td>
                                                <td>
                                                    <a>Beginning Balance</a>
                                                </td>
                                                <td>
                                                    <a></a>
                                                </td>
                                                <td>
                                                    <a></a>
                                                </td>
                                                <td>
                                                    <a></a>
                                                </td>
                                                <td style="text-align: right;">
                                                    <a>{{$a->qty}}</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" style="text-align: right;">
                                                    <a>({{$a->name}}) | Available Stock:</a>
                                                </td>
                                                <td colspan="5" style="text-align: right;">
                                                <a>{{$a->qty}}</a>
                                                </td>
                                            </tr>
                                            <?php $grand_total_val += $a->qty ?>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="5" style="text-align: right"><strong>Grand Total</strong></th>
                                                <th class="text-right"><strong>{{$grand_total_val}}</strong></th>
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
<script src="{{ asset('js/other/zebradatepicker.js?v=5-20200312-1327') }}" charset="utf-8"></script>
@endpush
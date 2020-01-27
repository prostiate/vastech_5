@extends('layouts/admin')

@section('contentheader')
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Vendor Balance</h2>
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
                                                <th style="width:150px;">Vendor / Date</th>
                                                <th class="text-left">Transaction</th>
                                                <th class="text-left">No</th>
                                                <th class="text-left">Due Date</th>
                                                <th class="text-right">Amount</th>
                                                <th class="text-right">Balance Due</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <?php $stop = 0 ?>
                                            <?php $total_grandtotal = 0 ?>
                                            <?php $total_balance_due = 0 ?>
                                            @foreach($contact as $c)
                                                @foreach($si as $s)
                                                    @if($s->contact_id == $c->id)
                                                        @if($stop == 0)
                                                            <?php $stop += 1 ?>
                                                            <tr>
                                                                <td colspan="6">
                                                                    <a href="/contacts/{{$c->id}}"><strong>{{$c->display_name}}</strong></a>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                        <tr>
                                                            <td><a>{{$s->transaction_date}}</a></td>
                                                            <td><a>Purchase Invoice</a></td>
                                                            <td><a>{{$s->number}}</a></td>
                                                            <td><a>{{$s->due_date}}</a></td>
                                                            <td class="text-right"><a>@number($s->grandtotal)</a></td>
                                                            <td class="text-right"><a>@number($s->balance_due)</a></td>
                                                        </tr>
                                                        <?php $total_grandtotal += $s->grandtotal ?>
                                                        <?php $total_balance_due += $s->balance_due ?>
                                                    @endif
                                                @endforeach
                                            <?php $stop = 0 ?>
                                            @endforeach
                                            <tr>
                                                <td colspan="3" class="text-center"></td>
                                                <td style="text-align: right;"><b>Grand Total</b></td>
                                                <td class="text-right"><b>@number($total_grandtotal)</b></td>
                                                <td class="text-right"><b>@number($total_balance_due)</b></td>
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
<script src="{{ asset('js/other/zebradatepicker.js?v=5-27012020') }}" charset="utf-8"></script>
<script>
    function next() {
        var start   = document.getElementById('datepicker1');
        window.location.href = "/reports/vendor_balance/" + start.value;
    }
</script>
@endpush
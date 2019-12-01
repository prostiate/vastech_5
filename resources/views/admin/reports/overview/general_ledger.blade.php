@extends('layouts/admin')

@section('contentheader')
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>General Ledger</h2>
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
                                                <th style="width:150px; text-align: center">Account Name / Date</th>
                                                <th class="text-left">Transaction Number</th>
                                                <th class="text-right">Debit</th>
                                                <th class="text-right">Credit</th>
                                                <th class="text-right">Balance</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $grand_total_debit = 0 ?>
                                            <?php $grand_total_credit = 0 ?>
                                            <?php $balance = 0 ?>
                                            <?php $balance2 = 0 ?>
                                            <?php $category = 0 ?>
                                            @foreach($coa_detail as $cdb => $cdb2)
                                            <?php $total_debit = 0 ?>
                                            <?php $total_credit = 0 ?>
                                            <tr>
                                                <td colspan="6">
                                                    @foreach($coa as $ca)
                                                        @if($cdb == $ca->id)
                                                        <a href="/chart_of_accounts/{{$ca->id}}"><strong>({{$ca->code}}) - {{$ca->name}}</strong></a>
                                                        @endif
                                                    @endforeach
                                                </td>
                                            </tr>
                                            @foreach($cdb2 as $a)
                                            <?php $total_debit += $a->debit ?>
                                            <?php $total_credit += $a->credit ?>
                                            <?php $grand_total_debit += $a->debit ?>
                                            <?php $grand_total_credit += $a->credit ?>
                                            <?php $balance += $a->debit - $a->credit ?>
                                            @if($balance == 0)
                                            @else
                                                @if($a->coa->coa_category_id == 13)
                                                <?php $balance2 += $a->credit - $a->debit ?>
                                                <?php $category += 1 ?>
                                                    <tr>
                                                        <td>
                                                            <a>{{$a->date}}</a>
                                                        </td>
                                                        <td>
                                                            <a>{{$a->number}}</a>
                                                        </td>
                                                        <td class="text-right">
                                                            <a>@number($a->debit)</a>
                                                        </td>
                                                        <td class="text-right">
                                                            <a>@number($a->credit)</a>
                                                        </td>
                                                        <td class="text-right">
                                                            <a>@if($balance2 < 0) ( @number(abs($balance2)) ) @else @number($balance2) @endif</a>
                                                        </td>
                                                    </tr>
                                                @else
                                                <?php $balance += $a->debit - $a->credit ?>
                                                <?php $category += 0 ?>
                                                    <tr>
                                                        <td>
                                                            <a>{{$a->date}}</a>
                                                        </td>
                                                        <td>
                                                            <a>{{$a->number}}</a>
                                                        </td>
                                                        <td class="text-right">
                                                            <a>@number($a->debit)</a>
                                                        </td>
                                                        <td class="text-right">
                                                            <a>@number($a->credit)</a>
                                                        </td>
                                                        <td class="text-right">
                                                            <a>@if($balance < 0) ( @number(abs($balance)) ) @else @number($balance) @endif</a>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endif
                                            @endforeach
                                            <tr>
                                                <td colspan="1" class="text-center"></td>
                                                <td style="text-align: right;"><b>Ending Balance</b></td>
                                                <td class="text-right"><b>@if($total_debit < 0 )( @number(abs($total_debit)) ) @else @number($total_debit) @endif</b></td>
                                                <td class="text-right"><b>@if($total_credit < 0 )( @number(abs($total_credit)) ) @else @number($total_credit) @endif</b></td>
                                                <td class="text-right"><b>@if($category > 0) 
                                                                            @if($balance2 < 0 )( @number(abs($balance2)) ) 
                                                                            @else @number($balance2)
                                                                            @endif
                                                                        @else 
                                                                            @if($balance < 0 )( @number(abs($balance)) ) 
                                                                            @else @number($balance)
                                                                            @endif
                                                                        @endif</b></td>
                                            </tr>
                                            <?php $balance = 0 ?>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="1" class="text-center"></td>
                                                <td style="text-align: right;"><b>Grand Total</b></td>
                                                <td class="text-right"><b>@number($grand_total_debit)</b></td>
                                                <td class="text-right"><b>@number($grand_total_credit)</b></td>
                                                <td></td>
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
        window.location.href = "/reports/general_ledger/" + start.value + '&' + end.value;
    }
</script>
@endpush
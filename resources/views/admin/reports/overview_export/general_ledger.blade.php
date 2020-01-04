
<table class="table table-hover">
    <thead>
        <tr>
            <th colspan="5" style="text-align: center;">
                <strong>{{$company->name}}</strong>
            </th>
        </tr>
        <tr>
            <th colspan="5" style="text-align: center;">
                <strong>General Ledger</strong>
            </th>
        </tr>
        <tr>
            <th colspan="5" style="text-align: center;">
                <strong>{{$start}} / {{$end}}</strong>
            </th>
        </tr>
        <tr>
            <th colspan="5" style="text-align: center;">
                <strong>(in IDR)</strong>
            </th>
        </tr>
    </thead>
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
        <?php $total_balance = 0 ?>
        <?php $total_balance2 = 0 ?>
        <?php $category = 0 ?>
        @foreach($coa_detail as $cdb => $cdb2)
            @if($cdb2->sum('credit') != 0 or $cdb2->sum('debit') != 0)
            <?php $total_debit = 0 ?>
            <?php $total_credit = 0 ?>
            <tr>
                <td colspan="6">
                    @foreach($coa as $ca)
                        @if($cdb == $ca->id)
                        <strong>({{$ca->code}}) - {{$ca->name}}</strong>
                        @endif
                    @endforeach
                </td>
            </tr>
            @foreach($cdb2 as $a)
            <?php $total_debit += $a->debit ?>
            <?php $total_credit += $a->credit ?>
            <?php $grand_total_debit += $a->debit ?>
            <?php $grand_total_credit += $a->credit ?>
                @if($a->debit != 0 or $a->credit != 0)
                    @if($a->coa->coa_category_id == 13)
                    <?php $balance2 += $a->credit - $a->debit ?>
                    <?php $category += 1 ?>
                    <?php $total_balance2 += $a->credit - $a->debit ?>
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
                    <?php $total_balance += $a->debit - $a->credit ?>
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
                                            @if($total_balance2 < 0 )( @number(abs($total_balance2)) ) 
                                            @else @number($total_balance2)
                                            @endif
                                        @else 
                                            @if($total_balance < 0 )( @number(abs($total_balance)) ) 
                                            @else @number($total_balance)
                                            @endif
                                        @endif</b></td>
            </tr>
            <?php $balance = 0 ?>
            <?php $balance2 = 0 ?>
            <?php $total_balance = 0 ?>
            <?php $total_balance2 = 0 ?>
            @endif
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
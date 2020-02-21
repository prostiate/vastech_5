<table class="table table-hover">
    <thead>
        <tr class="btn-dark">
            <th style="width:100px;">Date</th>
            <th class="text-left">Transaction Type</th>
            <th class="text-left">Transaction Number</th>
            <th class="text-left">Customer</th>
            <th class="text-left">Status</th>
            <th class="text-left" style="width:200px;">Memo</th>
            <th class="text-right">Total</th>
            <th class="text-right">Balance Due</th>
        </tr>
    </thead>
    <tbody>
        <?php $total_total = 0 ?>
        <?php $total_balance_due = 0 ?>
        @if(count($other_transaction) >= 1)
        @foreach($other_transaction as $ot)
        <?php $total_total += $ot->total ?>
        <?php $total_balance_due += $ot->balance_due ?>
        <tr>
            <td>{{$ot->transaction_date}}</td>
            <td><a href="#"><?php echo ucwords($ot->type) ?></a></td>
            <td><a href="#">{{$ot->number}}</a></td>
            @if($ot->type == 'closing book')
            <td><a href="#">-</a></td>
            @else
            <td><a href="#">{{$ot->ot_contact->display_name}}</a></td>
            @endif
            <td><a href="#">{{$ot->ot_status->name}}</a></td>
            <td><a href="#">{{$ot->memo}}</a></td>
            <td class="text-right">@number($ot->total)</td>
            <td class="text-right">@number($ot->balance_due)</td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="8" class="text-center">Data is not found</td>
        </tr>
        @endif
    </tbody>
    @if(count($other_transaction) >= 1)
    <tfoot>
        <tr>
            <td colspan="5" class="text-center"></td>
            <td style="text-align: right;"><b>TOTAL</b></td>
            <td class="text-right"><b>@number($total_total)</b></td>
            <td class="text-right"><b>@number($total_balance_due)</b></td>
        </tr>
    </tfoot>
    @endif
</table>
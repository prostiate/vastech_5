<table class="table table-hover">
    <thead>
        <tr class="btn-dark">
            <th style="width:150px;">Customer / Date</th>
            <th class="text-left">Transaction</th>
            <th class="text-left">No</th>
            <th class="text-left">Due Date</th>
            <th class="text-right">Amount</th>
            <th class="text-right">Balance Due</th>
        </tr>
    </thead>
    <tbody>
        <?php $stop = 0 ?>
        <?php $total_grandtotal = 0 ?>
        <?php $total_balance_due = 0 ?>
        @if(count($si) >= 1)
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
            <td><a>Sales Invoice</a></td>
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
        @else
        <tr>
            <td colspan="8" class="text-center">Data is not found</td>
        </tr>
        @endif
    </tbody>
    @if(count($si) >= 1)
    <tfoot>
        <tr>
            <td colspan="3" class="text-center"></td>
            <td style="text-align: right;"><b>Grand Total</b></td>
            <td class="text-right"><b>@number($total_grandtotal)</b></td>
            <td class="text-right"><b>@number($total_balance_due)</b></td>
        </tr>
    </tfoot>
    @endif
</table>
<table class="table table-hover">
    <thead>
        <tr class="btn-dark">
            <th style="width:150px;">Customer / Date</th>
            <th class="text-left">Transaction</th>
            <th class="text-left">No</th>
            <th class="text-left">Product</th>
            <th class="text-right">Qty</th>
            <th class="text-left">Unit</th>
            <th class="text-right">Unit Price</th>
            <th class="text-right">Amount</th>
            <th class="text-right">Total</th>
        </tr>
    </thead>
    <tbody>
        <?php $stop = 0 ?>
        <?php $total_amount = 0 ?>
        <?php $total_total = 0 ?>
        <?php $grandtotal_amount = 0 ?>
        <?php $grandtotal_total = 0 ?>
        @foreach($contact as $c)
        @foreach($si as $s)
        @if($s->contact_id == $c->id)
        <td colspan="9">
            <a href="/contacts/{{$c->id}}"><strong>{{$c->display_name}}</strong></a>
        </td>
        @foreach($sid as $sd)
        @if($sd->sale_invoice_id == $s->id)
        <tr>
            <td class="text-left">{{$s->transaction_date}}</td>
            <td class="text-left">Sales Invoice</td>
            <td class="text-left">{{$s->number}}</td>
            <td class="text-left">{{$sd->product->name}}</td>
            <td class="text-right">{{$sd->qty}}</td>
            <td class="text-left">{{$sd->unit->name}}</td>
            <td class="text-right">@number($sd->unit_price)</td>
            <td class="text-right">@number($sd->amount)</td>
            <?php $total_amount += $sd->amount ?>
            <?php $total_total += $total_amount ?>
            <?php $grandtotal_amount += $total_amount ?>
            <?php $grandtotal_total += $total_total ?>
            <td class="text-right">@number($total_amount)</td>
        </tr>
        @endif
        @endforeach
        @if($stop == 0)
        <?php $stop += 1 ?>
        <tr>
            <td colspan="6" class="text-center"></td>
            <td style="text-align: right;"><b>{{$c->display_name}} | Total Sales</b></td>
            <td class="text-right"><b>@number($total_amount)</b></td>
            <td class="text-right"><b>@number($total_total)</b></td>
        </tr>
        @endif
        <?php $total_amount = 0 ?>
        <?php $total_total = 0 ?>
        @endif
        <?php $stop = 0 ?>
        @endforeach
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="7" class="text-center"></td>
            <td style="text-align: right;"><b>Grand Total</b></td>
            <td class="text-right"><b>@number($grandtotal_total)</b></td>
        </tr>
    </tfoot>
</table>
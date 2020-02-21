<table class="table table-hover">
    <thead>
        <tr class="btn-dark">
            <th style="width:300px;">Customer</th>
            <th class="text-center">Total</th>
            <th class="text-center">1 - 30 Days</th>
            <th class="text-center">31 - 60 Days</th>
            <th class="text-center">61 - 90 Days</th>
            <th class="text-center">> 90 Days</th>
        </tr>
    </thead>
    <tfoot>
        <?php $total = 0 ?>
        <?php $total_satutiga = 0 ?>
        @foreach($contact as $c)
        @foreach($si as $sii)
        @if($c->id == $sii->contact_id)
        <tr>
            <td>{{$c->display_name}}</td>
            <?php $total += $sii->balance_due ?>
            <td class="text-center">@number($total)</td>
            <?php $satutiga_awal = date('Y-m-01', strtotime($sii->transaction_date)) ?>
            <?php $satutiga_akhir = date('Y-m-t', strtotime($sii->transaction_date)) ?>
            @if($sii->transaction_date >= $satutiga_awal && $sii->transaction_date <= $satutiga_akhir) <?php $total_satutiga += $sii->balance_due ?> <td class="text-center">@number($total_satutiga)</td>
                @endif
                <td class="text-center">0.00</td>
                <td class="text-center">0.00</td>
                <td class="text-center">0.00</td>
        </tr>
        @endif
        @endforeach
        <?php $total_satutiga = 0 ?>
        <?php $total = 0 ?>
        @endforeach
        <tr>
            <td class="text-left"><b>Total Receivable</b></td>
            <td class="text-center"><b></b></td>
            <td class="text-center"><b></b></td>
            <td class="text-center"><b>0.00</b></td>
            <td class="text-center"><b>0.00</b></td>
            <td class="text-center"><b>0.00</b></td>
        </tr>
    </tfoot>
</table>
<table class="table table-hover">
    <thead>
        <tr>
            <th colspan="5" style="text-align: center;">
                <strong>{{$company->name}}</strong>
            </th>
        </tr>
        <tr>
            <th colspan="5" style="text-align: center;">
                <strong>Journal Report</strong>
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
            <th class="text-left"></th>
            <th class="text-left"></th>
            <th class="text-right" style="width: 200px">Debit</th>
            <th class="text-right" style="width: 200px">Credit</th>
        </tr>
    </thead>
    <tbody>
        <?php $total_debit = 0 ?>
        <?php $total_credit = 0 ?>
        <?php $total_debit2 = 0 ?>
        <?php $total_credit2 = 0 ?>
        @foreach($coa_detail as $cdb => $cdb2)
            @if($cdb2->sum('debit') != 0 or $cdb2->sum('credit') != 0)
            <tr>
                <td colspan="6"><b>{{$cdb}} | @foreach($cdb2 as $a) {{$a->date}} (created on {{$a->created_at}}) @break @endforeach</b></td>
            </tr>
            @foreach($cdb2 as $b)
            <tr>
                <td></td>
                <td>({{$b->coa->code}}) - {{$b->coa->name}}</td>
                <td></td>
                <td class="text-right">@number($b->debit)</td>
                <td class="text-right">@number($b->credit)</td>
            </tr>
            <?php $total_debit += $b->debit ?>
            <?php $total_credit += $b->credit ?>
            @endforeach
            <?php $total_debit2 += $total_debit ?>
            <?php $total_credit2 += $total_credit ?>
            <tr>
                <td colspan="2" class="text-center"></td>
                <td style="text-align: right;"><b>Total</b></td>
                <td style="text-align: right;"><b>@number($total_debit)</b></td>
                <td style="text-align: right;"><b>@number($total_credit)</b></td>
            </tr>
            <?php $total_debit = 0 ?>
            <?php $total_credit = 0 ?>
            @endif
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2" class="text-center" ></td>
            <td style="text-align: right;" ><b>Grand Total</b></td>
            <td style="text-align: right;" ><b>@number($total_debit2)</b></td>
            <td style="text-align: right;" ><b>@number($total_credit2)</b></td>
        </tr>
    </tfoot>
</table>
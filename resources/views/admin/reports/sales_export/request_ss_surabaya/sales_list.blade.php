<table class="table table-border">
    <thead>
        <tr>
            <th colspan="8" style="text-align: center;">
                <strong>{{$company->name}}</strong>
            </th>
        </tr>
        <tr>
            <th colspan="8" style="text-align: center;">
                <strong>Sales List</strong>
            </th>
        </tr>
        <tr>
            <th colspan="8" style="text-align: center;">
                <strong>{{$start}} / {{$end}}</strong>
            </th>
        </tr>
        <tr>
            <th colspan="8" style="text-align: center;">
                <strong>{{$today}}</strong>
            </th>
        </tr>
        <tr style="backgroud-color: green;">
            <th rowspan="2" style="width:100px;">Date</th>
            <th rowspan="2" style="vertical-align: middle; text-align: center;">Transaction Type</th>
            <th rowspan="2" style="vertical-align: middle; text-align: center;">Transaction Number</th>
            <th rowspan="2" style="vertical-align: middle; text-align: center;">Customer</th>
            <th rowspan="2" style="vertical-align: middle; text-align: center;">Status</th>
            <th rowspan="2" style="vertical-align: middle; text-align: center;">Memo</th>
            <th rowspan="2" style="vertical-align: middle; text-align: center;">Total</th>
            <th rowspan="2" style="vertical-align: middle; text-align: center;">Balance Due</th>
        </tr>
    </thead>
    <tbody>
        <?php $grand_total = 0 ?>
        <?php $grand_balance_due = 0 ?>
        @forelse($customer as $ot)
        <tr>
            <td colspan="8"><b>{{$ot->first()->ot_contact->display_name}} </b></td>
        </tr>
        <?php $sub_total = 0 ?>
        <?php $sub_balance_due = 0 ?>
        @foreach($ot as $ot)
        <?php $sub_total += $ot->total ?>
        <?php $sub_balance_due += $ot->balance_due ?>
        <tr>
            <td>{{$ot->transaction_date}}</td>
            <td><?php echo ucwords($ot->type) ?></td>
            <td>{{$ot->number}}</td>
            @if($ot->type == 'closing book')
            <td>-</td>
            @else
            <td>{{$ot->ot_contact->display_name}}</td>
            @endif
            <td>{{$ot->ot_status->name}}</td>
            <td>{{$ot->memo}}</td>
            <td style="text-align: right;">@number($ot->total)</td>
            <td style="text-align: right;">@number($ot->balance_due)</td>
        </tr>
        @endforeach
        <?php $grand_total += $sub_total ?>
        <?php $grand_balance_due +=  $sub_balance_due ?>
        <tr>
            <td colspan="5" class="text-center"></td>
            <td style="text-align: right;"><b>SUB TOTAL</b></td>
            <td style="text-align: right;"><b>@number($sub_total)</b></td>
            <td style="text-align: right;"><b>@number($sub_balance_due)</b></td>
        </tr>
        @empty
        <tr>
            <td colspan="8" class="text-center">Data is not found</td>
        </tr>
        @endforelse
    </tbody>
    @if(count($customer) >= 1)
    <tfoot>
        <tr style="backgroud-color: green;">
            <td colspan="5" class="text-center"></td>
            <td style="text-align: right;"><b>TOTAL</b></td>
            <td style="text-align: right;"><b>@number($grand_total)</b></td>
            <td style="text-align: right;"><b>@number($grand_balance_due)</b></td>
        </tr>
    </tfoot>
    @endif
</table>

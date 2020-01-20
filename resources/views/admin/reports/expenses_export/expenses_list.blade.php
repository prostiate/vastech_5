<table class="table table-hover">
    <thead>
        <tr class="btn-dark">
            <th class="text-left">Date</th>
            <th class="text-left">Transaction</th>
            <th class="text-left">Number</th>
            <th class="text-left">Category</th>
            <th class="text-left">Description</th>
            <th class="text-left">Beneficiary</th>
            <th class="text-right">Amount</th>
            <th class="text-right">Tax</th>
            <th class="text-center">Status</th>
            <th class="text-right">Balance Due</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total_grandtotal = 0;
        $total_balance_due = 0;
        ?>
        @foreach($expense as $exx)
        <?php
        $total_grandtotal += $exx->grandtotal;
        $total_balance_due += $exx->balance_due;
        ?>
        <tr>
            <td class="text-left">{{$exx->transaction_date}}</td>
            <td class="text-left">Expense</td>
            <td class="text-left">{{$exx->number}}</td>
            <td class="text-left">
                @foreach($exx->expense_item as $exii)
                {{$exii->coa->name}};
                @endforeach
            </td>
            <td class="text-left">
                @foreach($exx->expense_item as $exii)
                {{$exii->desc}};
                @endforeach
            </td>
            <td class="text-left">{{$exx->expense_contact->display_name}}</td>
            <td class="text-right">@number($exx->grandtotal)</td>
            <td class="text-right">@number($exx->balance_due)</td>
            <td class="text-center">{{$exx->expense_status->name}}</td>
            <td class="text-right">@number($exx->balance_due)</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" class="text-center"></td>
            <td style="text-align: right;"><b>Grand Total</b></td>
            <td class="text-right"><b>@number($total_grandtotal)</b></td>
            <td></td>
            <td></td>
            <td class="text-right"><b>@number($total_balance_due)</b></td>
        </tr>
    </tfoot>
</table>
<table class="table table-hover">
    <thead>
        <tr class="btn-dark">
            <th class="text-left">Date</th>
            <th class="text-left" style="width:200px;">Number</th>
            <th class="text-left">Beneficiary</th>
            <th class="text-left">Memo</th>
            <th class="text-right">Tax</th>
            <th class="text-right">Total</th>
            <th class="text-center">Status</th>
            <th class="text-right">Balance Due</th>
        </tr>
    </thead>
    <tbody>
        @foreach($expense as $ot)
        <tr>
            <td>{{$ot->transaction_date}}</td>
            <td>Expense #{{$ot->number}}</td>
            <td>{{$ot->expense_contact->display_name}}</td>
            <td>{{$ot->memo}}</td>
            <td class="text-right">@number($ot->taxtotal)</td>
            <td class="text-right">@number($ot->grandtotal)</td>
            <td class="text-center">{{$ot->expense_status->name}}</td>
            <td class="text-right">@number($ot->balance_due)</td>
        </tr>
        <thead>
            <tr>
                <th style="width:100px;"></th>
                <th class="text-left" style="width:300px;">Account Name</th>
                <th class="text-left" style="width:200px;">Description</th>
                <th class="text-right" style="width:200px;">Amount</th>
                <th class="text-right" style="width:100px;">Tax</th>
                <th class="text-right" style="width:200px;">Total Amount</th>
                <th class="text-left" style="width:100px;"></th>
                <th style="width:100px;"></th>
            </tr>
        </thead>
        @foreach($ot->expense_item as $otsi)
        <tr>
            <td></td>
            <td>{{$otsi->coa->name}}</td>
            <td>{{$otsi->desc}}</td>
            <td class="text-right">@number($otsi->amount)</td>
            <td class="text-right">@number($otsi->amounttax)</td>
            <td class="text-right">@number($otsi->amountgrand)</td>
            <td></td>
            <td></td>
        </tr>
        @endforeach
        @endforeach
    </tbody>
</table>
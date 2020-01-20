<table class="table table-hover">
    <thead>
        <tr class="btn-dark">
            <th style="width:100px;">Date</th>
            <th class="text-left" style="width:200px;">Transaction Number</th>
            <th class="text-left" style="width:200px;">Memo</th>
            <th class="text-left" style="width:200px;">Customer</th>
            <th class="text-left" style="width:200px;">Warehouse</th>
            <th class="text-left" style="width:100px;">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($spk as $ot)
        <tr>
            <td>{{$ot->transaction_date}}</td>
            <td>Surat Perintah Kerja #{{$ot->number}}</td>
            <td>{{$ot->memo}}</td>
            <td>{{$ot->contact->display_name}}</td>
            <td>{{$ot->warehouse->name}}</td>
            <td>{{$ot->spk_status->name}}</td>
        </tr>
        <thead>
            <tr>
                <th style="width:100px;"></th>
                <th class="text-left" style="width:300px;">Product</th>
                <th class="text-left" style="width:200px;">Requirement Quantity</th>
                <th class="text-left" style="width:200px;">Quantity Remaining</th>
                <th class="text-left" style="width:100px;">Status</th>
                <th class="text-left" style="width:100px;"></th>
            </tr>
        </thead>
        @foreach($ot->spk_item as $otsi)
        <tr>
            <td></td>
            <td>{{$otsi->product->name}}</td>
            <td>{{$otsi->qty}}</td>
            <td>{{$otsi->qty_remaining}}</td>
            <td>{{$otsi->spk_item_status->name}}</td>
            <td></td>
        </tr>
        @endforeach
        @endforeach
    </tbody>
</table>
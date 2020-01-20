<table class="table table-hover">
    <thead>
        <tr class="btn-dark">
            <th style="width:100px;">Date</th>
            <th class="text-left" style="width:200px;">Transaction Number</th>
            <th class="text-left" style="width:200px;">Memo</th>
            <th class="text-left">Customer</th>
            <th class="text-left">Warehouse</th>
            <th class="text-left" style="width:100px;">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($spk as $ot)
        <tr>
            <td>{{$ot->transaction_date}}</td>
            <td>{{$ot->number}}</td>
            <td>{{$ot->memo}}</td>
            <td>{{$ot->contact->display_name}}</td>
            <td>{{$ot->warehouse->name}}</td>
            <td>{{$ot->spk_status->name}}</td>
        </tr>
        @endforeach
    </tbody>
</table>